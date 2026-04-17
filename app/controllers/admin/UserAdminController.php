<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\User;

class UserAdminController extends Controller
{

    private $model;
    private $userModel;
    const PER_PAGE = 20;

    public function __construct()
    {
        $this->requireAuth('admin');
        $this->model = new Hebergement();
        $this->userModel = new User();
    }

    // =========================================================
    //  LISTE DES UTILISATEURS
    // =========================================================
    public function index()
    {
        $role = $_GET['role'] ?? 'tous';
        $search = trim($_GET['search'] ?? '');
        $verifie = $_GET['verifie'] ?? '';
<<<<<<< HEAD
        $newsletter = $_GET['newsletter'] ?? '';  // ✅ AJOUTÉ
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;

        $where = "WHERE 1=1";
        $params = [];

        if ($role !== 'tous') {
            $where .= " AND role = ?";
            $params[] = $role;
        }
        if ($search !== '') {
            $where .= " AND (nom LIKE ? OR prenom LIKE ? OR email LIKE ?)";
            $like = "%$search%";
            $params = array_merge($params, [$like, $like, $like]);
        }
        if ($verifie !== '') {
            $where .= " AND est_verifie = ?";
            $params[] = (int) $verifie;
        }
<<<<<<< HEAD
        // ✅ AJOUTÉ : Filtre newsletter
        if ($newsletter !== '') {
            $where .= " AND newsletter = ?";
            $params[] = (int) $newsletter;
        }
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

        $total_res = $this->model->query("SELECT COUNT(*) as total FROM utilisateur $where", $params);
        $total = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $utilisateurs = $this->model->query(
            "SELECT id, nom, prenom, email, role, telephone, est_verifie, est_bloque,
<<<<<<< HEAD
                    statut_hebergeur, date_inscription, derniere_connexion, newsletter
=======
                    statut_hebergeur, date_inscription, derniere_connexion
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
             FROM utilisateur $where
             ORDER BY date_inscription DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

<<<<<<< HEAD
        // ✅ AJOUTÉ : Compteur newsletter
        $counts = ['tous' => 0, 'voyageur' => 0, 'hebergeur' => 0, 'admin' => 0, 'newsletter' => 0];
=======
        $counts = ['tous' => 0, 'voyageur' => 0, 'hebergeur' => 0, 'admin' => 0];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $cnt_res = $this->model->query("SELECT role, COUNT(*) as nb FROM utilisateur GROUP BY role");
        foreach ($cnt_res as $row) {
            $counts[$row->role] = $row->nb;
            $counts['tous'] += $row->nb;
        }
<<<<<<< HEAD
        
        // ✅ AJOUTÉ : Compter les inscrits à la newsletter
        $newsletterCount = $this->model->query("SELECT COUNT(*) as nb FROM utilisateur WHERE newsletter = 1");
        $counts['newsletter'] = $newsletterCount[0]->nb ?? 0;
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

        $this->view('admin/utilisateurs/index', [
            'utilisateurs' => $utilisateurs,
            'total' => $total,
            'total_pages' => $total_pages,
            'page' => $page,
            'counts' => $counts,
            'badges' => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  DÉTAIL D'UN UTILISATEUR
    // =========================================================
    public function show($id)
    {
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
            'utilisateur' => $u,
            'reservations' => $reservations,
            'badges' => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  BLOQUER UN UTILISATEUR
    // =========================================================
    public function bloquer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }
        if ((int) $id === (int) $_SESSION['user_id']) {
            $_SESSION['error'] = "Vous ne pouvez pas bloquer votre propre compte.";
            $this->redirect('/admin/utilisateurs');
        }
        $u = $this->getUserOuRediriger($id);
        
        $this->model->query("UPDATE utilisateur SET est_bloque = 1 WHERE id = ?", [$id]);
        
        // Si c'est un hébergeur, mettre aussi son statut à bloqué
        if ($u->role === 'hebergeur') {
            $this->userModel->updateHebergeurStatus($id, 'bloque');
        }

        $_SESSION['success'] = "{$u->prenom} {$u->nom} a été bloqué.";
        $this->redirect('/admin/utilisateurs');
    }

    public function debloquer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }
        $u = $this->getUserOuRediriger($id);
        
        $this->model->query("UPDATE utilisateur SET est_bloque = 0 WHERE id = ?", [$id]);
        
        // Si c'est un hébergeur actif, remettre son statut à actif
        if ($u->role === 'hebergeur' && $u->statut_hebergeur === 'actif') {
            $this->userModel->updateHebergeurStatus($id, 'actif');
        }

        $_SESSION['success'] = "{$u->prenom} {$u->nom} a été débloqué.";
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  VALIDER UN HÉBERGEUR
    // =========================================================
    public function validerHebergeur($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
            return;
        }
        
        $user = $this->getUserOuRediriger($id);
        
        if (!$user || $user->role !== 'hebergeur') {
            $_SESSION['error'] = "Cet utilisateur n'est pas un hébergeur.";
            $this->redirect('/admin/utilisateurs');
            return;
        }
        
        // Mettre à jour le statut
        $result = $this->userModel->updateHebergeurStatus($id, 'actif');
        
        if ($result) {
            $_SESSION['success'] = "L'hébergeur {$user->prenom} {$user->nom} a été validé.";
            $this->sendActivationEmail($user);
        } else {
            $_SESSION['error'] = "Erreur lors de la validation.";
        }
        
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  REFUSER UN HÉBERGEUR
    // =========================================================
    public function refuserHebergeur($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
            return;
        }
        
        $user = $this->getUserOuRediriger($id);
        
        if (!$user || $user->role !== 'hebergeur') {
            $_SESSION['error'] = "Cet utilisateur n'est pas un hébergeur.";
            $this->redirect('/admin/utilisateurs');
            return;
        }
        
        // Bloquer l'hébergeur
        $result = $this->userModel->updateHebergeurStatus($id, 'bloque');
        
        if ($result) {
            $_SESSION['success'] = "L'hébergeur {$user->prenom} {$user->nom} a été refusé.";
        } else {
            $_SESSION['error'] = "Erreur lors du refus.";
        }
        
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  CHANGER RÔLE
    // =========================================================
    public function changerRole($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }

        $nouveauRole = $_POST['role'] ?? '';
        $rolesValides = ['voyageur', 'hebergeur', 'admin'];

        if (!in_array($nouveauRole, $rolesValides)) {
            $_SESSION['error'] = "Rôle invalide.";
            $this->redirect('/admin/utilisateurs');
        }

        if ((int) $id === (int) $_SESSION['user_id'] && $nouveauRole !== 'admin') {
            $_SESSION['error'] = "Vous ne pouvez pas changer votre propre rôle.";
            $this->redirect('/admin/utilisateurs');
        }

        $u = $this->getUserOuRediriger($id);
        
        // Si on change en hébergeur, mettre le statut en attente
        if ($nouveauRole === 'hebergeur') {
            $this->model->query("UPDATE utilisateur SET role = ?, statut_hebergeur = 'en_attente' WHERE id = ?", [$nouveauRole, $id]);
        } else {
            $this->model->query("UPDATE utilisateur SET role = ?, statut_hebergeur = NULL WHERE id = ?", [$nouveauRole, $id]);
        }

        $_SESSION['success'] = "Le rôle de {$u->prenom} {$u->nom} a été changé en « $nouveauRole ».";
        $this->redirect('/admin/utilisateurs');
    }

    // =========================================================
    //  SUPPRIMER UN UTILISATEUR
    // =========================================================
    public function supprimer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/utilisateurs');
        }

        if ((int) $id === (int) $_SESSION['user_id']) {
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
    private function getUserOuRediriger(int $id): object
    {
        $r = $this->model->query("SELECT * FROM utilisateur WHERE id = ? LIMIT 1", [$id]);
        if (empty($r)) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            $this->redirect('/admin/utilisateurs');
        }
        return $r[0];
    }

    private function getBadges(): array
    {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
    
    private function sendActivationEmail($user)
    {
        $subject = "Votre compte hébergeur sur BeninExplore est activé";
        $message = "Bonjour {$user->prenom} {$user->nom},\n\n";
        $message .= "Félicitations ! Votre demande de compte hébergeur a été approuvée.\n";
        $message .= "Vous pouvez maintenant :\n";
        $message .= "- Gérer vos hébergements\n";
        $message .= "- Ajouter de nouvelles offres\n";
        $message .= "- Suivre vos réservations\n\n";
        $message .= "Connectez-vous à votre espace : https://beninexplore.com/hebergeur/dashboard\n\n";
        $message .= "Cordialement,\nL'équipe BeninExplore";
        
        mail($user->email, $subject, $message, "From: no-reply@beninexplore.com\r\n");
    }
}