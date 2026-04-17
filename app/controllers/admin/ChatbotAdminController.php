<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class ChatbotAdminController extends Controller {

    private $model;
    const PER_PAGE = 20;

    public function __construct() {
        $this->requireAuth('admin');
        $this->model = new Hebergement();
    }

    // =========================================================
    //  DASHBOARD CHATBOT (index)
    // =========================================================
    public function index() {
        // Stats
        $r = $this->model->query("SELECT COUNT(*) as nb FROM chatbot_conversations");
        $total_conv = $r[0]->nb ?? 0;

        $r = $this->model->query("SELECT COUNT(*) as nb FROM chatbot_conversations WHERE DATE(date_envoi) = CURDATE()");
        $conv_today = $r[0]->nb ?? 0;

        $r = $this->model->query("SELECT COUNT(*) as nb FROM chatbot_intentions");
        $total_intentions = $r[0]->nb ?? 0;

        $r = $this->model->query("SELECT COUNT(*) as nb FROM chatbot_conversations WHERE utilisateur_id IS NOT NULL");
        $conv_connectes = $r[0]->nb ?? 0;

        // Dernières conversations
        $conversations = $this->model->query(
            "SELECT c.*, u.nom as user_nom, u.prenom as user_prenom
             FROM chatbot_conversations c
             LEFT JOIN utilisateur u ON c.utilisateur_id = u.id
             ORDER BY c.date_envoi DESC
             LIMIT 10"
        );

        // Intentions les plus déclenchées (approx via mot_cle dans messages)
        $intentions = $this->model->query(
            "SELECT i.*, r.reponse_texte,
                    (SELECT COUNT(*) FROM chatbot_conversations c
                     WHERE LOWER(c.message_utilisateur COLLATE utf8mb4_unicode_ci)
                           LIKE CONCAT('%', LOWER(i.mot_cle COLLATE utf8mb4_unicode_ci), '%')) as nb_declenchements
             FROM chatbot_intentions i
             LEFT JOIN chatbot_reponses r ON r.intention_id = i.id
             ORDER BY nb_declenchements DESC"
        );

        $this->view('admin/chatbot/index', [
            'total_conv'       => $total_conv,
            'conv_today'       => $conv_today,
            'total_intentions' => $total_intentions,
            'conv_connectes'   => $conv_connectes,
            'conversations'    => $conversations,
            'intentions'       => $intentions,
            'badges'           => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  CONVERSATIONS (liste paginée)
    // =========================================================
    public function conversations() {
        $search = trim($_GET['search'] ?? '');
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $where   .= " AND (c.message_utilisateur LIKE ? OR c.reponse_bot LIKE ?)";
            $like     = "%$search%";
            $params   = [$like, $like];
        }

        $total_res   = $this->model->query("SELECT COUNT(*) as total FROM chatbot_conversations c $where", $params);
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $conversations = $this->model->query(
            "SELECT c.*, u.nom as user_nom, u.prenom as user_prenom, u.email as user_email
             FROM chatbot_conversations c
             LEFT JOIN utilisateur u ON c.utilisateur_id = u.id
             $where
             ORDER BY c.date_envoi DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        $this->view('admin/chatbot/conversations', [
            'conversations' => $conversations,
            'total'         => $total,
            'total_pages'   => $total_pages,
            'page'          => $page,
            'search'        => $search,
            'badges'        => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  INTENTIONS — LISTE
    // =========================================================
    public function intentions() {
        $intentions = $this->model->query(
            "SELECT i.*, r.id as reponse_id, r.reponse_texte, r.date_modification
             FROM chatbot_intentions i
             LEFT JOIN chatbot_reponses r ON r.intention_id = i.id
             ORDER BY i.date_creation DESC"
        );

        $this->view('admin/chatbot/intentions', [
            'intentions' => $intentions,
            'badges'     => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  INTENTION — CRÉER
    // =========================================================
    public function creerIntention() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/chatbot/intentions');
        }

        $mot_cle     = trim($_POST['mot_cle']      ?? '');
        $description = trim($_POST['description']  ?? '');
        $reponse     = trim($_POST['reponse_texte'] ?? '');

        if (empty($mot_cle) || empty($reponse)) {
            $_SESSION['error'] = "Le mot-clé et la réponse sont obligatoires.";
            $this->redirect('/admin/chatbot/intentions');
            return;
        }

        // Vérifier doublon mot_cle
        $exists = $this->model->query("SELECT id FROM chatbot_intentions WHERE mot_cle = ? LIMIT 1", [$mot_cle]);
        if (!empty($exists)) {
            $_SESSION['error'] = "Ce mot-clé existe déjà.";
            $this->redirect('/admin/chatbot/intentions');
            return;
        }

        $this->model->query(
            "INSERT INTO chatbot_intentions (mot_cle, description) VALUES (?, ?)",
            [$mot_cle, $description]
        );

        // Récupérer le dernier ID inséré
        $last = $this->model->query("SELECT id FROM chatbot_intentions WHERE mot_cle = ? LIMIT 1", [$mot_cle]);
        $intention_id = $last[0]->id ?? null;

        if ($intention_id) {
            $this->model->query(
                "INSERT INTO chatbot_reponses (intention_id, reponse_texte) VALUES (?, ?)",
                [$intention_id, $reponse]
            );
        }

        $_SESSION['success'] = "Intention \"$mot_cle\" créée avec succès.";
        $this->redirect('/admin/chatbot/intentions');
    }

    // =========================================================
    //  INTENTION — MODIFIER
    // =========================================================
    public function modifierIntention($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/chatbot/intentions');
        }

        $mot_cle     = trim($_POST['mot_cle']       ?? '');
        $description = trim($_POST['description']   ?? '');
        $reponse     = trim($_POST['reponse_texte'] ?? '');
        $reponse_id  = (int)($_POST['reponse_id']   ?? 0);

        if (empty($mot_cle) || empty($reponse)) {
            $_SESSION['error'] = "Le mot-clé et la réponse sont obligatoires.";
            $this->redirect('/admin/chatbot/intentions');
            return;
        }

        $this->model->query(
            "UPDATE chatbot_intentions SET mot_cle = ?, description = ? WHERE id = ?",
            [$mot_cle, $description, $id]
        );

        if ($reponse_id) {
            $this->model->query(
                "UPDATE chatbot_reponses SET reponse_texte = ? WHERE id = ?",
                [$reponse, $reponse_id]
            );
        } else {
            $this->model->query(
                "INSERT INTO chatbot_reponses (intention_id, reponse_texte) VALUES (?, ?)",
                [$id, $reponse]
            );
        }

        $_SESSION['success'] = "Intention \"$mot_cle\" mise à jour.";
        $this->redirect('/admin/chatbot/intentions');
    }

    // =========================================================
    //  INTENTION — SUPPRIMER
    // =========================================================
    public function supprimerIntention($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/chatbot/intentions');
        }

        $r = $this->model->query("SELECT mot_cle FROM chatbot_intentions WHERE id = ? LIMIT 1", [$id]);
        $label = $r[0]->mot_cle ?? "l'intention";

        $this->model->query("DELETE FROM chatbot_intentions WHERE id = ?", [$id]);

        $_SESSION['success'] = "Intention \"$label\" supprimée.";
        $this->redirect('/admin/chatbot/intentions');
    }

    // =========================================================
    //  DÉTAIL D'UNE SESSION
    // =========================================================
    public function conversation($sessionId) {
        $messages = $this->model->query(
            "SELECT c.*, u.prenom as user_prenom, u.nom as user_nom
             FROM chatbot_conversations c
             LEFT JOIN utilisateur u ON c.utilisateur_id = u.id
             WHERE c.session_id = ?
             ORDER BY c.date_envoi ASC",
            [$sessionId]
        );

        if (empty($messages)) {
            $_SESSION['error'] = "Session introuvable.";
            $this->redirect('/admin/chatbot/conversations');
        }

        $this->view('admin/chatbot/conversation', [
            'messages'   => $messages,
            'session_id' => $sessionId,
            'badges'     => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  SUPPRIMER UNE CONVERSATION
    // =========================================================
    public function supprimerConversation($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/chatbot/conversations');
        }
        $this->model->query("DELETE FROM chatbot_conversations WHERE id = ?", [$id]);
        $_SESSION['success'] = "Conversation supprimée.";
        $this->redirect('/admin/chatbot/conversations');
    }

    // =========================================================
    //  VIDER TOUTES LES CONVERSATIONS
    // =========================================================
    public function viderConversations() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/chatbot');
        }
        $this->model->query("DELETE FROM chatbot_conversations");
        $_SESSION['success'] = "Toutes les conversations ont été supprimées.";
        $this->redirect('/admin/chatbot');
    }

    // =========================================================
    //  PRIVÉ
    // =========================================================
    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}