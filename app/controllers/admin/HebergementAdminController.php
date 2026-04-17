<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;
use App\Models\TypeHebergement;

class HebergementAdminController extends Controller {

    private $hModel;
    const PER_PAGE = 15;

    public function __construct() {
        $this->requireAuth('admin');
        $this->hModel = new Hebergement();
    }

    // =========================================================
    //  LISTE avec filtres + pagination
    // =========================================================
    public function index() {
        $statut   = $_GET['statut']   ?? 'tous';
        $search   = trim($_GET['search']   ?? '');
        $ville_id = $_GET['ville_id'] ?? '';
        $type_id  = $_GET['type_id']  ?? '';
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $offset   = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($statut !== 'tous') {
            $where   .= " AND h.statut = ?";
            $params[] = $statut;
        }
        if (!empty($search)) {
            $where   .= " AND (h.nom LIKE ? OR v.nom LIKE ? OR u.prenom LIKE ? OR u.nom LIKE ?)";
            $like     = "%$search%";
            $params   = array_merge($params, [$like, $like, $like, $like]);
        }
        if (!empty($ville_id)) {
            $where   .= " AND h.ville_id = ?";
            $params[] = $ville_id;
        }
        if (!empty($type_id)) {
            $where   .= " AND h.type_id = ?";
            $params[] = $type_id;
        }

        $base_sql = "FROM hebergement h
                     JOIN ville v ON h.ville_id = v.id
                     LEFT JOIN type_hebergement t ON h.type_id = t.id
                     LEFT JOIN utilisateur u ON h.hebergeur_id = u.id
                     LEFT JOIN photo_hebergement ph ON ph.hebergement_id = h.id AND ph.est_principale = 1
                     $where";

        $count_res   = $this->hModel->query("SELECT COUNT(DISTINCT h.id) as total $base_sql", $params);
        $total       = $count_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $hebergements = $this->hModel->query(
            "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                    u.nom as hebergeur_nom, u.prenom as hebergeur_prenom, u.email as hebergeur_email,
                    ANY_VALUE(ph.url) as photo
             $base_sql
             GROUP BY h.id, v.nom, t.nom, u.nom, u.prenom, u.email
             ORDER BY h.date_creation DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        $counts  = ['tous' => 0, 'en_attente' => 0, 'approuve' => 0, 'rejete' => 0, 'suspendu' => 0];
        $cnt_res = $this->hModel->query("SELECT statut, COUNT(*) as nb FROM hebergement GROUP BY statut");
        foreach ($cnt_res as $row) {
            $counts[$row->statut] = $row->nb;
            $counts['tous'] += $row->nb;
        }

        $villeModel = new Ville();
        $typeModel  = new TypeHebergement();
        $badges     = ['nb_hebergements_attente' => $counts['en_attente']];

        $this->view('admin/hebergements/index', [
            'hebergements' => $hebergements,
            'total'        => $total,
            'total_pages'  => $total_pages,
            'page'         => $page,
            'counts'       => $counts,
            'villes'       => $villeModel->getActive(),
            'types'        => $typeModel->all(),
            'badges'       => $badges,
        ]);
    }

    // =========================================================
    //  VALIDER
    // =========================================================
    public function valider($id) {
        $this->changerStatut($id, 'approuve', 'approuvé');
    }

    // =========================================================
    //  REJETER
    // =========================================================
    public function rejeter($id) {
        $this->changerStatut($id, 'rejete', 'rejeté');
    }

    // =========================================================
    //  SUSPENDRE
    // =========================================================
    public function suspendre($id) {
        $this->changerStatut($id, 'suspendu', 'suspendu');
    }

    // =========================================================
    //  SUPPRIMER
    // =========================================================
    public function supprimer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/hebergements');
        }

        $heb = $this->getHebergementOuRediriger($id);

        $photos = $this->hModel->query(
            "SELECT url FROM photo_hebergement WHERE hebergement_id = ?", [$id]
        );
        foreach ($photos as $p) {
            $chemin = 'public' . $p->url;
            if (file_exists($chemin)) unlink($chemin);
        }

        $this->hModel->query("DELETE FROM hebergement WHERE id = ?", [$id]);

        $_SESSION['success'] = "L'hébergement \"{$heb->nom}\" a été supprimé.";
        $this->redirect('/admin/hebergements');
    }

    // =========================================================
    //  DÉTAIL
    // =========================================================
    public function show($id) {
        $result = $this->hModel->query(
            "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                    u.nom as hebergeur_nom, u.prenom as hebergeur_prenom, u.email as hebergeur_email
             FROM hebergement h
             JOIN ville v ON h.ville_id = v.id
             LEFT JOIN type_hebergement t ON h.type_id = t.id
             LEFT JOIN utilisateur u ON h.hebergeur_id = u.id
             WHERE h.id = ?",
            [$id]
        );

        if (empty($result)) {
            $_SESSION['error'] = "Hébergement introuvable.";
            $this->redirect('/admin/hebergements');
        }

        $hebergement = $result[0];

        // Photo principale
        $pp = $this->hModel->query(
            "SELECT * FROM photo_hebergement WHERE hebergement_id = ? AND est_principale = 1 LIMIT 1",
            [$id]
        );
        // Si aucune principale, prendre la première
        if (empty($pp)) {
            $pp = $this->hModel->query(
                "SELECT * FROM photo_hebergement WHERE hebergement_id = ? ORDER BY ordre ASC LIMIT 1",
                [$id]
            );
        }
        $photoPrincipale = $pp[0] ?? null;

        // 3 autres photos
        $autresPhotos = $this->hModel->query(
            "SELECT * FROM photo_hebergement
             WHERE hebergement_id = ? AND est_principale = 0
             ORDER BY ordre ASC LIMIT 3",
            [$id]
        );

        $badges = $this->getBadges();

        $this->view('admin/hebergements/show', [
            'hebergement'    => $hebergement,
            'photoPrincipale'=> $photoPrincipale,
            'autresPhotos'   => $autresPhotos,
            'badges'         => $badges,
        ]);
    }

    // =========================================================
    //  MÉTHODES PRIVÉES
    // =========================================================

    private function changerStatut(int $id, string $statut, string $label): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/hebergements');
        }

        $heb = $this->getHebergementOuRediriger($id);

        $this->hModel->query(
            "UPDATE hebergement SET statut = ? WHERE id = ?",
            [$statut, $id]
        );

        $_SESSION['success'] = "L'hébergement \"{$heb->nom}\" a été $label avec succès.";
        $this->redirect('/admin/hebergements');
    }

    private function getHebergementOuRediriger(int $id): object {
        $result = $this->hModel->query(
            "SELECT * FROM hebergement WHERE id = ? LIMIT 1", [$id]
        );
        if (empty($result)) {
            $_SESSION['error'] = "Hébergement introuvable.";
            $this->redirect('/admin/hebergements');
        }
        return $result[0];
    }

    private function getBadges(): array {
        $r = $this->hModel->query(
            "SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'"
        );
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}