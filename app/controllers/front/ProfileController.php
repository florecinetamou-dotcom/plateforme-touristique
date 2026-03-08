<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\User;

class ProfileController extends Controller {
    
    private $userModel;
    
    public function __construct() {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à votre profil";
            $this->redirect('/login');
        }
        
        $this->userModel = new User();
    }
    
    /**
     * Afficher le profil
     */
    public function index() {
        $user = $this->userModel->find($_SESSION['user_id']);
        
        $this->view('front/profile/index', [
            'title' => 'Mon profil - Tourisme Bénin',
            'user' => $user
        ]);
    }
    
    /**
     * Modifier le profil
     */
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEdit();
        }
        
        $user = $this->userModel->find($_SESSION['user_id']);
        
        $this->view('front/profile/edit', [
            'title' => 'Modifier mon profil - Tourisme Bénin',
            'user' => $user
        ]);
    }
    
    /**
     * Traitement de la modification
     */
    private function handleEdit() {
        $data = [
            'prenom' => $_POST['prenom'] ?? '',
            'nom' => $_POST['nom'] ?? '',
            'telephone' => $_POST['telephone'] ?? '',
            'langue_preferee' => $_POST['langue'] ?? 'fr',
            'newsletter' => isset($_POST['newsletter']) ? 1 : 0
        ];
        
        $errors = [];
        if (empty($data['prenom'])) $errors[] = "Le prénom est requis";
        if (empty($data['nom'])) $errors[] = "Le nom est requis";
        
        if (empty($errors)) {
            $updated = $this->userModel->update($_SESSION['user_id'], $data);
            
            if ($updated) {
                $_SESSION['user_name'] = $data['prenom'] . ' ' . $data['nom'];
                $_SESSION['success'] = "Profil mis à jour avec succès";
                $this->redirect('/profile');
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour";
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
        }
        
        $this->redirect('/profile/edit');
    }
    
    /**
     * Changer le mot de passe
     */
    public function password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePassword();
        }
        
        $this->view('front/profile/password', [
            'title' => 'Changer mon mot de passe - Tourisme Bénin'
        ]);
    }
    
    /**
     * Traitement du changement de mot de passe
     */
    private function handlePassword() {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        if (empty($current)) $errors[] = "Le mot de passe actuel est requis";
        if (strlen($new) < 6) $errors[] = "Le nouveau mot de passe doit contenir au moins 6 caractères";
        if ($new !== $confirm) $errors[] = "Les mots de passe ne correspondent pas";
        
        if (empty($errors)) {
            $user = $this->userModel->find($_SESSION['user_id']);
            
            if ($this->userModel->verifyPassword($current, $user->mot_de_passe_hash)) {
                $updated = $this->userModel->update($_SESSION['user_id'], [
                    'mot_de_passe_hash' => $this->userModel->hashPassword($new)
                ]);
                
                if ($updated) {
                    $_SESSION['success'] = "Mot de passe changé avec succès";
                    $this->redirect('/profile');
                } else {
                    $_SESSION['error'] = "Erreur lors du changement";
                }
            } else {
                $_SESSION['error'] = "Mot de passe actuel incorrect";
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
        }
        
        $this->redirect('/profile/password');
    }
}