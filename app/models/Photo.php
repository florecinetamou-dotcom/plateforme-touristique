<?php
namespace App\Models;

use Core\Model;

class Photo extends Model {
    protected $table = 'photo_hebergement';
    
    /**
     * Récupère toutes les photos d'un hébergement
     */
    public function getByHebergement($hebergementId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE hebergement_id = ? 
                ORDER BY est_principale DESC, ordre ASC";
        return $this->query($sql, [$hebergementId]);
    }
    
    /**
     * Récupère la photo principale
     */
    public function getPrincipale($hebergementId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE hebergement_id = ? AND est_principale = 1 
                LIMIT 1";
        $result = $this->query($sql, [$hebergementId]);
        return $result[0] ?? null;
    }
    
    /**
     * Supprime une photo (fichier + BDD)
     */
    public function deletePhoto($id) {
        $photo = $this->find($id);
        if ($photo) {
            // Supprimer le fichier physique
            $filePath = ROOT_PATH . '/public' . $photo->url;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            // Supprimer de la BDD
            return $this->delete($id);
        }
        return false;
    }
}