-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 31 Mai 2012 à 13:15
-- Version du serveur: 5.5.10
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `mahara`
--

-- --------------------------------------------------------

--
-- Structure de la table `atranscript_vet_tempo`
--

CREATE TABLE IF NOT EXISTS `atranscript_vet_tempo` (
  `artefact` bigint(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `cod_etu` varchar(255) DEFAULT NULL,
  `etbt` varchar(255) NOT NULL,
  `cod_vet` varchar(255) DEFAULT NULL,
  `libelle_vet` varchar(255) DEFAULT NULL,
  `datedelib` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `resultat` varchar(255) NOT NULL DEFAULT 'AJOURNE',
  `annee` varchar(255) DEFAULT NULL,
  `fait` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`artefact`),
  KEY `atravettemp_use_ix` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `atranscript_vet_tempo`
--

INSERT INTO `atranscript_vet_tempo` (`artefact`, `username`, `cod_etu`, `etbt`, `cod_vet`, `libelle_vet`, `datedelib`, `note`, `resultat`, `annee`, `fait`) VALUES
(1, 'lambda2', '12345', 'UNIV-NANTES', 'M1Info', 'Master 1 Informatique', '2012-05-27 13:12:09', '16', 'ADMIS', '2012', 'N');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `atranscript_vet_tempo`
--
ALTER TABLE `atranscript_vet_tempo`
  ADD CONSTRAINT `atravettemp_use_fk` FOREIGN KEY (`username`) REFERENCES `usr` (`username`);
