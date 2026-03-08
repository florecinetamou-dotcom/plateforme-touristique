<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Reservation;
use App\Models\Avis;  // ✅ Maintenant cette classe existe
use App\Middleware\HebergeurMiddleware;

class DashboardController extends Controller {
    
    private $hebergementModel;
    private $reservationModel;
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
        ]);
    }
    
    private function getTotalReservations($userId) {
        $sql = "SELECT COUNT(*) as total 
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                WHERE h.hebergeur_id = ?";
        $result = $this->reservationModel->query($sql, [$userId]);
        return $result[0]->total ?? 0;
    }
    
    private function getReservationsEnAttente($userId) {
        $sql = "SELECT COUNT(*) as total 
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                WHERE h.hebergeur_id = ? AND r.statut = 'en_attente'";
        $result = $this->reservationModel->query($sql, [$userId]);
        return $result[0]->total ?? 0;
    }
    
    private function getChiffreAffaires($userId) {
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
    }
}