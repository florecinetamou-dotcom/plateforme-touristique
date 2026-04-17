-- Migration: 009_create_reservations_table.sql
-- Table: reservation

USE `benin_tourisme`;

DROP TABLE IF EXISTS `reservation`;

CREATE TABLE `reservation` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `reference` VARCHAR(20) NOT NULL,
    `voyageur_id` INT(11) NOT NULL,
    `hebergement_id` INT(11) NOT NULL,
    `date_arrivee` DATE NOT NULL,
    `date_depart` DATE NOT NULL,
    `nombre_voyageurs` INT(11) DEFAULT NULL,
    `statut` ENUM('en_attente', 'confirmee', 'annulee', 'terminee', 'no_show') DEFAULT 'en_attente',
    `montant_total` DECIMAL(10,2) DEFAULT NULL,
    `accompte_verse` DECIMAL(10,2) DEFAULT 0.00,
    `mode_paiement` ENUM('carte', 'mobile_money', 'especes', 'virement') DEFAULT NULL,
    `paiement_id` VARCHAR(100) DEFAULT NULL,
    `date_reservation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_confirmation` TIMESTAMP NULL DEFAULT NULL,
    `date_annulation` TIMESTAMP NULL DEFAULT NULL,
    `notes` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `reference` (`reference`),
    KEY `voyageur_id` (`voyageur_id`),
    KEY `hebergement_id` (`hebergement_id`),
    KEY `idx_reservation_dates` (`date_arrivee`, `date_depart`),
    KEY `idx_reservation_statut` (`statut`),
    KEY `idx_reservation_reference` (`reference`),
    CONSTRAINT `fk_reservation_hebergement` 
        FOREIGN KEY (`hebergement_id`) 
        REFERENCES `hebergement` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_reservation_voyageur` 
        FOREIGN KEY (`voyageur_id`) 
        REFERENCES `utilisateur` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `chk_reservation_dates` CHECK (`date_depart` > `date_arrivee`),
    CONSTRAINT `chk_reservation_voyageurs` CHECK (`nombre_voyageurs` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;