-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 07 avr. 2025 à 14:31
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `pdo_c2_exe_ti2`
--
DROP DATABASE IF EXISTS `pdo_c2_exe_ti2`;
CREATE DATABASE IF NOT EXISTS `pdo_c2_exe_ti2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pdo_c2_exe_ti2`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
                                         `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
                                         `surname` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
                                         `email` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
                                         `message` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
                                         `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                         `valide` tinyint UNSIGNED NOT NULL DEFAULT '1',
                                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
