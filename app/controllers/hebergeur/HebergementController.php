<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Photo;
use App\Models\Ville;
use App\Models\TypeHebergement;
<<<<<<< HEAD
=======
use App\Middleware\HebergeurMiddleware;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 3));

class HebergementController extends Controller {

    private $hebergementModel;
    private $photoModel;

    public function __construct() {
<<<<<<< HEAD
        // ✅ Utilisation de la nouvelle structure de session
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Veuillez vous connecter";
            $this->redirect('/login');
            return;
        }
        
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'hebergeur') {
            $_SESSION['error'] = "Accès réservé aux hébergeurs";
            $this->redirect('/profile');
            return;
        }

=======
        HebergeurMiddleware::check();
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $this->hebergementModel = new Hebergement();
        $this->photoModel       = new Photo();
    }

    // ════════════════════════════════════════════════
    // LISTE des hébergements de l'hébergeur
    // ════════════════════════════════════════════════
    public function index() {
<<<<<<< HEAD
        $userId = $_SESSION['user']['id'];  // ✅ Nouvelle structure
=======
        $userId = $_SESSION['user_id'];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

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
<<<<<<< HEAD
        $userId      = $_SESSION['user']['id'];  // ✅ Nouvelle structure
=======
        $userId      = $_SESSION['user_id'];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
<<<<<<< HEAD
            $this->redirect('/hebergeur/hebergements');
=======
            header('Location: /hebergeur/hebergements');
            exit;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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

<<<<<<< HEAD
        $hebergement->images           = $images;
=======
        $hebergement->images          = $images;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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

<<<<<<< HEAD
        $errors = [];
        if (empty($_POST['nom']))          $errors[] = "Le nom est requis";
        if (empty($_POST['ville_id']))     $errors[] = "La ville est requise";
        if (empty($_POST['adresse']))      $errors[] = "L'adresse est requise";
        if (empty($_POST['prix_nuit_base']) || $_POST['prix_nuit_base'] <= 0)
            $errors[] = "Le prix doit être supérieur à 0";
=======
        // ── Validation ──
        $errors = [];
        if (empty($_POST['nom']))           $errors[] = "Le nom est requis";
        if (empty($_POST['ville_id']))      $errors[] = "La ville est requise";
        if (empty($_POST['adresse']))       $errors[] = "L'adresse est requise";
        if (empty($_POST['prix_nuit_base']) || $_POST['prix_nuit_base'] <= 0) {
            $errors[] = "Le prix doit être supérieur à 0";
        }
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old']   = $_POST;
            $this->redirect('/hebergeur/hebergements/create');
        }

<<<<<<< HEAD
        $hebergementId = $this->hebergementModel->create([
            'hebergeur_id'   => $_SESSION['user']['id'],  // ✅ Nouvelle structure
            'ville_id'       => $_POST['ville_id'],
            'type_id'        => !empty($_POST['type_id']) ? $_POST['type_id'] : null,
            'nom'            => $_POST['nom'],
            'description'    => $_POST['description']    ?? '',
=======
        // ── Création de l'hébergement ──
        $hebergementId = $this->hebergementModel->create([
            'hebergeur_id'   => $_SESSION['user_id'],
            'ville_id'       => $_POST['ville_id'],
            'type_id'        => !empty($_POST['type_id']) ? $_POST['type_id'] : null,
            'nom'            => $_POST['nom'],
            'description'    => $_POST['description'] ?? '',
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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

<<<<<<< HEAD
=======
        // ── Upload des photos ──
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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
<<<<<<< HEAD
        $userId      = $_SESSION['user']['id'];  // ✅ Nouvelle structure
=======
        $userId      = $_SESSION['user_id'];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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

<<<<<<< HEAD
        $userId      = $_SESSION['user']['id'];  // ✅ Nouvelle structure
=======
        $userId      = $_SESSION['user_id'];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

<<<<<<< HEAD
=======
        // ── Mise à jour des données ──
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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

<<<<<<< HEAD
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            $oldMain = $this->photoModel->getPrincipale($id);
            if ($oldMain) $this->photoModel->deletePhoto($oldMain->id);
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $id, 'main');
            if ($result['success']) {
                $this->hebergementModel->query(
                    "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre) VALUES (?, ?, 1, 0)",
=======
        // ── Upload photo principale ──
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            $oldMain = $this->photoModel->getPrincipale($id);
            if ($oldMain) {
                $this->photoModel->deletePhoto($oldMain->id);
            }
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $id, 'main');
            if ($result['success']) {
                $this->hebergementModel->query(
                    "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                     VALUES (?, ?, 1, 0)",
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                    [$id, $result['path']]
                );
            }
        }

<<<<<<< HEAD
        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name) || $_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) continue;
=======
        // ── Upload photos secondaires ──
        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name) || $_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) continue;

