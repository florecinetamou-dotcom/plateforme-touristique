-- Seeders: 006_avis_test.sql
-- Avis de test pour hébergements

USE `benin_tourisme`;

SET @voyageur_id = (SELECT id FROM utilisateur WHERE email = 'voyageur1@test.bj');
SET @azalai_id = (SELECT id FROM hebergement WHERE nom = 'Hôtel Azalaï Cotonou');
SET @chezmama_id = (SELECT id FROM hebergement WHERE nom = 'Chez Mama - Ouidah');

-- Réservations nécessaires pour les avis
INSERT INTO `reservation` (`reference`, `voyageur_id`, `hebergement_id`, `date_arrivee`, `date_depart`, `nombre_voyageurs`, `statut`, `montant_total`)
VALUES ('RES20240101', @voyageur_id, @azalai_id, '2024-01-15', '2024-01-18', 2, 'terminee', 255000);

INSERT INTO `reservation` (`reference`, `voyageur_id`, `hebergement_id`, `date_arrivee`, `date_depart`, `nombre_voyageurs`, `statut`, `montant_total`)
VALUES ('RES20240102', @voyageur_id, @chezmama_id, '2024-01-20', '2024-01-22', 1, 'terminee', 30000);

-- Avis Hôtel Azalaï
INSERT INTO `avis` (
    `reservation_id`, `voyageur_id`, `hebergement_id`, 
    `note_globale`, `note_proprete`, `note_communication`, `note_emplacement`, `note_qualite_prix`,
    `commentaire_public`, `est_verifie`
)
SELECT 
    r.id, @voyageur_id, @azalai_id,
    5, 5, 5, 5, 4,
    'Excellent séjour ! Personnel très professionnel, chambre spacieuse et propre. Piscine agréable. Petit-déjeuner copieux. Je recommande vivement.',
    1
FROM reservation r WHERE r.reference = 'RES20240101';

-- Avis Chez Mama
INSERT INTO `avis` (
    `reservation_id`, `voyageur_id`, `hebergement_id`,
    `note_globale`, `note_proprete`, `note_communication`, `note_emplacement`, `note_qualite_prix`,
    `commentaire_public`, `est_verifie`
)
SELECT 
    r.id, @voyageur_id, @chezmama_id,
    5, 4, 5, 4, 5,
    'Mama est une hôtesse exceptionnelle ! Cuisine délicieuse, accueil chaleureux. Ambiance familiale. Parfait pour découvrir Ouidah.',
    1
FROM reservation r WHERE r.reference = 'RES20240102';

-- Réponse de l'hébergeur
UPDATE `avis` 
SET `reponse_hebergeur` = 'Merci infiniment pour votre retour ! Au plaisir de vous recevoir à nouveau.',
    `date_reponse` = NOW()
WHERE `hebergement_id` = @azalai_id;