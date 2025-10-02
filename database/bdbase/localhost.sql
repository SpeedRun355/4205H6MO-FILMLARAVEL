-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2025 at 12:44 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filmreviewl_bd`
--
CREATE DATABASE IF NOT EXISTS `filmreviewl_bd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `filmreviewl_bd`;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int(255) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `global_rating` float UNSIGNED NOT NULL,
  `film_genre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `actors` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `director` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `name`, `global_rating`, `film_genre`, `actors`, `director`) VALUES
(1, 'feetlicks', 2, 'horror', 'joe mama', 'tarantino'),
(2, 'fast & dogshit', 3.1, 'action', 'dom torreto, tom cruise', 'cdawg'),
(3, 'Racist Racing', 4.6, 'racing', 'john racist', 'john directeur'),
(4, 'FentFantasy', 1.5, 'fantasy', 'john Fantasy', 'sleepy joe'),
(5, 'FartBigTV', 4.1, 'reality tv', 'smartfella', 'fartsmella'),
(6, 'HOMEBOUND', 3.2, 'idk man', 'im tired', 'i wanna go home'),
(7, 'ff7', 2.6, 'soulslike', 'lies of shit', 'wucheng fallen mid'),
(8, 'fdgh', 3, 'dfg', 'dg', 'fgd'),
(9, 'fdgh', 3, 'dfg', 'dg', 'fgd'),
(10, 'fdgh', 3, 'dfg', 'dg', 'fgd'),
(11, 'fdgh', 3, 'dfg', 'dg', 'fgd'),
(12, 'df', 2, 'df', 'df', 'df'),
(13, 'df', 2, 'df', 'df', 'df'),
(14, 'df', 2, 'df', 'df', 'df'),
(15, 'df', 3, 'df', 'df', 'df'),
(16, 'df', 3, 'f', 'f', 'dfg'),
(17, 'f', 3, 'f', 'f', 'f'),
(18, 'ew', 34, 'e', 'e', 'e');

-- --------------------------------------------------------

--
-- Table structure for table `film_user`
--

CREATE TABLE `film_user` (
  `id` int(255) UNSIGNED NOT NULL,
  `review` int(10) NOT NULL,
  `comment` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `film_id` int(10) UNSIGNED NOT NULL,
  `erace` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `film_user`
--

INSERT INTO `film_user` (`id`, `review`, `comment`, `user_id`, `film_id`, `erace`) VALUES
(6, 21, 'Écrivez votre commentaire ici', 1, 4, 0),
(7, 2, 'Écrivez votre commentaire ici', 1, 6, 0),
(8, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(9, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(10, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(11, 3, 'Écrivez votre commentaire ici', 1, 11, 1),
(12, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(13, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(14, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(15, 2, 'Écrivez votre commentaire ici', 1, 11, 1),
(16, 2, 'Écrivez votre commentaire ici', 1, 11, 0),
(17, 2, 'Écrivez votre commentaire ici', 1, 11, 0),
(18, 2, 'Écrivez votre commentaire ici', 1, 18, 1),
(20, 3, 'Écrivez votre commentaire ici', 1, 18, 1),
(21, 2, 'Écrivez votre commentaire ici', 1, 18, 1),
(22, 3, 'Écrivez votre commentaire ici', 3, 18, 1),
(23, 3, 'Écrivez votre commentaire ici', 3, 18, 1),
(24, 3, 'Écrivez votre commentaire ici', 3, 18, 1),
(25, 333, 'Écr3ivez votre commentaire ici', 3, 18, 1),
(26, 456, 'Écrivez votre commentaire ici', 3, 18, 1),
(27, 344, 'Écrivez votre commentaire ici', 3, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birthday` date NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `birthday`, `username`, `password`) VALUES
(1, 'DIAZ', 'MARIO', '2005-11-18', 'SpeedRun355', '123'),
(2, 'Hamel', 'Felix', '2006-05-02', 'Lapinoccc', '123'),
(3, 'admin', 'admin', '2025-09-09', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film_user`
--
ALTER TABLE `film_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_utilisateur` (`user_id`),
  ADD KEY `id_films` (`film_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `film_user`
--
ALTER TABLE `film_user`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `film_user`
--
ALTER TABLE `film_user`
  ADD CONSTRAINT `fk_id_films` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_id_utilisateurs` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
