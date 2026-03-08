<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;
use App\Models\SiteTouristique;

class HomeController extends Controller {
    
    public function index() {
        // Récupérer les données
        $hebergementModel = new Hebergement();
        $villeModel = new Ville();
        $siteModel = new SiteTouristique();
        
        $hebergementsPopulaires = $hebergementModel->getPopulaires(3);
        $villesPopulaires = $villeModel->getActive(); // Ou une méthode getPopulaires si elle existe
        $sitesPopulaires = $siteModel->getPopulaires(4); // À vérifier aussi
        
        // Compter le nombre total d'hébergements pour la stats
        $totalHebergements = count($hebergementModel->getApprouves());
        
        $this->view('front/home/index', [
            'title' => 'Accueil - BeninExplore',
            'hebergements_populaires' => $hebergementsPopulaires,
            'villes' => $villesPopulaires,
            'sites_populaires' => $sitesPopulaires,
            'total_hebergements' => $totalHebergements
        ]);
    }
    
    public function about() {
        $this->view('front/home/about', [
            'title' => 'À propos - BeninExplore'
        ]);
    }
    
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleContact();
        }
        
        $this->view('front/home/contact', [
            'title' => 'Contact - BeninExplore'
        ]);
    }
    
    private function handleContact() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
        
        $errors = [];
        if (empty($name)) $errors[] = "Le nom est requis";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
        if (strlen($message) < 10) $errors[] = "Message trop court";
        
        if (empty($errors)) {
            // Ici tu pourrais envoyer un email
            $_SESSION['success'] = "Message envoyé avec succès !";
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $_POST;
        }
        
        $this->redirect('/contact');
    }
}