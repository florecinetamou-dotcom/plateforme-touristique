-- Seeders: 003_admin_user.sql
-- Utilisateur admin par défaut

USE `benin_tourisme`;

-- Mot de passe: Admin123! (hashé en bcrypt)
INSERT INTO `utilisateur` (
    `email`, 
    `mot_de_passe_hash`, 
    `nom`, 
    `prenom`, 
    `role`, 
    `est_verifie`, 
    `langue_preferee`
) VALUES (
    'admin@benintourisme.bj',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: Admin123!
    'Administrateur',
    'Système',
    'admin',
    1,
    'fr'
) ON DUPLICATE KEY UPDATE `id` = `id`;

-- Compte hébergeur test
INSERT INTO `utilisateur` (
    `email`, 
    `mot_de_passe_hash`, 
    `nom`, 
    `prenom`, 
    `telephone`, 
    `role`, 
    `est_verifie`
) VALUES (
    'hebergeur1@test.bj',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Hôtel',
    'Azalaï',
    '+229 01 23 45 67',
    'hebergeur',
    1
);

INSERT INTO `utilisateur` (
    `email`, 
    `mot_de_passe_hash`, 
    `nom`, 
    `prenom`, 
    `telephone`, 
    `role`, 
    `est_verifie`
) VALUES (
    'voyageur1@test.bj',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Voyageur',
    'Jean',
    '+229 97 89 12 34',
    'voyageur',
    1
);

-- Profil hébergeur
INSERT INTO `profil_hebergeur` (
    `id`, 
    `nom_etablissement`, 
    `description`, 
    `adresse`, 
    `numero_siret`, 
    `statut_verification`
)
SELECT 
    `id`,
    'Hôtel Azalaï Cotonou',
    'Hôtel 4 étoiles en plein cœur de Cotonou, piscine, spa, restaurant gastronomique',
    'Boulevard de la Marina, Cotonou',
    '12345678901234',
    'verifie'
FROM `utilisateur` 
WHERE `email` = 'hebergeur1@test.bj';