<?php
<<<<<<< HEAD

=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\User;

<<<<<<< HEAD
class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // ════════════════════════════════════════
    // LOGIN
    // ════════════════════════════════════════
    public function login()
    {
        if (isset($_SESSION['user'])) {
=======
class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // ════════════════════════════════════════════════
    // CONNEXION
    // ════════════════════════════════════════════════
    public function login() {
        if (isset($_SESSION['user_id'])) {
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleLogin();
        }

        $this->view('front/auth/login', [
            'title' => 'Connexion - BeninExplore'
        ]);
    }

<<<<<<< HEAD
    private function handleLogin()
    {
        $email    = $_POST['email'] ?? '';
=======
    private function handleLogin() {
        $email    = $_POST['email']    ?? '';
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email et mot de passe requis";
<<<<<<< HEAD
            $_SESSION['old'] = ['email' => $email];
=======
            $_SESSION['old']   = ['email' => $email];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $this->redirect('/login');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && $this->userModel->verifyPassword($password, $user->mot_de_passe_hash)) {
<<<<<<< HEAD

            // ✅ Session unifiée — compatible navbar ET DashboardController
            $_SESSION['user'] = [
                'id'     => $user->id,
                'role'   => $user->role,
                'name'   => $user->prenom . ' ' . $user->nom,
                'email'  => $user->email,
                'prenom' => $user->prenom,
                'nom'    => $user->nom,
                'avatar' => $user->avatar_url ?? null,
            ];

            // ✅ Aliases pour les contrôleurs qui utilisent $_SESSION['user_id'] etc.
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $_SESSION['user_id']    = $user->id;
            $_SESSION['user_role']  = $user->role;
            $_SESSION['user_name']  = $user->prenom . ' ' . $user->nom;
            $_SESSION['user_email'] = $user->email;
<<<<<<< HEAD

            $_SESSION['success'] = "Connexion réussie ! Bienvenue " . $user->prenom;
=======
            $_SESSION['success']    = "Connexion réussie ! Bienvenue " . $user->prenom;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

            if ($user->role === 'admin') {
                $this->redirect('/admin/dashboard');
            } elseif ($user->role === 'hebergeur') {
                $this->redirect('/hebergeur/dashboard');
            } else {
                $this->redirect('/');
            }
<<<<<<< HEAD

        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            $_SESSION['old'] = ['email' => $email];
=======
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            $_SESSION['old']   = ['email' => $email];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $this->redirect('/login');
        }
    }

<<<<<<< HEAD
    // ════════════════════════════════════════
    // REGISTER
    // ════════════════════════════════════════
    public function register()
    {
        if (isset($_SESSION['user'])) {
=======
    // ════════════════════════════════════════════════
    // INSCRIPTION
    // ════════════════════════════════════════════════
    public function register() {
        if (isset($_SESSION['user_id'])) {
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleRegister();
        }

        $this->view('front/auth/register', [
            'title' => 'Inscription - BeninExplore'
        ]);
    }

<<<<<<< HEAD
    private function handleRegister()
    {
        $data = [
            'prenom'    => trim($_POST['prenom'] ?? ''),
            'nom'       => trim($_POST['nom'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'telephone' => trim($_POST['telephone'] ?? ''),
            'password'  => $_POST['password'] ?? '',
            'confirm'   => $_POST['password_confirm'] ?? '',
            'role'      => $_POST['role'] ?? 'voyageur',
        ];

        $errors = [];

        if (!$data['prenom']) $errors[] = "Prénom requis";
        if (!$data['nom'])    $errors[] = "Nom requis";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
        if (strlen($data['password']) < 6)                      $errors[] = "Mot de passe trop court (min 6 caractères)";
        if ($data['password'] !== $data['confirm'])             $errors[] = "Les mots de passe ne correspondent pas";

        if ($this->userModel->findByEmail($data['email'])) {
            $errors[] = "Email déjà utilisé";
        }

        if ($errors) {
=======
    private function handleRegister() {
        $data = [
            'prenom'           => trim($_POST['prenom']           ?? ''),
            'nom'              => trim($_POST['nom']              ?? ''),
            'email'            => trim($_POST['email']            ?? ''),
            'telephone'        => trim($_POST['telephone']        ?? ''),
            'password'         => $_POST['password']              ?? '',
            'password_confirm' => $_POST['password_confirm']      ?? '',
            'role'             => $_POST['role']                  ?? 'voyageur',
        ];

        $errors = [];
        if (empty($data['prenom']))                                  $errors[] = "Le prénom est requis";
        if (empty($data['nom']))                                     $errors[] = "Le nom est requis";
        if (empty($data['email']))                                   $errors[] = "L'email est requis";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))     $errors[] = "Email invalide";
        if (strlen($data['password']) < 6)                          $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
        if ($data['password'] !== $data['password_confirm'])        $errors[] = "Les mots de passe ne correspondent pas";

        if (empty($errors) && $this->userModel->findByEmail($data['email'])) {
            $errors[] = "Cet email est déjà utilisé";
        }

        if (!empty($errors)) {
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old']   = $data;
            $this->redirect('/register');
            return;
        }

<<<<<<< HEAD
        $role = in_array($data['role'], ['voyageur', 'hebergeur']) ? $data['role'] : 'voyageur';

        $userId = $this->userModel->createUser([
            'prenom'    => $data['prenom'],
            'nom'       => $data['nom'],
            'email'     => $data['email'],
            'telephone' => $data['telephone'],
            'password'  => $this->userModel->hashPassword($data['password']),
            'role'      => $role,
        ]);

        if ($userId) {
            $_SESSION['success'] = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        } else {
            $_SESSION['error'] = "Erreur lors de la création du compte";
        }

        $this->redirect('/login');
    }

    // ════════════════════════════════════════
    // FORGOT PASSWORD
    // ════════════════════════════════════════
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleForgotPassword();
        }

        $this->view('front/auth/forgot_password', [
            'title' => 'Mot de passe oublié - BeninExplore'
        ]);
    }

    private function handleForgotPassword()
    {
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['error'] = "Email requis";
            $this->redirect('/forgot_password');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $token      = bin2hex(random_bytes(32));
            $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->userModel->update($user->id, [
                'token_reinitialisation' => $token,
                'token_expiration'       => $expiration,
            ]);

            // Dev : afficher le lien en session
            $_SESSION['info'] = "Lien : http://" . $_SERVER['HTTP_HOST'] . "/reset_password?token=" . $token;
        }

        $_SESSION['success'] = "Si cet email existe, vous recevrez un lien de réinitialisation.";
        $this->redirect('/login');
    }

    // ════════════════════════════════════════
    // RESET PASSWORD
    // ════════════════════════════════════════
    public function resetPassword()
    {
=======
        $userId = $this->userModel->createUser([
            'email'     => $data['email'],
            'password'  => $this->userModel->hashPassword($data['password']),
            'nom'       => $data['nom'],
            'prenom'    => $data['prenom'],
            'telephone' => $data['telephone'],
            'role'      => $data['role'],
        ]);

        if ($userId) {
            $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            $_SESSION['old']   = $data;
            $this->redirect('/register');
        }
    }

    // ════════════════════════════════════════════════
    // MOT DE PASSE OUBLIÉ
    // ════════════════════════════════════════════════
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ??    '');
            $errors = [];

            if (empty($email)) {
                $errors['email'] = "L'email est requis";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Adresse email invalide";
            }

            if (empty($errors)) {
                $user = $this->userModel->findByEmail($email);

                if ($user) {
                    // Générer un token sécurisé
                    $token     = bin2hex(random_bytes(32));
                    $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    // Sauvegarder le token en BDD
                    $this->userModel->update($user->id, [
                        'token_reinitialisation' => $token,
                        'token_expiration'       => $expiration,
                    ]);

                    // ── En production : envoyer l'email ──
                    // $resetLink = 'http://tourisme_benin.test/reset-password?token=' . $token;
                    // mail($email, 'Réinitialisation mot de passe', "Lien : $resetLink");

                    // Pour le développement : afficher le lien en session
                    $_SESSION['dev_reset_token'] = $token;
                }

                // Message générique (sécurité : ne pas révéler si l'email existe)
                $this->view('front/auth/forgot_password', [
                    'title'   => 'Mot de passe oublié - BeninExplore',
                    'success' => true,
                    'errors'  => [],
                ]);
                return;
            }

            $this->view('front/auth/forgot_password', [
                'title'   => 'Mot de passe oublié - BeninExplore',
                'success' => false,
                'errors'  => $errors,
            ]);
            return;
        }

        $this->view('front/auth/forgot_password', [
            'title'   => 'Mot de passe oublié - BeninExplore',
            'success' => false,
            'errors'  => [],
        ]);
    }

    // ════════════════════════════════════════════════
    // RÉINITIALISATION DU MOT DE PASSE
    // ════════════════════════════════════════════════
    public function resetPassword() {
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $token = $_GET['token'] ?? $_POST['token'] ?? '';

        if (empty($token)) {
            $_SESSION['error'] = "Lien invalide ou expiré";
<<<<<<< HEAD
            $this->redirect('/forgot_password');
            return;
        }

=======
            $this->redirect('/forgot-password');
        }

        // Vérifier le token en BDD
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $users = $this->userModel->query(
            "SELECT * FROM utilisateur
             WHERE token_reinitialisation = ?
             AND token_expiration > NOW()
             LIMIT 1",
            [$token]
        );
