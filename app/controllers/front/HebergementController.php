<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;
use App\Models\TypeHebergement;
use App\Models\Photo;
<<<<<<< HEAD
=======
use App\Models\Avis;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

class HebergementController extends Controller {

    private $hebergementModel;
    private $photoModel;
<<<<<<< HEAD
=======
    private $avisModel;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    private const PER_PAGE = 9;

    public function __construct() {
        $this->hebergementModel = new Hebergement();
        $this->photoModel       = new Photo();
<<<<<<< HEAD
=======
        $this->avisModel        = new Avis();
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    }

    public function index() {
        $ville_id = $_GET['ville']    ?? '';
        $type_id  = $_GET['type']     ?? '';
        $prix_min = $_GET['prix_min'] ?? '';
        $prix_max = $_GET['prix_max'] ?? '';
        $capacite = $_GET['capacite'] ?? '';
        $search   = $_GET['q']        ?? '';
        $tri      = $_GET['tri']      ?? 'note';
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $offset   = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE h.statut = 'approuve'";
        $params = [];

        if (!empty($ville_id)) { $where .= " AND h.ville_id = ?";       $params[] = $ville_id; }
        if (!empty($type_id))  { $where .= " AND h.type_id = ?";        $params[] = $type_id;  }
        if (!empty($prix_min)) { $where .= " AND h.prix_nuit_base >= ?"; $params[] = $prix_min; }
        if (!empty($prix_max)) { $where .= " AND h.prix_nuit_base <= ?"; $params[] = $prix_max; }
        if (!empty($capacite)) { $where .= " AND h.capacite >= ?";       $params[] = $capacite; }
        if (!empty($search)) {
            $where   .= " AND (h.nom LIKE ? OR h.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $order = match($tri) {
            'prix_asc'  => "h.prix_nuit_base ASC",
            'prix_desc' => "h.prix_nuit_base DESC",
            'nom'       => "h.nom ASC",
            'recent'    => "h.date_creation DESC",
            default     => "h.note_moyenne DESC, h.date_creation DESC",
        };

        $base = "FROM hebergement h
                 JOIN ville v ON h.ville_id = v.id
                 LEFT JOIN type_hebergement t ON h.type_id = t.id
                 $where";

        $totalRes    = $this->hebergementModel->query("SELECT COUNT(*) as total $base", $params);
        $total       = $totalRes[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $hebergements = $this->hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                    (SELECT url FROM photo_hebergement
                     WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
             $base ORDER BY $order
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

<<<<<<< HEAD
        // ✅ Correction : Utilisation de $_SESSION['user']
        $favorisIds = [];
        if (!empty($_SESSION['user'])) {
            $favs = $this->hebergementModel->query(
                "SELECT hebergement_id FROM favori WHERE voyageur_id = ?",
                [$_SESSION['user']['id']]
=======
        $favorisIds = [];
        if (!empty($_SESSION['user_id'])) {
            $favs = $this->hebergementModel->query(
                "SELECT hebergement_id FROM favori WHERE voyageur_id = ?",
                [$_SESSION['user_id']]
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            );
            $favorisIds = array_column((array)$favs, 'hebergement_id');
        }

        $prix      = $this->hebergementModel->query(
            "SELECT MIN(prix_nuit_base) as min_prix, MAX(prix_nuit_base) as max_prix FROM hebergement WHERE statut = 'approuve'"
        );
        $prixRange = $prix[0] ?? null;

        $villeModel = new Ville();
        $typeModel  = new TypeHebergement();

        $this->view('front/hebergement/index', [
            'title'        => 'Hébergements - BeninExplore',
            'hebergements' => $hebergements,
            'villes'       => $villeModel->getActive(),
            'types'        => $typeModel->all(),
            'filters'      => compact('ville_id', 'type_id', 'prix_min', 'prix_max', 'capacite', 'search', 'tri'),
            'total'        => $total,
            'total_pages'  => $total_pages,
            'page'         => $page,
            'favorisIds'   => $favorisIds,
            'prixRange'    => $prixRange,
        ]);
    }

    public function show($id) {
        $result      = $this->hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom, v.id as ville_id, t.nom as type_nom
             FROM hebergement h JOIN ville v ON h.ville_id = v.id
             LEFT JOIN type_hebergement t ON h.type_id = t.id
             WHERE h.id = ? AND h.statut = 'approuve'", [$id]
        );
        $hebergement = $result[0] ?? null;
<<<<<<< HEAD
        
        if (!$hebergement) { 
            $_SESSION['error'] = "Hébergement non trouvé"; 
            $this->redirect('/hebergements'); 
        }

        $photos = $this->photoModel->getByHebergement($id);
        $photoPrincipale = null; 
        $photosSecondaires = [];
        
        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) {
                $photoPrincipale = $photo;
            } else {
                $photosSecondaires[] = $photo;
            }
        }
        
=======
        if (!$hebergement) { $_SESSION['error'] = "Hébergement non trouvé"; $this->redirect('/hebergements'); }

        $photos = $this->photoModel->getByHebergement($id);
        $photoPrincipale = null; $photosSecondaires = [];
        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) $photoPrincipale = $photo;
            else $photosSecondaires[] = $photo;
        }
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        if (!$photoPrincipale && !empty($photos)) {
            $photoPrincipale   = $photos[0];
            $photosSecondaires = array_filter($photos, fn($p) => $p->id != $photoPrincipale->id);
        }

<<<<<<< HEAD
        // ✅ Supprimé les références à avis
        // $avis      = $this->avisModel->getByHebergement($id, 5);
        // $statsAvis = $this->avisModel->getStats($id);
        
