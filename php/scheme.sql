-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generato il: Lug 25, 2014 alle 22:41
-- Versione del server: 5.5.32
-- Versione PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amm14_cusimanosimone`
--
CREATE DATABASE IF NOT EXISTS `amm14_cusimanosimone` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `amm14_cusimanosimone`;

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(32) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `descrizione`) VALUES
(1, 'Abbigliamento', 'Interdum et malesuada fames ac.'),
(2, 'Scarpe', 'Nam consequat nisl ut aliquet.'),
(3, 'Elettronica', 'In sit amet ligula quis.'),
(4, 'Integratori', 'Maecenas ornare nunc lacus, id.'),
(5, 'Borse', 'Aliquam a nisl risus. Aenean.');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE IF NOT EXISTS `prodotto` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(32) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `costo` float NOT NULL,
  `iva` float NOT NULL,
  `prezzo_vendita` float NOT NULL,
  `quantita` float NOT NULL,
  `id_categoria` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`id`, `nome`, `descrizione`, `costo`, `iva`, `prezzo_vendita`, `quantita`, `id_categoria`) VALUES
(1, 'T-Shirt Actizen', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 15, 22, 25, 5, 1),
(3, 'Wave Rider Blu', 'Etiam purus tellus, sodales luctus diam eget, tempus congue libero. Sed quis ultrices nunc. Sed.', 30, 22, 120, 1, 2),
(6, 'GPS On Move 50', 'In hac habitasse platea dictumst. Suspendisse et metus vitae tortor adipiscing dictum. Nam enim diam.', 20, 22, 70, 4, 3),
(7, 'Enervit R2 Sport 400 G Arancio', 'Phasellus nec dolor eget est hendrerit tincidunt at sit amet velit. Proin in imperdiet risus.', 7, 10, 30, 12, 4),
(8, 'Bevanda isotonica lime 2kg', 'Donec sapien eros, consequat eget erat nec, tincidunt consequat ipsum. Donec lacinia augue sed scelerisque.', 4, 10, 20, 15, 4),
(9, 'Trolley 105L', 'Fusce sit amet est non odio tempor dapibus sit amet ac ante. In ullamcorper placerat.', 25, 22, 60, 2, 5),
(10, 'Borsa grigio-azzurro 53L', 'Proin eu nibh ultrices, sagittis eros at, porta nibh. Duis id neque in felis tempus.', 12, 22, 30, 1, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE IF NOT EXISTS `utente` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `ruolo` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `username`, `password`, `nome`, `cognome`, `email`, `ruolo`) VALUES
(1, 'amministratore', 'amministratore', 'Simone Admin', 'Cusimano', 'si.cusimano1@studenti.unica.it', '0'),
(2, 'dipendente', 'dipendente', 'Simone Dipendente', 'Cusimano', 'si.cusimano1@studenti.unica.it', '1');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
