<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\SiteTouristique;
use App\Models\Ville;

class SiteController extends Controller {

    private $siteModel;

    public function __construct() {
        $this->siteModel = new SiteTouristique();
    }

    // ════════════════════════════════════════════════
    // LISTE des sites avec filtres
    // ════════════════════════════════════════════════
    public function index() {
        $categorie = $_GET['categorie'] ?? '';
        $ville_id  = $_GET['ville']     ?? '';
        $search    = $_GET['search']    ?? '';

        $sql = "SELECT s.*, v.nom as ville_nom,
                       (SELECT url FROM photo_site_touristique
                        WHERE site_id = s.id AND est_principale = 1
                        LIMIT 1) as photo_url
                FROM site_touristique s
                JOIN ville v ON s.ville_id = v.id
                WHERE s.est_valide = 1";

        $params = [];

        if (!empty($categorie)) {
            $sql     .= " AND s.categorie = ?";
            $params[] = $categorie;
        }
        if (!empty($ville_id)) {
            $sql     .= " AND s.ville_id = ?";
            $params[] = $ville_id;
        }
        if (!empty($search)) {
            $sql     .= " AND (s.nom LIKE ? OR s.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $sql .= " ORDER BY s.nom ASC";

        $sites = $this->siteModel->query($sql, $params);

        $villeModel = new Ville();
        $villes     = $villeModel->getActive();

        $categories = [
            'historique' => 'Historique',
            'nature'     => 'Nature',
            'culturel'   => 'Culturel',
            'religieux'  => 'Religieux',
            'autre'      => 'Autre'
        ];

        $this->view('front/site/index', [
            'title'      => 'Sites touristiques - BeninExplore',
            'sites'      => $sites,
            'villes'     => $villes,
            'categories' => $categories,
            'filters'    => [
                'categorie' => $categorie,
                'ville'     => $ville_id,
                'search'    => $search
            ]
        ]);
    }

    // ════════════════════════════════════════════════
    // DÉTAIL d'un site
    // ════════════════════════════════════════════════
    public function show($id) {
        if (!is_numeric($id)) {
            $_SESSION['error'] = "Site non trouvé";
            $this->redirect('/sites');
        }

        $site = $this->siteModel->getWithVille($id);

        if (!$site) {
            $_SESSION['error'] = "Site non trouvé";
            $this->redirect('/sites');
        }

        // Récupérer toutes les photos du site
        $photos = $this->siteModel->query(
            "SELECT * FROM photo_site_touristique
             WHERE site_id = ?
             ORDER BY est_principale DESC, ordre ASC",
            [$id]
        );

        // Séparer photo principale et secondaires
        $photoPrincipale   = null;
        $photosSecondaires = [];
        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) {
                $photoPrincipale = $photo;
            } else {
                $photosSecondaires[] = $photo;
            }
        }

        // Attacher aux objets pour la vue
        $site->photo_url           = $photoPrincipale->url ?? null;
        $site->photo_principale    = $photoPrincipale;
        $site->photos_secondaires  = $photosSecondaires;

        // Hébergements à proximité
        $hebergements = $this->siteModel->query(
            "SELECT h.*,
                    (SELECT url FROM photo_hebergement
                     WHERE hebergement_id = h.id AND est_principale = 1
                     LIMIT 1) as photo
             FROM hebergement h
             WHERE h.ville_id = ? AND h.statut = 'approuve'
             LIMIT 3",
            [$site->ville_id]
        );

        $this->view('front/site/show', [
            'title'        => $site->nom . ' - BeninExplore',
            'site'         => $site,
            'hebergements' => $hebergements
        ]);
    }
}