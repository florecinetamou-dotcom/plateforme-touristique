<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;

class FavoriController extends Controller {

    private $model;

    public function __construct() {
        $this->model = new Hebergement();
    }

    // ════════════════════════════════════════════════
    // LISTE des favoris de l'utilisateur connecté
    // ════════════════════════════════════════════════
    public function index() {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];

        $favoris = $this->model->query(
            "SELECT h.*, v.nom as ville_nom,
                    (SELECT url FROM photo_hebergement
                     WHERE hebergement_id = h.id AND est_principale = 1
                     LIMIT 1) as photo,
                    f.date_ajout, f.note_privee
             FROM favori f
             JOIN hebergement h ON f.hebergement_id = h.id
             LEFT JOIN ville v ON h.ville_id = v.id
             WHERE f.voyageur_id = ?
             ORDER BY f.date_ajout DESC",
            [$userId]
        );

        $this->view('front/favori/index', [
            'title'   => 'Mes favoris - BeninExplore',
            'favoris' => $favoris
        ]);
    }

    // ════════════════════════════════════════════════
    // TOGGLE — Ajouter ou retirer un favori
    // ════════════════════════════════════════════════
    public function toggle($hebergementId) {
        // Si non connecté → rediriger vers login
        if (empty($_SESSION['user_id'])) {
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['redirect' => '/login']);
                exit;
            }
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergements');
        }

        $userId = $_SESSION['user_id'];

        // Vérifier si déjà en favori
        $existe = $this->model->query(
            "SELECT 1 FROM favori WHERE voyageur_id = ? AND hebergement_id = ? LIMIT 1",
            [$userId, $hebergementId]
        );

        if (!empty($existe)) {
            // ── Retirer ──
            $this->model->query(
                "DELETE FROM favori WHERE voyageur_id = ? AND hebergement_id = ?",
                [$userId, $hebergementId]
            );
            $actif   = false;
            $message = "Retiré des favoris";
        } else {
            // ── Ajouter ──
            $this->model->query(
                "INSERT INTO favori (voyageur_id, hebergement_id, date_ajout) VALUES (?, ?, NOW())",
                [$userId, $hebergementId]
            );
            $actif   = true;
            $message = "Ajouté aux favoris";
        }

        // Réponse AJAX
        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'actif'   => $actif,
                'message' => $message
            ]);
            exit;
        }

        // Réponse normale (fallback sans JS)
        $_SESSION['success'] = $message;
        $referer = $_SERVER['HTTP_REFERER'] ?? '/hebergements';
        $this->redirect($referer);
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Vérifier si requête AJAX
    // ════════════════════════════════════════════════
    private function isAjax(): bool {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Vérifier connexion
    // ════════════════════════════════════════════════
    private function requireLogin(): void {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}