        $similaires = $this->getHebergementsSimilaires($hebergement);
        $hebergement->equipements_array = json_decode($hebergement->equipements ?? '[]', true);

        // ✅ Correction : Utilisation de $_SESSION['user']
        $isFavori = false;
        if (!empty($_SESSION['user'])) {
            $f = $this->hebergementModel->query(
                "SELECT 1 FROM favori WHERE voyageur_id = ? AND hebergement_id = ? LIMIT 1",
                [$_SESSION['user']['id'], $id]
=======
        $avis      = $this->avisModel->getByHebergement($id, 5);
        $statsAvis = $this->avisModel->getStats($id);
        $similaires= $this->getHebergementsSimilaires($hebergement);
        $hebergement->equipements_array = json_decode($hebergement->equipements ?? '[]', true);

        $isFavori = false;
        if (!empty($_SESSION['user_id'])) {
            $f = $this->hebergementModel->query(
                "SELECT 1 FROM favori WHERE voyageur_id = ? AND hebergement_id = ? LIMIT 1",
                [$_SESSION['user_id'], $id]
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            );
            $isFavori = !empty($f);
        }

        $this->view('front/hebergement/show', [
            'title'             => $hebergement->nom . ' - BeninExplore',
            'hebergement'       => $hebergement,
            'photos'            => $photos,
            'photoPrincipale'   => $photoPrincipale,
            'photosSecondaires' => $photosSecondaires,
<<<<<<< HEAD
            // 'avis'           => $avis,        // ❌ Supprimé
            // 'statsAvis'      => $statsAvis,   // ❌ Supprimé
=======
            'avis'              => $avis,
            'statsAvis'         => $statsAvis,
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            'similaires'        => $similaires,
            'isFavori'          => $isFavori,
        ]);
    }

    private function getHebergementsSimilaires($hebergement, $limit = 3) {
        return $this->hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom,
                    (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
             FROM hebergement h JOIN ville v ON h.ville_id = v.id
             WHERE h.statut = 'approuve' AND h.id != ? AND (h.ville_id = ? OR h.type_id = ?)
             ORDER BY h.note_moyenne DESC LIMIT ?",
            [$hebergement->id, $hebergement->ville_id, $hebergement->type_id, $limit]
        );
    }
}