<?php
namespace App\Models;

use Core\Model;

class ProfilHebergeur extends Model {
    protected $table = 'profil_hebergeur';
    protected $primaryKey = 'id'; // L'ID est le même que celui de l'utilisateur
    
    /**
     * Récupère le profil avec les infos utilisateur
     */
    public function getWithUser($id) {
        $sql = "SELECT p.*, u.email, u.nom, u.prenom, u.telephone 
                FROM profil_hebergeur p
                JOIN utilisateur u ON p.id = u.id
                WHERE p.id = ?";
        $result = $this->query($sql, [$id]);
        return $result[0] ?? null;
    }
    
    /**
     * Vérifie si le profil est complet
     */
    public function isComplete($id) {
        $profil = $this->find($id);
        if (!$profil) return false;
        
        return !empty($profil->nom_etablissement) 
            && !empty($profil->adresse);
    }
    
    /**
     * Récupère les hébergements de l'hébergeur
     */
    public function getHebergements($id) {
        $sql = "SELECT h.*, v.nom as ville_nom 
                FROM hebergement h
                JOIN ville v ON h.ville_id = v.id
                WHERE h.hebergeur_id = ?
                ORDER BY h.date_creation DESC";
        return $this->query($sql, [$id]);
    }
    
    /**
     * Met à jour ou crée le profil
     */
    public function updateOrCreate($id, $data) {
        $profil = $this->find($id);
        
        if ($profil) {
            return $this->update($id, $data);
        } else {
            $data['id'] = $id;
            return $this->create($data);
        }
    }
}