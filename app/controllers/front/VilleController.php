<?php
namespace App\Controllers\Front;

use App\Models\Ville;
use App\Models\Hebergement;
use App\Models\SiteTouristique;
use Core\Controller;

class VilleController extends Controller
{
    /**
     * Afficher la liste des villes
     */
    public function index()
    {
        $villeModel = new Ville();
        
        // CORRECTION : remplacer getAll() par all()
        $villes = $villeModel->all();
        
        $this->view('front/ville/index', [
            'villes' => $villes ?: []
        ]);
    }
    
    /**
     * Afficher les détails d'une ville
     */
    public function show($id)
    {
        // Vérifier que l'ID est valide
        if (!is_numeric($id)) {
            $this->redirect('/villes');
            return;
        }
        
        // Récupérer les informations de la ville
        $villeModel = new Ville();
        $ville = $villeModel->find($id);
        
        if (!$ville) {
            $_SESSION['error'] = "Ville non trouvée";
            $this->redirect('/villes');
            return;
        }
        
        // Récupérer les hébergements de cette ville
        $hebergementModel = new Hebergement();
        $hebergements = $hebergementModel->getByVille($id) ?: [];
        
        // Récupérer les sites touristiques de cette ville
        $siteModel = new SiteTouristique();
        $sites = $siteModel->getByVille($id) ?: [];
        
        // Statistiques
        $totalHebergements = count($hebergements);
        $totalSites = count($sites);
        
        $this->view('front/ville/show', [
            'ville' => $ville,
            'hebergements' => $hebergements,
            'sites' => $sites,
            'totalHebergements' => $totalHebergements,
            'totalSites' => $totalSites
        ]);
    }
}