-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 02 Mai 2018 à 10:19
-- Version du serveur :  5.7.22-0ubuntu0.16.04.1
-- Version de PHP :  7.0.29-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `checkpoint2`
--

-- --------------------------------------------------------

--
-- Structure de la table `beast`
--

CREATE TABLE `beast` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT 'http://via.placeholder.com/350x300',
  `size` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `id_planet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `beast`
--

INSERT INTO `beast` (`id`, `name`, `picture`, `size`, `area`, `id_movie`, `id_planet`) VALUES
(1, 'Orray', 'https://lumiere-a.akamaihd.net/v1/images/orray_05827d60.jpeg?region=374%2C0%2C1186%2C667&width=768', 2, 'desert', 2, 6),
(2, 'Massiff', 'http://via.placeholder.com/350x300', 1, 'Desert', 2, 6),
(3, 'Wampa', 'https://lumiere-a.akamaihd.net/v1/images/image_c3ce73b0.jpeg?region=0%2C0%2C1920%2C1080&width=768', 3, 'Cave', 5, 7),
(4, 'Tauntaun', 'https://lumiere-a.akamaihd.net/v1/images/databank_tauntaun_01_169_b7307446.jpeg?region=0%2C0%2C1560%2C878&width=768', 2, 'Ice desert', 5, 7),
(5, 'Happabore', 'https://lumiere-a.akamaihd.net/v1/images/happabore_ea2f08f6.jpeg?region=349%2C0%2C1132%2C636&width=768', 4, 'Desert', 7, 8),
(6, 'Luggabeast', 'https://lumiere-a.akamaihd.net/v1/images/luggabeast_3439af0a.jpeg?region=0%2C160%2C1560%2C880&width=768', 2, 'Desert', 7, 8),
(7, 'Wookie', 'https://lumiere-a.akamaihd.net/v1/images/databank_wookiee_01_169_e2d0ebd0.jpeg?region=0%2C0%2C1560%2C878&width=768', 2, 'Forest', 3, 9),
(8, 'Mandalorien', 'https://lumiere-a.akamaihd.net/v1/images/databank_mandaloriansupercommando_01_169_8b546b06.jpeg?region=0%2C0%2C1560%2C878&width=768', 2, 'City', 2, 3),
(9, 'Kaady', 'https://lumiere-a.akamaihd.net/v1/images/ep1_ia_72886_13afb761.jpeg?region=26%2C327%2C1268%2C713&width=768', 2, 'plain', 1, 10),
(10, 'Sando', 'https://lumiere-a.akamaihd.net/v1/images/databank_sandoaquamonster_01_156_f74ea1d7.jpeg?region=0%2C0%2C1560%2C878&width=768', 200, 'Water', 1, 10),
(11, 'Bantha', 'https://lumiere-a.akamaihd.net/v1/images/bantha-main-image_b3ab933d.jpeg?region=33%2C41%2C1381%2C776&width=768', 3, 'Desert', 4, 12),
(12, 'Dewback', 'https://lumiere-a.akamaihd.net/v1/images/databank_dewback_01_169_bc886996.jpeg?region=0%2C0%2C1560%2C878&width=768', 2, 'Desert', 4, 12),
(13, 'Varactyl', 'https://lumiere-a.akamaihd.net/v1/images/databank_varactyl_01_169_1af5a65d.jpeg?region=0%2C0%2C1560%2C878&width=768', 4, 'Cave', 3, 13),
(14, 'Ewok', 'https://lumiere-a.akamaihd.net/v1/images/databank_ewok_01_169_747db03a.jpeg?region=0%2C0%2C1560%2C878&width=768', 1, 'forest', 6, 14),
(15, 'Porg', 'https://lumiere-a.akamaihd.net/v1/images/porg-main_16933d3b.jpeg?region=0%2C0%2C1560%2C878&width=768', 1, 'Cliff', 8, 15);

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `movie`
--

INSERT INTO `movie` (`id`, `title`) VALUES
(1, 'Episode I : the Phantom Menace'),
(2, 'Episode II : Attack of the Clones'),
(3, 'Episode III : Revenge of the Sith'),
(4, 'Episode IV : A New Hope'),
(5, 'Episode V : The Empire Strikes Back'),
(6, 'Episode VI : Return of the Jedi'),
(7, 'Episode VII : The Force Awakens'),
(8, 'Episode VIII : The Last Jedi');

-- --------------------------------------------------------

--
-- Structure de la table `planet`
--

CREATE TABLE `planet` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `planet`
--

INSERT INTO `planet` (`id`, `name`) VALUES
(3, 'Mandalore'),
(4, 'Coruscant'),
(5, 'Dagobah'),
(6, 'Geonosis'),
(7, 'Hoth'),
(8, 'Jakku'),
(9, 'Kashyyyk'),
(10, 'Naboo'),
(12, 'Tatooine'),
(13, 'Utapau'),
(14, 'Endor'),
(15, 'Ahch-To');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `beast`
--
ALTER TABLE `beast`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_movie` (`id_movie`),
  ADD KEY `id_planet` (`id_planet`);

--
-- Index pour la table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `beast`
--
ALTER TABLE `beast`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `planet`
--
ALTER TABLE `planet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `beast`
--
ALTER TABLE `beast`
  ADD CONSTRAINT `beast_ibfk_1` FOREIGN KEY (`id_planet`) REFERENCES `planet` (`id`),
  ADD CONSTRAINT `beast_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id`);
