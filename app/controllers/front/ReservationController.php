<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Reservation;
use App\Models\User;

class ReservationController extends Controller {
    
    private $reservationModel;
    private $hebergementModel;
    
    public function __construct() {
        $this->reservationModel = new Reservation();
        $this->hebergementModel = new Hebergement();
    }
    
    /**
     * Formulaire de réservation
     */
    public function create($id) {
<<<<<<< HEAD
=======
        // Vérifier si l'utilisateur est connecté
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour réserver";
            $this->redirect('/login?redirect=/hebergement/' . $id . '/reserver');
        }
        
<<<<<<< HEAD
=======
        // Récupérer l'hébergement
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $hebergement = $this->hebergementModel->find($id);
        
        if (!$hebergement || $hebergement->statut !== 'approuve') {
            $_SESSION['error'] = "Hébergement non disponible";
            $this->redirect('/hebergements');
        }
        
<<<<<<< HEAD
=======
        // Récupérer le nom de la ville
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $ville = $this->hebergementModel->query(
            "SELECT nom FROM ville WHERE id = ?",
            [$hebergement->ville_id]
        );
        $hebergement->ville_nom = $ville[0]->nom ?? '';
        
<<<<<<< HEAD
=======
        // Récupérer la photo principale
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $photo = $this->hebergementModel->query(
            "SELECT url FROM photo_hebergement WHERE hebergement_id = ? AND est_principale = 1 LIMIT 1",
            [$id]
        );
        $hebergement->photo_principale = $photo[0]->url ?? null;
        
        $this->view('front/hebergement/reservation', [
<<<<<<< HEAD
            'title'       => 'Réservation - ' . $hebergement->nom,
=======
            'title' => 'Réservation - ' . $hebergement->nom,
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            'hebergement' => $hebergement
        ]);
    }
    
    /**
     * Traitement de la réservation
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/hebergements');
        }
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter";
            $this->redirect('/login');
        }
        
<<<<<<< HEAD
        $hebergement_id = $_POST['hebergement_id'] ?? 0;
        $date_arrivee   = $_POST['date_arrivee']   ?? '';
        $date_depart    = $_POST['date_depart']     ?? '';
        $nb_voyageurs   = $_POST['nb_voyageurs']    ?? 1;
        $telephone      = $_POST['telephone']       ?? '';
        $notes          = $_POST['notes']           ?? '';
=======
        // Récupération des données
        $hebergement_id = $_POST['hebergement_id'] ?? 0;
        $date_arrivee = $_POST['date_arrivee'] ?? '';
        $date_depart = $_POST['date_depart'] ?? '';
        $nb_voyageurs = $_POST['nb_voyageurs'] ?? 1;
        $telephone = $_POST['telephone'] ?? '';
        $notes = $_POST['notes'] ?? '';
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        
        // Validation
        $errors = [];
        
        if (empty($date_arrivee)) $errors[] = "La date d'arrivée est requise";
<<<<<<< HEAD
        if (empty($date_depart))  $errors[] = "La date de départ est requise";
=======
        if (empty($date_depart)) $errors[] = "La date de départ est requise";
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        
        if (!empty($date_arrivee) && !empty($date_depart)) {
            if ($date_depart <= $date_arrivee) {
                $errors[] = "La date de départ doit être postérieure à l'arrivée";
            }
            
<<<<<<< HEAD
=======
            // Vérifier la disponibilité
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $disponible = $this->reservationModel->checkDisponibilite(
                $hebergement_id, $date_arrivee, $date_depart
            );
            
            if (!$disponible) {
                $errors[] = "Ces dates ne sont pas disponibles";
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('/hebergement/' . $hebergement_id . '/reserver');
        }
        
<<<<<<< HEAD
        $hebergement = $this->hebergementModel->find($hebergement_id);
        
        $date1      = new \DateTime($date_arrivee);
        $date2      = new \DateTime($date_depart);
        $nb_nuits   = $date1->diff($date2)->days;
        $montant_total = $nb_nuits * $hebergement->prix_nuit_base;
        
        $reference = 'RES' . date('Ymd') . rand(1000, 9999);
        
        // ✅ CORRECTION BUG 4 : on insère puis on récupère l'ID
        //    avec SELECT LAST_INSERT_ID() car lastInsertId() n'existe
        //    pas dans le modèle de base du projet.
        $sql = "INSERT INTO reservation 
                (reference, voyageur_id, hebergement_id, date_arrivee, date_depart,
                 nombre_voyageurs, montant_total, notes, statut, date_reservation)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'confirmee', NOW())";
        
        $this->reservationModel->query($sql, [
=======
        // Récupérer l'hébergement pour calculer le prix
        $hebergement = $this->hebergementModel->find($hebergement_id);
        
        // Calculer le nombre de nuits et le montant total
        $date1 = new \DateTime($date_arrivee);
        $date2 = new \DateTime($date_depart);
        $nb_nuits = $date1->diff($date2)->days;
        $montant_total = $nb_nuits * $hebergement->prix_nuit_base;
        
        // Générer une référence unique
        $reference = 'RES' . date('Ymd') . rand(1000, 9999);
        
        // Créer la réservation
        $sql = "INSERT INTO reservation 
                (reference, voyageur_id, hebergement_id, date_arrivee, date_depart, 
                 nombre_voyageurs, montant_total, notes, statut, date_reservation) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'confirmee', NOW())";
        
        $result = $this->reservationModel->query($sql, [
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            $reference,
            $_SESSION['user_id'],
            $hebergement_id,
            $date_arrivee,
            $date_depart,
            $nb_voyageurs,
            $montant_total,
            $notes
        ]);
        
<<<<<<< HEAD
        // Récupération de l'ID de la ligne insérée
        $row            = $this->reservationModel->query("SELECT LAST_INSERT_ID() AS last_id");
        $reservation_id = $row[0]->last_id ?? null;
=======
        // Récupérer l'ID de la réservation créée
        $reservation_id = $this->reservationModel->lastInsertId();
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        
        if ($reservation_id) {
            $_SESSION['success'] = "Réservation confirmée ! Référence : " . $reference;
            $this->redirect('/reservation/confirmation/' . $reservation_id);
        } else {
            $_SESSION['error'] = "Erreur lors de la réservation";
            $this->redirect('/hebergement/' . $hebergement_id . '/reserver');
        }
    }
    
    /**
     * Page de confirmation
     */
    public function confirmation($id) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
