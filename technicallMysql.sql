-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 03 avr. 2020 à 15:15
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `technicall`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement_test`
--

DROP TABLE IF EXISTS `abonnement_test`;
CREATE TABLE IF NOT EXISTS `abonnement_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_abonnement` int(11) NOT NULL,
  `date_paiement` date NOT NULL,
  `heure_restante` int(11) NOT NULL,
  `id_membre` int(11) DEFAULT NULL,
  `fin_abonnement` date NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `abonnement_test`
--

INSERT INTO `abonnement_test` (`id`, `type_abonnement`, `date_paiement`, `heure_restante`, `id_membre`, `fin_abonnement`) VALUES
(1, 4, '2020-04-02', 25, NULL, '0000-00-00'),
(5, 1, '2020-04-03', 12, 7, '2020-05-03'),
(6, 1, '2020-04-02', 12, 8, '2020-05-02'),
(7, 1, '2020-04-03', 12, 9, '2020-05-03');

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

DROP TABLE IF EXISTS `demandes`;
CREATE TABLE IF NOT EXISTS `demandes` (
  `id_demandes` int(11) NOT NULL AUTO_INCREMENT,
  `nom_demande` varchar(200) NOT NULL,
  `prix_demande` varchar(50) NOT NULL,
  `type_demande` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `heure` TIME NOT NULL DEFAULT '00:00:00',
  `ville` varchar(255) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `statut_demande` char(1) NOT NULL DEFAULT '0',
  `id_intervenant_demande` int(11) DEFAULT NULL,
  `valide` tinyint(1) NOT NULL,
  `ref_devis` varchar(45) DEFAULT NULL,
  `ref_facture` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_demandes`),
  KEY `id_intervenant` (`id_intervenant_demande`)
) ;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`id_demandes`, `nom_demande`, `prix_demande`, `type_demande`, `date`, `heure`, `ville`, `code_postal`, `adresse`, `statut_demande`, `id_intervenant_demande`, `valide`, `ref_devis`, `ref_facture`) VALUES
(1, 'Besoin d\'un jardinier', '20', '', '2020-03-10', '18:42:23', 'Flins sur seine', '78410', '37 rue de meulan', '0', 1, 1, '1', '1'),
(2, 'Démarches Administratives  ', '55 €', 'Simple ', '2020-03-05', '02:11:00', 'FLINS SUR SEINE', '78410', '45 rue du chateau', '0', 0, 1, NULL, NULL),
(3, 'Démarches Administratives  ', '55 €', 'Simple ', '2020-03-05', '02:11:00', 'FLINS SUR SEINE', '78410', '45 rue du chateau', '0', 0, 1, NULL, NULL),
(4, 'Démarches Administratives  ', '55 €', 'Simple ', '2020-03-05', '02:11:00', 'FLINS SUR SEINE', '78410', '45 rue du chateau', '0', 0, 1, NULL, NULL),
(5, 'Démarches Administratives  ', '55 €', 'Simple ', '2020-03-05', '02:11:00', 'FLINS SUR SEINE', '78410', '45 rue du chateau', '0', 0, 1, NULL, NULL),
(6, 'Démarches Administratives  ', '55 €', 'Simple ', '2020-03-05', '02:11:00', 'FLINS SUR SEINE', '78410', '45 rue du chateau', '0', 2, 1, NULL, NULL),
(7, 'Visites d\'un proche (10 visites) ', '35 €', 'Récurrent ', '2020-03-25', '15:20:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(8, 'Visites d\'un proche (10 visites) ', '35 €', 'Récurrent ', '2020-03-25', '15:20:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(9, 'Visites d\'un proche (10 visites) ', '35 €', 'Récurrent ', '2020-03-25', '15:20:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(10, 'Visites d\'un proche (10 visites) ', '35 €', 'Récurrent ', '2020-03-25', '15:20:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(11, 'Gardes d\'animaux ', '25 €', 'Simple ', '2020-03-06', '12:15:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(12, 'Gardes d\'animaux ', '25 €', 'Simple ', '2020-03-06', '12:15:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(13, 'Gardes d\'animaux ', '25 €', 'Simple ', '2020-03-06', '12:15:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(14, 'Ménage ', '22 €', 'Simple ', '2020-03-03', '02:15:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(15, 'Ménage ', '22 €', 'Simple ', '2020-03-06', '02:15:00', 'Flins sur Seine', '78410', '48 rue des poulpe', '0', NULL, 1, NULL, NULL),
(16, 'Gardes d\'animaux ', '25 €', 'Simple ', '2020-03-19', '12:15:00', 'Flins sur Seine', '78410', '45 rue du chateau', '0', NULL, 1, NULL, NULL),
(17, 'Gardes d\'animaux ', '25 €', 'Simple ', '2020-03-19', '12:15:00', 'Flins sur Seine', '78410', '45 rue du chateau', '0', NULL, 1, NULL, NULL),
(18, 'Gardes d\'animaux ', '25 €', 'Simple ', '2020-03-19', '12:15:00', 'Flins sur Seine', '78410', '45 rue du chateau', '0', NULL, 1, NULL, NULL),
(19, 'Bricolage | Petits Travaux ', '20 €', 'Simple ', '2020-03-08', '20:15:00', 'Flins sur Seine', '78410', '25 rue des joues', '0', NULL, 1, NULL, NULL),
(20, '', '', '', '2020-03-12', '12:45:00', 'Flins sur seine', '78410', '37 rue de meulan', '0', NULL, 0, NULL, NULL),
(21, 'Gateau au chocolat', '', 'Simple', '2020-03-12', '12:45:00', 'Flins sur seine', '78410', '37 rue de meulan', '0', NULL, 0, NULL, NULL),
(22, 'Gateau au chocolat', '', 'Simple', '2020-03-12', '12:45:00', 'Flins sur seine', '78410', '37 rue de meulan', '0', NULL, 0, NULL, NULL),
(23, 'Gateau au chocolat', '', 'Simple', '2020-03-12', '12:45:00', 'Flins sur seine', '78410', '37 rue de meulan', '0', NULL, 0, NULL, NULL),
(24, 'Gateau au chocolat', '', '', '2020-03-12', '12:45:00', 'Flins sur seine', '78410', '37 rue de meulan', '0', NULL, 0, NULL, NULL),
(25, 'Gateau ', '24', 'Simple', '2020-03-17', '02:12:00', 'Flins', '45785', '45 rue des fleurs', '0', NULL, 1, NULL, NULL),
(26, 'Ordinateur', '50 €', 'Simple', '2145-12-03', '12:15:00', 'Coco', '78412', '45 rue des fleurs', '0', NULL, 0, NULL, NULL),
(27, 'Ordinateur', '50 €', 'Simple', '2145-12-03', '12:15:00', 'Coco', '78412', '45 rue des fleurs', '0', NULL, 0, NULL, NULL),
(28, 'Ordinateur', '50 €', 'Simple', '2145-12-03', '12:15:00', 'Coco', '78412', '45 rue des fleurs', '0', NULL, 0, NULL, NULL),
(29, 'Ordinateur', '50 €', 'Simple', '2145-12-03', '12:15:00', 'Coco', '78412', '45 rue des fleurs', '0', NULL, 0, NULL, NULL),
(30, 'Ordinateur', '50 €', 'Simple', '2145-12-03', '12:15:00', 'Coco', '78412', '45 rue des fleurs', '0', NULL, 1, NULL, NULL),
(31, 'Bouteille de champagne', '150 €', 'Simple', '2020-03-13', '19:00:00', 'Bagnolet', '92700', '6 rue du general leclerc', '0', NULL, 1, NULL, NULL),
(34, 'ccccccc', '12 €', 'Récurrent', '2020-03-20', '12:12:00', 'j;', '427', 'gh,d', '0', NULL, 1, NULL, NULL),
(35, 'Bouteille de champagne ', '150 €', 'Simple ', '2020-03-29', '21:00:00', 'Fecamp', '76400', 'Rue Gustave Couturier', '0', NULL, 1, NULL, NULL),
(36, 'teest', '200 €', 'Récurrent', '2020-03-29', '23:00:00', 'Fecamp', '76400', 'Rue Gustave Couturier', '0', NULL, 1, NULL, NULL),
(37, 'Baby-sitting ', '20 €', 'Simple ', '2020-03-29', '18:00:00', 'tata', '76400', 'Rue Gustave Couturier', '0', NULL, 1, NULL, NULL),
(38, 'Bouteille de champagne ', '150 €', 'Simple ', '2020-04-23', '12:12:00', 'az', '74125', 'az', '0', NULL, 1, NULL, NULL),
(39, 'Bouteille de champagne ', '150 €', 'Simple ', '2020-04-02', '20:00:00', 'Fecamp', '76400', 'Rue Gustave Couturier', '0', NULL, 1, NULL, NULL),
(40, 'test6', '400 €', 'Récurrent', '2020-04-02', '21:00:00', 'Fecamp', '76400', 'Rue Gustave Couturier', '0', NULL, 1, NULL, NULL),
(41, 'test5', '500 €', 'Récurrent', '1996-02-08', '05:06:00', 'Fecamp', '76400', 'Rue Gustave Couturier', '0', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demande_service`
--

DROP TABLE IF EXISTS `demande_service`;
CREATE TABLE IF NOT EXISTS `demande_service` (
  `id_demande_service` int(11) NOT NULL AUTO_INCREMENT,
  `id_demande` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  PRIMARY KEY (`id_demande_service`)
) ;

--
-- Déchargement des données de la table `demande_service`
--

INSERT INTO `demande_service` (`id_demande_service`, `id_demande`, `id_service`) VALUES
(1, 1, 1),
(2, 2, 4),
(3, 3, 1),
(5, 18, 10),
(6, 19, 3),
(7, 24, 11),
(8, 25, 11),
(9, 26, 11),
(10, 30, 11),
(11, 31, 12),
(14, 34, 16),
(15, 35, 12),
(16, 36, 17),
(17, 37, 9),
(18, 38, 12),
(19, 39, 12),
(20, 40, 18),
(21, 41, 19);

-- --------------------------------------------------------

--
-- Structure de la table `info_abonnement`
--

DROP TABLE IF EXISTS `info_abonnement`;
CREATE TABLE IF NOT EXISTS `info_abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description1` text NOT NULL,
  `description2` text NOT NULL,
  `description3` text NOT NULL,
  `nb_heure` int(11) NOT NULL,
  `type_abonnement` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `info_abonnement`
--

INSERT INTO `info_abonnement` (`id`, `description1`, `description2`, `description3`, `nb_heure`, `type_abonnement`) VALUES
(1, 'Bénéficiez d\'un accès privilégié en illimité 5j/7 de 9h à 20h ', 'Demandes illimitées de renseignements ', '12h de services/mois ', 12, 1),
(4, 'Bénéficiez d\'un accès privilégié en illimité 6j/7 de 9h à 20h ', 'Demandes illimitées de renseignements ', '25h de services/mois ', 25, 2),
(7, 'Bénéficiez d\'un accès privilégié en illimité 7j/7 24h/24', 'Demandes illimitées de renseignements ', '50h de services/mois', 50, 3);

-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

DROP TABLE IF EXISTS `intervenant`;
CREATE TABLE IF NOT EXISTS `intervenant` (
  `id` varchar(21) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `telephone` char(10) NOT NULL,
  `codepostal` char(5) NOT NULL,
  `ville` varchar(45) NOT NULL,
  `adresse` varchar(46) NOT NULL,
  `nomQrCode` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `intervenant`
--

INSERT INTO `intervenant` (`id`, `nom`, `prenom`, `mail`, `telephone`, `codepostal`, `ville`, `adresse`, `nomQrCode`, `birthdate`) VALUES
('CCi_11999', 'Ciret', 'Corentin', 'corentin.cour@myges.fr', '0130260723', '95240', 'Coremeilles-en-Parisis', '30 rue germain-pilon', 'CiretCorentinCCi_11999Qr.bmp', '1999-11-17'),
('DBr_11922', 'Briatte', 'Deelon', 'Sananes@esgi.fr', '0154646465', '71000', 'Paris', 'sdqsf', 'BriatteDelonDBr_11922Qr.bmp', '1922-01-17'),
('DCo_11666', 'Colo', 'Detroi', 'ColoDetroi@gmail.com', '0165686978', '71001', 'ici', '30 rue de labas', 'ColoDetroiDCo_11666Qr.bmp', '1666-11-11'),
('GVi_07999', 'Viot', 'Gabriel', 'test@test.fr', '0236598565', '75000', 'truc', 'truc', 'ViotGabrielGVi_07999Qr.bmp', '1999-07-05'),
('MJe_11989', 'Ciret', 'Corentin', 'corentin.cour@myges.fr', '0130260723', '95240', 'Coremeilles-en-Parisis', '30 rue germain-pilon', 'JeanMichelleMJe_11989Qr.bmp', '1999-11-17');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(120) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `date_creation` date NOT NULL,
  `admin` tinyint(4) DEFAULT 0,
  `actif` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id_membre`)
) ;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `nom`, `prenom`, `date_naissance`, `email`, `pseudo`, `mdp`, `code_postal`, `date_creation`, `admin`, `actif`) VALUES
(1, 'Admin', 'Admin', '1996-12-03', 'admin@hotmail.fr', 'Admin', '$2y$10$paJx9Mmh8pLFjc7GGrw8L.aB8zdhpe4pB2KPa11WvtntP9DBojkIq', '', '2020-03-01', 0, 0),
(2, 'test', 'test', '2000-12-01', 'test@hotmail.fr', 'test', '$2y$10$t/IX8exW1tP/WCumUOyhn.y7uPZWRj/5zzLoP1YlGS0C..LqvExmq', '78410', '2020-03-01', 0, 0),
(6, 'lalo', 'lilo', '1996-12-03', 'lolo@hotmail.fr', 'loupe', '$2y$10$p2QNMyM7YP7/l.q.5grMk.zfQ.NaJm1gEW5mBegpfMVk1KgPK8Lxu', '12458', '2020-03-18', 0, 0),
(7, 'VIOT', 'Gab', '1999-07-05', 'gabriel76.viot@gmail.com', 'Admin1', '$2y$10$oHbF2X7N.c0SUrzvQbLpDe1B9bcazCjWY0MdCVYswg4jc4heft./i', '76400', '2020-03-29', 1, 0),
(8, 'Aras', 'Lola', '1996-04-08', 'lola@gmail.com', 'Membre', '$2y$10$1k7WmyxsJ/bDIQCai1muReGR2pX2ZTdlLt88R/eOcIGgKaYXTBAhu', '78542', '2020-04-02', 0, 0),
(9, 'azeeazeaz', 'mezaezaeaz', '1996-08-05', 'azezaeaze@gmail.com', 'test3', '$2y$10$DbcBB/uV8Exqyq9au/fvuOYUeJQTcrQXLHNDxuCqSM.iY8pJ2WwZe', '75652', '2020-04-03', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `membre_demande`
--

DROP TABLE IF EXISTS `membre_demande`;
CREATE TABLE IF NOT EXISTS `membre_demande` (
  `id_membre_demande` int(11) NOT NULL AUTO_INCREMENT,
  `id_demande` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  PRIMARY KEY (`id_membre_demande`),
  KEY `id_membre` (`id_membre`),
  KEY `id_demande` (`id_demande`)
) ;

--
-- Déchargement des données de la table `membre_demande`
--

INSERT INTO `membre_demande` (`id_membre_demande`, `id_demande`, `id_membre`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 2, 1),
(4, 14, 1),
(5, 15, 1),
(6, 16, 1),
(7, 16, 1),
(8, 17, 1),
(9, 18, 1),
(10, 19, 1),
(11, 20, 1),
(12, 21, 1),
(13, 22, 1),
(14, 23, 1),
(15, 24, 1),
(16, 25, 1),
(17, 26, 1),
(18, 27, 1),
(19, 28, 1),
(20, 29, 1),
(21, 30, 1),
(22, 31, 1),
(25, 34, 1),
(26, 35, 7),
(27, 36, 7),
(28, 37, 7),
(29, 38, 7),
(30, 39, 7),
(31, 40, 7),
(32, 41, 7);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int(11) NOT NULL AUTO_INCREMENT,
  `paiement_status` int(11) NOT NULL,
  `paiement_ammount` int(11) NOT NULL,
  `paiement_currency` int(11) NOT NULL,
  `paiement_date` date NOT NULL,
  `email_paiement` varchar(120) NOT NULL,
  PRIMARY KEY (`id_paiement`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id_services` int(11) NOT NULL AUTO_INCREMENT,
  `nom_service` varchar(60) NOT NULL,
  `tarif` int(11) NOT NULL,
  `id_type_service` int(11) NOT NULL,
  `service_valide` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_services`)
) ;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id_services`, `nom_service`, `tarif`, `id_type_service`, `service_valide`) VALUES
(1, 'Jardinier', 20, 1, 1),
(2, 'Ménage', 22, 1, 1),
(3, 'Bricolage | Petits Travaux', 20, 1, 1),
(4, 'Démarches Administratives ', 55, 1, 1),
(5, 'Récupération de paquets', 11, 1, 1),
(6, 'Visites d\'un proche (10 visites)', 35, 2, 1),
(7, 'Ménages (25 commandes minimum)', 17, 2, 1),
(8, 'Gardes d\'enfants', 20, 1, 1),
(9, 'Baby-sitting', 20, 1, 1),
(10, 'Gardes d\'animaux', 25, 1, 1),
(11, 'Ordinateur', 50, 1, 1),
(12, 'Bouteille de champagne', 150, 1, 1),
(19, 'test5', 500, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `type_abonnement`
--

DROP TABLE IF EXISTS `type_abonnement`;
CREATE TABLE IF NOT EXISTS `type_abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(120) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Déchargement des données de la table `type_abonnement`
--

INSERT INTO `type_abonnement` (`id`, `nom`, `prix`) VALUES
(1, 'Abonnement de base', 240000),
(2, 'Abonnement Familial', 360000),
(3, 'Abonnement Prenium', 600000);

-- --------------------------------------------------------

--
-- Structure de la table `type_service`
--

DROP TABLE IF EXISTS `type_service`;
CREATE TABLE IF NOT EXISTS `type_service` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type` varchar(150) NOT NULL,
  PRIMARY KEY (`id_type`)
) ;

--
-- Déchargement des données de la table `type_service`
--

INSERT INTO `type_service` (`id_type`, `nom_type`) VALUES
(1, 'Simple'),
(2, 'Récurrent');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
