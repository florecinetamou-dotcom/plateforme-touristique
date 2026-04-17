<?php
namespace App\Controllers\Hebergeur;

use Core\Controller;
use App\Models\Reservation;
use App\Models\Hebergement;
<<<<<<< HEAD
=======
use App\Middleware\HebergeurMiddleware;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

class ReservationController extends Controller {
    
    private $reservationModel;
<<<<<<< HEAD
    private $hebergementModel;
    
    public function __construct() {
        // ✅ Utilisation de la nouvelle structure de session
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Veuillez vous connecter";
            $this->redirect('/login');
            return;
        }
        
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'hebergeur') {
            $_SESSION['error'] = "Accès réservé aux hébergeurs";
            $this->redirect('/profile');
            return;
        }

        $this->reservationModel = new Reservation();
        $this->hebergementModel = new Hebergement();
    }
    
    /**
     * Liste des réservations reçues par l'hébergeur
     */
    public function index() {
        $userId = $_SESSION['user']['id'];  // ✅ Nouvelle structure
        
        $reservations = $this->reservationModel->query(
            "SELECT r.*, h.nom as hebergement_nom, 
                    u.prenom, u.nom as voyageur_nom, u.email, u.telephone
=======
    
    public function __construct() {
        HebergeurMiddleware::check();
        $this->reservationModel = new Reservation();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        $reservations = $this->reservationModel->query(
            "SELECT r.*, h.nom as hebergement_nom, 
                    u.prenom, u.nom as voyageur_nom, u.email
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             JOIN utilisateur u ON r.voyageur_id = u.id
             WHERE h.hebergeur_id = ?
             ORDER BY r.date_arrivee DESC",
            [$userId]
        );
        
        $this->view('hebergeur/reservations/index', [
<<<<<<< HEAD
            'title'        => 'Mes réservations reçues - BeninExplore',
            'reservations' => $reservations,
        ]);
    }
    
    /**
     * Détail d'une réservation
     */
    public function show($id) {
        $userId = $_SESSION['user']['id'];  // ✅ Nouvelle structure
        
        $result = $this->reservationModel->query(
            "SELECT r.*, h.nom as hebergement_nom, h.adresse,
                    u.prenom, u.nom as voyageur_nom, u.email, u.telephone
             FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             JOIN utilisateur u ON r.voyageur_id = u.id
             WHERE r.id = ? AND h.hebergeur_id = ?",
            [$id, $userId]
        );
        $reservation = $result[0] ?? null;
        
        if (!$reservation) {
            $_SESSION['error'] = "Réservation introuvable";
            $this->redirect('/hebergeur/reservations');
        }
        
        $this->view('hebergeur/reservations/show', [
            'title'       => 'Réservation #' . ($reservation->reference ?? $id),
            'reservation' => $reservation,
        ]);
    }
    
    /**
     * Confirmer une réservation en attente
     */
=======
            'title' => 'Mes réservations - BeninExplore',
            'reservations' => $reservations
        ]);
    }
    
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    public function confirmer($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/reservations');
        }
        
<<<<<<< HEAD
        // Vérifier que la réservation appartient bien à cet hébergeur
        $userId = $_SESSION['user']['id'];  // ✅ Nouvelle structure
        $check  = $this->reservationModel->query(
            "SELECT r.id FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             WHERE r.id = ? AND h.hebergeur_id = ?",
            [$id, $userId]
        );
        
        if (empty($check)) {
            $_SESSION['error'] = "Réservation introuvable";
            $this->redirect('/hebergeur/reservations');
        }
        
        $this->reservationModel->update($id, [
            'statut'             => 'confirmee',
            'date_confirmation'  => date('Y-m-d H:i:s'),
        ]);
        
        $_SESSION['success'] = "Réservation confirmée ✅";
        $this->redirect('/hebergeur/reservations');
    }
    
    /**
     * Annuler une réservation
     */
=======
        $this->reservationModel->update($id, [
            'statut' => 'confirmee',
            'date_confirmation' => date('Y-m-d H:i:s')
        ]);
        
        $_SESSION['success'] = "Réservation confirmée";
        $this->redirect('/hebergeur/reservations');
    }
    
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    public function annuler($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergeur/reservations');
        }
        
<<<<<<< HEAD
        $userId = $_SESSION['user']['id'];  // ✅ Nouvelle structure
        $check  = $this->reservationModel->query(
            "SELECT r.id FROM reservation r
             JOIN hebergement h ON r.hebergement_id = h.id
             WHERE r.id = ? AND h.hebergeur_id = ?",
            [$id, $userId]
        );
        
        if (empty($check)) {
            $_SESSION['error'] = "Réservation introuvable";
            $this->redirect('/hebergeur/reservations');
        }
        
        $this->reservationModel->update($id, [
            'statut'          => 'annulee',
            'date_annulation' => date('Y-m-d H:i:s'),
=======
        $this->reservationModel->update($id, [
            'statut' => 'annulee',
            'date_annulation' => date('Y-m-d H:i:s')
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        ]);
        
        $_SESSION['success'] = "Réservation annulée";
        $this->redirect('/hebergeur/reservations');
    }
}