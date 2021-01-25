-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Jan 2021 um 15:11
-- Server-Version: 10.4.13-MariaDB
-- PHP-Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `abschlussprojekt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `erreichbar`
--

CREATE TABLE `erreichbar` (
  `id` int(11) NOT NULL,
  `mitarbeiter` text NOT NULL,
  `gruppe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `erreichbar`
--

INSERT INTO `erreichbar` (`id`, `mitarbeiter`, `gruppe`) VALUES
(1, 'Johannes - 056132456', 'H10N06'),
(2, 'H10N07 - 0622312345', 'H10N06'),
(3, 'Annika - 030451235', 'H10N06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `vername` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `gruppe` varchar(20) NOT NULL,
  `eingetragen_am` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `events`
--

INSERT INTO `events` (`id`, `vername`, `name`, `gruppe`, `eingetragen_am`) VALUES
(1, 'Zockerabend', 'zocken.jpg', 'H10N06', '2020-09-14'),
(2, 'Grillen', 'grillen.jpg', 'H10N06', '2020-09-14'),
(3, 'Fußball', 'fußbalö.jpeg', 'H10N06', '2020-09-14');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eventsnrml`
--

CREATE TABLE `eventsnrml` (
  `id` int(11) NOT NULL,
  `namev` varchar(200) NOT NULL,
  `wann` datetime NOT NULL,
  `wo` varchar(200) NOT NULL,
  `gruppe` varchar(20) NOT NULL,
  `eingetragen_am` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `eventsnrml`
--

INSERT INTO `eventsnrml` (`id`, `namev`, `wann`, `wo`, `gruppe`, `eingetragen_am`) VALUES
(1, 'Kochen entfällt!', '2020-09-16 17:30:00', 'Große Küche', 'H10N06', '2020-09-14'),
(2, 'Spieleabend', '2020-09-15 20:00:00', 'großer Gruppenraum', 'H10N06', '2020-09-14');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `nachricht` varchar(200) NOT NULL,
  `datum` datetime NOT NULL,
  `gruppe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`id`, `nachricht`, `datum`, `gruppe`) VALUES
(1, 'Fensterputzer zwischen 10 Uhr - 12 Uht', '2020-09-17 10:00:00', 'H10N06'),
(2, 'Kein Frühdienst!', '2020-09-18 06:30:00', 'H10N06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `eingetragen_am` date NOT NULL DEFAULT current_timestamp(),
  `gruppe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `post`
--

INSERT INTO `post` (`id`, `name`, `eingetragen_am`, `gruppe`) VALUES
(1, 'Dennis', '2020-09-14', 'H10N06'),
(2, 'Thomas', '2020-09-14', 'H10N06'),
(3, 'Henning', '2020-09-14', 'H10N06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teilnehmer`
--

CREATE TABLE `teilnehmer` (
  `id` int(11) NOT NULL,
  `vname` text NOT NULL,
  `nname` text NOT NULL,
  `mitarb` varchar(4) NOT NULL,
  `nr` varchar(20) NOT NULL,
  `gruppe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teilnehmer`
--

INSERT INTO `teilnehmer` (`id`, `vname`, `nname`, `mitarb`, `nr`, `gruppe`) VALUES
(1, 'Dennis', 'Mager', 'Nein', '', 'H10N06'),
(2, 'Thomas ', 'Grimm', 'Nein', '', 'H10N06'),
(3, 'Henning ', 'Reichel', 'Nein', '', 'H10N06'),
(4, 'Philip', 'Graser', 'Nein', '', 'H10N06'),
(5, 'Walter', 'Steuernagel', 'Nein', '', 'H10N06'),
(6, 'Johannes', 'Baus', 'Ja', '056132456', 'H10N06'),
(7, 'Dietmar', 'Engelmann', 'Ja', '06223456987', 'H10N06'),
(8, 'Annika', 'Schad', 'Ja', '030451235', 'H10N06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `telnr`
--

CREATE TABLE `telnr` (
  `id` int(11) NOT NULL,
  `nr` varchar(11) NOT NULL,
  `gruppennr` varchar(20) NOT NULL,
  `gruppe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `telnr`
--

INSERT INTO `telnr` (`id`, `nr`, `gruppennr`, `gruppe`) VALUES
(1, '0622312345', 'H10N07', 'H10N06'),
(2, '06223987755', 'H10N08', 'H10N06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `passwort` varchar(2000) NOT NULL,
  `gruppe` varchar(20) NOT NULL,
  `eingetragen_am` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `passwort`, `gruppe`, `eingetragen_am`) VALUES
(1, '$2y$10$pInMdkDNwmSbk6nznExbu.u0DbF3Jz2afVuZCCuxxU3cICcjkarnq', 'H10N06', '2020-07-23'),
(2, '$2y$10$pInMdkDNwmSbk6nznExbu.u0DbF3Jz2afVuZCCuxxU3cICcjkarnq', 'H10N07', '2020-07-23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wetter`
--

CREATE TABLE `wetter` (
  `id` int(11) NOT NULL,
  `ort` varchar(30) NOT NULL,
  `gruppe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `wetter`
--

INSERT INTO `wetter` (`id`, `ort`, `gruppe`) VALUES
(3, 'Berlin', 'H10N06');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `erreichbar`
--
ALTER TABLE `erreichbar`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `eventsnrml`
--
ALTER TABLE `eventsnrml`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teilnehmer`
--
ALTER TABLE `teilnehmer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `telnr`
--
ALTER TABLE `telnr`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `wetter`
--
ALTER TABLE `wetter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `erreichbar`
--
ALTER TABLE `erreichbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `eventsnrml`
--
ALTER TABLE `eventsnrml`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `teilnehmer`
--
ALTER TABLE `teilnehmer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `telnr`
--
ALTER TABLE `telnr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `wetter`
--
ALTER TABLE `wetter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
