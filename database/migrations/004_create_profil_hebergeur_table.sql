-- Migration: 004_create_profil_hebergeur.sql
-- Table: profil_hebergeur

USE `benin_tourisme`;

DROP TABLE IF EXISTS `profil_hebergeur`;

CREATE TABLE `profil_hebergeur` (
    `id` INT(11) NOT NULL,
    `nom_etablissement` VARCHAR(200) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `adresse` TEXT DEFAULT NULL,
    `numero_siret` VARCHAR(14) DEFAULT NULL,
    `statut_verification` ENUM('en_attente', 'verifie', 'rejete') DEFAULT 'en_attente',
    PRIMARY KEY (`id`),
    UNIQUE KEY `numero_siret` (`numero_siret`),
    KEY `idx_hebergeur_statut` (`statut_verification`),
    CONSTRAINT `fk_hebergeur_utilisateur` 
        FOREIGN KEY (`id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;