-- Migration: 002_create_villes_table.sql
-- Table: ville

USE `benin_tourisme`;

DROP TABLE IF EXISTS `ville`;

CREATE TABLE `ville` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `latitude` DECIMAL(10,8) DEFAULT NULL,
    `longitude` DECIMAL(11,8) DEFAULT NULL,
    `photo_url` VARCHAR(500) DEFAULT NULL,
    `est_active` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY `idx_ville_nom` (`nom`),
    KEY `idx_ville_active` (`est_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;