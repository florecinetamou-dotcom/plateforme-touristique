<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class ReservationAdminController extends Controller {

    private $model;
    const PER_PAGE = 15;

    public function __construct() {
        $this->requireAuth('admin');
        $this->model = new Hebergement();
    }

    // =========================================================
    //  LISTE
    // =========================================================
    public function index() {
        $statut   = $_GET['statut']   ?? 'tous';
        $search   = trim($_GET['search'] ?? '');
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $offset   = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($statut !== 'tous') {
            $where   .= " AND r.statut = ?";
            $params[] = $statut;
        }
        if ($search !== '') {
            $where   .= " AND (r.reference LIKE ? OR u.nom LIKE ? OR u.prenom LIKE ? OR h.nom LIKE ?)";
            $like     = "%$search%";
            $params   = array_merge($params, [$like, $like, $like, $like]);
        }

        $base = "FROM reservation r
                 JOIN utilisateur u ON r.voyageur_id = u.id
                 JOIN hebergement h ON r.hebergement_id = h.id
                 JOIN ville v ON h.ville_id = v.id
                 $where";

        $total_res   = $this->model->query("SELECT COUNT(*) as total $base", $params);
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $reservations = $this->model->query(
            "SELECT r.*,
                    u.nom as voyageur_nom, u.prenom as voyageur_prenom, u.email as voyageur_email,
                    h.nom as hebergement_nom,
                    v.nom as ville_nom
             $base
             ORDER BY r.date_reservation DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        // Compteurs par statut
        $counts = ['tous' => 0, 'en_attente' => 0, 'confirmee' => 0, 'annulee' => 0, 'terminee' => 0, 'no_show' => 0];
        $cnt = $this->model->query("SELECT statut, COUNT(*) as nb FROM reservation GROUP BY statut");
        foreach ($cnt as $row) {
            $counts[$row->statut] = $row->nb;
            $counts['tous'] += $row->nb;
        }

        // Stats financières
        $stats = [];
        $r = $this->model->query("SELECT COALESCE(SUM(montant_total),0) as total FROM reservation WHERE statut = 'confirmee'");
        $stats['revenus_confirmes'] = $r[0]->total ?? 0;

        $r = $this->model->query("SELECT COALESCE(SUM(montant_total),0) as total FROM reservation WHERE statut = 'confirmee' AND MONTH(date_reservation) = MONTH(NOW()) AND YEAR(date_reservation) = YEAR(NOW())");
        $stats['revenus_mois'] = $r[0]->total ?? 0;

        $this->view('admin/reservations/index', [
            'reservations' => $reservations,
            'total'        => $total,
            'total_pages'  => $total_pages,
            'page'         => $page,
            'counts'       => $counts,
            'stats'        => $stats,
            'badges'       => $this->getBadges(),
            'filters'      => compact('statut', 'search'),
        ]);
    }

    // =========================================================
    //  DÉTAIL
    // =========================================================
    public function show($id) {
        $result = $this->model->query(
            "SELECT r.*,
                    u.nom as voyageur_nom, u.prenom as voyageur_prenom,
                    u.email as voyageur_email, u.telephone as voyageur_tel,
                    h.nom as hebergement_nom, h.prix_nuit_base,
                    v.nom as ville_nom
             FROM reservation r
             JOIN utilisateur u ON r.voyageur_id = u.id
             JOIN hebergement h ON r.hebergement_id = h.id
             JOIN ville v ON h.ville_id = v.id
             WHERE r.id = ? LIMIT 1",
            [$id]
        );

        if (empty($result)) {
            $_SESSION['error'] = "Réservation introuvable.";
            $this->redirect('/admin/reservations');
        }

        $this->view('admin/reservations/show', [
            'reservation' => $result[0],
            'badges'      => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  CONFIRMER
    // =========================================================
    public function confirmer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/reservations');
        }
        $this->model->query(
            "UPDATE reservation SET statut = 'confirmee', date_confirmation = NOW() WHERE id = ?", [$id]
        );
        $_SESSION['success'] = "Réservation confirmée.";
        $this->redirect('/admin/reservations/' . $id);
    }

    // =========================================================
    //  ANNULER
    // =========================================================
    public function annuler($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/reservations');
        }
        $this->model->query(
            "UPDATE reservation SET statut = 'annulee', date_annulation = NOW() WHERE id = ?", [$id]
        );
        $_SESSION['success'] = "Réservation annulée.";
        $this->redirect('/admin/reservations/' . $id);
    }

    // =========================================================
    //  PRIVÉ
    // =========================================================
    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}