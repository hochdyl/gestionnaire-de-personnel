-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 14 déc. 2019 à 11:57
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lusac`
--
CREATE DATABASE IF NOT EXISTS `lusac` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lusac`;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_cont` int(11) NOT NULL AUTO_INCREMENT,
  `nom_cont` varchar(30) CHARACTER SET utf8 NOT NULL,
  `mail_cont` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_cont`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

DROP TABLE IF EXISTS `etapes`;
CREATE TABLE IF NOT EXISTS `etapes` (
  `id_etp` int(11) NOT NULL AUTO_INCREMENT,
  `nom_etp` varchar(30) NOT NULL,
  `numero_etp` varchar(3) NOT NULL,
  PRIMARY KEY (`id_etp`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etapes`
--

INSERT INTO `etapes` (`id_etp`, `nom_etp`, `numero_etp`) VALUES
(1, 'Formulaire agent', '1'),
(2, 'Formulaire agent', '1.1'),
(3, 'Convention de stage', '2.1'),
(4, 'Convention doctorale', '2.2'),
(5, 'Contrat de travail', '2.3'),
(6, 'Persopass', '3'),
(7, 'Persopass', '3.1'),
(8, 'Léocarte', '4'),
(9, 'Léocarte', '4.1'),
(10, 'Léocarte', '4.2'),
(11, 'Départ', '5');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id_mem` int(11) NOT NULL AUTO_INCREMENT,
  `nom_mem` varchar(30) NOT NULL,
  `prenom_mem` varchar(30) NOT NULL,
  `mail_mem` varchar(30) NOT NULL,
  `statut_mem` varchar(30) NOT NULL,
  `datenaiss_mem` date DEFAULT NULL,
  `pays_mem` varchar(30) DEFAULT NULL,
  `localisation_mem` varchar(30) DEFAULT NULL,
  `dateent_mem` date DEFAULT NULL,
  `datesrt_mem` date DEFAULT NULL,
  PRIMARY KEY (`id_mem`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id_mem`, `nom_mem`, `prenom_mem`, `mail_mem`, `statut_mem`, `datenaiss_mem`, `pays_mem`, `localisation_mem`, `dateent_mem`, `datesrt_mem`) VALUES
(1, 'Hochet', 'Dylan', 'Waspuma@gmail.com', 'ATER', NULL, NULL, NULL, NULL, NULL),
(2, 'Hochet', 'Dylan', 'Waspuma@gmail.com', 'ATER', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

DROP TABLE IF EXISTS `ressources`;
CREATE TABLE IF NOT EXISTS `ressources` (
  `id_rsc` int(11) NOT NULL AUTO_INCREMENT,
  `nom_rsc` varchar(30) NOT NULL,
  PRIMARY KEY (`id_rsc`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ressources`
--

INSERT INTO `ressources` (`id_rsc`, `nom_rsc`) VALUES
(1, 'Image'),
(2, 'Document');

-- --------------------------------------------------------

--
-- Structure de la table `situation`
--

DROP TABLE IF EXISTS `situation`;
CREATE TABLE IF NOT EXISTS `situation` (
  `mem_sit` int(11) NOT NULL,
  `etp_sit` int(11) NOT NULL,
  `datedeb_sit` date DEFAULT NULL,
  `datefin_sit` date DEFAULT NULL,
  KEY `fk_mem_sit` (`mem_sit`),
  KEY `fk_etp_sit` (`etp_sit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `situation`
--

INSERT INTO `situation` (`mem_sit`, `etp_sit`, `datedeb_sit`, `datefin_sit`) VALUES
(1, 1, NULL, '2019-12-14'),
(1, 2, NULL, NULL),
(1, 5, NULL, NULL),
(1, 6, NULL, NULL),
(1, 7, NULL, NULL),
(1, 8, NULL, NULL),
(1, 9, NULL, NULL),
(1, 10, NULL, NULL),
(1, 11, NULL, NULL),
(2, 1, NULL, NULL),
(2, 2, NULL, NULL),
(2, 5, NULL, NULL),
(2, 6, NULL, NULL),
(2, 7, NULL, NULL),
(2, 8, NULL, NULL),
(2, 9, NULL, NULL),
(2, 10, NULL, NULL),
(2, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `upload`
--

DROP TABLE IF EXISTS `upload`;
CREATE TABLE IF NOT EXISTS `upload` (
  `mem_upl` int(11) NOT NULL,
  `rsc_upl` int(11) NOT NULL,
  `nom_upl` varchar(30) NOT NULL,
  `date_upl` date NOT NULL,
  `poid_upl` varchar(30) NOT NULL,
  KEY `fk_mem_upl` (`mem_upl`),
  KEY `fk_rsc_upl` (`rsc_upl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `upload`
--

INSERT INTO `upload` (`mem_upl`, `rsc_upl`, `nom_upl`, `date_upl`, `poid_upl`) VALUES
(1, 1, 'avatar', '2019-12-14', '127.96 KB'),
(1, 1, 'ressources/1/avatar.jpg', '2019-12-14', '79.70 KB');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `situation`
--
ALTER TABLE `situation`
  ADD CONSTRAINT `fk_etp_sit` FOREIGN KEY (`etp_sit`) REFERENCES `etapes` (`id_etp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mem_sit` FOREIGN KEY (`mem_sit`) REFERENCES `membres` (`id_mem`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `fk_mem_upl` FOREIGN KEY (`mem_upl`) REFERENCES `membres` (`id_mem`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rsc_upl` FOREIGN KEY (`rsc_upl`) REFERENCES `ressources` (`id_rsc`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
