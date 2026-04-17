-- Migration: 017_create_photo_site_touristique_table.sql
-- Table: photo_site_touristique

USE `tourisme_benin`;

DROP TABLE IF EXISTS `photo_site_touristique`;

CREATE TABLE `photo_site_touristique` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `site_id` INT(11) NOT NULL,
    `url` TEXT NOT NULL,
    `est_principale` TINYINT(1) DEFAULT 0,
    `ordre` INT(11) DEFAULT 0,
    `description` VARCHAR(255) DEFAULT NULL,
    `date_ajout` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `site_id` (`site_id`),
    KEY `idx_photo_principale` (`site_id`, `est_principale`),
    CONSTRAINT `fk_photo_site_touristique` 
        FOREIGN KEY (`site_id`) 
        REFERENCES `site_touristique` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
