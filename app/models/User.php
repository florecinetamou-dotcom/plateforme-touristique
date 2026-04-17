<?php
namespace App\Models;

use Core\Model;

class User extends Model {
    protected $table = 'utilisateur';
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function createUser($data) {
        try {
            $sql = "INSERT INTO {$this->table} 
                    (email, mot_de_passe_hash, nom, prenom, telephone, role, date_inscription) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $data['email'],
                $data['password'],
                $data['nom'],
                $data['prenom'],
                $data['telephone'] ?? null,
                $data['role'] ?? 'voyageur'
            ]);
            
            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;
            
        } catch (\PDOException $e) {
            error_log("Erreur création utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Vérifier si un hébergeur est actif et validé
     */
    public function isHebergeurActif($userId)
    {
        $sql = "SELECT role, statut_hebergeur, est_bloque FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        return ($user && $user->role === 'hebergeur' && $user->statut_hebergeur === 'actif' && $user->est_bloque == 0);
    }
    
    /**
     * Vérifier si un hébergeur est en attente de validation
     */
    public function isHebergeurEnAttente($userId)
    {
        $sql = "SELECT role, statut_hebergeur FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        return ($user && $user->role === 'hebergeur' && $user->statut_hebergeur === 'en_attente');
    }
    
    /**
     * Vérifier si un hébergeur est bloqué
     */
    public function isHebergeurBloque($userId)
    {
        $sql = "SELECT role, statut_hebergeur, est_bloque FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        return ($user && $user->role === 'hebergeur' && ($user->statut_hebergeur === 'bloque' || $user->est_bloque == 1));
    }
    
    /**
     * Mettre à jour le statut d'un hébergeur
     */
    public function updateHebergeurStatus($userId, $statut)
    {
        $sql = "UPDATE {$this->table} SET statut_hebergeur = ?, valide_le = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$statut, $userId]);
    }
    
    /**
     * Récupérer tous les hébergeurs pour l'admin
     */
    public function getAllHebergeurs()
    {
        $sql = "SELECT u.id, u.nom, u.prenom, u.email, u.role, u.statut_hebergeur, u.est_bloque, u.date_inscription,
                       u.telephone, u.est_verifie,
                       (SELECT COUNT(*) FROM hebergement WHERE hebergeur_id = u.id) as total_hebergements,
                       (SELECT COUNT(*) FROM hebergement WHERE hebergeur_id = u.id AND statut = 'en_attente') as en_attente
                FROM {$this->table} u
                WHERE u.role = 'hebergeur'
                ORDER BY FIELD(u.statut_hebergeur, 'en_attente', 'actif', 'bloque'), u.date_inscription DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les statistiques des hébergeurs
     */
    public function getHebergeursStats()
    {
        $sql = "SELECT 
                    SUM(CASE WHEN statut_hebergeur = 'actif' THEN 1 ELSE 0 END) as actifs,
                    SUM(CASE WHEN statut_hebergeur = 'en_attente' THEN 1 ELSE 0 END) as en_attente,
                    SUM(CASE WHEN statut_hebergeur = 'bloque' THEN 1 ELSE 0 END) as bloques,
                    COUNT(*) as total
                FROM {$this->table}
                WHERE role = 'hebergeur'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
}