<<<<<<< HEAD
=======
        // Récupérer la réservation avec les détails
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $sql = "SELECT r.*, h.nom as hebergement_nom, v.nom as ville_nom
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                JOIN ville v ON h.ville_id = v.id
                WHERE r.id = ? AND r.voyageur_id = ?";
        
<<<<<<< HEAD
        $result      = $this->reservationModel->query($sql, [$id, $_SESSION['user_id']]);
=======
        $result = $this->reservationModel->query($sql, [$id, $_SESSION['user_id']]);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $reservation = $result[0] ?? null;
        
        if (!$reservation) {
            $this->redirect('/reservations');
        }
        
        $this->view('front/hebergement/confirmation', [
<<<<<<< HEAD
            'title'       => 'Confirmation de réservation',
=======
            'title' => 'Confirmation de réservation',
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            'reservation' => $reservation
        ]);
    }
    
    /**
     * Liste des réservations de l'utilisateur
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $reservations = $this->reservationModel->getUserReservations($_SESSION['user_id']);
<<<<<<< HEAD
        $upcoming     = $this->reservationModel->getUpcomingReservations($_SESSION['user_id']);
        $past         = $this->reservationModel->getPastReservations($_SESSION['user_id']);
        
        $this->view('front/reservation/index', [
            'title'        => 'Mes réservations',
            'reservations' => $reservations,
            'upcoming'     => $upcoming,
            'past'         => $past
=======
        $upcoming = $this->reservationModel->getUpcomingReservations($_SESSION['user_id']);
        $past = $this->reservationModel->getPastReservations($_SESSION['user_id']);
        
        $this->view('front/reservation/index', [
            'title' => 'Mes réservations',
            'reservations' => $reservations,
            'upcoming' => $upcoming,
            'past' => $past
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        ]);
    }
    
    /**
     * Détail d'une réservation
     */
    public function show($id) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
<<<<<<< HEAD
=======
        // Récupérer la réservation avec tous les détails
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $sql = "SELECT r.*, h.nom as hebergement_nom, h.adresse, h.telephone as hebergeur_tel,
                       v.nom as ville_nom, u.prenom, u.nom
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                JOIN ville v ON h.ville_id = v.id
                JOIN utilisateur u ON h.hebergeur_id = u.id
                WHERE r.id = ? AND r.voyageur_id = ?";
        
<<<<<<< HEAD
        $result      = $this->reservationModel->query($sql, [$id, $_SESSION['user_id']]);
=======
        $result = $this->reservationModel->query($sql, [$id, $_SESSION['user_id']]);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $reservation = $result[0] ?? null;
        
        if (!$reservation) {
            $this->redirect('/reservations');
        }
        
        $this->view('front/reservation/show', [
<<<<<<< HEAD
            'title'       => 'Réservation #' . $reservation->reference,
=======
            'title' => 'Réservation #' . $reservation->reference,
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            'reservation' => $reservation
        ]);
    }
    
    /**
     * Annuler une réservation
     */
    public function cancel($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/reservations');
        }
        
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
<<<<<<< HEAD
=======
        // Vérifier que la réservation appartient à l'utilisateur
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $reservation = $this->reservationModel->find($id);
        
        if (!$reservation || $reservation->voyageur_id != $_SESSION['user_id']) {
            $_SESSION['error'] = "Réservation non trouvée";
            $this->redirect('/reservations');
        }
        
<<<<<<< HEAD
        $date_arrivee = new \DateTime($reservation->date_arrivee);
        $now          = new \DateTime();
        $diff         = $now->diff($date_arrivee);
=======
        // Vérifier si la réservation peut être annulée (plus de 24h avant)
        $date_arrivee = new \DateTime($reservation->date_arrivee);
        $now = new \DateTime();
        $diff = $now->diff($date_arrivee);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        
        if ($diff->days < 1 && $diff->invert == 0) {
            $_SESSION['error'] = "Les réservations ne peuvent être annulées que plus de 24h avant l'arrivée";
            $this->redirect('/reservation/' . $id);
        }
        
        $annule = $this->reservationModel->annuler($id);
        
        if ($annule) {
            $_SESSION['success'] = "Réservation annulée avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de l'annulation";
        }
        
        $this->redirect('/reservations');
    }
}