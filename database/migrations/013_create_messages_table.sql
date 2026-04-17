-- Migration: 013_create_messages_table.sql
-- Table: message

USE `benin_tourisme`;

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `expediteur_id` INT(11) NOT NULL,
    `destinataire_id` INT(11) NOT NULL,
    `reservation_id` INT(11) DEFAULT NULL,
    `contenu` TEXT NOT NULL,
    `est_lu` TINYINT(1) DEFAULT 0,
    `date_envoi` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `expediteur_id` (`expediteur_id`),
    KEY `destinataire_id` (`destinataire_id`),
    KEY `reservation_id` (`reservation_id`),
    KEY `idx_message_lu` (`est_lu`),
    KEY `idx_message_date` (`date_envoi`),
    CONSTRAINT `fk_message_expediteur` 
        FOREIGN KEY (`expediteur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_message_destinataire` 
        FOREIGN KEY (`destinataire_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_message_reservation` 
        FOREIGN KEY (`reservation_id`) 
        REFERENCES `reservation` (`id`) 
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;