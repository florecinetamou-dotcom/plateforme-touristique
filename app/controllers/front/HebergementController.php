<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;
use App\Models\TypeHebergement;
use App\Models\Photo;
use App\Models\Avis;

class HebergementController extends Controller {
    
    private $hebergementModel;
    private $photoModel;
    private $avisModel;
    
    public function __construct() {
        $this->hebergementModel = new Hebergement();
        $this->photoModel = new Photo();
        $this->avisModel = new Avis();
    }
    
    /**
     * Liste des hébergements avec filtres
     */
    public function index() {
        // Récupérer les filtres
        $ville_id = $_GET['ville'] ?? '';
        $type_id = $_GET['type'] ?? '';
        $prix_min = $_GET['prix_min'] ?? '';
        $prix_max = $_GET['prix_max'] ?? '';
        $capacite = $_GET['capacite'] ?? '';
        $search = $_GET['q'] ?? '';
        
        // Construction de la requête
        $sql = "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
                FROM hebergement h
                JOIN ville v ON h.ville_id = v.id
                LEFT JOIN type_hebergement t ON h.type_id = t.id
                WHERE h.statut = 'approuve'";
        
        $params = [];
        
        if (!empty($ville_id)) {
            $sql .= " AND h.ville_id = ?";
            $params[] = $ville_id;
        }
        
        if (!empty($type_id)) {
            $sql .= " AND h.type_id = ?";
            $params[] = $type_id;
        }
        
        if (!empty($prix_min)) {
            $sql .= " AND h.prix_nuit_base >= ?";
            $params[] = $prix_min;
        }
        
        if (!empty($prix_max)) {
            $sql .= " AND h.prix_nuit_base <= ?";
            $params[] = $prix_max;
        }
        
        if (!empty($capacite)) {
            $sql .= " AND h.capacite >= ?";
            $params[] = $capacite;
        }
        
        if (!empty($search)) {
            $sql .= " AND (h.nom LIKE ? OR h.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        $sql .= " ORDER BY h.note_moyenne DESC, h.date_creation DESC";
        
        $hebergements = $this->hebergementModel->query($sql, $params);
        
        // Récupérer les villes et types pour les filtres
        $villeModel = new Ville();
        $typeModel = new TypeHebergement();
        
        $villes = $villeModel->getActive();
        $types = $typeModel->all();
        
        $this->view('front/hebergement/index', [
            'title' => 'Hébergements - BeninExplore',
            'hebergements' => $hebergements,
            'villes' => $villes,
            'types' => $types,
            'filters' => [
                'ville' => $ville_id,
                'type' => $type_id,
                'prix_min' => $prix_min,
                'prix_max' => $prix_max,
                'capacite' => $capacite,
                'search' => $search
            ]
        ]);
    }
    
    /**
     * Détail d'un hébergement avec toutes les photos
     */
    public function show($id) {
        // Récupérer l'hébergement avec les noms de ville et type
        $sql = "SELECT h.*, v.nom as ville_nom, v.id as ville_id, t.nom as type_nom
                FROM hebergement h
                JOIN ville v ON h.ville_id = v.id
                LEFT JOIN type_hebergement t ON h.type_id = t.id
                WHERE h.id = ? AND h.statut = 'approuve'";
        
        $result = $this->hebergementModel->query($sql, [$id]);
        $hebergement = $result[0] ?? null;
        
        if (!$hebergement) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergements');
        }
        
        // 🔥 RÉCUPÉRER TOUTES LES PHOTOS
        $photos = $this->photoModel->getByHebergement($id);
        
        // Séparer la photo principale des secondaires
        $photoPrincipale = null;
        $photosSecondaires = [];
        
        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) {
                $photoPrincipale = $photo;
            } else {
                $photosSecondaires[] = $photo;
            }
        }
        
        // Si pas de photo principale, prendre la première comme principale
        if (!$photoPrincipale && !empty($photos)) {
            $photoPrincipale = $photos[0];
            // Retirer des secondaires si elle y était
            $photosSecondaires = array_filter($photos, function($p) use ($photoPrincipale) {
                return $p->id != $photoPrincipale->id;
            });
        }
        
        // 🔥 RÉCUPÉRER LES AVIS
        $avis = $this->avisModel->getByHebergement($id, 5); // 5 derniers avis
        
        // 🔥 STATISTIQUES DES AVIS
        $statsAvis = $this->avisModel->getStats($id);
        
        // 🔥 HÉBERGEMENTS SIMILAIRES (même ville ou même type)
        $similaires = $this->getHebergementsSimilaires($hebergement);
        
        // Décoder les équipements JSON
        $hebergement->equipements_array = json_decode($hebergement->equipements ?? '[]', true);
        
        $this->view('front/hebergement/show', [
            'title' => $hebergement->nom . ' - BeninExplore',
            'hebergement' => $hebergement,
            'photos' => $photos,
            'photoPrincipale' => $photoPrincipale,
            'photosSecondaires' => $photosSecondaires,
            'avis' => $avis,
            'statsAvis' => $statsAvis,
            'similaires' => $similaires
        ]);
    }
    
    /**
     * Récupère les hébergements similaires
     */
    private function getHebergementsSimilaires($hebergement, $limit = 3) {
        $sql = "SELECT h.*, v.nom as ville_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
                FROM hebergement h
                JOIN ville v ON h.ville_id = v.id
                WHERE h.statut = 'approuve' 
                AND h.id != ? 
                AND (h.ville_id = ? OR h.type_id = ?)
                ORDER BY h.note_moyenne DESC
                LIMIT ?";
        
        return $this->hebergementModel->query($sql, [
            $hebergement->id,
            $hebergement->ville_id,
            $hebergement->type_id,
            $limit
        ]);
    }
}