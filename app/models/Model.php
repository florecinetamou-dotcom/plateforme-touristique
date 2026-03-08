<?php
namespace App\Models;

use App\Config\Database;
use PDO;

abstract class Model {
    protected $db;
    protected $table;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Récupère tous les enregistrements
     */
    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Trouve un enregistrement par ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Trouve avec des conditions
     */
    public function where($conditions) {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        $where = [];
        $params = [];
        
        foreach ($conditions as $field => $value) {
            $where[] = "$field = ?";
            $params[] = $value;
        }
        
        $sql .= implode(' AND ', $where);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Crée un enregistrement
     */
    public function create($data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Met à jour un enregistrement
     */
    public function update($id, $data) {
        $set = [];
        foreach (array_keys($data) as $field) {
            $set[] = "$field = ?";
        }
        $set = implode(', ', $set);
        
        $sql = "UPDATE {$this->table} SET {$set} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        $values = array_values($data);
        $values[] = $id;
        
        return $stmt->execute($values);
    }
    
    /**
     * Supprime un enregistrement
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    /**
     * Requête personnalisée
     */
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}