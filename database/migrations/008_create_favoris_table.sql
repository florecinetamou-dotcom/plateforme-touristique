-- Migration: 008_create_favoris_table.sql
-- Table: favori

USE `benin_tourisme`;

DROP TABLE IF EXISTS `favori`;

CREATE TABLE `favori` (
    `voyageur_id` INT(11) NOT NULL,
    `hebergement_id` INT(11) NOT NULL,
    `date_ajout` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `note_privee` TEXT DEFAULT NULL,
    PRIMARY KEY (`voyageur_id`, `hebergement_id`),
    KEY `hebergement_id` (`hebergement_id`),
    KEY `idx_favori_date` (`date_ajout`),
    CONSTRAINT `fk_favori_hebergement` 
        FOREIGN KEY (`hebergement_id`) 
        REFERENCES `hebergement` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_favori_voyageur` 
        FOREIGN KEY (`voyageur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;