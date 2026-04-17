-- Migration: 011_create_avis_table.sql
-- Table: avis

USE `benin_tourisme`;

DROP TABLE IF EXISTS `avis`;

CREATE TABLE `avis` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `reservation_id` INT(11) NOT NULL,
    `voyageur_id` INT(11) NOT NULL,
    `hebergement_id` INT(11) NOT NULL,
    `note_globale` TINYINT(1) NOT NULL,
    `note_proprete` TINYINT(1) DEFAULT NULL,
    `note_communication` TINYINT(1) DEFAULT NULL,
    `note_emplacement` TINYINT(1) DEFAULT NULL,
    `note_qualite_prix` TINYINT(1) DEFAULT NULL,
    `commentaire_public` TEXT DEFAULT NULL,
    `commentaire_prive` TEXT DEFAULT NULL,
    `reponse_hebergeur` TEXT DEFAULT NULL,
    `date_reponse` TIMESTAMP NULL DEFAULT NULL,
    `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `est_verifie` TINYINT(1) DEFAULT 0,
    `signalement` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_avis_reservation` (`reservation_id`),
    KEY `voyageur_id` (`voyageur_id`),
    KEY `hebergement_id` (`hebergement_id`),
    KEY `idx_avis_note` (`note_globale`),
    KEY `idx_avis_date` (`date_creation`),
    KEY `idx_avis_verifie` (`est_verifie`),
    CONSTRAINT `fk_avis_reservation` 
        FOREIGN KEY (`reservation_id`) 
        REFERENCES `reservation` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_avis_voyageur` 
        FOREIGN KEY (`voyageur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_avis_hebergement` 
        FOREIGN KEY (`hebergement_id`) 
        REFERENCES `hebergement` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `chk_avis_notes` CHECK (
        `note_globale` BETWEEN 1 AND 5 AND
        `note_proprete` BETWEEN 1 AND 5 AND
        `note_communication` BETWEEN 1 AND 5 AND
        `note_emplacement` BETWEEN 1 AND 5 AND
        `note_qualite_prix` BETWEEN 1 AND 5
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;