<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class AvisAdminController extends Controller {

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
        $filtre  = $_GET['filtre']  ?? 'tous';
        $search  = trim($_GET['search'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $offset  = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($filtre === 'signales') {
            $where .= " AND a.signalement = 1";
        } elseif ($filtre === 'non_verifies') {
            $where .= " AND a.est_verifie = 0";
        } elseif ($filtre === 'verifies') {
            $where .= " AND a.est_verifie = 1";
        }

        if ($search !== '') {
            $where   .= " AND (u.nom LIKE ? OR u.prenom LIKE ? OR h.nom LIKE ?)";
            $like     = "%$search%";
            $params   = array_merge($params, [$like, $like, $like]);
        }

        $base = "FROM avis a
                 JOIN utilisateur u ON a.voyageur_id = u.id
                 JOIN hebergement h ON a.hebergement_id = h.id
                 $where";

        $total_res   = $this->model->query("SELECT COUNT(*) as total $base", $params);
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $avis = $this->model->query(
            "SELECT a.*,
                    u.nom as voyageur_nom, u.prenom as voyageur_prenom,
                    h.nom as hebergement_nom
             $base
             ORDER BY a.signalement DESC, a.date_creation DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        // Compteurs
        $counts = [];
        $r = $this->model->query("SELECT COUNT(*) as nb FROM avis");
        $counts['tous'] = $r[0]->nb ?? 0;
        $r = $this->model->query("SELECT COUNT(*) as nb FROM avis WHERE signalement = 1");
        $counts['signales'] = $r[0]->nb ?? 0;
        $r = $this->model->query("SELECT COUNT(*) as nb FROM avis WHERE est_verifie = 0");
        $counts['non_verifies'] = $r[0]->nb ?? 0;
        $r = $this->model->query("SELECT COUNT(*) as nb FROM avis WHERE est_verifie = 1");
        $counts['verifies'] = $r[0]->nb ?? 0;

        // Note moyenne globale
        $r = $this->model->query("SELECT ROUND(AVG(note_globale), 1) as moy FROM avis WHERE est_verifie = 1");
        $note_moyenne = $r[0]->moy ?? 0;

        $this->view('admin/avis/index', [
            'avis'         => $avis,
            'total'        => $total,
            'total_pages'  => $total_pages,
            'page'         => $page,
            'counts'       => $counts,
            'note_moyenne' => $note_moyenne,
            'badges'       => $this->getBadges(),
            'filters'      => compact('filtre', 'search'),
        ]);
    }

    // =========================================================
    //  DÉTAIL
    // =========================================================
    public function show($id) {
        $result = $this->model->query(
            "SELECT a.*,
                    u.nom as voyageur_nom, u.prenom as voyageur_prenom, u.email as voyageur_email,
                    h.nom as hebergement_nom,
                    v.nom as ville_nom
             FROM avis a
             JOIN utilisateur u ON a.voyageur_id = u.id
             JOIN hebergement h ON a.hebergement_id = h.id
             JOIN ville v ON h.ville_id = v.id
             WHERE a.id = ? LIMIT 1",
            [$id]
        );

        if (empty($result)) {
            $_SESSION['error'] = "Avis introuvable.";
            $this->redirect('/admin/avis');
        }

        $this->view('admin/avis/show', [
            'avis'   => $result[0],
            'badges' => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  VÉRIFIER
    // =========================================================
    public function verifier($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/avis');
        }
        $this->model->query("UPDATE avis SET est_verifie = 1, signalement = 0 WHERE id = ?", [$id]);
        $_SESSION['success'] = "Avis vérifié et publié.";
        $this->redirect('/admin/avis/' . $id);
    }

    // =========================================================
    //  SUPPRIMER
    // =========================================================
    public function supprimer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/avis');
        }
        $this->model->query("DELETE FROM avis WHERE id = ?", [$id]);
        $_SESSION['success'] = "Avis supprimé.";
        $this->redirect('/admin/avis');
    }

    // =========================================================
    //  REJETER SIGNALEMENT (garder l'avis mais retirer le flag)
    // =========================================================
    public function rejeterSignalement($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/avis');
        }
        $this->model->query("UPDATE avis SET signalement = 0 WHERE id = ?", [$id]);
        $_SESSION['success'] = "Signalement rejeté — l'avis reste publié.";
        $this->redirect('/admin/avis/' . $id);
    }

    // =========================================================
    //  PRIVÉ
    // =========================================================
    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}