-- Migration: 014_create_voyages_table.sql
-- Table: voyage

USE `benin_tourisme`;

DROP TABLE IF EXISTS `voyage`;

CREATE TABLE `voyage` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `voyageur_id` INT(11) NOT NULL,
    `titre` VARCHAR(200) NOT NULL,
    `date_debut` DATE DEFAULT NULL,
    `date_fin` DATE DEFAULT NULL,
    `budget_estime` DECIMAL(10,2) DEFAULT NULL,
    `notes` TEXT DEFAULT NULL,
    `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `voyageur_id` (`voyageur_id`),
    KEY `idx_voyage_dates` (`date_debut`, `date_fin`),
    CONSTRAINT `fk_voyage_voyageur` 
        FOREIGN KEY (`voyageur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;