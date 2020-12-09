-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 08 déc. 2020 à 14:04
-- Version du serveur :  8.0.22-0ubuntu0.20.04.3
-- Version de PHP : 7.3.22-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbascci_sygesca3`
--

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `publie_par` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `modifie_par` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `publie_le` datetime DEFAULT NULL,
  `modifie_le` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `nom`, `code`, `slug`, `publie_par`, `modifie_par`, `publie_le`, `modifie_le`) VALUES
(1, 'EQUIPE NATIONALE', '01', '01-equipe-nationale', 'admin', 'admin', '2017-06-01 15:41:32', '2017-06-01 15:41:32'),
(2, 'COMITE NATIONAL DE DIRECTION', '02', '02-comite-national-d', 'admin', 'admin', '2017-06-01 15:41:50', '2019-12-28 09:35:17'),
(3, 'CONSEIL NATIONAL DES AÎNES', '03', '03-conseil-national-', 'admin', 'admin', '2017-06-01 15:42:14', '2020-02-07 13:23:50'),
(4, 'ABENGOUROU', '04', '04-abengourou', 'admin', 'admin', '2017-06-01 15:42:35', '2017-06-01 15:42:35'),
(5, 'ABIDJAN', '05', '05-abidjan', 'admin', 'admin', '2017-06-01 15:43:01', '2017-06-01 15:43:01'),
(6, 'AGBOVILLE', '06', '06-agboville', 'admin', 'admin', '2017-06-01 15:43:19', '2017-06-01 15:43:19'),
(7, 'BONDOUKOU', '07', '07-bondoukou', 'admin', 'admin', '2017-06-01 15:43:41', '2017-06-01 15:43:41'),
(8, 'BOUAKE', '08', '08-bouake', 'admin', 'admin', '2017-06-01 15:43:54', '2017-06-01 15:43:54'),
(9, 'DALOA', '09', '09-daloa', 'admin', 'admin', '2017-06-01 15:45:05', '2017-06-01 15:45:05'),
(10, 'GAGNOA', '10', '10-gagnoa', 'admin', 'admin', '2017-06-01 15:45:26', '2017-06-01 15:45:26'),
(11, 'GRAND BASSAM', '11', '11-grand-bassam', 'admin', 'admin', '2017-06-01 15:45:46', '2017-06-01 15:45:46'),
(12, 'KATIOLA', '12', '12-katiola', 'admin', 'admin', '2017-06-01 15:46:02', '2017-06-01 15:46:02'),
(13, 'KORHOGO', '13', '13-korhogo', 'admin', 'admin', '2017-06-01 15:46:14', '2017-06-01 15:46:14'),
(14, 'MAN', '14', '14-man', 'admin', 'admin', '2017-06-01 15:46:28', '2017-06-01 15:46:28'),
(15, 'ODIENNE', '15', '15-odienne', 'admin', 'admin', '2017-06-01 15:46:38', '2017-06-01 15:46:38'),
(16, 'SAN PEDRO', '16', '16-san-pedro', 'admin', 'admin', '2017-06-01 15:46:50', '2017-06-01 15:46:50'),
(17, 'YAMOUSSOUKRO', '17', '17-yamoussoukro', 'admin', 'admin', '2017-06-01 15:47:15', '2017-06-01 15:47:15'),
(18, 'YOPOUGON', '18', '18-yopougon', 'admin', 'admin', '2017-06-01 15:47:28', '2017-06-01 15:47:28'),
(19, 'DIASPORA', '19', '19-diaspora', 'admin', 'admin', '2019-05-10 15:58:05', '2019-05-10 15:58:05'),
(20, 'EQUIPE TECHNIQUE', '20', '20-equipe-technique', 'admin', 'admin', '2019-10-28 15:56:10', '2019-10-28 15:56:10'),
(21, 'COMMISSARIAT AUX COMPTES', '21', '21-commissariat-aux-', 'admin', 'admin', '2019-12-06 14:35:04', '2019-12-06 14:35:04'),
(22, 'SCOUT DE CÔTE D\'IVOIRE (ASCCI)', '22', '22-scout-de-cote-div', 'admin', 'admin', '2019-12-06 19:01:11', '2019-12-10 15:36:54');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
