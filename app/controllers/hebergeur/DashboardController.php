<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Reservation;
<<<<<<< HEAD
// use App\Models\Avis;  // ← Supprimé car table avis n'existe pas
=======
use App\Models\Avis;  // ✅ Maintenant cette classe existe
use App\Middleware\HebergeurMiddleware;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

class DashboardController extends Controller {
    
    private $hebergementModel;
    private $reservationModel;
<<<<<<< HEAD
    
    public function __construct() {
        // ✅ Utilisation de la nouvelle structure de session
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à l'espace hébergeur";
            $this->redirect('/login');
            return;
        }
        
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'hebergeur') {
            $_SESSION['error'] = "Accès réservé aux hébergeurs";
            $this->redirect('/profile');
            return;
        }

        $this->hebergementModel = new Hebergement();
        $this->reservationModel = new Reservation();
    }
    
    public function index() {
        // ✅ Utilisation de la nouvelle structure
        $userId = $_SESSION['user']['id'];
        
        $hebergements = $this->hebergementModel->query(
            "SELECT * FROM hebergement WHERE hebergeur_id = ?",
            [$userId]
        );
        
        $stats = [
            'total_hebergements'      => count($hebergements),
            'hebergements_actifs'     => count(array_filter($hebergements, fn($h) => $h->statut === 'approuve')),
            'total_reservations'      => $this->getTotalReservations($userId),
            'reservations_en_attente' => $this->getReservationsEnAttente($userId),
            'chiffre_affaires'        => $this->getChiffreAffaires($userId),
            'note_moyenne'            => 0, // Note désactivée car table avis n'existe pas
        ];
        
        $recentReservations = $this->getRecentReservations($userId, 5);
        
        $this->view('hebergeur/dashboard/index', [
            'title'              => 'Dashboard Hébergeur - BeninExplore',
            'stats'              => $stats,
            'recentReservations' => $recentReservations,
            'hebergements'       => $hebergements,
=======
    private $avisModel;
    
    public function __construct() {
        // Vérifier que l'utilisateur est hébergeur
        HebergeurMiddleware::check();
        
        $this->hebergementModel = new Hebergement();
        $this->reservationModel = new Reservation();
        $this->avisModel = new Avis();  // ✅ Maintenant ça fonctionne
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Récupérer les hébergements de l'hébergeur
        $hebergements = $this->hebergementModel->where(['hebergeur_id' => $userId]);
        
        // Statistiques
        $stats = [
            'total_hebergements' => count($hebergements),
            'hebergements_actifs' => count(array_filter($hebergements, function($h) { 
                return $h->statut === 'approuve'; 
            })),
            'total_reservations' => $this->getTotalReservations($userId),
            'reservations_en_attente' => $this->getReservationsEnAttente($userId),
            'chiffre_affaires' => $this->getChiffreAffaires($userId),
            'note_moyenne' => $this->getNoteMoyenne($userId)
        ];
        
        // Dernières réservations
        $recentReservations = $this->getRecentReservations($userId, 5);
        
        $this->view('hebergeur/dashboard/index', [
            'title' => 'Dashboard Hébergeur - BeninExplore',
            'stats' => $stats,
            'recentReservations' => $recentReservations
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        ]);
    }
    
    private function getTotalReservations($userId) {
<<<<<<< HEAD
        $result = $this->reservationModel->query(
            "SELECT COUNT(*) as total 
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             WHERE h.hebergeur_id = ?",
            [$userId]
        );
=======
        $sql = "SELECT COUNT(*) as total 
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                WHERE h.hebergeur_id = ?";
        $result = $this->reservationModel->query($sql, [$userId]);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        return $result[0]->total ?? 0;
    }
    
    private function getReservationsEnAttente($userId) {
<<<<<<< HEAD
        $result = $this->reservationModel->query(
            "SELECT COUNT(*) as total 
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             WHERE h.hebergeur_id = ? AND r.statut = 'en_attente'",
            [$userId]
        );
=======
        $sql = "SELECT COUNT(*) as total 
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                WHERE h.hebergeur_id = ? AND r.statut = 'en_attente'";
        $result = $this->reservationModel->query($sql, [$userId]);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        return $result[0]->total ?? 0;
    }
    
    private function getChiffreAffaires($userId) {
<<<<<<< HEAD
        $result = $this->reservationModel->query(
            "SELECT COALESCE(SUM(r.montant_total), 0) as total 
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             WHERE h.hebergeur_id = ? AND r.statut = 'confirmee'",
            [$userId]
        );
        return $result[0]->total ?? 0;
    }
    
    // Note moyenne désactivée car table avis n'existe pas
    // private function getNoteMoyenne($userId) { ... }
    
    private function getRecentReservations($userId, $limit) {
        return $this->reservationModel->query(
            "SELECT r.*, h.nom as hebergement_nom, 
                    u.prenom, u.nom as voyageur_nom
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             JOIN utilisateur u ON r.voyageur_id = u.id
             WHERE h.hebergeur_id = ?
             ORDER BY r.date_reservation DESC
             LIMIT ?",
            [$userId, $limit]
        );
=======
        $sql = "SELECT SUM(r.montant_total) as total 
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                WHERE h.hebergeur_id = ? AND r.statut = 'confirmee'";
        $result = $this->reservationModel->query($sql, [$userId]);
        return $result[0]->total ?? 0;
    }
    
    private function getNoteMoyenne($userId) {
        $sql = "SELECT AVG(a.note_globale) as moyenne 
                FROM avis a
                JOIN hebergement h ON a.hebergement_id = h.id
                WHERE h.hebergeur_id = ? AND a.est_verifie = 1";
        $result = $this->avisModel->query($sql, [$userId]);
        return round($result[0]->moyenne ?? 0, 1);
    }
    
    private function getRecentReservations($userId, $limit) {
        $sql = "SELECT r.*, h.nom as hebergement_nom, 
                       u.prenom, u.nom as voyageur_nom
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                JOIN utilisateur u ON r.voyageur_id = u.id
                WHERE h.hebergeur_id = ?
                ORDER BY r.date_reservation DESC
                LIMIT ?";
        return $this->reservationModel->query($sql, [$userId, $limit]);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    }
}