<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Page de connexion
     */
    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleLogin();
        }
        
        $this->view('front/auth/login', [
            'title' => 'Connexion - Tourisme Bénin'
        ]);
    }
    
    /**
     * Traitement de la connexion
     */
    private function handleLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email et mot de passe requis";
            $_SESSION['old'] = ['email' => $email];
            $this->redirect('/login');
            return;
        }
        
        $user = $this->userModel->findByEmail($email);
        
        if ($user && $this->userModel->verifyPassword($password, $user->mot_de_passe_hash)) {
            // Connexion réussie
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_name'] = $user->prenom . ' ' . $user->nom;
            $_SESSION['user_email'] = $user->email;
            
            $_SESSION['success'] = "Connexion réussie ! Bienvenue " . $user->prenom;
            
            // Redirection selon le rôle
            if ($user->role === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/');
            }
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            $_SESSION['old'] = ['email' => $email];
            $this->redirect('/login');
        }
    }
    
    /**
     * Page d'inscription
     */
    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleRegister();
        }
        
        $this->view('front/auth/register', [
            'title' => 'Inscription - Tourisme Bénin'
        ]);
    }
    
    /**
     * Traitement de l'inscription
     */
    private function handleRegister() {
        // Récupération des données
        $data = [
            'prenom' => trim($_POST['prenom'] ?? ''),
            'nom' => trim($_POST['nom'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'telephone' => trim($_POST['telephone'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'role' => $_POST['role'] ?? 'voyageur'
        ];
        
        // Validation
        $errors = [];
        
        if (empty($data['prenom'])) $errors[] = "Le prénom est requis";
        if (empty($data['nom'])) $errors[] = "Le nom est requis";
        if (empty($data['email'])) $errors[] = "L'email est requis";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
        if (strlen($data['password']) < 6) $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
        if ($data['password'] !== $data['password_confirm']) $errors[] = "Les mots de passe ne correspondent pas";
        
        // Vérifier si l'email existe déjà
        if (empty($errors)) {
            $existingUser = $this->userModel->findByEmail($data['email']);
            if ($existingUser) {
                $errors[] = "Cet email est déjà utilisé";
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $data;
            $this->redirect('/register');
            return;
        }
        
        // Créer l'utilisateur
        $userData = [
            'email' => $data['email'],
            'password' => $this->userModel->hashPassword($data['password']),
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'role' => $data['role']
        ];
        
        $userId = $this->userModel->createUser($userData);
        
        if ($userId) {
            $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        $_SESSION = [];
        session_start();
        $_SESSION['success'] = "Vous avez été déconnecté";
        $this->redirect('/');
    }
}