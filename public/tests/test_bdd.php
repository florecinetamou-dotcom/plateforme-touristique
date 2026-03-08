<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// Charger .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

echo "<h1>🔌 Test de connexion BDD</h1>";

try {
    $pdo = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'] ?? ''
    );
    
    echo "<p style='color:green'>✅ Connexion réussie !</p>";
    
    // Vérifier les tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Tables trouvées : " . count($tables) . "</p>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . $table . "</li>";
    }
    echo "</ul>";
    
    // Vérifier les villes
    $villes = $pdo->query("SELECT id, nom FROM ville")->fetchAll(PDO::FETCH_OBJ);
    echo "<p>Villes trouvées : " . count($villes) . "</p>";
    echo "<ul>";
    foreach ($villes as $ville) {
        echo "<li>ID {$ville->id} : {$ville->nom}</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Erreur : " . $e->getMessage() . "</p>";
}