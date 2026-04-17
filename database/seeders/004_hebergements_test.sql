-- Seeders: 004_hebergements_test.sql
-- Hébergements de test

USE `benin_tourisme`;

-- Récupérer les IDs
SET @hebergeur_id = (SELECT id FROM utilisateur WHERE email = 'hebergeur1@test.bj');
SET @cotonou_id = (SELECT id FROM ville WHERE nom = 'Cotonou');
SET @ouidah_id = (SELECT id FROM ville WHERE nom = 'Ouidah');
SET @grandpopo_id = (SELECT id FROM ville WHERE nom = 'Grand-Popo');
SET @hotel_id = (SELECT id FROM type_hebergement WHERE nom = 'Hôtel');
SET @maison_hote_id = (SELECT id FROM type_hebergement WHERE nom = 'Maison d\'hôte');
SET @villa_id = (SELECT id FROM type_hebergement WHERE nom = 'Villa');
SET @ecolodge_id = (SELECT id FROM type_hebergement WHERE nom = 'Eco-lodge');

-- Hébergement 1: Hôtel Azalaï Cotonou
INSERT INTO `hebergement` (
    `hebergeur_id`, `ville_id`, `type_id`, `nom`, `description`, 
    `adresse`, `prix_nuit_base`, `capacite`, `chambres`, `lits`, 
    `salles_de_bain`, `equipements`, `latitude`, `longitude`, `statut`
) VALUES (
    @hebergeur_id, @cotonou_id, @hotel_id, 
    'Hôtel Azalaï Cotonou',
    'Luxe et confort au cœur de Cotonou. Piscine extérieure, spa, salle de sport, 3 restaurants. Idéal pour voyages d\'affaires et séjours touristiques.',
    'Boulevard de la Marina, Cotonou',
    85000, 4, 30, 60, 30,
    '["wifi", "climatisation", "piscine", "spa", "restaurant", "room service", "parking", "salle de sport", "bar", "concierge"]',
    6.35472000, 2.43667000,
    'approuve'
);

-- Hébergement 2: Maison d'hôte Chez Mama
INSERT INTO `hebergement` (
    `hebergeur_id`, `ville_id`, `type_id`, `nom`, `description`,
    `adresse`, `prix_nuit_base`, `capacite`, `chambres`, `lits`,
    `salles_de_bain`, `equipements`, `latitude`, `longitude`, `statut`
) VALUES (
    @hebergeur_id, @ouidah_id, @maison_hote_id,
    'Chez Mama - Ouidah',
    'Maison d\'hôte traditionnelle tenue par Mama. Ambiance familiale, cuisine locale, à 5 min de la Route des Esclaves.',
    'Quartier Zoungbodji, Ouidah',
    15000, 4, 3, 5, 2,
    '["wifi", "ventilateur", "petit-déjeuner inclus", "cuisine partagée", "jardin", "parking"]',
    6.36667000, 2.08333000,
    'approuve'
);

-- Hébergement 3: Villa Océane Grand-Popo
INSERT INTO `hebergement` (
    `hebergeur_id`, `ville_id`, `type_id`, `nom`, `description`,
    `adresse`, `prix_nuit_base`, `capacite`, `chambres`, `lits`,
    `salles_de_bain`, `equipements`, `latitude`, `longitude`, `statut`
) VALUES (
    @hebergeur_id, @grandpopo_id, @villa_id,
    'Villa Océane',
    'Magnifique villa avec piscine face à l\'océan. 4 chambres climatisées, grande terrasse, accès direct plage.',
    'Boulevard du Littoral, Grand-Popo',
    120000, 8, 4, 8, 4,
    '["wifi", "climatisation", "piscine", "cuisine équipée", "terrasse", "parking privé", "accès plage", "television", "lave-linge"]',
    6.28333000, 1.81667000,
    'approuve'
);

-- Hébergement 4: Eco-lodge Pendjari
INSERT INTO `hebergement` (
    `hebergeur_id`, `ville_id`, `type_id`, `nom`, `description`,
    `adresse`, `prix_nuit_base`, `capacite`, `chambres`, `lits`,
    `salles_de_bain`, `equipements`, `statut`
) VALUES (
    @hebergeur_id, (SELECT id FROM ville WHERE nom = 'Natitingou'), @ecolodge_id,
    'Eco-lodge de la Pendjari',
    'Campement écologique aux portes du parc national. Cases traditionnelles en banco, toilettes sèches, eau solaire. Expérience authentique.',
    'Route de la Pendjari, Tanguiéta',
    25000, 4, 8, 16, 4,
    '["restaurant", "visites guidées", "observation faune", "artisanat local", "parking"]',
    'approuve'
);

-- Photos principales
INSERT INTO `photo_hebergement` (`hebergement_id`, `url`, `est_principale`, `ordre`, `description`)
SELECT id, '/uploads/hebergements/azalai-1.jpg', 1, 1, 'Piscine de l\'hôtel' FROM hebergement WHERE nom = 'Hôtel Azalaï Cotonou';

INSERT INTO `photo_hebergement` (`hebergement_id`, `url`, `est_principale`, `ordre`, `description`)
SELECT id, '/uploads/hebergements/chez-mama-1.jpg', 1, 1, 'Façade maison d\'hôte' FROM hebergement WHERE nom = 'Chez Mama - Ouidah';

INSERT INTO `photo_hebergement` (`hebergement_id`, `url`, `est_principale`, `ordre`, `description`)
SELECT id, '/uploads/hebergements/villa-oceane-1.jpg', 1, 1, 'Vue sur l\'océan' FROM hebergement WHERE nom = 'Villa Océane';

INSERT INTO `photo_hebergement` (`hebergement_id`, `url`, `est_principale`, `ordre`, `description`)
SELECT id, '/uploads/hebergements/pendjari-1.jpg', 1, 1, 'Case traditionnelle' FROM hebergement WHERE nom = 'Eco-lodge de la Pendjari';