<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 3));

class SiteAdminController extends Controller {

    private $model;
    const PER_PAGE = 15;

    public function __construct() {
        $this->requireAuth('admin');
        $this->model = new Hebergement();
    }

    // ════════════════════════════════════════════════
    // LISTE
    // ════════════════════════════════════════════════
    public function index() {
        $search    = trim($_GET['search']   ?? '');
        $ville_id  = $_GET['ville_id']      ?? '';
        $categorie = $_GET['categorie']     ?? '';
        $valide    = $_GET['valide']        ?? '';
        $page      = max(1, (int)($_GET['page'] ?? 1));
        $offset    = ($page - 1) * self::PER_PAGE;

        $where  = "WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $where   .= " AND (s.nom LIKE ? OR s.description LIKE ?)";
            $like     = "%$search%";
            $params   = array_merge($params, [$like, $like]);
        }
        if ($ville_id !== '') { $where .= " AND s.ville_id = ?"; $params[] = $ville_id; }
        if ($categorie !== '') { $where .= " AND s.categorie = ?"; $params[] = $categorie; }
        if ($valide !== '') { $where .= " AND s.est_valide = ?"; $params[] = (int)$valide; }

        $total_res   = $this->model->query(
            "SELECT COUNT(*) as total FROM site_touristique s LEFT JOIN ville v ON s.ville_id = v.id $where",
            $params
        );
        $total       = $total_res[0]->total ?? 0;
        $total_pages = max(1, ceil($total / self::PER_PAGE));

        $sites = $this->model->query(
            "SELECT s.*, v.nom as ville_nom,
                    (SELECT url FROM photo_site_touristique WHERE site_id = s.id AND est_principale = 1 LIMIT 1) as photo_url
             FROM site_touristique s
             LEFT JOIN ville v ON s.ville_id = v.id
             $where
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

    // ════════════════════════════════════════════════
    // FORMULAIRE CRÉATION
    // ════════════════════════════════════════════════
    public function create() {
        $villes = $this->model->query("SELECT id, nom FROM ville WHERE est_active = 1 ORDER BY nom ASC");

        $this->view('admin/sites/form', [
            'site'              => null,
            'villes'            => $villes,
            'badges'            => $this->getBadges(),
            'mode'              => 'create',
            'photoPrincipale'   => null,
            'photosSecondaires' => [],
        ]);
    }

    // ════════════════════════════════════════════════
    // ENREGISTRER
    // ════════════════════════════════════════════════
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $data = $this->validerFormulaire();
        if (!$data) return;

        $this->model->query(
            "INSERT INTO site_touristique
             (ville_id, nom, description, categorie, adresse, latitude, longitude,
              prix_entree, heure_ouverture, heure_fermeture, est_valide)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['ville_id'], $data['nom'], $data['description'], $data['categorie'],
                $data['adresse'], $data['latitude'] ?: null, $data['longitude'] ?: null,
                $data['prix_entree'], $data['heure_ouverture'] ?: null,
                $data['heure_fermeture'] ?: null, $data['est_valide'],
            ]
        );

        $res    = $this->model->query("SELECT LAST_INSERT_ID() as id");
        $siteId = $res[0]->id ?? null;

        if ($siteId) {
            $this->handlePhotoUpload($siteId);
        }

