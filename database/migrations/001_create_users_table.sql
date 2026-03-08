-- Migration: 001_create_users_table.sql
-- Table: utilisateur

USE `benin_tourisme`;

DROP TABLE IF EXISTS `utilisateur`;

CREATE TABLE `utilisateur` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `mot_de_passe_hash` VARCHAR(255) NOT NULL,
    `nom` VARCHAR(100) DEFAULT NULL,
    `prenom` VARCHAR(100) DEFAULT NULL,
    `telephone` VARCHAR(20) DEFAULT NULL,
    `role` ENUM('voyageur', 'hebergeur', 'admin') DEFAULT 'voyageur',
    `avatar_url` VARCHAR(500) DEFAULT NULL,
    `est_verifie` TINYINT(1) DEFAULT 0,
    `date_inscription` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `derniere_connexion` TIMESTAMP NULL DEFAULT NULL,
    `langue_preferee` VARCHAR(10) DEFAULT 'fr',
    `newsletter` TINYINT(1) DEFAULT 0,
    `token_reinitialisation` VARCHAR(100) DEFAULT NULL,
    `token_expiration` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    KEY `idx_utilisateur_role` (`role`),
    KEY `idx_utilisateur_verifie` (`est_verifie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;