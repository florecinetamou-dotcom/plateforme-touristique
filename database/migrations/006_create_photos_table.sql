-- Migration: 006_create_photos_table.sql
-- Table: photo_hebergement

USE `benin_tourisme`;

DROP TABLE IF EXISTS `photo_hebergement`;

CREATE TABLE `photo_hebergement` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `hebergement_id` INT(11) NOT NULL,
    `url` TEXT NOT NULL,
    `est_principale` TINYINT(1) DEFAULT 0,
    `ordre` INT(11) DEFAULT 0,
    `description` VARCHAR(255) DEFAULT NULL,
    `date_ajout` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `hebergement_id` (`hebergement_id`),
    KEY `idx_photo_principale` (`hebergement_id`, `est_principale`),
    CONSTRAINT `fk_photo_hebergement` 
        FOREIGN KEY (`hebergement_id`) 
        REFERENCES `hebergement` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;