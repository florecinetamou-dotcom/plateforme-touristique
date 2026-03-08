-- Migration: 015_create_chatbot_tables.sql
-- Tables: conversation_chatbot, message_chatbot, reponse_chatbot, intention_chatbot

USE `benin_tourisme`;

-- Table des conversations
DROP TABLE IF EXISTS `conversation_chatbot`;
CREATE TABLE `conversation_chatbot` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `utilisateur_id` INT(11) DEFAULT NULL,
    `session_id` VARCHAR(100) NOT NULL,
    `date_debut` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_fin` TIMESTAMP NULL DEFAULT NULL,
    `statut` ENUM('active', 'terminee', 'abandonnee') DEFAULT 'active',
    PRIMARY KEY (`id`),
    KEY `utilisateur_id` (`utilisateur_id`),
    KEY `session_id` (`session_id`),
    KEY `idx_conversation_statut` (`statut`),
    CONSTRAINT `fk_conversation_utilisateur` 
        FOREIGN KEY (`utilisateur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des messages du chatbot
DROP TABLE IF EXISTS `message_chatbot`;
CREATE TABLE `message_chatbot` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `conversation_id` INT(11) NOT NULL,
    `expediteur` ENUM('user', 'bot') NOT NULL,
    `contenu` TEXT NOT NULL,
    `intention` VARCHAR(50) DEFAULT NULL,
    `date_envoi` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `conversation_id` (`conversation_id`),
    KEY `idx_message_date` (`date_envoi`),
    CONSTRAINT `fk_message_conversation` 
        FOREIGN KEY (`conversation_id`) 
        REFERENCES `conversation_chatbot` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des réponses pré-définies
DROP TABLE IF EXISTS `reponse_chatbot`;
CREATE TABLE `reponse_chatbot` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `intention` VARCHAR(50) NOT NULL,
    `mot_clef` VARCHAR(255) DEFAULT NULL,
    `reponse` TEXT NOT NULL,
    `priorite` INT(11) DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `intention` (`intention`),
    KEY `idx_reponse_priorite` (`priorite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des intentions
DROP TABLE IF EXISTS `intention_chatbot`;
CREATE TABLE `intention_chatbot` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(50) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `reponse_par_defaut` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;