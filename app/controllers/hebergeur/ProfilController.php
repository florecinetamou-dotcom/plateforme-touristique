<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\User;
use App\Models\ProfilHebergeur;
use App\Middleware\HebergeurMiddleware;

class ProfilController extends Controller {
    
    private $userModel;
    private $profilModel;
    
    public function __construct() {
        HebergeurMiddleware::check();
        $this->userModel = new User();
        $this->profilModel = new ProfilHebergeur();
    }
    
    /**
     * Afficher le profil
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        
        $user = $this->userModel->find($userId);
        $profil = $this->profilModel->find($userId);
        
        $this->view('hebergeur/profil/index', [
            'title' => 'Mon profil - BeninExplore',
            'user' => $user,
            'profil' => $profil
        ]);
    }
    
    /**
     * Modifier le profil
     */
    public function edit() {
        $userId = $_SESSION['user_id'];
        
        $user = $this->userModel->find($userId);
        $profil = $this->profilModel->find($userId);
        
        $this->view('hebergeur/profil/edit', [
            'title' => 'Modifier mon profil - BeninExplore',
            'user' => $user,
            'profil' => $profil
        ]);
    }
    
    /**
     * Mettre à jour le profil
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/profil');
        }
        
        $userId = $_SESSION['user_id'];
        
        // Mettre à jour les infos utilisateur
        $userData = [
            'telephone' => $_POST['telephone'] ?? '',
            'langue_preferee' => $_POST['langue'] ?? 'fr',
            'newsletter' => isset($_POST['newsletter']) ? 1 : 0
        ];
        
        $this->userModel->update($userId, $userData);
        
        // Mettre à jour le profil hébergeur
        $profilData = [
            'nom_etablissement' => $_POST['nom_etablissement'] ?? '',
            'description' => $_POST['description'] ?? '',
            'adresse' => $_POST['adresse'] ?? ''
        ];
        
        $this->profilModel->update($userId, $profilData);
        
        $_SESSION['success'] = "Profil mis à jour avec succès";
        $this->redirect('/hebergeur/profil');
    }
}