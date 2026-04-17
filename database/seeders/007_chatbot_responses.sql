-- Seeders: 007_chatbot_responses.sql
-- Réponses pré-définies pour le chatbot

USE `benin_tourisme`;

-- Intentions
INSERT INTO `intention_chatbot` (`nom`, `description`, `reponse_par_defaut`) VALUES
('salutation', 'Bonjour, salut, coucou, hello', 'Bonjour ! Je suis l''assistant virtuel de Tourisme Bénin. Comment puis-je vous aider ?'),
('recherche_hebergement', 'Chercher un logement, hôtel, auberge', 'Je peux vous aider à trouver un hébergement. Quelle ville souhaitez-vous visiter ?'),
('recherche_site', 'Visiter, sites touristiques, monuments', 'Le Bénin regorge de sites magnifiques ! Quelle région vous intéresse ?'),
('prix', 'Tarif, coût, combien, budget', 'Les prix varient selon le type d''hébergement. Voulez-vous que je vous donne une fourchette ?'),
('transport', 'Se déplacer, taxi, bus, voiture', 'Plusieurs options : zemidjan (taxi-moto), taxi classique, bus interurbain, location de voiture.'),
('securite', 'Sécurité, dangereux, prudent', 'Le Bénin est un pays accueillant. Restez vigilant dans les grandes villes et évitez les bijoux ostentatoires.'),
('climat', 'Météo, pluie, chaud, saison', 'Saison sèche : novembre à mars. Saison des pluies : avril à octobre. L''harmattan de décembre à février.'),
('vaudou', 'Vaudou, fétiche, cérémonie', 'Le vaudou est une religion reconnue au Bénin. Ouidah est le berceau du vaudou. Fête nationale le 10 janvier.'),
('cuisine', 'Manger, nourriture, restaurant, plat', 'Spécialités : pâte rouge (akassa), igname pilée, poisson braisé, agouti, poulet bicyclette.'),
('au_revoir', 'Au revoir, merci, bye', 'Merci d''avoir utilisé Tourisme Bénin ! Belle journée à vous. N''hésitez pas à revenir.');

-- Réponses spécifiques
INSERT INTO `reponse_chatbot` (`intention`, `mot_clef`, `reponse`, `priorite`) VALUES
('salutation', 'bonjour,salut,coucou,hello', 'Bonjour ! 🌞 Je suis votre guide virtuel pour le Bénin. Que cherchez-vous ?', 10),
('salutation', 'bonsoir', 'Bonsoir ! Ravi de vous aider à préparer votre voyage au Bénin.', 10),

('recherche_hebergement', 'hôtel,hotel', 'Nous avons de nombreux hôtels : Azalaï, Novotel, Bel Azur... Quelle ville ?', 20),
('recherche_hebergement', 'auberge', 'Les auberges sont économiques et conviviales. À Cotonou, Ouidah, Grand-Popo.', 15),
('recherche_hebergement', 'maison d\'hôte,maison d\'hote,chez', 'Les maisons d''hôte offrent une expérience authentique. Je peux vous recommander "Chez Mama" à Ouidah !', 15),

('recherche_site', 'abomey,palais,roi', 'Les Palais Royaux d''Abomey sont classés UNESCO. Visite incontournable !', 20),
('recherche_site', 'ouidah,esclave,python', 'La Route des Esclaves et le Temple des Pythons sont les sites majeurs de Ouidah.', 20),
('recherche_site', 'ganvié,lac,pilotis', 'Ganvié est la plus grande cité lacustre d''Afrique. Balade en pirogue inoubliable !', 20),
('recherche_site', 'pendjari,safari,parc', 'Le Parc National de la Pendjari est le meilleur endroit pour voir des éléphants, lions, buffles en liberté.', 20),

('prix', 'budget', 'Budget hébergement : auberge (8-15k FCFA), maison d''hôte (10-20k), hôtel (20-100k+).', 15),
('prix', 'économique,pas cher', 'Pour petit budget : auberges et maisons d''hôte. À partir de 8 000 FCFA la nuit.', 15),

('transport', 'zemidjan,zemi', 'Le zemidjan est le taxi-moto béninois. Rapide et économique (200-500 FCFA en ville).', 15),
('transport', 'taxi', 'Taxis classiques : comptez 1000-1500 FCFA pour une course en ville. Négociez avant.', 15),
('transport', 'bus', 'Bus interurbains : TGP, Confort, Star. Relient les grandes villes. Cotonou-Parakou : 5000 FCFA.', 15),

('cuisine', 'pâte,akassa', 'L''akassa est une pâte de maïs fermenté, souvent servie avec de la sauce et du poisson.', 10),
('cuisine', 'agouti', 'L''agouti (rongeur) est un met de fête. Goût prononcé, texture ferme. À essayer !', 10),
('cuisine', 'poulet', 'Le poulet bicyclette est élevé en liberté, viande ferme et savoureuse.', 10),

('vaudou', 'fétiche,gris-gris', 'Le vaudou est partout dans la culture béninoise. Le Marché des Fétiches à Cotonou est impressionnant.', 15),

('au_revoir', 'merci,bye,aurevoir', 'Merci de votre visite ! À bientôt sur Tourisme Bénin. 🇧🇯', 20),
('au_revoir', 'merci,bye,aurevoir', 'Au revoir ! Passez une excellente journée. N''oubliez pas la crème solaire ! 😎', 15);