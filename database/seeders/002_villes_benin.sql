-- Seeders: 002_villes_benin.sql
-- Villes touristiques du Bénin

USE `benin_tourisme`;

INSERT INTO `ville` (`nom`, `description`, `latitude`, `longitude`, `est_active`) VALUES
('Cotonou', 'Capitale économique du Bénin - Centre d\'affaires, marchés, vie nocturne', 6.36540000, 2.41833000, 1),
('Porto-Novo', 'Capitale administrative - Ville historique, musées, architecture coloniale', 6.49646000, 2.60359000, 1),
('Abomey', 'Ancienne capitale du royaume du Dahomey - Palais royaux (UNESCO)', 7.18286000, 1.99120000, 1),
('Ouidah', 'Berceau du vaudou - Route des Esclaves, plages, fort portugais', 6.36667000, 2.08333000, 1),
('Grand-Popo', 'Station balnéaire - Bouche du Roy, lagunes, pêche artisanale', 6.28333000, 1.81667000, 1),
('Natitingou', 'Porte d\'entrée du parc national de la Pendjari - Culture Ditammari', 10.30417000, 1.37944000, 1),
('Parakou', 'Plus grande ville du Nord-Bénin - Carrefour commercial, artisanat', 9.33716000, 2.63074000, 1),
('Ganvié', 'Plus grande cité lacustre d\'Afrique - Village sur pilotis, lac Nokoué', 6.46667000, 2.41667000, 1),
('Bohicon', 'Centre commercial du Zou - Marché international', 7.20000000, 2.06667000, 1),
('Lokossa', 'Ville des collines - Marché, artisanat', 6.63333000, 1.71667000, 1),
('Abomey-Calavi', 'Cité universitaire - Commune la plus peuplée', 6.44889000, 2.35556000, 1),
('Djougou', 'Carrefour commercial du Nord-Ouest - Diversité culturelle', 9.70853000, 1.66598000, 1),
('Kandi', 'Ville cotonnière - Proche du parc W', 11.12917000, 2.93861000, 1),
('Savalou', 'Ville royale - Palais, marchés', 7.93333000, 1.96667000, 1),
('Sèmè-Podji', 'Zone industrielle et portuaire', 6.38333000, 2.61667000, 1)
ON DUPLICATE KEY UPDATE `id` = `id`;