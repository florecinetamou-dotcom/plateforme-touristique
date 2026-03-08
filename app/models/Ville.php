<?php
namespace App\Models;

use Core\Model;

class Ville extends Model {
    protected $table = 'ville'; // Correspond à la table 'ville' dans tourisme_benin.sql
    
    /**
     * Récupère uniquement les villes marquées comme actives
        */
    public function getActive() {
        return $this->where(['est_active' => 1]); // Utilise la colonne 'est_active' du SQL
    }
}