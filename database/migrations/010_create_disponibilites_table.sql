-- Migration: 010_create_disponibilites_table.sql
-- Table: disponibilite

USE `benin_tourisme`;

DROP TABLE IF EXISTS `disponibilite`;

CREATE TABLE `disponibilite` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `hebergement_id` INT(11) NOT NULL,
    `date` DATE NOT NULL,
    `est_disponible` TINYINT(1) DEFAULT 1,
    `prix_du_jour` DECIMAL(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_dispo_jour` (`hebergement_id`, `date`),
    KEY `hebergement_id` (`hebergement_id`),
    KEY `idx_dispo_date` (`date`),
    KEY `idx_dispo_available` (`est_disponible`),
    CONSTRAINT `fk_dispo_hebergement` 
        FOREIGN KEY (`hebergement_id`) 
        REFERENCES `hebergement` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;