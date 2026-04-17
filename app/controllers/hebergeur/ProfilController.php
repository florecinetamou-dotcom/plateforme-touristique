<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\User;
<<<<<<< HEAD
=======
use App\Models\ProfilHebergeur;
use App\Middleware\HebergeurMiddleware;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 3));

class ProfilController extends Controller {

    private $userModel;
<<<<<<< HEAD

    public function __construct() {
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
        
        $this->userModel = new User();
    }

    public function index() {
        $userId = $_SESSION['user']['id'];
        $user   = $this->userModel->find($userId);
        $stats  = $this->getHebergeurStats($userId);

        $this->view('hebergeur/profil/index', [
            'title' => 'Mon profil hébergeur - BeninExplore',
            'user'  => $user,
            'stats' => $stats,
        ]);
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEdit();
            return;
        }
        
        $userId = $_SESSION['user']['id'];
        $user   = $this->userModel->find($userId);
        
        $this->view('hebergeur/profil/edit', [
            'title' => 'Modifier mon profil hébergeur - BeninExplore',
            'user'  => $user,
        ]);
    }

    private function handleEdit(): void {
        $userId      = $_SESSION['user']['id'];
        $prenom      = trim($_POST['prenom']      ?? '');
        $nom         = trim($_POST['nom']         ?? '');
        $telephone   = trim($_POST['telephone']   ?? '');
        $langue      = $_POST['langue']           ?? 'fr';
        $newsletter  = isset($_POST['newsletter']) ? 1 : 0;

        $errors = [];
        if (empty($prenom)) $errors[] = "Le prénom est requis";
        if (empty($nom))    $errors[] = "Le nom est requis";

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('/hebergeur/profil/edit');
            return;
        }

        $data = [
            'prenom'          => $prenom,
            'nom'             => $nom,
            'telephone'       => $telephone,
            'langue_preferee' => $langue,
            'newsletter'      => $newsletter,
        ];

