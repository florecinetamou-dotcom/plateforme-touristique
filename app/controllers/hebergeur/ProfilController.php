<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\User;
use App\Models\ProfilHebergeur;
use App\Middleware\HebergeurMiddleware;

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 3));

class ProfilController extends Controller {

    private $userModel;
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

        // Stats hébergeur
        $stats = $this->userModel->query(
            "SELECT
                (SELECT COUNT(*) FROM hebergement   WHERE hebergeur_id = ?) as nb_hebergements,
                (SELECT COUNT(*) FROM hebergement   WHERE hebergeur_id = ? AND statut = 'approuve') as nb_actifs,
                (SELECT COUNT(*) FROM reservation r
                 JOIN hebergement h ON r.hebergement_id = h.id
                 WHERE h.hebergeur_id = ?) as nb_reservations",
            [$userId, $userId, $userId]
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
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarUrl = $this->uploadAvatar($_FILES['avatar'], $userId);
            if ($avatarUrl) {
                // Supprimer l'ancien avatar
                $user = $this->userModel->find($userId);
                if (!empty($user->avatar_url) && strpos($user->avatar_url, '/uploads/') !== false) {
                    $old = ROOT_PATH . '/public' . $user->avatar_url;
                    if (file_exists($old)) unlink($old);
                }
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

        // Vérifier si le profil existe déjà
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
    private function uploadAvatar(array $file, int $userId): ?string {
        $uploadDir = ROOT_PATH . '/public/uploads/avatars/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) return null;
        if ($file['size'] > 2 * 1024 * 1024) return null;

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return '/uploads/avatars/' . $filename;
        }
        return null;
    }
}