-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 02 mai 2020 à 20:29
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `nb_point` int(11) NOT NULL,
  `id_membre` int(11) DEFAULT NULL,
  `debut_abonnement` date NOT NULL,
  `fin_abonnement` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_membre_abonnement` (`id_membre`),
  KEY `type_abonnement_test` (`type_abonnement`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `abonnement_test`
--

INSERT INTO `abonnement_test` (`id`, `type_abonnement`, `date_paiement`, `nb_point`, `id_membre`, `debut_abonnement`, `fin_abonnement`) VALUES
(5, 6, '2020-04-25', 200, 7, '2020-04-25', '2020-05-25');

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

DROP TABLE IF EXISTS `demandes`;
CREATE TABLE IF NOT EXISTS `demandes` (
  `id_demandes` int(11) NOT NULL AUTO_INCREMENT,
  `id_membre` int(11) NOT NULL,
  `nom_demande` varchar(200) NOT NULL,
  `nb_heure` int(11) NOT NULL,
  `taux_horaire` int(11) DEFAULT NULL,
  `point_unite` int(11) DEFAULT NULL,
  `prix_demande` varchar(50) DEFAULT NULL,
  `point_demande` int(11) DEFAULT NULL,
  `type_demande` varchar(50) NOT NULL,
  `date_demande` date NOT NULL,
  `heure` time NOT NULL,
  `ville` varchar(255) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `statut_demande` char(1) NOT NULL DEFAULT '0',
  `id_intervenant_demande` varchar(20) DEFAULT NULL,
  `ref_devis` varchar(45) DEFAULT NULL,
  `ref_facture` varchar(45) DEFAULT NULL,
  `statut_devis` int(11) DEFAULT 0,
  `refuser` int(11) NOT NULL DEFAULT 0,
  `id_service_membre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_demandes`),
  KEY `id_membre1` (`id_membre`),
  KEY `id_intervenant_1` (`id_intervenant_demande`),
  KEY `id_service_membre` (`id_service_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`id_demandes`, `id_membre`, `nom_demande`, `nb_heure`, `taux_horaire`, `point_unite`, `prix_demande`, `point_demande`, `type_demande`, `date_demande`, `heure`, `ville`, `code_postal`, `adresse`, `statut_demande`, `id_intervenant_demande`, `ref_devis`, `ref_facture`, `statut_devis`, `refuser`, `id_service_membre`) VALUES