        $_SESSION['success'] = "Site \"{$data['nom']}\" créé avec succès.";
        $this->redirect('/admin/sites');
    }

    // ════════════════════════════════════════════════
    // FORMULAIRE ÉDITION
    // ════════════════════════════════════════════════
    public function edit($id) {
        $site   = $this->getSiteOuRediriger($id);
        $villes = $this->model->query("SELECT id, nom FROM ville WHERE est_active = 1 ORDER BY nom ASC");
        $photos = $this->getPhotosSite($id);

        $photoPrincipale   = null;
        $photosSecondaires = [];
        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) $photoPrincipale = $photo;
            else $photosSecondaires[] = $photo;
        }

        $this->view('admin/sites/form', [
            'site'              => $site,
            'villes'            => $villes,
            'badges'            => $this->getBadges(),
            'mode'              => 'edit',
            'photoPrincipale'   => $photoPrincipale,
            'photosSecondaires' => $photosSecondaires,
        ]);
    }

    // ════════════════════════════════════════════════
    // METTRE À JOUR
    // ════════════════════════════════════════════════
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $this->getSiteOuRediriger($id);
        $data = $this->validerFormulaire();
        if (!$data) return;

        $this->model->query(
            "UPDATE site_touristique SET
             ville_id=?, nom=?, description=?, categorie=?, adresse=?,
             latitude=?, longitude=?, prix_entree=?,
             heure_ouverture=?, heure_fermeture=?, est_valide=?
             WHERE id=?",
            [
                $data['ville_id'], $data['nom'], $data['description'], $data['categorie'],
                $data['adresse'], $data['latitude'] ?: null, $data['longitude'] ?: null,
                $data['prix_entree'], $data['heure_ouverture'] ?: null,
                $data['heure_fermeture'] ?: null, $data['est_valide'], $id,
            ]
        );

        $this->handlePhotoUpload($id);

        $_SESSION['success'] = "Site \"{$data['nom']}\" mis à jour.";
        $this->redirect('/admin/sites');
    }

    // ════════════════════════════════════════════════
    // SUPPRIMER
    // ════════════════════════════════════════════════
    public function supprimer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $site = $this->getSiteOuRediriger($id);

        foreach ($this->getPhotosSite($id) as $photo) {
            $this->supprimerFichierPhoto($photo->url);
        }
        $this->model->query("DELETE FROM photo_site_touristique WHERE site_id = ?", [$id]);
        $this->model->query("DELETE FROM site_touristique WHERE id = ?", [$id]);

        $_SESSION['success'] = "Site \"{$site->nom}\" supprimé.";
        $this->redirect('/admin/sites');
    }

    // ════════════════════════════════════════════════
    // TOGGLE PUBLIER / DÉPUBLIER
    // ════════════════════════════════════════════════
    public function toggleValide($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/sites');
        }

        $site    = $this->getSiteOuRediriger($id);
        $nouveau = $site->est_valide ? 0 : 1;

        $this->model->query("UPDATE site_touristique SET est_valide = ? WHERE id = ?", [$nouveau, $id]);

        $_SESSION['success'] = "Site \"{$site->nom}\" " . ($nouveau ? 'publié' : 'dépublié') . ".";
        $this->redirect('/admin/sites');
    }

    // ════════════════════════════════════════════════
    // DÉTAIL
    // ════════════════════════════════════════════════
    public function show($id) {
        $site   = $this->getSiteOuRediriger($id);
        $photos = $this->getPhotosSite($id);

        $photoPrincipale   = null;
        $photosSecondaires = [];
        foreach ($photos as $photo) {
            if ($photo->est_principale == 1) $photoPrincipale = $photo;
            else $photosSecondaires[] = $photo;
        }

        $site->photo_principale   = $photoPrincipale;
        $site->photos_secondaires = $photosSecondaires;
        $site->photo_url          = $photoPrincipale->url ?? null;

        $this->view('admin/sites/show', [
            'site'   => $site,
            'badges' => $this->getBadges(),
        ]);
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Gérer l'upload photo principale + secondaires
    // ════════════════════════════════════════════════
    private function handlePhotoUpload(int $siteId): void {
        $uploadDir = ROOT_PATH . '/public/uploads/sites/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        // Photo principale
        if (isset($_FILES['photo_principale']) && $_FILES['photo_principale']['error'] === UPLOAD_ERR_OK) {
            // Supprimer l'ancienne
            $ancienne = $this->model->query(
                "SELECT * FROM photo_site_touristique WHERE site_id = ? AND est_principale = 1 LIMIT 1",
                [$siteId]
            );
            if (!empty($ancienne)) {
                $this->supprimerFichierPhoto($ancienne[0]->url);
                $this->model->query(
                    "DELETE FROM photo_site_touristique WHERE site_id = ? AND est_principale = 1",
                    [$siteId]
                );
            }

            $result = $this->uploadPhoto($_FILES['photo_principale'], $uploadDir, $siteId, 'main');
            if ($result['success']) {
                $this->model->query(
                    "INSERT INTO photo_site_touristique (site_id, url, est_principale, ordre) VALUES (?, ?, 1, 0)",
                    [$siteId, $result['path']]
                );
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
                    'size'     => $_FILES['photos_secondaires']['size'][$key],
                ];

                $result = $this->uploadPhoto($file, $uploadDir, $siteId, 'sec_' . ($key + 1));
                if ($result['success']) {
                    $this->model->query(
                        "INSERT INTO photo_site_touristique (site_id, url, est_principale, ordre) VALUES (?, ?, 0, ?)",
                        [$siteId, $result['path'], $key + 1]
                    );
                }
            }
        }
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Upload + validation d'un fichier photo
    // ════════════════════════════════════════════════
    private function uploadPhoto(array $file, string $uploadDir, int $siteId, string $suffix): array {
        $result = ['success' => false, 'path' => null, 'error' => null];

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'])) {
            $result['error'] = "Type non autorisé ($mimeType)";
            return $result;
        }
        if ($file['size'] > 3 * 1024 * 1024) {
            $result['error'] = "Fichier trop volumineux (max 3 Mo)";
            return $result;
        }

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'site_' . $siteId . '_' . $suffix . '_' . time() . '.' . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            $result['success'] = true;
            $result['path']    = '/uploads/sites/' . $filename;
        } else {
            $result['error'] = "Échec du déplacement vers $uploadDir$filename";
        }

        return $result;
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Supprimer fichier physique
    // ════════════════════════════════════════════════
    private function supprimerFichierPhoto(string $url): void {
        if (!empty($url) && strpos($url, '/uploads/') !== false) {
            $chemin = ROOT_PATH . '/public' . $url;
            if (file_exists($chemin)) unlink($chemin);
        }
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Toutes les photos d'un site
    // ════════════════════════════════════════════════
    private function getPhotosSite(int $siteId): array {
        return $this->model->query(
            "SELECT * FROM photo_site_touristique WHERE site_id = ? ORDER BY est_principale DESC, ordre ASC",
            [$siteId]
        );
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Valider le formulaire POST
    // ════════════════════════════════════════════════
    private function validerFormulaire(): array|false {
        $nom      = trim($_POST['nom']       ?? '');
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

    // ════════════════════════════════════════════════
    // PRIVÉ — Récupérer un site ou rediriger
    // ════════════════════════════════════════════════
    private function getSiteOuRediriger(int $id): object {
        $r = $this->model->query(
            "SELECT s.*, v.nom as ville_nom FROM site_touristique s
             LEFT JOIN ville v ON s.ville_id = v.id
             WHERE s.id = ? LIMIT 1",
            [$id]
        );
        if (empty($r)) {
            $_SESSION['error'] = "Site touristique introuvable.";
            $this->redirect('/admin/sites');
        }
        return $r[0];
    }

    // ════════════════════════════════════════════════
    // PRIVÉ — Badges sidebar
    // ════════════════════════════════════════════════
    private function getBadges(): array {
        $r = $this->model->query("SELECT COUNT(*) as nb FROM hebergement WHERE statut = 'en_attente'");
        return ['nb_hebergements_attente' => $r[0]->nb ?? 0];
    }
}