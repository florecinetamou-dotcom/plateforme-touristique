-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
<<<<<<< HEAD
-- Generation Time: Apr 16, 2026 at 03:16 PM
=======
-- Generation Time: Mar 04, 2026 at 11:35 PM
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tourisme_benin`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_hebergement_note` (IN `p_hebergement_id` INT)   BEGIN
    UPDATE hebergement h
    SET note_moyenne = (
        SELECT COALESCE(AVG(note_globale), 0)
        FROM avis a
        WHERE a.hebergement_id = p_hebergement_id
        AND a.est_verifie = 1
    )
    WHERE h.id = p_hebergement_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
<<<<<<< HEAD
=======
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `reservation_id` int NOT NULL,
  `voyageur_id` int NOT NULL,
  `hebergement_id` int NOT NULL,
  `note_globale` tinyint(1) NOT NULL,
  `note_proprete` tinyint(1) DEFAULT NULL,
  `note_communication` tinyint(1) DEFAULT NULL,
  `note_emplacement` tinyint(1) DEFAULT NULL,
  `note_qualite_prix` tinyint(1) DEFAULT NULL,
  `commentaire_public` text COLLATE utf8mb4_unicode_ci,
  `commentaire_prive` text COLLATE utf8mb4_unicode_ci,
  `reponse_hebergeur` text COLLATE utf8mb4_unicode_ci,
  `date_reponse` timestamp NULL DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_verifie` tinyint(1) DEFAULT '0',
  `signalement` tinyint(1) DEFAULT '0'
) ;

--
-- Triggers `avis`
--
DELIMITER $$
CREATE TRIGGER `after_avis_delete` AFTER DELETE ON `avis` FOR EACH ROW BEGIN
    CALL update_hebergement_note(OLD.hebergement_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_avis_insert` AFTER INSERT ON `avis` FOR EACH ROW BEGIN
    CALL update_hebergement_note(NEW.hebergement_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_avis_update` AFTER UPDATE ON `avis` FOR EACH ROW BEGIN
    CALL update_hebergement_note(NEW.hebergement_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_conversations`
--

CREATE TABLE `chatbot_conversations` (
  `id` int NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `message_utilisateur` text NOT NULL,
  `reponse_bot` text NOT NULL,
  `date_envoi` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_intentions`
--

CREATE TABLE `chatbot_intentions` (
  `id` int NOT NULL,
  `mot_cle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_intentions`
--

INSERT INTO `chatbot_intentions` (`id`, `mot_cle`, `description`, `date_creation`) VALUES
(1, 'bonjour', 'Accueil des utilisateurs', '2026-02-25 02:43:08'),
(2, 'prix', 'Informations générales sur les tarifs', '2026-02-25 02:43:08'),
(3, 'ouidah', 'Informations sur la ville de Ouidah', '2026-02-25 02:43:08'),
(4, 'contact', 'Coordonnées de l\'assistance', '2026-02-25 02:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_reponses`
--

CREATE TABLE `chatbot_reponses` (
  `id` int NOT NULL,
  `intention_id` int NOT NULL,
  `reponse_texte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_reponses`
--

INSERT INTO `chatbot_reponses` (`id`, `intention_id`, `reponse_texte`, `date_modification`) VALUES
(1, 1, 'Bonjour ! Je suis l\'assistant BeninExplore. Comment puis-je vous aider dans votre voyage ?', '2026-02-25 02:43:08'),
(2, 2, 'Les prix varient selon l\'hébergement choisi. Vous pouvez filtrer les résultats par budget sur notre page d\'accueil.', '2026-02-25 02:43:08'),
(3, 3, 'Ouidah est une ville historique célèbre pour sa Porte du Non-Retour et son Temple des Pythons. Souhaitez-vous voir les hébergements là-bas ?', '2026-02-25 02:43:08'),
(4, 4, 'Vous pouvez nous contacter par email à support@beninexplore.bj ou appeler le +229 00 00 00 00.', '2026-02-25 02:43:08');

-- --------------------------------------------------------

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Table structure for table `disponibilite`
--

CREATE TABLE `disponibilite` (
  `id` int NOT NULL,
  `hebergement_id` int NOT NULL,
  `date` date NOT NULL,
  `est_disponible` tinyint(1) DEFAULT '1',
  `prix_du_jour` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favori`
--

CREATE TABLE `favori` (
  `voyageur_id` int NOT NULL,
  `hebergement_id` int NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note_privee` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

<<<<<<< HEAD
--
-- Dumping data for table `favori`
--

INSERT INTO `favori` (`voyageur_id`, `hebergement_id`, `date_ajout`, `note_privee`) VALUES
(1008, 26, '2026-04-15 22:27:53', NULL);

=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- --------------------------------------------------------

--
-- Table structure for table `hebergement`
--

CREATE TABLE `hebergement` (
  `id` int NOT NULL,
  `hebergeur_id` int NOT NULL,
  `ville_id` int NOT NULL,
  `type_id` int DEFAULT NULL,
  `nom` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `adresse` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_nuit_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `capacite` int DEFAULT NULL,
  `chambres` int DEFAULT NULL,
  `lits` int DEFAULT NULL,
  `salles_de_bain` int DEFAULT NULL,
  `equipements` json DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `note_moyenne` decimal(3,2) DEFAULT '0.00',
  `statut` enum('en_attente','approuve','rejete','suspendu') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  `politique_annulation` text COLLATE utf8mb4_unicode_ci,
  `regles_maison` text COLLATE utf8mb4_unicode_ci,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `hebergement`
--

INSERT INTO `hebergement` (`id`, `hebergeur_id`, `ville_id`, `type_id`, `nom`, `description`, `adresse`, `prix_nuit_base`, `capacite`, `chambres`, `lits`, `salles_de_bain`, `equipements`, `latitude`, `longitude`, `note_moyenne`, `statut`, `politique_annulation`, `regles_maison`, `date_creation`) VALUES
<<<<<<< HEAD
(26, 1008, 2, 5, 'villa Léa', 'Située à Porto-Novo, la Villa Léa est un hébergement moderne qui allie confort, calme et accessibilité. Idéalement implantée dans un quartier paisible, elle constitue un cadre parfait pour un séjour en famille, entre amis ou pour des déplacements professionnels.\r\n\r\nLa villa dispose de chambres spacieuses et bien aménagées, d’un salon accueillant et lumineux, ainsi que d’une cuisine entièrement équipée. Chaque espace est conçu pour offrir un maximum de confort et garantir un séjour agréable aux visiteurs.\r\n\r\nPour répondre aux besoins des voyageurs, la Villa Léa propose également des équipements essentiels tels que la climatisation, une connexion Wi-Fi, un service de sécurité et un parking. Son environnement calme permet de se détendre tout en restant proche des commodités et des principaux centres d’intérêt de la ville.\r\n\r\nGrâce à son ambiance conviviale et à ses prestations de qualité, la Villa Léa représente une excellente option d’hébergement pour découvrir Porto-Novo et profiter pleinement de votre séjour.', 'Porto-Novo, quartier Djassin', '100000.00', 6, 3, 3, 2, NULL, NULL, NULL, '0.00', 'approuve', NULL, NULL, '2026-04-15 22:25:27');
=======
(20, 1001, 1, 3, 'VILLA', 'BONNE', '9CCX+FJ5\r\nRue 1212B', '120000.00', 10, 13, 12, 13, NULL, NULL, NULL, '0.00', 'en_attente', NULL, NULL, '2026-02-21 00:59:41');
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `expediteur_id` int NOT NULL,
  `destinataire_id` int NOT NULL,
  `reservation_id` int DEFAULT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_lu` tinyint(1) DEFAULT '0',
  `date_envoi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `type` enum('reservation','message','paiement','avis','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_lu` tinyint(1) DEFAULT '0',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photo_hebergement`
--

CREATE TABLE `photo_hebergement` (
  `id` int NOT NULL,
  `hebergement_id` int NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_principale` tinyint(1) DEFAULT '0',
  `ordre` int DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

<<<<<<< HEAD
--
-- Dumping data for table `photo_hebergement`
--

INSERT INTO `photo_hebergement` (`id`, `hebergement_id`, `url`, `est_principale`, `ordre`, `description`, `date_ajout`) VALUES
(23, 26, '/uploads/hebergements/heb_26_main_1776291927.jpg', 1, 0, NULL, '2026-04-15 22:25:27'),
(24, 26, '/uploads/hebergements/heb_26_sec_2_1776291927.jpg', 0, 2, NULL, '2026-04-15 22:25:27'),
(25, 26, '/uploads/hebergements/heb_26_sec_1_1776292981.jpg', 0, 1, NULL, '2026-04-15 22:43:01'),
(26, 26, '/uploads/hebergements/heb_26_sec_2_1776292981.jpg', 0, 2, NULL, '2026-04-15 22:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `photo_site_touristique`
--

CREATE TABLE `photo_site_touristique` (
  `id` int UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_principale` tinyint(1) NOT NULL DEFAULT '0',
  `ordre` int NOT NULL DEFAULT '0',
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photo_site_touristique`
--

INSERT INTO `photo_site_touristique` (`id`, `site_id`, `url`, `est_principale`, `ordre`, `date_ajout`) VALUES
(5, 2, '/uploads/sites/site_2_main_1776288104.jpg', 1, 0, '2026-04-15 22:21:44'),
(6, 2, '/uploads/sites/site_2_sec_1_1776288104.jpeg', 0, 1, '2026-04-15 22:21:44'),
(7, 2, '/uploads/sites/site_2_sec_2_1776288104.jpeg', 0, 2, '2026-04-15 22:21:44'),
(8, 2, '/uploads/sites/site_2_sec_3_1776288104.jpeg', 0, 3, '2026-04-15 22:21:44');
=======
-- --------------------------------------------------------

--
-- Table structure for table `profil_hebergeur`
--

CREATE TABLE `profil_hebergeur` (
  `id` int NOT NULL,
  `nom_etablissement` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `adresse` text COLLATE utf8mb4_unicode_ci,
  `numero_siret` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_verification` enum('en_attente','verifie','rejete') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil_hebergeur`
--

INSERT INTO `profil_hebergeur` (`id`, `nom_etablissement`, `description`, `adresse`, `numero_siret`, `statut_verification`) VALUES
(1001, 'Mon Établissement', NULL, NULL, NULL, 'en_attente');
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int NOT NULL,
  `reference` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voyageur_id` int NOT NULL,
  `hebergement_id` int NOT NULL,
  `date_arrivee` date NOT NULL,
  `date_depart` date NOT NULL,
  `nombre_voyageurs` int DEFAULT NULL,
  `statut` enum('en_attente','confirmee','annulee','terminee','no_show') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  `montant_total` decimal(10,2) DEFAULT NULL,
  `accompte_verse` decimal(10,2) DEFAULT '0.00',
  `mode_paiement` enum('carte','mobile_money','especes','virement') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paiement_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_reservation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_confirmation` timestamp NULL DEFAULT NULL,
  `date_annulation` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci
) ;

--
-- Triggers `reservation`
--
DELIMITER $$
CREATE TRIGGER `after_reservation_insert` AFTER INSERT ON `reservation` FOR EACH ROW BEGIN
    -- Notification pour l'hébergeur
    INSERT INTO notification (utilisateur_id, type, titre, contenu, lien)
    SELECT 
        h.hebergeur_id,
        'reservation',
        'Nouvelle réservation',
        CONCAT('Vous avez reçu une réservation de ', u.prenom, ' ', u.nom),
        CONCAT('/admin/reservations/', NEW.id)
    FROM hebergement h
    JOIN utilisateur u ON u.id = NEW.voyageur_id
    WHERE h.id = NEW.hebergement_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_reservation_insert` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
    DECLARE ref VARCHAR(20);
    SET ref = CONCAT('RES', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(FLOOR(RAND() * 10000), 4, '0'));
    SET NEW.reference = ref;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `site_touristique`
--

CREATE TABLE `site_touristique` (
<<<<<<< HEAD
  `id` int UNSIGNED NOT NULL,
=======
  `id` int NOT NULL,
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
  `ville_id` int NOT NULL,
  `nom` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `categorie` enum('historique','nature','culturel','religieux','autre') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'autre',
  `adresse` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `prix_entree` decimal(10,2) DEFAULT '0.00',
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  `photo_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_valide` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

<<<<<<< HEAD
--
-- Dumping data for table `site_touristique`
--

INSERT INTO `site_touristique` (`id`, `ville_id`, `nom`, `description`, `categorie`, `adresse`, `latitude`, `longitude`, `prix_entree`, `heure_ouverture`, `heure_fermeture`, `photo_url`, `est_valide`) VALUES
(2, 3, 'PALAIS ROYAL ABOMEY', 'Le Palais Royal d’Abomey est l’un des sites historiques les plus importants du Bénin. Situé dans la ville d’Abomey, il constitue un témoignage exceptionnel de l’histoire du royaume du Dahomey, qui a dominé la région du XVIIe au XIXe siècle.\r\n\r\nConstruit à partir du XVIIe siècle, le palais est en réalité un ensemble de plusieurs résidences royales édifiées par les différents rois qui se sont succédé. Chaque souverain faisait bâtir son propre palais à côté de celui de son prédécesseur, ce qui a donné naissance à un vaste complexe s’étendant sur plusieurs hectares. Les matériaux utilisés sont principalement la terre battue, le bois et la paille, caractéristiques de l’architecture traditionnelle locale.', 'historique', 'Bénin - Abomey calavi', '7.16150000', '1.17180000', '5000.00', '08:00:00', '17:00:00', NULL, 1);

=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- --------------------------------------------------------

--
-- Table structure for table `type_hebergement`
--

CREATE TABLE `type_hebergement` (
  `id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_hebergement`
--

INSERT INTO `type_hebergement` (`id`, `nom`, `icone_url`, `description`) VALUES
(1, 'Hôtel', '/icons/hotel.png', 'Établissement hôtelier classique avec services'),
(2, 'Auberge', '/icons/auberge.png', 'Petit hébergement convivial et économique'),
(3, 'Maison d\'hôte', '/icons/maison-hote.png', 'Hébergement chez l\'habitant'),
(4, 'Appartement', '/icons/appartement.png', 'Logement entier avec kitchenette'),
(5, 'Villa', '/icons/villa.png', 'Maison indépendante avec jardin');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
<<<<<<< HEAD
  `role` enum('admin','voyageur','hebergeur') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'voyageur',
  `avatar_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_verifie` tinyint(1) NOT NULL DEFAULT '0',
  `est_bloque` tinyint(1) NOT NULL DEFAULT '0',
=======
  `role` enum('voyageur','hebergeur','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'voyageur',
  `avatar_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_verifie` tinyint(1) DEFAULT '0',
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` timestamp NULL DEFAULT NULL,
  `langue_preferee` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'fr',
  `newsletter` tinyint(1) DEFAULT '0',
  `token_reinitialisation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
<<<<<<< HEAD
  `token_expiration` timestamp NULL DEFAULT NULL,
  `statut_hebergeur` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valide_le` datetime DEFAULT NULL,
  `valide_par` int DEFAULT NULL
=======
  `token_expiration` timestamp NULL DEFAULT NULL
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateur`
--

<<<<<<< HEAD
INSERT INTO `utilisateur` (`id`, `email`, `mot_de_passe_hash`, `nom`, `prenom`, `telephone`, `role`, `avatar_url`, `est_verifie`, `est_bloque`, `date_inscription`, `derniere_connexion`, `langue_preferee`, `newsletter`, `token_reinitialisation`, `token_expiration`, `statut_hebergeur`, `valide_le`, `valide_par`) VALUES
(1002, 'admin@beninexplore.bj', '$2y$10$1B7UD2bwexvKLNub16K2cuM3mVdA80f7A.3nOymnvdMeZd.q8oHxi', 'Admin', 'Super', NULL, 'admin', NULL, 1, 0, '2026-03-04 00:51:05', '2026-04-14 19:55:18', 'fr', 0, 'e1749e12e5d41974e54ebd15744b80c5c003c850d28052c17df6ff61ec2c6dbd', '2026-04-27 20:36:50', NULL, NULL, NULL),
(1008, 'tom@gmail.com', '$2y$10$r9xApGxj7yyopp/VcBfrHu6cbeUNNMRXnT0AOXwu3t64IiGSsN916', 'TOMY', 'Jean', '0155912082', 'hebergeur', '/uploads/avatars/hebergeur_1008_1776290042.jpg', 0, 0, '2026-04-15 21:00:41', NULL, 'fr', 1, NULL, NULL, NULL, NULL, NULL);
=======
INSERT INTO `utilisateur` (`id`, `email`, `mot_de_passe_hash`, `nom`, `prenom`, `telephone`, `role`, `avatar_url`, `est_verifie`, `date_inscription`, `derniere_connexion`, `langue_preferee`, `newsletter`, `token_reinitialisation`, `token_expiration`) VALUES
(3, 'florecinetamou@gmail.com', '$2y$10$CIEQBD5GX9X2cqB5hA5TAebiscBRyUSyTIcbD8ZA91tvKyBNREUjy', 'Tamou', 'Florecine', '0152963478', 'voyageur', NULL, 0, '2026-02-14 02:54:02', NULL, 'fr', 0, NULL, NULL),
(1001, 'john@gmail.com', '$2y$10$btTbPVxUPU0lCE8iXQPp0.1j5KmEIyEAjS2pM.c6pGGhOpFTjPKN.', 'JOHNSON', 'Dave', '0166859284', 'hebergeur', NULL, 0, '2026-02-21 00:28:11', NULL, 'fr', 0, NULL, NULL),
(1002, 'admin@beninexplore.bj', '$2y$10$1B7UD2bwexvKLNub16K2cuM3mVdA80f7A.3nOymnvdMeZd.q8oHxi', 'Admin', 'Super', NULL, 'admin', NULL, 1, '2026-03-04 00:51:05', '2026-03-04 01:04:26', 'fr', 0, NULL, NULL);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

-- --------------------------------------------------------

--
-- Table structure for table `ville`
--

CREATE TABLE `ville` (
  `id` int NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `photo_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `description`, `latitude`, `longitude`, `photo_url`, `est_active`) VALUES
<<<<<<< HEAD
(1, 'Cotonou', 'Cotonou, située sur la côte du golfe de Guinée, est la capitale économique du Bénin et constitue une destination incontournable pour les amateurs de tourisme culturel et balnéaire. Ville dynamique et cosmopolite, Cotonou séduit par son ambiance vivante, son hospitalité chaleureuse et la richesse de son patrimoine. Elle offre un mélange harmonieux entre modernité et traditions africaines, permettant aux visiteurs de découvrir à la fois un mode de vie urbain animé et des pratiques culturelles ancestrales.\r\n\r\nAu cœur de la ville, le célèbre Marché Dantokpa représente l’un des plus grands marchés d’Afrique de l’Ouest. Véritable centre économique et culturel, il propose une diversité impressionnante de produits allant des tissus traditionnels aux épices locales, en passant par l’artisanat et les objets du quotidien. Non loin de là, la Fondation Zinsou offre une immersion dans l’art contemporain africain, mettant en valeur le talent et la créativité des artistes du continent.\r\n\r\nLa ville est également réputée pour ses plages bordées par l’océan Atlantique, où les visiteurs peuvent profiter de moments de détente tout en admirant de magnifiques couchers de soleil. Pour les amateurs d’artisanat, le Centre Artisanal de Cotonou constitue un lieu privilégié pour découvrir et acquérir des objets faits à la main, reflétant le savoir-faire local.\r\n\r\nEn matière de gastronomie, Cotonou propose une expérience culinaire riche et variée, avec des spécialités locales telles que le poulet bicyclette, le poisson braisé ou encore des plats à base de pâte accompagnée de sauces traditionnelles. La ville se distingue également par sa vie nocturne animée, rythmée par la musique africaine et l’ambiance conviviale des maquis et des bars.\r\n\r\nEnfin, Cotonou représente un excellent point de départ pour explorer d’autres sites touristiques du Bénin, notamment Ouidah, connue pour son histoire liée à la route des esclaves, ou encore Grand-Popo, appréciée pour ses plages paisibles.\r\n\r\nAinsi, Cotonou s’impose comme une destination complète, alliant découverte culturelle, détente et expériences authentiques, idéale pour tout visiteur souhaitant explorer le Bénin dans toute sa diversité.', '6.37030000', '2.39120000', '/uploads/villes/ville_69e01797048c4.jpg', 1),
=======
(1, 'Cotonou', 'Capitale économique du Bénin - Centre d\'affaires et de commerce', NULL, NULL, NULL, 1),
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
(2, 'Porto-Novo', 'Capitale administrative - Ville historique', NULL, NULL, NULL, 1),
(3, 'Abomey', 'Ancienne capitale du royaume du Dahomey - Palais royaux', NULL, NULL, NULL, 1),
(4, 'Ouidah', 'Ville historique de la route des esclaves - Plages', NULL, NULL, NULL, 1),
(5, 'Grand-Popo', 'Station balnéaire - Bouche du Roy', NULL, NULL, NULL, 1),
(6, 'Natitingou', 'Porte d\'entrée du parc national de la Pendjari', NULL, NULL, NULL, 1),
(7, 'Parakou', 'Plus grande ville du Nord-Bénin - Carrefour commercial', NULL, NULL, NULL, 1),
(8, 'Ganvié', 'Cité lacustre sur le lac Nokoué', NULL, NULL, NULL, 1),
(9, 'Bohicon', 'Centre commercial du Zou', NULL, NULL, NULL, 1),
(10, 'Lokossa', 'Ville des collines', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `voyage`
--

CREATE TABLE `voyage` (
  `id` int NOT NULL,
  `voyageur_id` int NOT NULL,
  `titre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `budget_estime` decimal(10,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
<<<<<<< HEAD
=======
-- Stand-in structure for view `vue_hebergements_complets`
-- (See below for the actual view)
--
CREATE TABLE `vue_hebergements_complets` (
`id` int
,`nom` varchar(200)
,`description` text
,`prix_nuit_base` decimal(10,2)
,`note_moyenne` decimal(3,2)
,`statut` enum('en_attente','approuve','rejete','suspendu')
,`ville` varchar(100)
,`photo_principale` text
,`type_hebergement` varchar(50)
,`nom_etablissement` varchar(200)
,`capacite` int
,`chambres` int
);

-- --------------------------------------------------------

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Stand-in structure for view `vue_reservations_actives`
-- (See below for the actual view)
--
CREATE TABLE `vue_reservations_actives` (
<<<<<<< HEAD
`accompte_verse` decimal(10,2)
,`date_annulation` timestamp
,`date_arrivee` date
,`date_confirmation` timestamp
,`date_depart` date
,`date_reservation` timestamp
,`hebergement_id` int
,`hebergement_nom` varchar(200)
,`id` int
,`mode_paiement` enum('carte','mobile_money','especes','virement')
,`montant_total` decimal(10,2)
,`nombre_voyageurs` int
,`notes` text
,`paiement_id` varchar(100)
,`reference` varchar(20)
,`statut` enum('en_attente','confirmee','annulee','terminee','no_show')
,`voyageur_email` varchar(255)
,`voyageur_id` int
,`voyageur_nom` varchar(100)
,`voyageur_prenom` varchar(100)
=======
`id` int
,`reference` varchar(20)
,`voyageur_id` int
,`hebergement_id` int
,`date_arrivee` date
,`date_depart` date
,`nombre_voyageurs` int
,`statut` enum('en_attente','confirmee','annulee','terminee','no_show')
,`montant_total` decimal(10,2)
,`accompte_verse` decimal(10,2)
,`mode_paiement` enum('carte','mobile_money','especes','virement')
,`paiement_id` varchar(100)
,`date_reservation` timestamp
,`date_confirmation` timestamp
,`date_annulation` timestamp
,`notes` text
,`voyageur_nom` varchar(100)
,`voyageur_prenom` varchar(100)
,`voyageur_email` varchar(255)
,`hebergement_nom` varchar(200)
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
);

-- --------------------------------------------------------

--
<<<<<<< HEAD
=======
-- Structure for view `vue_hebergements_complets`
--
DROP TABLE IF EXISTS `vue_hebergements_complets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_hebergements_complets`  AS SELECT `h`.`id` AS `id`, `h`.`nom` AS `nom`, `h`.`description` AS `description`, `h`.`prix_nuit_base` AS `prix_nuit_base`, `h`.`note_moyenne` AS `note_moyenne`, `h`.`statut` AS `statut`, `v`.`nom` AS `ville`, `ph`.`url` AS `photo_principale`, `th`.`nom` AS `type_hebergement`, `ph2`.`nom_etablissement` AS `nom_etablissement`, `h`.`capacite` AS `capacite`, `h`.`chambres` AS `chambres` FROM ((((`hebergement` `h` join `ville` `v` on((`h`.`ville_id` = `v`.`id`))) left join `type_hebergement` `th` on((`h`.`type_id` = `th`.`id`))) left join `profil_hebergeur` `ph2` on((`h`.`hebergeur_id` = `ph2`.`id`))) left join `photo_hebergement` `ph` on(((`ph`.`hebergement_id` = `h`.`id`) and (`ph`.`est_principale` = 1))))  ;

-- --------------------------------------------------------

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Structure for view `vue_reservations_actives`
--
DROP TABLE IF EXISTS `vue_reservations_actives`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_reservations_actives`  AS SELECT `r`.`id` AS `id`, `r`.`reference` AS `reference`, `r`.`voyageur_id` AS `voyageur_id`, `r`.`hebergement_id` AS `hebergement_id`, `r`.`date_arrivee` AS `date_arrivee`, `r`.`date_depart` AS `date_depart`, `r`.`nombre_voyageurs` AS `nombre_voyageurs`, `r`.`statut` AS `statut`, `r`.`montant_total` AS `montant_total`, `r`.`accompte_verse` AS `accompte_verse`, `r`.`mode_paiement` AS `mode_paiement`, `r`.`paiement_id` AS `paiement_id`, `r`.`date_reservation` AS `date_reservation`, `r`.`date_confirmation` AS `date_confirmation`, `r`.`date_annulation` AS `date_annulation`, `r`.`notes` AS `notes`, `u`.`nom` AS `voyageur_nom`, `u`.`prenom` AS `voyageur_prenom`, `u`.`email` AS `voyageur_email`, `h`.`nom` AS `hebergement_nom` FROM ((`reservation` `r` join `utilisateur` `u` on((`r`.`voyageur_id` = `u`.`id`))) join `hebergement` `h` on((`r`.`hebergement_id` = `h`.`id`))) WHERE ((`r`.`statut` in ('en_attente','confirmee')) AND (`r`.`date_depart` >= curdate()))  ;

--
-- Indexes for dumped tables
--

--
<<<<<<< HEAD
=======
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_avis_reservation` (`reservation_id`),
  ADD KEY `voyageur_id` (`voyageur_id`),
  ADD KEY `hebergement_id` (`hebergement_id`);

--
-- Indexes for table `chatbot_conversations`
--
ALTER TABLE `chatbot_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chat_utilisateur` (`utilisateur_id`);

--
-- Indexes for table `chatbot_intentions`
--
ALTER TABLE `chatbot_intentions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mot_cle` (`mot_cle`);

--
-- Indexes for table `chatbot_reponses`
--
ALTER TABLE `chatbot_reponses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reponse_intention` (`intention_id`);

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Indexes for table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_dispo_jour` (`hebergement_id`,`date`),
  ADD KEY `hebergement_id` (`hebergement_id`);

--
-- Indexes for table `favori`
--
ALTER TABLE `favori`
  ADD PRIMARY KEY (`voyageur_id`,`hebergement_id`),
  ADD KEY `hebergement_id` (`hebergement_id`);

--
-- Indexes for table `hebergement`
--
ALTER TABLE `hebergement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hebergeur_id` (`hebergeur_id`),
  ADD KEY `ville_id` (`ville_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `idx_hebergement_statut` (`statut`),
  ADD KEY `idx_hebergement_note` (`note_moyenne`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediteur_id` (`expediteur_id`),
  ADD KEY `destinataire_id` (`destinataire_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `idx_message_lu` (`est_lu`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `idx_notification_lu` (`est_lu`);

--
-- Indexes for table `photo_hebergement`
--
ALTER TABLE `photo_hebergement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hebergement_id` (`hebergement_id`);

--
<<<<<<< HEAD
-- Indexes for table `photo_site_touristique`
--
ALTER TABLE `photo_site_touristique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_site_id` (`site_id`),
  ADD KEY `idx_principale` (`site_id`,`est_principale`);
=======
-- Indexes for table `profil_hebergeur`
--
ALTER TABLE `profil_hebergeur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_siret` (`numero_siret`);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `voyageur_id` (`voyageur_id`),
  ADD KEY `hebergement_id` (`hebergement_id`),
  ADD KEY `idx_reservation_dates` (`date_arrivee`,`date_depart`),
  ADD KEY `idx_reservation_statut` (`statut`);

--
<<<<<<< HEAD
-- Indexes for table `site_touristique`
--
ALTER TABLE `site_touristique`
  ADD PRIMARY KEY (`id`);

--
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Indexes for table `type_hebergement`
--
ALTER TABLE `type_hebergement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
<<<<<<< HEAD
  ADD KEY `idx_utilisateur_role` (`role`),
  ADD KEY `idx_statut_hebergeur` (`statut_hebergeur`),
  ADD KEY `idx_role_statut` (`role`,`statut_hebergeur`);
=======
  ADD KEY `idx_utilisateur_role` (`role`);
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

--
-- Indexes for table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ville_nom` (`nom`);

--
-- Indexes for table `voyage`
--
ALTER TABLE `voyage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voyageur_id` (`voyageur_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
<<<<<<< HEAD
=======
-- AUTO_INCREMENT for table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatbot_conversations`
--
ALTER TABLE `chatbot_conversations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatbot_intentions`
--
ALTER TABLE `chatbot_intentions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chatbot_reponses`
--
ALTER TABLE `chatbot_reponses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- AUTO_INCREMENT for table `disponibilite`
--
ALTER TABLE `disponibilite`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hebergement`
--
ALTER TABLE `hebergement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
<<<<<<< HEAD
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

--
-- AUTO_INCREMENT for table `photo_hebergement`
--
ALTER TABLE `photo_hebergement`
<<<<<<< HEAD
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `photo_site_touristique`
--
ALTER TABLE `photo_site_touristique`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
=======
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
<<<<<<< HEAD
-- AUTO_INCREMENT for table `site_touristique`
--
ALTER TABLE `site_touristique`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- AUTO_INCREMENT for table `type_hebergement`
--
ALTER TABLE `type_hebergement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
<<<<<<< HEAD
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;
=======
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

--
-- AUTO_INCREMENT for table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `voyage`
--
ALTER TABLE `voyage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
<<<<<<< HEAD
=======
-- Constraints for table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_avis_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_avis_voyageur` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chatbot_conversations`
--
ALTER TABLE `chatbot_conversations`
  ADD CONSTRAINT `fk_chat_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chatbot_reponses`
--
ALTER TABLE `chatbot_reponses`
  ADD CONSTRAINT `fk_reponse_intention` FOREIGN KEY (`intention_id`) REFERENCES `chatbot_intentions` (`id`) ON DELETE CASCADE;

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Constraints for table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `fk_dispo_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergement` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `fk_favori_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_favori_voyageur` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hebergement`
--
ALTER TABLE `hebergement`
<<<<<<< HEAD
  ADD CONSTRAINT `fk_hebergement_hebergeur` FOREIGN KEY (`hebergeur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
=======
  ADD CONSTRAINT `fk_hebergement_hebergeur` FOREIGN KEY (`hebergeur_id`) REFERENCES `profil_hebergeur` (`id`) ON DELETE CASCADE,
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
  ADD CONSTRAINT `fk_hebergement_type` FOREIGN KEY (`type_id`) REFERENCES `type_hebergement` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_hebergement_ville` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_destinataire` FOREIGN KEY (`destinataire_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_message_expediteur` FOREIGN KEY (`expediteur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_message_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `photo_hebergement`
--
ALTER TABLE `photo_hebergement`
  ADD CONSTRAINT `fk_photo_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergement` (`id`) ON DELETE CASCADE;

--
<<<<<<< HEAD
=======
-- Constraints for table `profil_hebergeur`
--
ALTER TABLE `profil_hebergeur`
  ADD CONSTRAINT `fk_hebergeur_utilisateur` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reservation_voyageur` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voyage`
--
ALTER TABLE `voyage`
  ADD CONSTRAINT `fk_voyage_voyageur` FOREIGN KEY (`voyageur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
