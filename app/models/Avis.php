<?php
namespace App\Models;

use Core\Model;

class Avis extends Model {
    protected $table = 'avis';
    
    /**
     * Récupère les avis d'un hébergement
     */
    public function getByHebergement($hebergementId, $limit = null) {
        $sql = "SELECT a.*, u.prenom, u.nom, u.avatar_url
                FROM {$this->table} a
                JOIN utilisateur u ON a.voyageur_id = u.id
                WHERE a.hebergement_id = ? AND a.est_verifie = 1
                ORDER BY a.date_creation DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            return $this->query($sql, [$hebergementId, $limit]);
        }
        
        return $this->query($sql, [$hebergementId]);
    }
    
    /**
     * Récupère les statistiques des avis
     */
    public function getStats($hebergementId) {
        $sql = "SELECT 
                COUNT(*) as total_avis,
                AVG(note_globale) as moyenne_globale,
                AVG(note_proprete) as moyenne_proprete,
                AVG(note_communication) as moyenne_communication,
                AVG(note_emplacement) as moyenne_emplacement,
                AVG(note_qualite_prix) as moyenne_qualite_prix,
                SUM(CASE WHEN note_globale = 5 THEN 1 ELSE 0 END) as note_5,
                SUM(CASE WHEN note_globale = 4 THEN 1 ELSE 0 END) as note_4,
                SUM(CASE WHEN note_globale = 3 THEN 1 ELSE 0 END) as note_3,
                SUM(CASE WHEN note_globale = 2 THEN 1 ELSE 0 END) as note_2,
                SUM(CASE WHEN note_globale = 1 THEN 1 ELSE 0 END) as note_1
                FROM {$this->table}
                WHERE hebergement_id = ? AND est_verifie = 1";
        
        $result = $this->query($sql, [$hebergementId]);
        return $result[0] ?? null;
    }
}