=======
    private $profilModel;

    public function __construct() {
        HebergeurMiddleware::check();
        $this->userModel   = new User();
        $this->profilModel = new ProfilHebergeur();
    }

    // ════════════════════════════════════════════════
    // AFFICHER le profil
    // ════════════════════════════════════════════════
    public function index() {
        $userId = $_SESSION['user_id'];
        $user   = $this->userModel->find($userId);
        $profil = $this->profilModel->find($userId);
        
        // Ajouter le statut hébergeur
        if ($user && $user->role === 'hebergeur') {
            $user->statut_hebergeur = $user->statut_hebergeur ?? 'en_attente';
        }

        // Stats hébergeur
        $stats = $this->userModel->query(
            "SELECT
                (SELECT COUNT(*) FROM hebergement   WHERE hebergeur_id = ?) as nb_hebergements,
                (SELECT COUNT(*) FROM hebergement   WHERE hebergeur_id = ? AND statut = 'approuve') as nb_actifs,
                (SELECT COUNT(*) FROM reservation r
                 JOIN hebergement h ON r.hebergement_id = h.id
                 WHERE h.hebergeur_id = ?) as nb_reservations,
                (SELECT COUNT(*) FROM avis a
                 JOIN hebergement h ON a.hebergement_id = h.id
                 WHERE h.hebergeur_id = ?) as nb_avis",
            [$userId, $userId, $userId, $userId]
        );
        $stats = $stats[0] ?? null;

        $this->view('hebergeur/profil/index', [
            'title'  => 'Mon profil - BeninExplore',
            'user'   => $user,
            'profil' => $profil,
            'stats'  => $stats,
        ]);
    }

    // ════════════════════════════════════════════════
    // FORMULAIRE modification
    // ════════════════════════════════════════════════
    public function edit() {
        $userId = $_SESSION['user_id'];
        $user   = $this->userModel->find($userId);
        $profil = $this->profilModel->find($userId);

        $this->view('hebergeur/profil/edit', [
            'title'  => 'Modifier mon profil - BeninExplore',
            'user'   => $user,
            'profil' => $profil,
        ]);
    }

    // ════════════════════════════════════════════════
    // TRAITEMENT mise à jour
    // ════════════════════════════════════════════════
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/profil');
        }

        $userId = $_SESSION['user_id'];

        // ── Données utilisateur ──
        $userData = [
            'telephone'       => trim($_POST['telephone']  ?? ''),
            'langue_preferee' => $_POST['langue']          ?? 'fr',
            'newsletter'      => isset($_POST['newsletter']) ? 1 : 0,
        ];

        // ── Upload avatar ──
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarUrl = $this->uploadAvatar($_FILES['avatar'], $userId);
            if ($avatarUrl) {
                $user = $this->userModel->find($userId);
                if (!empty($user->avatar_url) && strpos($user->avatar_url, '/uploads/') !== false) {
                    $old = ROOT_PATH . '/public' . $user->avatar_url;
                    if (file_exists($old)) unlink($old);
                }
<<<<<<< HEAD
                $data['avatar_url'] = $avatarUrl;
            }
        }

        $updated = $this->userModel->update($userId, $data);

        if ($updated) {
            $_SESSION['user']['name']   = $prenom . ' ' . $nom;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['nom']    = $nom;
            $_SESSION['success']        = "Profil hébergeur mis à jour avec succès ✅";
            $this->redirect('/hebergeur/profil');
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour";
            $this->redirect('/hebergeur/profil/edit');
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/profil');
            return;
        }

        $userId  = $_SESSION['user']['id'];
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password']     ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $errors = [];
        if (empty($current))   $errors[] = "Le mot de passe actuel est requis";
        if (strlen($new) < 6)  $errors[] = "Le nouveau mot de passe doit contenir au moins 6 caractères";
        if ($new !== $confirm)  $errors[] = "Les mots de passe ne correspondent pas";

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('/hebergeur/profil');
            return;
        }

        $user = $this->userModel->find($userId);

        if (!$this->userModel->verifyPassword($current, $user->mot_de_passe_hash)) {
            $_SESSION['error'] = "Mot de passe actuel incorrect";
            $this->redirect('/hebergeur/profil');
            return;
        }

        $updated = $this->userModel->update($userId, [
            'mot_de_passe_hash' => $this->userModel->hashPassword($new)
        ]);

        if ($updated) {
            $_SESSION['success'] = "Mot de passe changé avec succès 🔒";
        } else {
            $_SESSION['error'] = "Erreur lors du changement de mot de passe";
        }
        $this->redirect('/hebergeur/profil');
    }

    private function getHebergeurStats($userId) {
        $sql = "SELECT
                    (SELECT COUNT(*) FROM hebergement WHERE hebergeur_id = ?) as nb_hebergements,
                    (SELECT COUNT(*) FROM reservation r
                     JOIN hebergement h ON r.hebergement_id = h.id
                     WHERE h.hebergeur_id = ?) as nb_reservations,
                    (SELECT COALESCE(SUM(r.montant_total), 0) FROM reservation r
                     JOIN hebergement h ON r.hebergement_id = h.id
                     WHERE h.hebergeur_id = ? AND r.statut = 'confirmee') as chiffre_affaires";

        $result = $this->userModel->query($sql, [$userId, $userId, $userId]);
        return $result[0] ?? null;
    }

=======
                $userData['avatar_url'] = $avatarUrl;
            }
        }

        $this->userModel->update($userId, $userData);

        // ── Données profil hébergeur ──
        $profilData = [
            'nom_etablissement' => trim($_POST['nom_etablissement'] ?? ''),
            'description'       => trim($_POST['description']       ?? ''),
            'adresse'           => trim($_POST['adresse']           ?? ''),
            'numero_siret'      => trim($_POST['numero_siret']      ?? ''),
        ];

        $existingProfil = $this->profilModel->find($userId);
        if ($existingProfil) {
            $this->profilModel->update($userId, $profilData);
        } else {
            $profilData['id'] = $userId;
            $this->profilModel->create($profilData);
        }

        $_SESSION['success'] = "Profil mis à jour avec succès ✅";
        $this->redirect('/hebergeur/profil');
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Upload avatar
    // ════════════════════════════════════════════════
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    private function uploadAvatar(array $file, int $userId): ?string {
        $uploadDir = ROOT_PATH . '/public/uploads/avatars/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) return null;
        if ($file['size'] > 2 * 1024 * 1024) return null;

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
<<<<<<< HEAD
        $filename = 'hebergeur_' . $userId . '_' . time() . '.' . $ext;
=======
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return '/uploads/avatars/' . $filename;
        }
        return null;
    }
}