<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;
use App\Models\SiteTouristique;
use App\Models\Avis;

class HomeController extends Controller {

    public function index() {
        $hebergementModel = new Hebergement();
        $villeModel       = new Ville();
        $siteModel        = new SiteTouristique();

        // ── Hébergements populaires (3) avec photo ──
        $hebergementsPopulaires = $hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom,
                    (SELECT url FROM photo_hebergement
                     WHERE hebergement_id = h.id AND est_principale = 1
                     LIMIT 1) as photo
             FROM hebergement h
             JOIN ville v ON h.ville_id = v.id
             WHERE h.statut = 'approuve'
             ORDER BY h.note_moyenne DESC, h.date_creation DESC
             LIMIT 3"
        );

        // ── Villes actives avec nb hébergements + photo ──
        $villes = $villeModel->query(
            "SELECT v.*,
                    (SELECT COUNT(*) FROM hebergement h
                     WHERE h.ville_id = v.id AND h.statut = 'approuve') as nb_hebergements,
                    (SELECT COUNT(*) FROM site_touristique s
                     WHERE s.ville_id = v.id AND s.est_valide = 1) as nb_sites
             FROM ville v
             WHERE v.est_active = 1
             ORDER BY nb_hebergements DESC
             LIMIT 3"
        );

        // ── Sites touristiques populaires (4) avec photo ──
        $sitesPopulaires = $siteModel->query(
            "SELECT s.*, v.nom as ville_nom,
                    (SELECT url FROM photo_site_touristique
                     WHERE site_id = s.id AND est_principale = 1
                     LIMIT 1) as photo_url
             FROM site_touristique s
             JOIN ville v ON s.ville_id = v.id
             WHERE s.est_valide = 1
             ORDER BY s.id DESC
             LIMIT 4"
        );

        // ── Stats réelles ──
        $stats = $hebergementModel->query(
            "SELECT
                (SELECT COUNT(*) FROM hebergement     WHERE statut = 'approuve')  as nb_hebergements,
                (SELECT COUNT(*) FROM site_touristique WHERE est_valide = 1)       as nb_sites,
                (SELECT COUNT(*) FROM ville            WHERE est_active = 1)       as nb_villes,
                (SELECT COUNT(*) FROM utilisateur      WHERE role = 'voyageur')    as nb_voyageurs"
        );
        $stats = $stats[0] ?? null;

        // ── Derniers avis (témoignages) ──
        $avisModel   = new Avis();
        $temoignages = $avisModel->query(
            "SELECT a.*, u.prenom, u.nom, u.avatar_url, v.nom as ville_nom
             FROM avis a
             JOIN utilisateur u ON a.voyageur_id = u.id
             JOIN hebergement h ON a.hebergement_id = h.id
             JOIN ville v ON h.ville_id = v.id
             WHERE a.est_verifie = 1 AND a.note_globale >= 4
             ORDER BY a.date_creation DESC
             LIMIT 3"
        );

        $this->view('front/home/index', [
            'title'                   => 'Accueil - BeninExplore',
            'hebergements_populaires' => $hebergementsPopulaires,
            'villes'                  => $villes,
            'sites_populaires'        => $sitesPopulaires,
            'stats'                   => $stats,
            'temoignages'             => $temoignages,
        ]);
    }

    public function about() {
        $this->view('front/home/about', ['title' => 'À propos - BeninExplore']);
    }

    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleContact();
        }
        $this->view('front/home/contact', ['title' => 'Contact - BeninExplore']);
    }

    private function handleContact(): void {
        $name    = trim($_POST['name']    ?? '');
        $email   = trim($_POST['email']   ?? '');
        $message = trim($_POST['message'] ?? '');

        $errors = [];
        if (empty($name))                                 $errors[] = "Le nom est requis";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))   $errors[] = "Email invalide";
        if (strlen($message) < 10)                        $errors[] = "Message trop court";

        if (empty($errors)) {
            $_SESSION['success'] = "Message envoyé avec succès !";
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old']   = $_POST;
        }

        $this->redirect('/contact');
    }
}