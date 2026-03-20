<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Photo;
use App\Models\Ville;
use App\Models\TypeHebergement;
use App\Middleware\HebergeurMiddleware;

// ── CORRECTION : 3 niveaux depuis app/Controllers/Hebergeur/ ──
// Hebergeur/ → Controllers/ → app/ → tourisme_benin/ ✅
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 3));

class HebergementController extends Controller {

    private $hebergementModel;
    private $photoModel;

    public function __construct() {
        HebergeurMiddleware::check();
        $this->hebergementModel = new Hebergement();
        $this->photoModel       = new Photo();
    }

    // ════════════════════════════════════════════════
    // LISTE des hébergements de l'hébergeur
    // ════════════════════════════════════════════════
    public function index() {
        $userId = $_SESSION['user_id'];

        $hebergements = $this->hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                    (SELECT url FROM photo_hebergement
                     WHERE hebergement_id = h.id AND est_principale = 1
                     LIMIT 1) as photo
             FROM hebergement h
             LEFT JOIN ville v ON h.ville_id = v.id
             LEFT JOIN type_hebergement t ON h.type_id = t.id
             WHERE h.hebergeur_id = ?
             ORDER BY h.date_creation DESC",
            [$userId]
        );

        $this->view('hebergeur/hebergements/index', [
            'title'        => 'Mes hébergements - BeninExplore',
            'hebergements' => $hebergements
        ]);
    }

    // ════════════════════════════════════════════════
    // DÉTAILS d'un hébergement
    // ════════════════════════════════════════════════
    public function voir($id) {
        $userId      = $_SESSION['user_id'];
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            header('Location: /hebergeur/hebergements');
            exit;
        }

        $photos          = $this->photoModel->getByHebergement($id);
        $images          = [];
        $photoPrincipale = null;

        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) {
                $photoPrincipale = $photo;
                array_unshift($images, $photo);
            } else {
                $images[] = $photo;
            }
        }

        $hebergement->images          = $images;
        $hebergement->photo_principale = $photoPrincipale;

        $this->view('hebergeur/hebergements/voir', [
            'title'       => $hebergement->nom . ' - BeninExplore',
            'hebergement' => $hebergement
        ]);
    }

    // ════════════════════════════════════════════════
    // FORMULAIRE d'ajout
    // ════════════════════════════════════════════════
    public function create() {
        $villeModel = new Ville();
        $typeModel  = new TypeHebergement();

        $this->view('hebergeur/hebergements/create', [
            'title'  => 'Ajouter un hébergement',
            'villes' => $villeModel->getActive(),
            'types'  => $typeModel->all()
        ]);
    }

    // ════════════════════════════════════════════════
    // TRAITEMENT de l'ajout
    // ════════════════════════════════════════════════
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/hebergements');
        }

        // ── Validation ──
        $errors = [];
        if (empty($_POST['nom']))           $errors[] = "Le nom est requis";
        if (empty($_POST['ville_id']))      $errors[] = "La ville est requise";
        if (empty($_POST['adresse']))       $errors[] = "L'adresse est requise";
        if (empty($_POST['prix_nuit_base']) || $_POST['prix_nuit_base'] <= 0) {
            $errors[] = "Le prix doit être supérieur à 0";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old']   = $_POST;
            $this->redirect('/hebergeur/hebergements/create');
        }

        // ── Création de l'hébergement ──
        $hebergementId = $this->hebergementModel->create([
            'hebergeur_id'   => $_SESSION['user_id'],
            'ville_id'       => $_POST['ville_id'],
            'type_id'        => !empty($_POST['type_id']) ? $_POST['type_id'] : null,
            'nom'            => $_POST['nom'],
            'description'    => $_POST['description'] ?? '',
            'adresse'        => $_POST['adresse'],
            'prix_nuit_base' => $_POST['prix_nuit_base'],
            'capacite'       => $_POST['capacite']       ?? 1,
            'chambres'       => $_POST['chambres']       ?? 1,
            'lits'           => $_POST['lits']           ?? 1,
            'salles_de_bain' => $_POST['salles_de_bain'] ?? 1,
            'statut'         => 'en_attente',
            'date_creation'  => date('Y-m-d H:i:s')
        ]);

        if (!$hebergementId) {
            $_SESSION['error'] = "Erreur lors de l'ajout";
            $_SESSION['old']   = $_POST;
            $this->redirect('/hebergeur/hebergements/create');
        }

        // ── Upload des photos ──
        $uploadErrors = $this->handlePhotoUpload($hebergementId);

        if (!empty($uploadErrors)) {
            $_SESSION['warning'] = "Hébergement créé, mais certaines photos n'ont pas pu être sauvegardées : " . implode(', ', $uploadErrors);
        } else {
            $_SESSION['success'] = "Hébergement ajouté avec succès. En attente de validation.";
        }

        unset($_SESSION['old']);
        $this->redirect('/hebergeur/hebergements');
    }

    // ════════════════════════════════════════════════
    // FORMULAIRE d'édition
    // ════════════════════════════════════════════════
    public function edit($id) {
        $userId      = $_SESSION['user_id'];
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

        $photos            = $this->photoModel->getByHebergement($id);
        $photoPrincipale   = null;
        $photosSecondaires = [];

        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) {
                $photoPrincipale = $photo;
            } else {
                $photosSecondaires[] = $photo;
            }
        }

        $villeModel = new Ville();
        $typeModel  = new TypeHebergement();

        $this->view('hebergeur/hebergements/edit', [
            'title'             => 'Modifier un hébergement',
            'hebergement'       => $hebergement,
            'photos'            => $photos,
            'photoPrincipale'   => $photoPrincipale,
            'photosSecondaires' => $photosSecondaires,
            'villes'            => $villeModel->getActive(),
            'types'             => $typeModel->all()
        ]);
    }

    // ════════════════════════════════════════════════
    // TRAITEMENT de la modification
    // ════════════════════════════════════════════════
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/hebergements');
        }

        $userId      = $_SESSION['user_id'];
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

        // ── Mise à jour des données ──
        $updated = $this->hebergementModel->update($id, [
            'ville_id'       => $_POST['ville_id']       ?? $hebergement->ville_id,
            'type_id'        => $_POST['type_id']        ?? $hebergement->type_id,
            'nom'            => $_POST['nom']            ?? $hebergement->nom,
            'description'    => $_POST['description']    ?? $hebergement->description,
            'adresse'        => $_POST['adresse']        ?? $hebergement->adresse,
            'prix_nuit_base' => $_POST['prix_nuit_base'] ?? $hebergement->prix_nuit_base,
            'capacite'       => $_POST['capacite']       ?? $hebergement->capacite,
            'chambres'       => $_POST['chambres']       ?? $hebergement->chambres,
            'lits'           => $_POST['lits']           ?? $hebergement->lits,
            'salles_de_bain' => $_POST['salles_de_bain'] ?? $hebergement->salles_de_bain
        ]);

        if (!$updated) {
            $_SESSION['error'] = "Erreur lors de la modification";
            $this->redirect('/hebergeur/hebergements/edit/' . $id);
        }

        // ── Upload photo principale ──
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            // Supprimer l'ancienne
            $oldMain = $this->photoModel->getPrincipale($id);
            if ($oldMain) {
                $this->photoModel->deletePhoto($oldMain->id);
            }
            // Uploader la nouvelle
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $id, 'main');
            if ($result['success']) {
                $this->hebergementModel->query(
                    "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                     VALUES (?, ?, 1, 0)",
                    [$id, $result['path']]
                );
            }
        }

        // ── Upload photos secondaires ──
        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name) || $_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) continue;

                $file = [
                    'name'     => $_FILES['photos_secondaires']['name'][$key],
                    'type'     => $_FILES['photos_secondaires']['type'][$key],
                    'tmp_name' => $_FILES['photos_secondaires']['tmp_name'][$key],
                    'error'    => $_FILES['photos_secondaires']['error'][$key],
                    'size'     => $_FILES['photos_secondaires']['size'][$key]
                ];

                $result = $this->uploadPhoto($file, $uploadDir, $id, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->hebergementModel->query(
                        "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                         VALUES (?, ?, 0, ?)",
                        [$id, $result['path'], $key + 1]
                    );
                }
            }
        }

        $_SESSION['success'] = "Hébergement modifié avec succès";
        $this->redirect('/hebergeur/hebergements');
    }

    // ════════════════════════════════════════════════
    // SUPPRESSION d'un hébergement
    // ════════════════════════════════════════════════
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/hebergements');
        }

        $userId      = $_SESSION['user_id'];
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

        if ($this->hebergementModel->delete($id)) {
            $_SESSION['success'] = "Hébergement supprimé";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression";
        }

        $this->redirect('/hebergeur/hebergements');
    }

    // ════════════════════════════════════════════════
    // PRIVATE — Upload des photos (create)
    // ════════════════════════════════════════════════
    private function handlePhotoUpload($hebergementId) {
        $errors    = [];
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Photo principale
        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $hebergementId, 'main');
            if ($result['success']) {
                $this->hebergementModel->query(
                    "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                     VALUES (?, ?, 1, 0)",
                    [$hebergementId, $result['path']]
                );
            } else {
                $errors[] = "Photo principale : " . $result['error'];
            }
        }

        // Photos secondaires
        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name) || $_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) continue;

                $file = [
                    'name'     => $_FILES['photos_secondaires']['name'][$key],
                    'type'     => $_FILES['photos_secondaires']['type'][$key],
                    'tmp_name' => $_FILES['photos_secondaires']['tmp_name'][$key],
                    'error'    => $_FILES['photos_secondaires']['error'][$key],
                    'size'     => $_FILES['photos_secondaires']['size'][$key]
                ];

                $result = $this->uploadPhoto($file, $uploadDir, $hebergementId, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->hebergementModel->query(
                        "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                         VALUES (?, ?, 0, ?)",
                        [$hebergementId, $result['path'], $key + 1]
                    );
                } else {
                    $errors[] = "Photo " . ($key + 1) . " : " . $result['error'];
                }
            }
        }

        return $errors;
    }

    // ════════════════════════════════════════════════
    // PRIVATE — Upload et validation d'une photo
    // ════════════════════════════════════════════════
    private function uploadPhoto($file, $uploadDir, $hebergementId, $suffix) {
        $result = ['success' => false, 'path' => null, 'error' => null];

        // Vérifier le type MIME réel
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'])) {
            $result['error'] = "Type de fichier non autorisé ($mimeType)";
            return $result;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $result['error'] = "Fichier trop volumineux (max 5 Mo)";
            return $result;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename  = 'heb_' . $hebergementId . '_' . $suffix . '_' . time() . '.' . $extension;
        $filepath  = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $result['success'] = true;
            $result['path']    = '/uploads/hebergements/' . $filename;
        } else {
            $result['error'] = "Impossible de déplacer le fichier vers $filepath";
        }

        return $result;
    }
}