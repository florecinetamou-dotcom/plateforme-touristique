<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Photo;
use App\Models\Ville;
use App\Models\TypeHebergement;
use App\Middleware\HebergeurMiddleware;

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 2));

class HebergementController extends Controller {

    private $hebergementModel;
    private $photoModel;

    public function __construct() {
        HebergeurMiddleware::check();
        $this->hebergementModel = new Hebergement();
        $this->photoModel = new Photo();
    }

    /**
     * Liste des hébergements de l'hébergeur
     */
    public function index() {
        $userId = $_SESSION['user_id'];

        $hebergements = $this->hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                    (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
             FROM hebergement h
             LEFT JOIN ville v ON h.ville_id = v.id
             LEFT JOIN type_hebergement t ON h.type_id = t.id
             WHERE h.hebergeur_id = ?
             ORDER BY h.date_creation DESC",
            [$userId]
        );

        $this->view('hebergeur/hebergements/index', [
            'title' => 'Mes hébergements - BeninExplore',
            'hebergements' => $hebergements
        ]);
    }

    /**
     * Voir les détails d'un hébergement (AVEC RÉCUPÉRATION DES PHOTOS)
     */
    public function voir($id) {
        $userId = $_SESSION['user_id'];

        // Récupérer l'hébergement avec les infos de ville et type
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            header('Location: /hebergeur/hebergements');
            exit;
        }

        // Récupérer TOUTES les photos de l'hébergement
        $photos = $this->photoModel->getByHebergement($id);

