-- Migration: 003_create_type_hebergement.sql
-- Table: type_hebergement

USE `benin_tourisme`;

DROP TABLE IF EXISTS `type_hebergement`;

CREATE TABLE `type_hebergement` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(50) NOT NULL,
    `icone_url` VARCHAR(500) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;