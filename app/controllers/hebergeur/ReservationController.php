<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Reservation;
use App\Models\Hebergement;
use App\Middleware\HebergeurMiddleware;

class ReservationController extends Controller {
    
    private $reservationModel;
    
    public function __construct() {
        HebergeurMiddleware::check();
        $this->reservationModel = new Reservation();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        $reservations = $this->reservationModel->query(
            "SELECT r.*, h.nom as hebergement_nom, 
                    u.prenom, u.nom as voyageur_nom, u.email
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             JOIN utilisateur u ON r.voyageur_id = u.id
             WHERE h.hebergeur_id = ?
             ORDER BY r.date_arrivee DESC",
            [$userId]
        );
        
        $this->view('hebergeur/reservations/index', [
            'title' => 'Mes réservations - BeninExplore',
            'reservations' => $reservations
        ]);
    }
    
    public function confirmer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/reservations');
        }
        
        $this->reservationModel->update($id, [
            'statut' => 'confirmee',
            'date_confirmation' => date('Y-m-d H:i:s')
        ]);
        
        $_SESSION['success'] = "Réservation confirmée";
        $this->redirect('/hebergeur/reservations');
    }
    
    public function annuler($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/reservations');
        }
        
        $this->reservationModel->update($id, [
            'statut' => 'annulee',
            'date_annulation' => date('Y-m-d H:i:s')
        ]);
        
        $_SESSION['success'] = "Réservation annulée";
        $this->redirect('/hebergeur/reservations');
    }
}