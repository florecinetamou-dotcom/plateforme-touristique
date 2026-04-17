<?php
<<<<<<< HEAD
namespace Core;

=======
namespace App\Models;

use App\Config\Database;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
use PDO;

abstract class Model {
    protected $db;
    protected $table;
<<<<<<< HEAD
    protected $primaryKey = 'id';

    public function __construct() {
        $this->db = Database::getInstance();
    }

=======
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    /**
     * Récupère tous les enregistrements
     */
    public function all() {
<<<<<<< HEAD
        $sql  = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Trouve un enregistrement par son ID
     */
    public function find($id) {
        $sql  = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
=======
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Trouve un enregistrement par ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
<<<<<<< HEAD

    /**
     * Trouve des enregistrements selon des conditions
     */
    public function where(array $conditions) {
        $where  = [];
        $params = [];
        foreach ($conditions as $field => $value) {
            $where[]  = "$field = ?";
            $params[] = $value;
        }
        $sql  = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $where);
=======
    
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
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
<<<<<<< HEAD

    /**
     * Crée un nouvel enregistrement — retourne le nouvel ID
     */
    public function create(array $data) {
        $fields       = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql  = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    /**
     * Met à jour un enregistrement — retourne true/false
     */
    public function update($id, array $data) {
        $set = implode(', ', array_map(fn($f) => "$f = ?", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $values   = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    /**
     * Supprime un enregistrement — retourne true/false
     */
    public function delete($id) {
        $sql  = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * ✅ CORRECTION : query() détecte automatiquement le type de requête.
     *    - SELECT           → retourne un tableau de résultats (fetchAll)
     *    - INSERT/UPDATE
     *      DELETE/REPLACE   → retourne true/false (pas de fetchAll)
     *    - INSERT           → si $returnId=true, retourne le dernier ID inséré
     */
    public function query(string $sql, array $params = [], bool $returnId = false) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $verb = strtoupper(strtok(ltrim($sql), " \t\n\r"));

        if ($verb === 'SELECT') {
            return $stmt->fetchAll();
        }

        if ($returnId && $verb === 'INSERT') {
            return $this->db->lastInsertId();
        }

        // INSERT / UPDATE / DELETE / REPLACE → succès ou échec
        return $stmt->rowCount() >= 0; // rowCount() >= 0 = la requête a abouti
    }

    /**
     * Compte le nombre d'enregistrements
     */
    public function count(array $conditions = []) {
        if (empty($conditions)) {
            $sql  = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->db->query($sql);
        } else {
            $where  = [];
            $params = [];
            foreach ($conditions as $field => $value) {
                $where[]  = "$field = ?";
                $params[] = $value;
            }
            $sql  = "SELECT COUNT(*) as total FROM {$this->table} WHERE " . implode(' AND ', $where);
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
        }
        $result = $stmt->fetch();
        return $result->total ?? 0;
=======
    
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
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    }
}