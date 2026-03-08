-- Migration: 012_create_notifications_table.sql
-- Table: notification

USE `benin_tourisme`;

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `utilisateur_id` INT(11) NOT NULL,
    `type` ENUM('reservation', 'message', 'paiement', 'avis', 'admin') NOT NULL,
    `titre` VARCHAR(255) NOT NULL,
    `contenu` TEXT NOT NULL,
    `lien` VARCHAR(500) DEFAULT NULL,
    `est_lu` TINYINT(1) DEFAULT 0,
    `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `utilisateur_id` (`utilisateur_id`),
    KEY `idx_notification_lu` (`est_lu`),
    KEY `idx_notification_date` (`date_creation`),
    CONSTRAINT `fk_notification_utilisateur` 
        FOREIGN KEY (`utilisateur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;