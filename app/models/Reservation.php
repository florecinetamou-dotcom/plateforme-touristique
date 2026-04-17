<?php
namespace App\Models;

use Core\Model;

class Reservation extends Model {
    protected $table = 'reservation';
    
    /**
     * Récupère l'ID de la dernière insertion
     */
    public function lastInsertId() {
        return $this->db->lastInsertId();
    }
    
    /**
     * Récupère les réservations d'un utilisateur
     */
    public function getUserReservations($userId) {
        $sql = "SELECT r.*, h.nom as hebergement_nom, v.nom as ville_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                JOIN ville v ON h.ville_id = v.id
                WHERE r.voyageur_id = ?
                ORDER BY r.date_reservation DESC";
        return $this->query($sql, [$userId]);
    }
    
    /**
     * Récupère les réservations à venir
     */
    public function getUpcomingReservations($userId) {
        $sql = "SELECT r.*, h.nom as hebergement_nom, v.nom as ville_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                JOIN ville v ON h.ville_id = v.id
                WHERE r.voyageur_id = ? AND r.date_depart >= CURDATE()
                ORDER BY r.date_arrivee ASC";
        return $this->query($sql, [$userId]);
    }
    
    /**
     * Récupère l'historique des réservations
     */
    public function getPastReservations($userId) {
        $sql = "SELECT r.*, h.nom as hebergement_nom, v.nom as ville_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo
                FROM reservation r
                JOIN hebergement h ON r.hebergement_id = h.id
                JOIN ville v ON h.ville_id = v.id
                WHERE r.voyageur_id = ? AND r.date_depart < CURDATE()
                ORDER BY r.date_depart DESC";
        return $this->query($sql, [$userId]);
    }
    
    /**
     * Vérifie si un hébergement est disponible pour une période
     */
    public function checkDisponibilite($hebergementId, $dateArrivee, $dateDepart) {
        $sql = "SELECT COUNT(*) as total
                FROM reservation
                WHERE hebergement_id = ?
                AND statut IN ('en_attente', 'confirmee')
                AND (
                    (date_arrivee <= ? AND date_depart > ?) OR
                    (date_arrivee < ? AND date_depart >= ?) OR
                    (date_arrivee >= ? AND date_depart <= ?)
                )";
        
        $result = $this->query($sql, [
            $hebergementId,
            $dateDepart, $dateArrivee,
            $dateDepart, $dateArrivee,
            $dateArrivee, $dateDepart
        ]);
        
        return $result[0]->total == 0;
    }
    
    /**
     * Annule une réservation
     */
    public function annuler($id) {
        return $this->update($id, [
            'statut' => 'annulee',
            'date_annulation' => date('Y-m-d H:i:s')
        ]);
    }
}