        // Organiser les photos : principale d'abord, puis secondaires
        $images = [];
        $photoPrincipale = null;

        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) {
                $photoPrincipale = $photo;
                // La photo principale en premier
                array_unshift($images, $photo);
            } else {
                $images[] = $photo;
            }
        }

        // Ajouter les images à l'objet hébergement pour la vue
        $hebergement->images = $images;
        $hebergement->photo_principale = $photoPrincipale;

        $this->view('hebergeur/hebergements/voir', [
            'title' => $hebergement->nom . ' - BeninExplore',
            'hebergement' => $hebergement
        ]);
    }

    /**
     * Formulaire d'ajout d'hébergement
     */
    public function create() {
        $villeModel = new Ville();
        $typeModel = new TypeHebergement();

        $villes = $villeModel->getActive();
        $types = $typeModel->all();

        $this->view('hebergeur/hebergements/create', [
            'title' => 'Ajouter un hébergement',
            'villes' => $villes,
            'types' => $types
        ]);
    }

    /**
     * Traitement de l'ajout avec photos
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/hebergements');
        }

        // Validation
        $errors = [];
        if (empty($_POST['nom'])) $errors[] = "Le nom est requis";
        if (empty($_POST['ville_id'])) $errors[] = "La ville est requise";
        if (empty($_POST['adresse'])) $errors[] = "L'adresse est requise";
        if (empty($_POST['prix_nuit_base']) || $_POST['prix_nuit_base'] <= 0) {
            $errors[] = "Le prix doit être supérieur à 0";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old'] = $_POST;
            $this->redirect('/hebergeur/hebergements/create');
        }

        // Données hébergement
        $data = [
            'hebergeur_id' => $_SESSION['user_id'],
            'ville_id' => $_POST['ville_id'],
            'type_id' => !empty($_POST['type_id']) ? $_POST['type_id'] : null,
            'nom' => $_POST['nom'],
            'description' => $_POST['description'] ?? '',
            'adresse' => $_POST['adresse'],
            'prix_nuit_base' => $_POST['prix_nuit_base'],
            'capacite' => $_POST['capacite'] ?? 1,
            'chambres' => $_POST['chambres'] ?? 1,
            'lits' => $_POST['lits'] ?? 1,
            'salles_de_bain' => $_POST['salles_de_bain'] ?? 1,
            'statut' => 'en_attente',
            'date_creation' => date('Y-m-d H:i:s')
        ];

        $hebergementId = $this->hebergementModel->create($data);

        if (!$hebergementId) {
            $_SESSION['error'] = "Erreur lors de l'ajout";
            $_SESSION['old'] = $_POST;
            $this->redirect('/hebergeur/hebergements/create');
        }

        // Traitement des photos
        $uploadErrors = $this->handlePhotoUpload($hebergementId);

        if (!empty($uploadErrors)) {
            $_SESSION['warning'] = "Hébergement créé, mais certaines photos n'ont pas pu être sauvegardées.";
        } else {
            $_SESSION['success'] = "Hébergement ajouté avec succès. En attente de validation.";
        }

        $this->redirect('/hebergeur/hebergements');
    }

    /**
     * Formulaire d'édition
     */
    public function edit($id) {
        $userId = $_SESSION['user_id'];

        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

        // Récupérer toutes les photos
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

        $villeModel = new Ville();
        $typeModel = new TypeHebergement();

        $villes = $villeModel->getActive();
        $types = $typeModel->all();

        $this->view('hebergeur/hebergements/edit', [
            'title' => 'Modifier un hébergement',
            'hebergement' => $hebergement,
            'photos' => $photos,
            'photoPrincipale' => $photoPrincipale,
            'photosSecondaires' => $photosSecondaires,
            'villes' => $villes,
            'types' => $types
        ]);
    }

    /**
     * Traitement de la modification
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/hebergements');
        }

        $userId = $_SESSION['user_id'];
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

        // Mise à jour des données
        $data = [
            'ville_id' => $_POST['ville_id'] ?? $hebergement->ville_id,
            'type_id' => $_POST['type_id'] ?? $hebergement->type_id,
            'nom' => $_POST['nom'] ?? $hebergement->nom,
            'description' => $_POST['description'] ?? $hebergement->description,
            'adresse' => $_POST['adresse'] ?? $hebergement->adresse,
            'prix_nuit_base' => $_POST['prix_nuit_base'] ?? $hebergement->prix_nuit_base,
            'capacite' => $_POST['capacite'] ?? $hebergement->capacite,
            'chambres' => $_POST['chambres'] ?? $hebergement->chambres,
            'lits' => $_POST['lits'] ?? $hebergement->lits,
            'salles_de_bain' => $_POST['salles_de_bain'] ?? $hebergement->salles_de_bain
        ];

        $updated = $this->hebergementModel->update($id, $data);

        if (!$updated) {
            $_SESSION['error'] = "Erreur lors de la modification";
            $this->redirect('/hebergeur/hebergements/edit/' . $id);
        }

        // GESTION DES PHOTOS
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Si une nouvelle photo principale est uploadée
        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            // Supprimer l'ancienne photo principale
            $oldMain = $this->photoModel->getPrincipale($id);
            if ($oldMain) {
                $this->photoModel->deletePhoto($oldMain->id);
            }

            // Uploader la nouvelle
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $id, 'main');
            if ($result['success']) {
                $sql = "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                        VALUES (?, ?, 1, 0)";
                $this->hebergementModel->query($sql, [$id, $result['path']]);
            }
        }

        // Gestion des photos secondaires
        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name)) continue;

                if ($_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $file = [
                    'name' => $_FILES['photos_secondaires']['name'][$key],
                    'type' => $_FILES['photos_secondaires']['type'][$key],
                    'tmp_name' => $_FILES['photos_secondaires']['tmp_name'][$key],
                    'error' => $_FILES['photos_secondaires']['error'][$key],
                    'size' => $_FILES['photos_secondaires']['size'][$key]
                ];

                $result = $this->uploadPhoto($file, $uploadDir, $id, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $sql = "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                            VALUES (?, ?, 0, ?)";
                    $this->hebergementModel->query($sql, [$id, $result['path'], $key + 1]);
                }
            }
        }

        $_SESSION['success'] = "Hébergement modifié avec succès";
        $this->redirect('/hebergeur/hebergements');
    }

    /**
     * Supprimer un hébergement
     */
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/hebergements');
        }

        $userId = $_SESSION['user_id'];
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

        // Supprimer les photos (fichiers + BDD)
        $photos = $this->photoModel->getByHebergement($id);
        foreach ($photos as $photo) {
            $this->photoModel->deletePhoto($photo->id);
        }

        $deleted = $this->hebergementModel->delete($id);

        if ($deleted) {
            $_SESSION['success'] = "Hébergement supprimé";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression";
        }

        $this->redirect('/hebergeur/hebergements');
    }

    /**
     * Gère l'upload des photos (pour create)
     */
    private function handlePhotoUpload($hebergementId) {
        $uploadErrors = [];
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Photo principale
        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $hebergementId, 'main');
            if ($result['success']) {
                $sql = "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                        VALUES (?, ?, 1, 0)";
                $this->hebergementModel->query($sql, [$hebergementId, $result['path']]);
            } else {
                $uploadErrors[] = "Photo principale : " . $result['error'];
            }
        }

        // Photos secondaires
        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name)) continue;
                if ($_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) continue;

                $file = [
                    'name' => $_FILES['photos_secondaires']['name'][$key],
                    'type' => $_FILES['photos_secondaires']['type'][$key],
                    'tmp_name' => $_FILES['photos_secondaires']['tmp_name'][$key],
                    'error' => $_FILES['photos_secondaires']['error'][$key],
                    'size' => $_FILES['photos_secondaires']['size'][$key]
                ];

                $result = $this->uploadPhoto($file, $uploadDir, $hebergementId, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $sql = "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                            VALUES (?, ?, 0, ?)";
                    $this->hebergementModel->query($sql, [$hebergementId, $result['path'], $key + 1]);
                } else {
                    $uploadErrors[] = "Photo " . ($key + 1) . " : " . $result['error'];
                }
            }
        }

        return $uploadErrors;
    }

    /**
     * Upload une photo avec validation
     */
    private function uploadPhoto($file, $uploadDir, $hebergementId, $suffix) {
        $result = ['success' => false, 'path' => null, 'error' => null];

        // Vérifier le type MIME réel
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mimeType, $allowedTypes)) {
            $result['error'] = "Type de fichier non autorisé";
            return $result;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $result['error'] = "Fichier trop volumineux (max 5 Mo)";
            return $result;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'heb_' . $hebergementId . '_' . $suffix . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $result['success'] = true;
            $result['path'] = '/uploads/hebergements/' . $filename;
        } else {
            $result['error'] = "Erreur lors de la sauvegarde";
        }

        return $result;
    }
}
