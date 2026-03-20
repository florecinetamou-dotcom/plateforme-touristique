<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\User;

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 3));

class ProfileController extends Controller {

    private $userModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à votre profil";
            $this->redirect('/login');
        }
        $this->userModel = new User();
    }

    // ════════════════════════════════════════════════
    // AFFICHER le profil
    // ════════════════════════════════════════════════
    public function index() {
        $user = $this->userModel->find($_SESSION['user_id']);

        // Statistiques du voyageur
        $stats = $this->userModel->query(
            "SELECT
                (SELECT COUNT(*) FROM reservation WHERE voyageur_id = ?) as nb_reservations,
                (SELECT COUNT(*) FROM favori      WHERE voyageur_id = ?) as nb_favoris,
                (SELECT COUNT(*) FROM avis         WHERE voyageur_id = ?) as nb_avis",
            [$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id']]
        );
        $stats = $stats[0] ?? null;

        $this->view('front/profile/index', [
            'title' => 'Mon profil - BeninExplore',
            'user'  => $user,
            'stats' => $stats,
        ]);
    }

    // ════════════════════════════════════════════════
    // MODIFIER le profil
    // ════════════════════════════════════════════════
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEdit();
            return;
        }

        $user = $this->userModel->find($_SESSION['user_id']);

        $this->view('front/profile/edit', [
            'title' => 'Modifier mon profil - BeninExplore',
            'user'  => $user,
        ]);
    }

    private function handleEdit(): void {
        $prenom    = trim($_POST['prenom']    ?? '');
        $nom       = trim($_POST['nom']       ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $langue    = $_POST['langue']         ?? 'fr';
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;

        $errors = [];
        if (empty($prenom)) $errors[] = "Le prénom est requis";
        if (empty($nom))    $errors[] = "Le nom est requis";

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('/profile/edit');
        }

        $data = [
            'prenom'          => $prenom,
            'nom'             => $nom,
            'telephone'       => $telephone,
            'langue_preferee' => $langue,
            'newsletter'      => $newsletter,
        ];

        // ── Upload avatar ──
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarUrl = $this->uploadAvatar($_FILES['avatar']);
            if ($avatarUrl) {
                // Supprimer l'ancien avatar
                $user = $this->userModel->find($_SESSION['user_id']);
                if (!empty($user->avatar_url) && strpos($user->avatar_url, '/uploads/') !== false) {
                    $old = ROOT_PATH . '/public' . $user->avatar_url;
                    if (file_exists($old)) unlink($old);
                }
                $data['avatar_url'] = $avatarUrl;
            }
        }

        $updated = $this->userModel->update($_SESSION['user_id'], $data);

        if ($updated) {
            $_SESSION['user_name']   = $prenom . ' ' . $nom;
            $_SESSION['success']     = "Profil mis à jour avec succès ✅";
            $this->redirect('/profile');
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour";
            $this->redirect('/profile/edit');
        }
    }

    // ════════════════════════════════════════════════
    // CHANGER le mot de passe
    // ════════════════════════════════════════════════
    public function password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePassword();
            return;
        }

        $this->view('front/profile/password', [
            'title' => 'Changer mon mot de passe - BeninExplore',
        ]);
    }

    private function handlePassword(): void {
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password']     ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $errors = [];
        if (empty($current))      $errors[] = "Le mot de passe actuel est requis";
        if (strlen($new) < 6)     $errors[] = "Le nouveau mot de passe doit contenir au moins 6 caractères";
        if ($new !== $confirm)    $errors[] = "Les mots de passe ne correspondent pas";

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('/profile/password');
        }

        $user = $this->userModel->find($_SESSION['user_id']);

        if (!$this->userModel->verifyPassword($current, $user->mot_de_passe_hash)) {
            $_SESSION['error'] = "Mot de passe actuel incorrect";
            $this->redirect('/profile/password');
        }

        $updated = $this->userModel->update($_SESSION['user_id'], [
            'mot_de_passe_hash' => $this->userModel->hashPassword($new)
        ]);

        if ($updated) {
            $_SESSION['success'] = "Mot de passe changé avec succès 🔒";
            $this->redirect('/profile');
        } else {
            $_SESSION['error'] = "Erreur lors du changement";
            $this->redirect('/profile/password');
        }
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Upload avatar
    // ════════════════════════════════════════════════
    private function uploadAvatar(array $file): ?string {
        $uploadDir = ROOT_PATH . '/public/uploads/avatars/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) return null;
        if ($file['size'] > 2 * 1024 * 1024) return null;

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return '/uploads/avatars/' . $filename;
        }
        return null;
    }
}