(1, 7, 'test1', 15, NULL, 10, NULL, 150, 'perso', '2020-05-14', '12:12:00', 'pzp', '45154', '1545', '0', NULL, 'Devis1-01-05-2020.pdf', NULL, 0, 0, NULL),
(2, 7, 'Cadeau', 1, NULL, 5, NULL, 5, 'perso', '2020-05-14', '12:12:00', 'pzp', '45154', '1545', '0', NULL, 'Devis1-01-05-2020.pdf', NULL, 0, 0, NULL),
(3, 7, 'Visites d\'un proche (10 visites) ', 1, NULL, 35, NULL, 35, 'simple', '2020-05-23', '11:11:00', 'Paris', '76400', '37 rue des voucles', '0', NULL, 'Devis3-01-05-2020.pdf', 'Facture3-01-05-2020.pdf', 0, 0, 6),
(4, 7, 'test2', 1, NULL, 200, NULL, 200, 'perso', '2020-05-21', '12:12:00', 'p', '4512', '45', '0', NULL, 'Devis4-01-05-2020.pdf', NULL, 0, 0, NULL),
(5, 7, 'Papier', 1, NULL, 2, NULL, 2, 'perso', '2020-05-21', '12:12:00', 'p', '4512', '45', '0', NULL, 'Devis4-01-05-2020.pdf', NULL, 0, 0, NULL),
(6, 7, 'test3', 1, NULL, 12, NULL, 12, 'perso', '2020-05-22', '12:12:00', 'pa', '45', '45', '0', NULL, '6-01-05-2020.pdf', NULL, 0, 0, NULL),
(7, 7, 'p', 1, NULL, 5, NULL, 5, 'perso', '2020-05-22', '12:12:00', 'pa', '45', '45', '0', NULL, '6-01-05-2020.pdf', NULL, 0, 0, NULL),
(8, 7, 'test5', 5, NULL, 1, NULL, 5, 'perso', '2020-05-05', '05:05:00', '5', '5', '5', '0', NULL, '8-01-05-2020.pdf', NULL, 0, 0, NULL),
(9, 7, 'a', 4, NULL, 4, NULL, 16, 'perso', '2020-05-05', '05:05:00', '5', '5', '5', '0', NULL, 'Devis8-01-05-2020.pdf', NULL, 0, 0, NULL),
(10, 7, '8', 8, NULL, 8, NULL, 64, 'perso', '2020-05-05', '05:05:00', '5', '5', '5', '0', NULL, 'Devis8-01-05-2020.pdf', NULL, 0, 0, NULL),
(11, 7, 'y', 5, NULL, 5, NULL, 25, 'perso', '2020-05-05', '05:05:00', '5', '5', '5', '0', NULL, 'Devis8-01-05-2020.pdf', NULL, 0, 0, NULL),
(12, 8, 'test prix', 2, 3, NULL, '5', NULL, 'perso', '2020-02-05', '12:01:00', 'p', 'p', 'p', '0', 'DBr_11922', 'Devis12-01-05-2020.pdf', 'Facture12-01-05-2020.pdf', 1, 0, NULL),
(16, 8, 'p', 2, 2, NULL, '4', NULL, 'perso', '2020-02-05', '12:01:00', 'p', 'p', 'p', '0', 'DBr_11922', 'Devis12-01-05-2020.pdf', 'Facture12-01-05-2020.pdf', 1, 0, NULL),
(17, 7, 'Récupération de paquets ', 1, NULL, 11, NULL, 11, 'simple', '2020-05-27', '11:11:00', 'Paris', '76400', '37 rue des voucles', '0', NULL, 'Devis17-01-05-2020.pdf', 'Facture17-01-05-2020.pdf', 0, 0, 5),
(18, 7, 'Ordinateur ', 2, NULL, 50, NULL, 100, 'simple', '2020-02-19', '22:02:00', 'Paris', '76400', '37 rue des voucles', '0', NULL, 'Devis18-01-05-2020.pdf', 'Facture18-01-05-2020.pdf', 0, 0, 11),
(19, 7, 'Ordinateur ', 5, NULL, 50, NULL, 250, 'simple', '2020-05-08', '04:44:00', 'Paris', '76400', '37 rue des voucles', '0', NULL, 'Devis19-01-05-2020.pdf', 'Facture19-01-05-2020.pdf', 0, 0, 11),
(20, 7, 'Ordinateur ', 5, NULL, 50, NULL, 250, 'simple', '2020-05-08', '04:44:00', 'Paris', '76400', '37 rue des voucles', '0', NULL, 'Devis19-01-05-2020.pdf', 'Facture19-01-05-2020.pdf', 0, 0, 11),
(21, 7, 'Visites d\'un proche (10 visites) ', 2, NULL, 35, NULL, 70, 'simple', '2020-05-01', '04:45:00', 'Paris', '76400', '37 rue des voucles', '0', NULL, 'Devis21-01-05-2020.pdf', 'Facture21-01-05-2020.pdf', 0, 0, 6),
(22, 7, 'Ordinateur ', 10, NULL, 50, NULL, 500, 'simple', '2020-05-09', '12:12:00', 'Paris', '76400', '37 rue des voucles', '0', 'DBr_11922', 'Devis22-01-05-2020.pdf', 'Facture22-01-05-2020.pdf', 0, 0, 11),
(25, 8, 'Ordinateur ', 10, 50, NULL, '500', NULL, 'simple', '2020-05-14', '11:11:00', '15', '1547', '15', '0', NULL, 'Devis23-01-05-2020.pdf', 'Facture23-01-05-2020.pdf', 0, 0, 11),
(26, 8, 'Récupération de paquets ', 5, 11, NULL, '55', NULL, 'simple', '2020-05-10', '12:12:00', '15', '1547', '15', '0', 'DBr_11922', 'Devis26-01-05-2020.pdf', 'Facture26-01-05-2020.pdf', 0, 0, 5),
(27, 7, 'Test valide', 1, NULL, 100, NULL, 100, 'perso', '2020-05-06', '11:11:00', 'jlj', '1424', 'jlijl', '0', NULL, 'Devis27-01-05-2020.pdf', 'Facture27-01-05-2020.pdf', 1, 0, NULL),
(30, 7, 'Blou', 2, NULL, 5, NULL, 10, 'perso', '2020-05-06', '11:11:00', 'jlj', '1424', 'jlijl', '0', NULL, 'Devis27-01-05-2020.pdf', 'Facture27-01-05-2020.pdf', 1, 0, NULL),
(31, 8, 'Test valide prix', 2, 110, NULL, '220', NULL, 'perso', '2020-05-12', '12:12:00', 'pa', '123', '123', '0', NULL, 'Devis31-02-05-2020.pdf', 'Facture31-02-05-2020.pdf', 1, 0, NULL),
(32, 8, 'Truc', 1, 5, NULL, '5', NULL, 'perso', '2020-05-12', '12:12:00', 'pa', '123', '123', '0', NULL, 'Devis31-02-05-2020.pdf', 'Facture31-02-05-2020.pdf', 1, 0, NULL),
(33, 7, 'GeneDevis', 12, NULL, 8, NULL, 100, 'perso', '2020-05-14', '12:12:00', 'pa', '45123', 'pa', '0', NULL, NULL, NULL, 0, 1, NULL),
(34, 7, 'ez', 1, NULL, 42, NULL, 42, 'perso', '2020-05-14', '04:44:00', 'th', 'th', 'th', '0', NULL, 'Devis34-02-05-2020.pdf', NULL, 0, 0, NULL),
(35, 7, 'salut', 1, NULL, 1, NULL, 1, 'perso', '2020-05-14', '04:44:00', 'th', 'th', 'th', '0', NULL, 'Devis34-02-05-2020.pdf', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `info_abonnement`
--

DROP TABLE IF EXISTS `info_abonnement`;
CREATE TABLE IF NOT EXISTS `info_abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description1` text DEFAULT NULL,
  `description2` text DEFAULT NULL,
  `description3` text DEFAULT NULL,
  `nb_point` int(11) NOT NULL,
  `type_abonnement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_abonnement` (`type_abonnement`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `info_abonnement`
--

INSERT INTO `info_abonnement` (`id`, `description1`, `description2`, `description3`, `nb_point`, `type_abonnement`) VALUES
(1, 'Bénéficiez d\'un accès privilégié en illimité 5j/7 de 9h à 20h ', 'Demandes illimitées de renseignements ', '2400 points', 2400, 1),
(4, 'Bénéficiez d\'un accès privilégié en illimité 6j/7 de 9h à 20h ', 'Demandes illimitées de renseignements ', '3600 points', 3600, 2),
(7, 'Bénéficiez d\'un accès privilégié en illimité 7j/7 24h/24', 'Demandes illimitées de renseignements ', '6000 points', 6000, 3),
(10, 'Garder les même avantages que votre abonnement', 'Demandes illimitées de renseignements ', 'Un ajout de 100 points sera effectué sur votre compte', 100, 6);

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
  `valide` int(11) NOT NULL DEFAULT 0,
  `mdp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `intervenant`
--

INSERT INTO `intervenant` (`id`, `nom`, `prenom`, `mail`, `telephone`, `codepostal`, `ville`, `adresse`, `nomQrCode`, `birthdate`, `valide`, `mdp`) VALUES
('CCi_11999', 'Ciret', 'Corentin', 'corentin.cour@myges.fr', '0130260723', '95240', 'Coremeilles-en-Parisis', '30 rue germain-pilon', 'CiretCorentinCCi_11999Qr.bmp', '1999-11-17', 0, NULL),
('DBr_11922', 'Briatte', 'Delon', 'Sananes@esgi.fr', '0154646465', '71000', 'Paris', 'sdqsf', 'BriatteDelonDBr_11922Qr.bmp', '1922-01-17', 0, NULL),
('DCo_11666', 'Colo', 'Detroimp', 'ColoDetroi@gmail.com', '0165686978', '71001', 'ici', '30 rue de labas', 'ColoDetroiDCo_11666Qr.bmp', '1666-11-11', 0, NULL),
('GVi_07999', 'Viot', 'Gabriel', 'test@test.fr', '0236598565', '75000', 'truc', 'truc', 'ViotGabrielGVi_07999Qr.bmp', '1999-07-05', 0, NULL),
('MJe_11989', 'Ciret', 'Corentin', 'corentin.cour@myges.fr', '0130260723', '95240', 'Coremeilles-en-Parisis', '30 rue germain-pilon', 'JeanMichelleMJe_11989Qr.bmp', '1999-11-17', 0, NULL);

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
  `adresse` varchar(200) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `date_creation` date NOT NULL,
  `admin` tinyint(4) DEFAULT 0,
  `actif` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `nom`, `prenom`, `date_naissance`, `email`, `pseudo`, `mdp`, `adresse`, `ville`, `code_postal`, `date_creation`, `admin`, `actif`) VALUES
(1, 'Admin', 'Admin', '1996-12-03', 'admin@hotmail.fr', 'Admin', '$2y$10$paJx9Mmh8pLFjc7GGrw8L.aB8zdhpe4pB2KPa11WvtntP9DBojkIq', '', '', '', '2020-03-01', 0, 0),
(2, 'test', 'test', '2000-12-01', 'test@hotmail.fr', 'test', '$2y$10$t/IX8exW1tP/WCumUOyhn.y7uPZWRj/5zzLoP1YlGS0C..LqvExmq', '', '', '78410', '2020-03-01', 0, 0),
(6, 'lalo', 'lilo', '1996-12-03', 'lolo@hotmail.fr', 'loupe', '$2y$10$p2QNMyM7YP7/l.q.5grMk.zfQ.NaJm1gEW5mBegpfMVk1KgPK8Lxu', '', '', '12458', '2020-03-18', 0, 0),
(7, 'VIOT', 'Gab', '1999-07-05', 'gabriel76.viot@gmail.com', 'Admin1', '$2y$10$oHbF2X7N.c0SUrzvQbLpDe1B9bcazCjWY0MdCVYswg4jc4heft./i', '37 rue des voucles', 'Paris', '76400', '2020-03-29', 1, 0),
(8, 'ccccc', 'ccccc', '1996-12-03', 'cc@hotmail.fr', 'ccccc', '$2y$10$OfAV4bIXt2VymmixVyouSOoEHbP/BIEEUJWVdLXj/10puMxxpYyX2', '15', '15', '1547', '2020-04-25', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(150) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `role_intervenant`
--

DROP TABLE IF EXISTS `role_intervenant`;
CREATE TABLE IF NOT EXISTS `role_intervenant` (
  `id_role_intervenant` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_intervenant` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role_intervenant`),
  KEY `id_role` (`id_role`),
  KEY `id_intervenant` (`id_intervenant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id_services` int(11) NOT NULL AUTO_INCREMENT,
  `nom_service` varchar(60) NOT NULL,
  `tarif` int(11) NOT NULL,
  `service_valide` tinyint(1) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_services`),
  KEY `id_role_service` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id_services`, `nom_service`, `tarif`, `service_valide`, `id_role`) VALUES
(1, 'Jardinier', 20, 1, NULL),
(2, 'Ménage', 22, 1, NULL),
(3, 'Bricolage | Petits Travaux', 20, 1, NULL),
(4, 'Démarches Administratives ', 55, 1, NULL),
(5, 'Récupération de paquets', 11, 1, NULL),
(6, 'Visites d\'un proche (10 visites)', 35, 1, NULL),
(7, 'Ménages (25 commandes minimum)', 17, 1, NULL),
(8, 'Gardes d\'enfants', 20, 1, NULL),
(9, 'Baby-sitting', 20, 1, NULL),
(10, 'Gardes d\'animaux', 25, 1, NULL),
(11, 'Ordinateur', 50, 1, NULL),
(12, 'Bouteille de champagne', 150, 1, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_abonnement`
--

INSERT INTO `type_abonnement` (`id`, `nom`, `prix`) VALUES
(1, 'Abonnement de base', 240000),
(2, 'Abonnement Familial', 360000),
(3, 'Abonnement Prenium', 600000),
(6, 'Pack n°1', 20000);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement_test`
--
ALTER TABLE `abonnement_test`
  ADD CONSTRAINT `id_membre_abonnement` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `type_abonnement_test` FOREIGN KEY (`type_abonnement`) REFERENCES `type_abonnement` (`id`);

--
-- Contraintes pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `id_intervenant_1` FOREIGN KEY (`id_intervenant_demande`) REFERENCES `intervenant` (`id`),
  ADD CONSTRAINT `id_membre1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `id_service_membre` FOREIGN KEY (`id_service_membre`) REFERENCES `services` (`id_services`);

--
-- Contraintes pour la table `info_abonnement`
--
ALTER TABLE `info_abonnement`
  ADD CONSTRAINT `id_type_abonnement` FOREIGN KEY (`type_abonnement`) REFERENCES `type_abonnement` (`id`);

--
-- Contraintes pour la table `role_intervenant`
--
ALTER TABLE `role_intervenant`
  ADD CONSTRAINT `id_intervenant` FOREIGN KEY (`id_intervenant`) REFERENCES `intervenant` (`id`),
  ADD CONSTRAINT `id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `id_role_service` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
