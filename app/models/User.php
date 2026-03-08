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
                $data['password'], // déjà hashé
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
            // Log l'erreur
            error_log("Erreur création utilisateur: " . $e->getMessage());
            return false;
        }
    }
}