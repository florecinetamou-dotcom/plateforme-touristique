<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class AdminAuthController extends Controller {

    private $model;

    public function __construct() {
        $this->model = new Hebergement(); // réutilise query()
    }

    // =========================================================
    //  PAGE LOGIN
    // =========================================================
    public function loginPage() {
        // Si déjà connecté en admin → dashboard
        if ($this->estConnecteAdmin()) {
            $this->redirect('/admin/dashboard');
        }

        // Quelques stats pour le panneau gauche
        $stats = [];
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'approuve'");
        $stats['hebergements'] = $r[0]->nb ?? 0;

        $r = $this->model->query("SELECT COUNT(*) as nb FROM ville WHERE est_active = 1");
        $stats['villes'] = $r[0]->nb ?? 0;

        $r = $this->model->query("SELECT COUNT(*) as nb FROM utilisateur");
        $stats['utilisateurs'] = $r[0]->nb ?? 0;

        $this->view('admin/auth/login', ['stats' => $stats]);
    }

    // =========================================================
    //  TRAITEMENT LOGIN
    // =========================================================
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/login');
        }

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $remember = isset($_POST['remember']);

        // Validation basique
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            $_SESSION['old']   = ['email' => $email];
            $this->redirect('/admin/login');
        }

        // Recherche de l'utilisateur
        $result = $this->model->query(
            "SELECT * FROM utilisateur WHERE email = ? AND role = 'admin' LIMIT 1",
            [$email]
        );

        if (empty($result)) {
            $_SESSION['error'] = "Identifiants incorrects ou compte non administrateur.";
            $_SESSION['old']   = ['email' => $email];
            $this->redirect('/admin/login');
        }

        $user = $result[0];

        // Vérification du mot de passe
        if (!password_verify($password, $user->mot_de_passe_hash)) {
            $_SESSION['error'] = "Mot de passe incorrect.";
            $_SESSION['old']   = ['email' => $email];
            $this->redirect('/admin/login');
        }

        // Vérifier que le compte est bien vérifié
        if (!$user->est_verifie) {
            $_SESSION['error'] = "Ce compte n'est pas encore activé.";
            $this->redirect('/admin/login');
        }

        // ── Connexion réussie ──
        $this->connecterAdmin($user, $remember);

        // Mettre à jour la dernière connexion
        $this->model->query(
            "UPDATE utilisateur SET derniere_connexion = NOW() WHERE id = ?",
            [$user->id]
        );

        $this->redirect('/admin/dashboard');
    }

    // =========================================================
    //  LOGOUT
    // =========================================================
    public function logout() {
        unset(
            $_SESSION['user_id'],
            $_SESSION['user_nom'],
            $_SESSION['user_prenom'],
            $_SESSION['user_email'],
            $_SESSION['user_role'],
            $_SESSION['admin_logged_in']
        );

        if (isset($_COOKIE['admin_remember'])) {
            setcookie('admin_remember', '', time() - 3600, '/', '', true, true);
        }

        $this->redirect('/admin/login');
    }

    // =========================================================
    //  MÉTHODES PRIVÉES
    // =========================================================

    private function connecterAdmin(object $user, bool $remember): void {
        session_regenerate_id(true);

        $_SESSION['user_id']         = $user->id;
        $_SESSION['user_nom']        = $user->nom;
        $_SESSION['user_prenom']     = $user->prenom;
        $_SESSION['user_email']      = $user->email;
        $_SESSION['user_role']       = $user->role;
        $_SESSION['admin_logged_in'] = true;

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->model->query(
                "UPDATE utilisateur SET token_reinitialisation = ?, token_expiration = DATE_ADD(NOW(), INTERVAL 30 DAY) WHERE id = ?",
                [$token, $user->id]
            );
            setcookie('admin_remember', $token, time() + (30 * 24 * 3600), '/', '', true, true);
        }
    }

    private function estConnecteAdmin(): bool {
        return isset($_SESSION['admin_logged_in'])
            && $_SESSION['admin_logged_in'] === true
            && ($_SESSION['user_role'] ?? '') === 'admin';
    }
}