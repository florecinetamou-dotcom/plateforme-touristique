-- Migration: 007_create_sites_touristiques.sql
-- Table: site_touristique

USE `benin_tourisme`;

DROP TABLE IF EXISTS `site_touristique`;

CREATE TABLE `site_touristique` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `ville_id` INT(11) NOT NULL,
    `nom` VARCHAR(200) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `categorie` ENUM('historique', 'nature', 'culturel', 'religieux', 'autre') DEFAULT 'autre',
    `adresse` TEXT DEFAULT NULL,
    `latitude` DECIMAL(10,8) DEFAULT NULL,
    `longitude` DECIMAL(11,8) DEFAULT NULL,
    `prix_entree` DECIMAL(10,2) DEFAULT 0.00,
    `heure_ouverture` TIME DEFAULT NULL,
    `heure_fermeture` TIME DEFAULT NULL,
    `photo_url` VARCHAR(500) DEFAULT NULL,
    `est_valide` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY `ville_id` (`ville_id`),
    KEY `idx_site_categorie` (`categorie`),
    KEY `idx_site_valide` (`est_valide`),
    CONSTRAINT `fk_site_ville` 
        FOREIGN KEY (`ville_id`) 
        REFERENCES `ville` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;