-- Seeders: 001_types_hebergement.sql
-- Types d'hébergement

USE `benin_tourisme`;

INSERT INTO `type_hebergement` (`nom`, `icone_url`, `description`) VALUES
('Hôtel', '/assets/icons/hotel.png', 'Établissement hôtelier classique avec services (réception, ménage, restauration)'),
('Auberge', '/assets/icons/auberge.png', 'Petit hébergement convivial et économique, souvent familial'),
('Maison d\'hôte', '/assets/icons/maison-hote.png', 'Hébergement chez l\'habitant, ambiance locale et authentique'),
('Appartement', '/assets/icons/appartement.png', 'Logement entier avec kitchenette, idéal pour séjours moyens et longs'),
('Villa', '/assets/icons/villa.png', 'Maison indépendante avec jardin ou piscine, parfait pour groupes et familles'),
('Résidence', '/assets/icons/residence.png', 'Complexe avec plusieurs appartements et services communs'),
('Campement', '/assets/icons/campement.png', 'Hébergement en pleine nature, proche des parcs et réserves'),
('Eco-lodge', '/assets/icons/ecolodge.png', 'Hébergement écologique, construction traditionnelle et durable')
ON DUPLICATE KEY UPDATE `id` = `id`;