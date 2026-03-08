<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class UserAdminController extends Controller {

    private $model;
    const PER_PAGE = 20;

    public function __construct() {
        $this->requireAuth('admin');
        $this->model = new Hebergement(); // réutilise query()
    }

    // =========================================================
    //  LISTE
    // =========================================================
    public function index() {
        $role    = $_GET['role']    ?? 'tous';
        $search  = trim($_GET['search']  ?? '');
        $verifie = $_GET['verifie'] ?? '';
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $offset  = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($role !== 'tous') {
            $where   .= " AND role = ?";
            $params[] = $role;
        }
        if ($search !== '') {
            $where   .= " AND (nom LIKE ? OR prenom LIKE ? OR email LIKE ?)";
            $like     = "%$search%";
            $params   = array_merge($params, [$like, $like, $like]);
        }
        if ($verifie !== '') {
            $where   .= " AND est_verifie = ?";
            $params[] = (int)$verifie;
        }

        $total_res   = $this->model->query("SELECT COUNT(*) as total FROM utilisateur $where", $params);
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $utilisateurs = $this->model->query(
            "SELECT id, nom, prenom, email, role, telephone, est_verifie, date_inscription, derniere_connexion
             FROM utilisateur $where
             ORDER BY date_inscription DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        $counts  = ['tous' => 0, 'voyageur' => 0, 'hebergeur' => 0, 'admin' => 0];
        $cnt_res = $this->model->query("SELECT role, COUNT(*) as nb FROM utilisateur GROUP BY role");
        foreach ($cnt_res as $row) {
            $counts[$row->role] = $row->nb;
            $counts['tous'] += $row->nb;
        }

        $this->view('admin/utilisateurs/index', [
            'utilisateurs' => $utilisateurs,
            'total'        => $total,
            'total_pages'  => $total_pages,
            'page'         => $page,
            'counts'       => $counts,
            'badges'       => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  DÉTAIL
    // =========================================================
    public function show($id) {
        $u = $this->getUserOuRediriger($id);

        $reservations = $this->model->query(
            "SELECT r.*, h.nom as hebergement_nom
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             WHERE r.voyageur_id = ?
             ORDER BY r.date_reservation DESC
             LIMIT 10",
            [$id]
        );

        $this->view('admin/utilisateurs/show', [
            'utilisateur'  => $u,
            'reservations' => $reservations,
            'badges'       => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  BLOQUER
    // =========================================================
    public function bloquer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }

        if ((int)$id === (int)$_SESSION['user_id']) {
            $_SESSION['error'] = "Vous ne pouvez pas bloquer votre propre compte.";
            $this->redirect('/admin/utilisateurs');
        }

        $u = $this->getUserOuRediriger($id);
        $this->model->query("UPDATE utilisateur SET est_verifie = 0 WHERE id = ?", [$id]);

        $_SESSION['success'] = "{$u->prenom} {$u->nom} a été bloqué.";
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  DÉBLOQUER
    // =========================================================
    public function debloquer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }

        $u = $this->getUserOuRediriger($id);
        $this->model->query("UPDATE utilisateur SET est_verifie = 1 WHERE id = ?", [$id]);

        $_SESSION['success'] = "{$u->prenom} {$u->nom} a été débloqué.";
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  CHANGER RÔLE
    // =========================================================
    public function changerRole($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }

        $nouveauRole  = $_POST['role'] ?? '';
        $rolesValides = ['voyageur', 'hebergeur', 'admin'];

        if (!in_array($nouveauRole, $rolesValides)) {
            $_SESSION['error'] = "Rôle invalide.";
            $this->redirect('/admin/utilisateurs');
        }

        if ((int)$id === (int)$_SESSION['user_id'] && $nouveauRole !== 'admin') {
            $_SESSION['error'] = "Vous ne pouvez pas changer votre propre rôle.";
            $this->redirect('/admin/utilisateurs');
        }

        $u = $this->getUserOuRediriger($id);
        $this->model->query("UPDATE utilisateur SET role = ? WHERE id = ?", [$nouveauRole, $id]);

        $_SESSION['success'] = "Le rôle de {$u->prenom} {$u->nom} a été changé en « $nouveauRole ».";
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  SUPPRIMER
    // =========================================================
    public function supprimer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }

        if ((int)$id === (int)$_SESSION['user_id']) {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer votre propre compte.";
            $this->redirect('/admin/utilisateurs');
        }

        $u = $this->getUserOuRediriger($id);
        $this->model->query("DELETE FROM utilisateur WHERE id = ?", [$id]);

        $_SESSION['success'] = "L'utilisateur {$u->prenom} {$u->nom} a été supprimé.";
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  PRIVÉ
    // =========================================================
    private function getUserOuRediriger(int $id): object {
        $r = $this->model->query("SELECT * FROM utilisateur WHERE id = ? LIMIT 1", [$id]);
        if (empty($r)) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            $this->redirect('/admin/utilisateurs');
        }
        return $r[0];
    }

    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}