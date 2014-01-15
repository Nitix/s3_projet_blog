-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 14 Janvier 2014 à 20:03
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `toyblog`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE IF NOT EXISTS `billets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) DEFAULT NULL,
  `body` text,
  `cat_id` int(11) DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `billets`
--

INSERT INTO `billets` (`id`, `titre`, `body`, `cat_id`, `user_id`, `date`) VALUES
(1, 'go sluc, go', 'tout est dans le titre', 1, 1, '2006-11-30 11:22:27'),
(2, 'Concert : nolwenn live', 'c''est d''la balle, Ca vaut bien Mick Jagger et Iggy Stooges reunis.\r\nAngus Young doit l''ecouter en boucle...', 3, 1, '2006-11-30 11:29:50'),
(3, 'Trolol', 'Je suis la desc torlol', 3, 1, '2014-01-07 23:37:11'),
(4, 'Trolol', 'Trololol', 4, 1, '2014-01-07 23:48:43'),
(5, 'Jambon', 'J''aime le jambon', 4, 1, '2014-01-08 08:52:08'),
(6, 'BEacon power', 'Hummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\n', 1, 1, '2014-01-10 12:17:55'),
(7, 'BEacon power 2', 'Hummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\nHummmmmmmmmmmmmmmmmmm\r\n', 73, 1, '2014-01-10 12:18:05');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `titre`, `description`) VALUES
(1, 'sport', 'tout sur le sport en general'),
(2, 'cinema', 'tout sur le cinema'),
(3, 'music', 'toute la music que j''aaiiiimeuh, elle vient de la, elle vient du bluuuuuuzee'),
(4, 'tele', 'tout sur les programmes tele, les emissions, les series, et vos stars preferes'),
(73, 'Jambon', 'Je suis trop un jambon');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `speudo` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(68) NOT NULL,
  `level` int(11) NOT NULL,
  `salt` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `speudo` (`speudo`),
  UNIQUE KEY `email` (`email`),

  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `speudo`, `password`, `level`, `salt`) VALUES
(1, 'Default', '$2y$10$4.neYS9whUtKYtbnVO1bWeyvF51.DfOgvEwHnAm5JUwYqc8pIHPrW', 0, 'A8tHewKpxvUl0VIq'),
(3, 'test', '$2y$10$YDRcx8W8KslLCCIOKd/aNe3YWqeIknAk30fR4Wze6zRUil7Cm2M.O', 0, 'Bhcks9HBtClpb8Qi'),
(4, 'mom', '$2y$10$HJyoz1KfiJQ/hdOH.Bg0YeApORx8xxRYIyd2d2SnRkwv5j40crutW', 0, 'pE6kkux6oMNxBfEv');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
