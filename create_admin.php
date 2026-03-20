<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=tourisme_benin;charset=utf8mb4",
    "root",
    "",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$hash = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO utilisateur (email, mot_de_passe_hash, nom, prenom, role, est_verifie, date_inscription)
    VALUES (?, ?, 'Admin', 'Super', 'admin', 1, NOW())
    ON DUPLICATE KEY UPDATE 
        mot_de_passe_hash = ?,
        est_verifie = 1,
        role = 'admin'
");

$stmt->execute(['admin@beninexplore.bj', $hash, $hash]);

echo "✅ Compte admin créé/mis à jour !<br>";
echo "Email : admin@beninexplore.bj<br>";
echo "Mot de passe : admin123<br>";
echo "Hash généré : " . $hash;
?>