<<<<<<< HEAD

        $user = $users[0] ?? null;

        if (!$user) {
            $_SESSION['error'] = "Ce lien est invalide ou a expiré.";
            $this->redirect('/forgot_password');
            return;
=======
        $user = $users[0] ?? null;

        if (!$user) {
            $_SESSION['error'] = "Ce lien est invalide ou a expiré. Veuillez recommencer.";
            $this->redirect('/forgot-password');
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new     = $_POST['new_password']     ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $errors  = [];

<<<<<<< HEAD
            if (strlen($new) < 6)  $errors[] = "Mot de passe trop court (min 6 caractères)";
            if ($new !== $confirm)  $errors[] = "Les mots de passe ne correspondent pas";
=======
            if (strlen($new) < 6)      $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
            if ($new !== $confirm)     $errors[] = "Les mots de passe ne correspondent pas";
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

            if (empty($errors)) {
                $this->userModel->update($user->id, [
                    'mot_de_passe_hash'      => $this->userModel->hashPassword($new),
                    'token_reinitialisation' => null,
                    'token_expiration'       => null,
                ]);

<<<<<<< HEAD
                $_SESSION['success'] = "Mot de passe réinitialisé avec succès !";
                $this->redirect('/login');
                return;
            }

            $this->view('front/auth/reset_password', [
                'title'  => 'Réinitialisation du mot de passe',
=======
                $_SESSION['success'] = "Mot de passe réinitialisé avec succès ! Vous pouvez vous connecter.";
                $this->redirect('/login');
            }

            $this->view('front/auth/reset_password', [
                'title'  => 'Nouveau mot de passe - BeninExplore',
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                'token'  => $token,
                'errors' => $errors,
            ]);
            return;
        }

        $this->view('front/auth/reset_password', [
<<<<<<< HEAD
            'title'  => 'Réinitialisation du mot de passe',
=======
            'title'  => 'Nouveau mot de passe - BeninExplore',
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            'token'  => $token,
            'errors' => [],
        ]);
    }

<<<<<<< HEAD
    // ════════════════════════════════════════
    // LOGOUT
    // ════════════════════════════════════════
    public function logout()
    {
        // ✅ Supprimer toutes les clés de session utilisateur
        unset(
            $_SESSION['user'],
            $_SESSION['user_id'],
            $_SESSION['user_role'],
            $_SESSION['user_name'],
            $_SESSION['user_email']
        );

        $_SESSION['success'] = "Déconnexion réussie";
=======
    // ════════════════════════════════════════════════
    // DÉCONNEXION
    // ════════════════════════════════════════════════
    public function logout() {
        session_destroy();
        $_SESSION = [];
        session_start();
        $_SESSION['success'] = "Vous avez été déconnecté avec succès.";
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $this->redirect('/');
    }
}