<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;

class SiteAdminController extends Controller {

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
        $search   = trim($_GET['search']   ?? '');
        $ville_id = $_GET['ville_id']      ?? '';
        $categorie= $_GET['categorie']     ?? '';
        $valide   = $_GET['valide']        ?? '';
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $offset   = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $where   .= " AND (s.nom LIKE ? OR s.description LIKE ?)";
            $like     = "%$search%";
            $params   = array_merge($params, [$like, $like]);
        }
        if ($ville_id !== '') {
            $where   .= " AND s.ville_id = ?";
            $params[] = $ville_id;
        }
        if ($categorie !== '') {
            $where   .= " AND s.categorie = ?";
            $params[] = $categorie;
        }
        if ($valide !== '') {
            $where   .= " AND s.est_valide = ?";
            $params[] = (int)$valide;
        }

        $base = "FROM site_touristique s JOIN ville v ON s.ville_id = v.id $where";

        $total_res   = $this->model->query("SELECT COUNT(*) as total $base", $params);
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $sites = $this->model->query(
            "SELECT s.*, v.nom as ville_nom $base
             ORDER BY s.id DESC
             LIMIT " . self::PER_PAGE . " OFFSET $offset",
            $params
        );

        $villes = $this->model->query("SELECT id, nom FROM ville WHERE est_active = 1 ORDER BY nom ASC");

        $this->view('admin/sites/index', [
            'sites'       => $sites,
            'total'       => $total,
            'total_pages' => $total_pages,
            'page'        => $page,
            'villes'      => $villes,
            'badges'      => $this->getBadges(),
            'filters'     => compact('search', 'ville_id', 'categorie', 'valide'),
        ]);
    }

    // =========================================================
    //  FORMULAIRE CRÉATION
    // =========================================================
    public function create() {
        $villes = $this->model->query("SELECT id, nom FROM ville WHERE est_active = 1 ORDER BY nom ASC");

        $this->view('admin/sites/form', [
            'site'   => null,
            'villes' => $villes,
            'badges' => $this->getBadges(),
            'mode'   => 'create',
        ]);
    }

    // =========================================================
    //  ENREGISTRER
    // =========================================================
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $data = $this->validerFormulaire();
        if (!$data) return;

        // Upload photo
        $photo_url = $this->uploadPhoto();

        $this->model->query(
            "INSERT INTO site_touristique 
             (ville_id, nom, description, categorie, adresse, latitude, longitude, prix_entree, heure_ouverture, heure_fermeture, photo_url, est_valide)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['ville_id'],
                $data['nom'],
                $data['description'],
                $data['categorie'],
                $data['adresse'],
                $data['latitude'] ?: null,
                $data['longitude'] ?: null,
                $data['prix_entree'],
                $data['heure_ouverture'] ?: null,
                $data['heure_fermeture'] ?: null,
                $photo_url,
                $data['est_valide'],
            ]
        );

        $_SESSION['success'] = "Site touristique \"{$data['nom']}\" créé avec succès.";
        $this->redirect('/admin/sites');
    }

    // =========================================================
    //  FORMULAIRE ÉDITION
    // =========================================================
    public function edit($id) {
        $site = $this->getSiteOuRediriger($id);
        $villes = $this->model->query("SELECT id, nom FROM ville WHERE est_active = 1 ORDER BY nom ASC");

        $this->view('admin/sites/form', [
            'site'   => $site,
            'villes' => $villes,
            'badges' => $this->getBadges(),
            'mode'   => 'edit',
        ]);
    }

    // =========================================================
    //  METTRE À JOUR
    // =========================================================
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $site = $this->getSiteOuRediriger($id);
        $data = $this->validerFormulaire();
        if (!$data) return;

        // Upload nouvelle photo si fournie
        $photo_url = $this->uploadPhoto() ?? $site->photo_url;

        $this->model->query(
            "UPDATE site_touristique SET
             ville_id=?, nom=?, description=?, categorie=?, adresse=?,
             latitude=?, longitude=?, prix_entree=?,
             heure_ouverture=?, heure_fermeture=?, photo_url=?, est_valide=?
             WHERE id=?",
            [
                $data['ville_id'],
                $data['nom'],
                $data['description'],
                $data['categorie'],
                $data['adresse'],
                $data['latitude'] ?: null,
                $data['longitude'] ?: null,
                $data['prix_entree'],
                $data['heure_ouverture'] ?: null,
                $data['heure_fermeture'] ?: null,
                $photo_url,
                $data['est_valide'],
                $id,
            ]
        );

        $_SESSION['success'] = "Site \"{$data['nom']}\" mis à jour avec succès.";
        $this->redirect('/admin/sites');
    }

    // =========================================================
    //  SUPPRIMER
    // =========================================================
    public function supprimer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $site = $this->getSiteOuRediriger($id);

        // Supprimer la photo physique si locale
        if (!empty($site->photo_url) && strpos($site->photo_url, '/uploads/') !== false) {
            $chemin = dirname(__DIR__, 3) . '/public' . $site->photo_url;
            if (file_exists($chemin)) unlink($chemin);
        }

        $this->model->query("DELETE FROM site_touristique WHERE id = ?", [$id]);

        $_SESSION['success'] = "Site \"{$site->nom}\" supprimé.";
        $this->redirect('/admin/sites');
    }

    // =========================================================
    //  TOGGLE PUBLIER / DÉPUBLIER
    // =========================================================
    public function toggleValide($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $site      = $this->getSiteOuRediriger($id);
        $nouveau   = $site->est_valide ? 0 : 1;
        $label     = $nouveau ? 'publié' : 'dépublié';

        $this->model->query("UPDATE site_touristique SET est_valide = ? WHERE id = ?", [$nouveau, $id]);

        $_SESSION['success'] = "Site \"{$site->nom}\" $label.";
        $this->redirect('/admin/sites');
    }

    // =========================================================
    //  DÉTAIL
    // =========================================================
    public function show($id) {
        $site = $this->getSiteOuRediriger($id);

        $this->view('admin/sites/show', [
            'site'   => $site,
            'badges' => $this->getBadges(),
        ]);
    }

    // =========================================================
    //  PRIVÉ
    // =========================================================
    private function validerFormulaire(): array|false {
        $nom      = trim($_POST['nom']      ?? '');
        $ville_id = (int)($_POST['ville_id'] ?? 0);

        if (empty($nom) || $ville_id === 0) {
            $_SESSION['error'] = "Le nom et la ville sont obligatoires.";
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/sites/create');
            return false;
        }

        return [
            'ville_id'        => $ville_id,
            'nom'             => $nom,
            'description'     => trim($_POST['description']     ?? ''),
            'categorie'       => $_POST['categorie']            ?? 'autre',
            'adresse'         => trim($_POST['adresse']         ?? ''),
            'latitude'        => trim($_POST['latitude']        ?? ''),
            'longitude'       => trim($_POST['longitude']       ?? ''),
            'prix_entree'     => (float)($_POST['prix_entree']  ?? 0),
            'heure_ouverture' => trim($_POST['heure_ouverture'] ?? ''),
            'heure_fermeture' => trim($_POST['heure_fermeture'] ?? ''),
            'est_valide'      => isset($_POST['est_valide']) ? 1 : 0,
        ];
    }

    private function uploadPhoto(): ?string {
        if (empty($_FILES['photo']['name'])) return null;

        $file    = $_FILES['photo'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($file['type'], $allowed)) {
            $_SESSION['error'] = "Format de photo invalide (JPG, PNG, WEBP uniquement).";
            return null;
        }

        if ($file['size'] > 3 * 1024 * 1024) {
            $_SESSION['error'] = "La photo ne doit pas dépasser 3 Mo.";
            return null;
        }

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'site_' . uniqid() . '.' . $ext;
        $dir      = dirname(__DIR__, 3) . '/public/uploads/sites/';

        if (!is_dir($dir)) mkdir($dir, 0755, true);

        move_uploaded_file($file['tmp_name'], $dir . $filename);

        return '/uploads/sites/' . $filename;
    }

    private function getSiteOuRediriger(int $id): object {
        $r = $this->model->query(
            "SELECT s.*, v.nom as ville_nom FROM site_touristique s
             JOIN ville v ON s.ville_id = v.id
             WHERE s.id = ? LIMIT 1",
            [$id]
        );
        if (empty($r)) {
            $_SESSION['error'] = "Site touristique introuvable.";
            $this->redirect('/admin/sites');
        }
        return $r[0];
    }

    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}