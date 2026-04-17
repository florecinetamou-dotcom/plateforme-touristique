<?php
namespace App\Models;

use Core\Model;

class Hebergement extends Model {
    protected $table = 'hebergement';
    
    /**
     * Récupère les hébergements approuvés
     */
    public function getApprouves() {
        return $this->where(['statut' => 'approuve']);
    }
    
    /**
     * Récupère les hébergements par ville
     */
    public function getByVille($villeId) {
        return $this->where(['ville_id' => $villeId, 'statut' => 'approuve']);
    }
    
    /**
     * 🔥 NOUVELLE MÉTHODE - Récupère les hébergements populaires
     */
    public function getPopulaires($limit = 6) {
        $sql = "SELECT h.*, v.nom as ville_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo_principale
                FROM hebergement h
                JOIN ville v ON h.ville_id = v.id
                WHERE h.statut = 'approuve'
                ORDER BY h.note_moyenne DESC, h.date_creation DESC
                LIMIT ?";
        return $this->query($sql, [$limit]);
    }
    
    /**
     * Recherche d'hébergements
     */
    public function search($keyword) {
        $sql = "SELECT h.*, v.nom as ville_nom,
                       (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo_principale
                FROM hebergement h
                JOIN ville v ON h.ville_id = v.id
                WHERE h.statut = 'approuve'
                AND (h.nom LIKE ? OR h.description LIKE ?)
                ORDER BY h.note_moyenne DESC";
        return $this->query($sql, ["%$keyword%", "%$keyword%"]);
    }
}