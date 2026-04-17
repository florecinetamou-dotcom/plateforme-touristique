-- Migration: 005_create_hebergements_table.sql
-- Table: hebergement

USE `benin_tourisme`;

DROP TABLE IF EXISTS `hebergement`;

CREATE TABLE `hebergement` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `hebergeur_id` INT(11) NOT NULL,
    `ville_id` INT(11) NOT NULL,
    `type_id` INT(11) DEFAULT NULL,
    `nom` VARCHAR(200) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `adresse` TEXT NOT NULL,
    `prix_nuit_base` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `capacite` INT(11) DEFAULT NULL,
    `chambres` INT(11) DEFAULT NULL,
    `lits` INT(11) DEFAULT NULL,
    `salles_de_bain` INT(11) DEFAULT NULL,
    `equipements` JSON DEFAULT NULL,
    `latitude` DECIMAL(10,8) DEFAULT NULL,
    `longitude` DECIMAL(11,8) DEFAULT NULL,
    `note_moyenne` DECIMAL(3,2) DEFAULT 0.00,
    `statut` ENUM('en_attente', 'approuve', 'rejete', 'suspendu') DEFAULT 'en_attente',
    `politique_annulation` TEXT DEFAULT NULL,
    `regles_maison` TEXT DEFAULT NULL,
    `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `hebergeur_id` (`hebergeur_id`),
    KEY `ville_id` (`ville_id`),
    KEY `type_id` (`type_id`),
    KEY `idx_hebergement_statut` (`statut`),
    KEY `idx_hebergement_note` (`note_moyenne`),
    KEY `idx_hebergement_prix` (`prix_nuit_base`),
    CONSTRAINT `fk_hebergement_hebergeur` 
        FOREIGN KEY (`hebergeur_id`) 
        REFERENCES `profil_hebergeur` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_hebergement_type` 
        FOREIGN KEY (`type_id`) 
        REFERENCES `type_hebergement` (`id`) 
        ON DELETE SET NULL,
    CONSTRAINT `fk_hebergement_ville` 
        FOREIGN KEY (`ville_id`) 
        REFERENCES `ville` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `chk_hebergement_capacite` CHECK (`capacite` > 0),
    CONSTRAINT `chk_hebergement_prix` CHECK (`prix_nuit_base` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;