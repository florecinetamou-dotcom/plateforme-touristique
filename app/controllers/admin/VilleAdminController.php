<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class VilleAdminController extends Controller {

    private $model;
    const PER_PAGE = 15;

    public function __construct() {
        $this->requireAuth('admin');
        $this->model = new Hebergement(); // réutilise query()
    }

    // =========================================================
    //  LISTE
    // =========================================================
    public function index() {
        $search = trim($_GET['search'] ?? '');
        $active = $_GET['active']      ?? '';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $where   .= " AND nom LIKE ?";
            $params[] = "%$search%";
        }
        if ($active !== '') {
            $where   .= " AND est_active = ?";
            $params[] = (int)$active;
        }

        $total_res   = $this->model->query("SELECT COUNT(*) as total FROM ville $where", $params);
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $villes = $this->model->query(
            "SELECT v.*,
                    (SELECT COUNT(*) FROM hebergement h WHERE h.ville_id = v.id) as nb_hebergements,
                    (SELECT COUNT(*) FROM site_touristique s WHERE s.ville_id = v.id) as nb_sites
             FROM ville v
             $where
             ORDER BY v.nom ASC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        $this->view('admin/villes/index', [
            'villes'      => $villes,
            'total'       => $total,
            'total_pages' => $total_pages,
            'page'        => $page,
            'badges'      => $this->getBadges(),
            'filters'     => compact('search', 'active'),
        ]);
    }

    // =========================================================
    //  FORMULAIRE CRÉATION
    // =========================================================
    public function create() {
        $this->view('admin/villes/form', [
            'ville'  => null,
            'mode'   => 'create',
            'badges' => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  ENREGISTRER
    // =========================================================
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/villes');
        }

        $data = $this->validerFormulaire();
        if (!$data) return;

        // Vérifier doublon
        $exists = $this->model->query(
            "SELECT id FROM ville WHERE nom = ? LIMIT 1", [$data['nom']]
        );
        if (!empty($exists)) {
            $_SESSION['error'] = "Une ville avec ce nom existe déjà.";
            $this->redirect('/admin/villes/create');
            return;
        }

        $photo_url = $this->uploadPhoto();

        $this->model->query(
            "INSERT INTO ville (nom, description, latitude, longitude, photo_url, est_active)
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                $data['nom'],
                $data['description'],
                $data['latitude']  ?: null,
                $data['longitude'] ?: null,
                $photo_url,
                $data['est_active'],
            ]
        );

        $_SESSION['success'] = "Ville \"{$data['nom']}\" créée avec succès.";
        $this->redirect('/admin/villes');
    }

    // =========================================================
    //  FORMULAIRE ÉDITION
    // =========================================================
    public function edit($id) {
        $ville = $this->getVilleOuRediriger($id);

        $this->view('admin/villes/form', [
            'ville'  => $ville,
            'mode'   => 'edit',
            'badges' => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  METTRE À JOUR
    // =========================================================
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/villes');
        }

        $ville = $this->getVilleOuRediriger($id);
        $data  = $this->validerFormulaire();
        if (!$data) return;

        // Vérifier doublon (sauf elle-même)
        $exists = $this->model->query(
            "SELECT id FROM ville WHERE nom = ? AND id != ? LIMIT 1",
            [$data['nom'], $id]
        );
        if (!empty($exists)) {
            $_SESSION['error'] = "Une autre ville avec ce nom existe déjà.";
            $this->redirect("/admin/villes/edit/$id");
            return;
        }

        $photo_url = $this->uploadPhoto() ?? $ville->photo_url;

        $this->model->query(
            "UPDATE ville SET nom=?, description=?, latitude=?, longitude=?, photo_url=?, est_active=?
             WHERE id=?",
            [
                $data['nom'],
                $data['description'],
                $data['latitude']  ?: null,
                $data['longitude'] ?: null,
                $photo_url,
                $data['est_active'],
                $id,
            ]
        );

        $_SESSION['success'] = "Ville \"{$data['nom']}\" mise à jour.";
        $this->redirect('/admin/villes');
    }

    // =========================================================
    //  SUPPRIMER
    // =========================================================
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/villes');
        }

        $ville = $this->getVilleOuRediriger($id);

        // Vérifier qu'aucun hébergement n'est lié
        $nb = $this->model->query(
            "SELECT COUNT(*) as nb FROM hebergement WHERE ville_id = ?", [$id]
        );
        if (($nb[0]->nb ?? 0) > 0) {
            $_SESSION['error'] = "Impossible de supprimer \"{$ville->nom}\" — elle contient des hébergements.";
            $this->redirect('/admin/villes');
            return;
        }

        // Supprimer la photo locale si existe
        if (!empty($ville->photo_url) && strpos($ville->photo_url, '/uploads/') !== false) {
            $chemin = dirname(__DIR__, 3) . '/public' . $ville->photo_url;
            if (file_exists($chemin)) unlink($chemin);
        }

        $this->model->query("DELETE FROM ville WHERE id = ?", [$id]);

        $_SESSION['success'] = "Ville \"{$ville->nom}\" supprimée.";
        $this->redirect('/admin/villes');
    }

    // =========================================================
    //  TOGGLE ACTIF
    // =========================================================
    public function toggleActive($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/villes');
        }

        $ville   = $this->getVilleOuRediriger($id);
        $nouveau = $ville->est_active ? 0 : 1;
        $label   = $nouveau ? 'activée' : 'désactivée';

        $this->model->query("UPDATE ville SET est_active = ? WHERE id = ?", [$nouveau, $id]);

        $_SESSION['success'] = "Ville \"{$ville->nom}\" $label.";
        $this->redirect('/admin/villes');
    }

    // =========================================================
    //  DÉTAIL
    // =========================================================
    public function show($id) {
        $ville = $this->getVilleOuRediriger($id);

        $hebergements = $this->model->query(
            "SELECT id, nom, statut, prix_nuit_base FROM hebergement WHERE ville_id = ? ORDER BY nom ASC LIMIT 10",
            [$id]
        );

        $sites = $this->model->query(
            "SELECT id, nom, categorie, est_valide FROM site_touristique WHERE ville_id = ? ORDER BY nom ASC LIMIT 10",
            [$id]
        );

        $this->view('admin/villes/show', [
            'ville'        => $ville,
            'hebergements' => $hebergements,
            'sites'        => $sites,
            'badges'       => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  PRIVÉ
    // =========================================================
    private function validerFormulaire(): array|false {
        $nom = trim($_POST['nom'] ?? '');

        if (empty($nom)) {
            $_SESSION['error'] = "Le nom de la ville est obligatoire.";
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/villes/create');
            return false;
        }

        return [
            'nom'         => $nom,
            'description' => trim($_POST['description'] ?? ''),
            'latitude'    => trim($_POST['latitude']    ?? ''),
            'longitude'   => trim($_POST['longitude']   ?? ''),
            'est_active'  => isset($_POST['est_active']) ? 1 : 0,
        ];
    }

    private function uploadPhoto(): ?string {
        if (empty($_FILES['photo']['name'])) return null;

        $file    = $_FILES['photo'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($file['type'], $allowed)) {
            $_SESSION['error'] = "Format invalide (JPG, PNG, WEBP uniquement).";
            return null;
        }
        if ($file['size'] > 3 * 1024 * 1024) {
            $_SESSION['error'] = "La photo ne doit pas dépasser 3 Mo.";
            return null;
        }

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'ville_' . uniqid() . '.' . $ext;
        $dir      = dirname(__DIR__, 3) . '/public/uploads/villes/';

        if (!is_dir($dir)) mkdir($dir, 0755, true);

        move_uploaded_file($file['tmp_name'], $dir . $filename);

        return '/uploads/villes/' . $filename;
    }

    private function getVilleOuRediriger(int $id): object {
        $r = $this->model->query("SELECT * FROM ville WHERE id = ? LIMIT 1", [$id]);
        if (empty($r)) {
            $_SESSION['error'] = "Ville introuvable.";
            $this->redirect('/admin/villes');
        }
        return $r[0];
    }

    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}