-- Migration: 016_create_migrations_table.sql
-- Table: migrations (pour le suivi des migrations)

USE `benin_tourisme`;

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT UNSIGNED NOT NULL,
    `executed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_migration` (`migration`),
    KEY `idx_migrations_batch` (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;