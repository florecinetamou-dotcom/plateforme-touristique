-- Seeders: 005_sites_touristiques.sql
-- Sites touristiques du Bénin

USE `benin_tourisme`;

-- Abomey
SET @abomey_id = (SELECT id FROM ville WHERE nom = 'Abomey');
-- Ouidah
SET @ouidah_id = (SELECT id FROM ville WHERE nom = 'Ouidah');
-- Ganvié
SET @ganvie_id = (SELECT id FROM ville WHERE nom = 'Ganvié');
-- Natitingou
SET @natitingou_id = (SELECT id FROM ville WHERE nom = 'Natitingou');
-- Porto-Novo
SET @portonovo_id = (SELECT id FROM ville WHERE nom = 'Porto-Novo');

INSERT INTO `site_touristique` (`ville_id`, `nom`, `description`, `categorie`, `adresse`, `prix_entree`, `heure_ouverture`, `heure_fermeture`, `est_valide`) VALUES
(@abomey_id, 'Palais Royaux d\'Abomey', 'Ensemble de 12 palais construits par les rois du Dahomey. Site UNESCO. Musée historique.', 'historique', 'Centre-ville d\'Abomey', 5000, '09:00:00', '17:00:00', 1),

(@ouidah_id, 'Route des Esclaves', 'Chemin emprunté par les esclaves vers la "Porte du non-retour". Parcours mémoriel.', 'historique', 'De la Place Chacha à la plage', 2000, '08:00:00', '18:00:00', 1),

(@ouidah_id, 'Temple des Pythons', 'Temple vaudou abritant des pythons sacrés. Symbole du culte vaudou à Ouidah.', 'religieux', 'Place Maro, Ouidah', 1500, '09:00:00', '12:00:00', 1),
(@ouidah_id, 'Fort Portugais', 'Ancien fort colonial portugais. Musée d\'histoire de Ouidah.', 'historique', 'Boulevard de la Marina, Ouidah', 2000, '09:00:00', '18:00:00', 1),

(@ganvie_id, 'Cité lacustre de Ganvié', 'Plus grand village lacustre d\'Afrique. Maisons sur pilotis, vie sur l\'eau.', 'culturel', 'Lac Nokoué', 3000, '08:00:00', '18:00:00', 1),

(@natitingou_id, 'Tata Somba', 'Habitat traditionnel des ethnies Ditammari. Maisons en forme de château fort.', 'culturel', 'Vallée de la Tanéka, Boukoumbé', 2500, '08:00:00', '17:00:00', 1),

(@natitingou_id, 'Parc National de la Pendjari', 'Réserve de biosphère UNESCO. Éléphants, lions, buffles, antilopes. Plus belle savane d\'Afrique de l\'Ouest.', 'nature', 'Tanguiéta', 10000, '06:00:00', '18:00:00', 1),

((SELECT id FROM ville WHERE nom = 'Parakou'), 'Musée ethnographique de Parakou', 'Arts et traditions du Nord-Bénin. Masques, statues, tissus.', 'culturel', 'Place de l\'Indépendance, Parakou', 1500, '09:00:00', '17:00:00', 1),

(@portonovo_id, 'Musée Honmè', 'Ancien palais du roi Toffa. Objets royaux, histoire de Porto-Novo.', 'historique', 'Avenue de la République, Porto-Novo', 2000, '09:00:00', '17:00:00', 1),

(@portonovo_id, 'Mosquée centrale de Porto-Novo', 'Mosquée historique au style afro-brésilien. Architecture unique.', 'religieux', 'Quartier Afrique, Porto-Novo', 0, '08:00:00', '20:00:00', 1);