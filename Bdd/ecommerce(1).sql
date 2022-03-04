-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 déc. 2021 à 11:55
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id_address` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `address2` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id_cart` int(11) NOT NULL AUTO_INCREMENT,
  `id_command_line` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_cart`),
  KEY `fk-cart-commandline` (`id_command_line`),
  KEY `fk-cart-user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

DROP TABLE IF EXISTS `command`;
CREATE TABLE IF NOT EXISTS `command` (
  `id_command` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `command_date` date NOT NULL,
  PRIMARY KEY (`id_command`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commandline`
--

DROP TABLE IF EXISTS `commandline`;
CREATE TABLE IF NOT EXISTS `commandline` (
  `id_command_line` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_command_line`),
  KEY `fk-commandline-product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id_faq` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id_faq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `category` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `weight` varchar(4) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `productphoto`
--

DROP TABLE IF EXISTS `productphoto`;
CREATE TABLE IF NOT EXISTS `productphoto` (
  `id_product` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL,
  KEY `fk-productphoto-photo` (`id_photo`),
  KEY `fk-productphoto-product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `id_address` int(11) NOT NULL,
  `pseudo` varchar(250) NOT NULL,
  `age` int(11) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `oui` (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `userphoto`
--

DROP TABLE IF EXISTS `userphoto`;
CREATE TABLE IF NOT EXISTS `userphoto` (
  `id_user_photo` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL,
  PRIMARY KEY (`id_user_photo`),
  KEY `fk-userphoto-user` (`id_user`),
  KEY `fk-userphoto-photo` (`id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk-cart-commandline` FOREIGN KEY (`id_command_line`) REFERENCES `commandline` (`id_command_line`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-cart-user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `command_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commandline`
--
ALTER TABLE `commandline`
  ADD CONSTRAINT `fk-commandline-product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `productphoto`
--
ALTER TABLE `productphoto`
  ADD CONSTRAINT `fk-productphoto-photo` FOREIGN KEY (`id_photo`) REFERENCES `photo` (`id_photo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-productphoto-product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `oui` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`);

--
-- Contraintes pour la table `userphoto`
--
ALTER TABLE `userphoto`
  ADD CONSTRAINT `fk-userphoto-photo` FOREIGN KEY (`id_photo`) REFERENCES `photo` (`id_photo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-userphoto-user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
