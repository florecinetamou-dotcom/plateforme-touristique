<?php
namespace App\Models;

use Core\Model;

class SiteTouristique extends Model {
    protected $table = 'site_touristique';
    
    /**
     * Récupère les sites populaires
     */
    public function getPopulaires($limit = 4) {
        $sql = "SELECT s.*, v.nom as ville_nom 
                FROM site_touristique s
                LEFT JOIN ville v ON s.ville_id = v.id
                WHERE s.est_valide = 1
                ORDER BY s.nom ASC
                LIMIT ?";
        return $this->query($sql, [$limit]);
    }
    
    /**
     * Récupère les sites par catégorie
     */
    public function getByCategorie($categorie) {
        $sql = "SELECT s.*, v.nom as ville_nom 
                FROM site_touristique s
                LEFT JOIN ville v ON s.ville_id = v.id
                WHERE s.categorie = ? AND s.est_valide = 1
                ORDER BY s.nom ASC";
        return $this->query($sql, [$categorie]);
    }
    
    /**
     * Récupère les sites d'une ville
     */
    public function getByVille($villeId) {
        $sql = "SELECT s.*, v.nom as ville_nom 
                FROM site_touristique s
                LEFT JOIN ville v ON s.ville_id = v.id
                WHERE s.ville_id = ? AND s.est_valide = 1
                ORDER BY s.nom ASC";
        return $this->query($sql, [$villeId]);
    }
    
    /**
     * Récupère tous les sites valides
     */
    public function getAllValides() {
        $sql = "SELECT s.*, v.nom as ville_nom 
                FROM site_touristique s
                LEFT JOIN ville v ON s.ville_id = v.id
                WHERE s.est_valide = 1
                ORDER BY s.nom ASC";
        return $this->query($sql);
    }
}