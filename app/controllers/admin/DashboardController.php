<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Hebergement;

class DashboardController extends Controller {

    public function __construct() {
        $this->requireAuth('admin');
    }

    public function index() {

        $hModel = new Hebergement();
        $stats  = [];

        try {
            $r = $hModel->query("SELECT COUNT(*) as total FROM utilisateur");
            $stats['total_utilisateurs'] = $r[0]->total ?? 0;

            $r = $hModel->query("SELECT COUNT(*) as total FROM utilisateur WHERE MONTH(date_inscription) = MONTH(NOW()) AND YEAR(date_inscription) = YEAR(NOW())");
            $stats['nouveaux_users_mois'] = $r[0]->total ?? 0;

            $r = $hModel->query("SELECT COUNT(*) as total FROM hebergement");
            $stats['total_hebergements'] = $r[0]->total ?? 0;

            $r = $hModel->query("SELECT COUNT(*) as total FROM hebergement WHERE statut = 'en_attente'");
            $stats['hebergements_attente'] = $r[0]->total ?? 0;

            $r = $hModel->query("SELECT COUNT(*) as total FROM reservation");
            $stats['total_reservations'] = $r[0]->total ?? 0;

            $r = $hModel->query("SELECT COUNT(*) as total FROM reservation WHERE statut IN ('en_attente','confirmee') AND date_depart >= CURDATE()");
            $stats['reservations_actives'] = $r[0]->total ?? 0;

            $r = $hModel->query("SELECT COALESCE(SUM(montant_total), 0) as total FROM reservation WHERE statut = 'confirmee' AND MONTH(date_reservation) = MONTH(NOW()) AND YEAR(date_reservation) = YEAR(NOW())");
            $stats['revenus_mois'] = $r[0]->total ?? 0;

<<<<<<< HEAD
            // ✅ NOUVEAU : Compter les inscrits à la newsletter
            $r = $hModel->query("SELECT COUNT(*) as total FROM utilisateur WHERE newsletter = 1");
            $stats['newsletter_inscrits'] = $r[0]->total ?? 0;

=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $hebergements_attente = $hModel->query(
                "SELECT h.*, v.nom as ville_nom, t.nom as type_nom,
                        CONCAT(u_info.prenom, ' ', u_info.nom) as hebergeur_nom
                 FROM hebergement h
                 JOIN ville v ON h.ville_id = v.id
                 LEFT JOIN type_hebergement t ON h.type_id = t.id
                 LEFT JOIN utilisateur u_info ON h.hebergeur_id = u_info.id
                 WHERE h.statut = 'en_attente'
                 ORDER BY h.date_creation DESC
                 LIMIT 5"
            );

            $derniers_inscrits = $hModel->query(
<<<<<<< HEAD
                "SELECT id, nom, prenom, role, date_inscription, newsletter
=======
                "SELECT id, nom, prenom, role, date_inscription
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                 FROM utilisateur
                 ORDER BY date_inscription DESC
                 LIMIT 6"
            );

            $dernieres_reservations = $hModel->query(
                "SELECT r.*, u.nom as voyageur_nom, u.prenom as voyageur_prenom, h.nom as hebergement_nom
                 FROM reservation r
                 JOIN utilisateur u ON r.voyageur_id = u.id
                 JOIN hebergement h ON r.hebergement_id = h.id
                 ORDER BY r.date_reservation DESC
                 LIMIT 8"
            );

        } catch (\Exception $e) {
<<<<<<< HEAD
            $stats                  = array_fill_keys(['total_utilisateurs','nouveaux_users_mois','total_hebergements','hebergements_attente','total_reservations','reservations_actives','revenus_mois','newsletter_inscrits'], 0);
=======
            $stats                  = array_fill_keys(['total_utilisateurs','nouveaux_users_mois','total_hebergements','hebergements_attente','total_reservations','reservations_actives','revenus_mois'], 0);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $hebergements_attente   = [];
            $derniers_inscrits      = [];
            $dernieres_reservations = [];
        }

<<<<<<< HEAD
        // ✅ AJOUT : badge newsletter
        $badges = [
            'nb_hebergements_attente' => $stats['hebergements_attente'] ?? 0,
            'nb_newsletter' => $stats['newsletter_inscrits'] ?? 0,  // ✅ NOUVEAU
        ];
=======
        $badges = ['nb_hebergements_attente' => $stats['hebergements_attente'] ?? 0];
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

        $this->view('admin/dashboard/index', [
            'stats'                  => $stats,
            'hebergements_attente'   => $hebergements_attente,
            'derniers_inscrits'      => $derniers_inscrits,
            'dernieres_reservations' => $dernieres_reservations,
            'badges'                 => $badges,
        ]);
    }
}