>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                $file = [
                    'name'     => $_FILES['photos_secondaires']['name'][$key],
                    'type'     => $_FILES['photos_secondaires']['type'][$key],
                    'tmp_name' => $_FILES['photos_secondaires']['tmp_name'][$key],
                    'error'    => $_FILES['photos_secondaires']['error'][$key],
                    'size'     => $_FILES['photos_secondaires']['size'][$key]
                ];
<<<<<<< HEAD
                $result = $this->uploadPhoto($file, $uploadDir, $id, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->hebergementModel->query(
                        "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre) VALUES (?, ?, 0, ?)",
=======

                $result = $this->uploadPhoto($file, $uploadDir, $id, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->hebergementModel->query(
                        "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                         VALUES (?, ?, 0, ?)",
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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

<<<<<<< HEAD
        $userId      = $_SESSION['user']['id'];  // ✅ Nouvelle structure
=======
        $userId      = $_SESSION['user_id'];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $hebergement = $this->hebergementModel->find($id);

        if (!$hebergement || $hebergement->hebergeur_id != $userId) {
            $_SESSION['error'] = "Hébergement non trouvé";
            $this->redirect('/hebergeur/hebergements');
        }

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
    // PRIVATE — Upload des photos
    // ════════════════════════════════════════════════
    private function handlePhotoUpload($hebergementId) {
        $errors    = [];
        $uploadDir = ROOT_PATH . '/public/uploads/hebergements/';
<<<<<<< HEAD
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
=======

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $hebergementId, 'main');
            if ($result['success']) {
                $this->hebergementModel->query(
<<<<<<< HEAD
                    "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre) VALUES (?, ?, 1, 0)",
=======
                    "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                     VALUES (?, ?, 1, 0)",
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                    [$hebergementId, $result['path']]
                );
            } else {
                $errors[] = "Photo principale : " . $result['error'];
            }
        }

        if (isset($_FILES['photos_secondaires'])) {
            foreach ($_FILES['photos_secondaires']['name'] as $key => $name) {
                if (empty($name) || $_FILES['photos_secondaires']['error'][$key] !== UPLOAD_ERR_OK) continue;
<<<<<<< HEAD
=======

>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                $file = [
                    'name'     => $_FILES['photos_secondaires']['name'][$key],
                    'type'     => $_FILES['photos_secondaires']['type'][$key],
                    'tmp_name' => $_FILES['photos_secondaires']['tmp_name'][$key],
                    'error'    => $_FILES['photos_secondaires']['error'][$key],
                    'size'     => $_FILES['photos_secondaires']['size'][$key]
                ];
<<<<<<< HEAD
                $result = $this->uploadPhoto($file, $uploadDir, $hebergementId, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->hebergementModel->query(
                        "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre) VALUES (?, ?, 0, ?)",
=======

                $result = $this->uploadPhoto($file, $uploadDir, $hebergementId, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->hebergementModel->query(
                        "INSERT INTO photo_hebergement (hebergement_id, url, est_principale, ordre)
                         VALUES (?, ?, 0, ?)",
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                        [$hebergementId, $result['path'], $key + 1]
                    );
                } else {
                    $errors[] = "Photo " . ($key + 1) . " : " . $result['error'];
                }
            }
        }

        return $errors;
    }

    private function uploadPhoto($file, $uploadDir, $hebergementId, $suffix) {
        $result = ['success' => false, 'path' => null, 'error' => null];

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'])) {
            $result['error'] = "Type de fichier non autorisé ($mimeType)";
            return $result;
        }
<<<<<<< HEAD
=======

>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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