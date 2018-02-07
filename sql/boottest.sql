-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 07. úno 2018, 19:26
-- Verze serveru: 5.7.14
-- Verze PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `boottest`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180207121241'),
('20180207121947'),
('20180207123618'),
('20180207154141'),
('20180207172058'),
('20180207182922');

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `watchdog_activated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `quantity`, `watchdog_activated`) VALUES
(1, 'zxsvxzcv', '2.00', 15, 1),
(2, 'pokus', '10.00', 9, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `watchdog`
--

DROP TABLE IF EXISTS `watchdog`;
CREATE TABLE `watchdog` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `changed_column_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `old_value` decimal(10,2) NOT NULL,
  `new_value` decimal(10,2) NOT NULL,
  `id_rule` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `watchdog`
--

INSERT INTO `watchdog` (`id`, `id_product`, `changed_column_name`, `old_value`, `new_value`, `id_rule`) VALUES
(9, 1, 'price', '3.00', '2.00', 1),
(10, 1, 'price', '3.00', '2.00', 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `watchdog_rule`
--

DROP TABLE IF EXISTS `watchdog_rule`;
CREATE TABLE `watchdog_rule` (
  `id` int(11) NOT NULL,
  `changed_column_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `changed_column_operation` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `changed_column_value` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `watchdog_rule`
--

INSERT INTO `watchdog_rule` (`id`, `changed_column_name`, `changed_column_operation`, `changed_column_value`) VALUES
(1, 'price', '-', NULL),
(2, 'quantity', 'Z', NULL),
(3, 'price', '<', '5.00');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Klíče pro tabulku `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `watchdog`
--
ALTER TABLE `watchdog`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `watchdog_rule`
--
ALTER TABLE `watchdog_rule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `watchdog`
--
ALTER TABLE `watchdog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pro tabulku `watchdog_rule`
--
ALTER TABLE `watchdog_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
