-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `frigo` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `frigo`;

DROP TABLE IF EXISTS `aliment`;
CREATE TABLE `aliment` (
  `idAliment` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idCategorie` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`idAliment`),
  UNIQUE KEY `nom` (`nom`),
  KEY `idCategorie` (`idCategorie`),
  CONSTRAINT `aliment_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `aliment` (`idAliment`, `nom`, `idCategorie`) VALUES
(6,	'tarte',	5),
(17,	'dinde',	4),
(18,	'carottes rapées',	6),
(19,	'oeuf',	6),
(20,	'Poulet',	4);

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `idCategorie` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idCategorie`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categorie` (`idCategorie`, `nom`) VALUES
(5,	'dessert'),
(6,	'entrée'),
(4,	'plat');

DROP TABLE IF EXISTS `conteneur`;
CREATE TABLE `conteneur` (
  `idConteneur` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('frigo') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idConteneur`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `conteneur` (`idConteneur`, `type`) VALUES
(1,	'frigo');

DROP TABLE IF EXISTS `contient`;
CREATE TABLE `contient` (
  `idContient` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idConteneur` tinyint(3) unsigned NOT NULL,
  `idAliment` tinyint(3) unsigned NOT NULL,
  `dateFin` date NOT NULL,
  `consomme` bit(1) NOT NULL,
  PRIMARY KEY (`idContient`),
  KEY `idConteneur` (`idConteneur`),
  KEY `idAliment` (`idAliment`),
  CONSTRAINT `contient_ibfk_1` FOREIGN KEY (`idConteneur`) REFERENCES `conteneur` (`idConteneur`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contient_ibfk_2` FOREIGN KEY (`idAliment`) REFERENCES `aliment` (`idAliment`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `contient` (`idContient`, `idConteneur`, `idAliment`, `dateFin`, `consomme`) VALUES
(2,	1,	6,	'2016-01-01',	CONV('1', 2, 10) + 0),
(3,	1,	17,	'2016-01-26',	CONV('0', 2, 10) + 0),
(4,	1,	18,	'2015-12-01',	CONV('1', 2, 10) + 0),
(5,	1,	17,	'2015-12-25',	CONV('1', 2, 10) + 0),
(6,	1,	18,	'2016-01-07',	CONV('1', 2, 10) + 0),
(7,	1,	6,	'2016-01-02',	CONV('0', 2, 10) + 0),
(8,	1,	19,	'2016-01-10',	CONV('1', 2, 10) + 0),
(9,	1,	20,	'2016-01-25',	CONV('0', 2, 10) + 0),
(10,	1,	18,	'2016-01-01',	CONV('1', 2, 10) + 0),
(11,	1,	6,	'2017-01-01',	CONV('0', 2, 10) + 0),
(12,	1,	19,	'2020-07-05',	CONV('1', 2, 10) + 0);

-- 2016-09-30 11:50:16
