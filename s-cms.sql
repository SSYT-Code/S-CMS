-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 16 Noi 2016 la 12:20
-- Versiune server: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s-cms`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `nick` varchar(32) NOT NULL,
  `password` varchar(24) NOT NULL,
  `email` varchar(129) NOT NULL,
  `numeprenume` varchar(129) NOT NULL,
  `posts` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'http://r25.imgfast.net/users/2513/71/04/52/avatars/16890-8.png',
  `rank` int(11) NOT NULL DEFAULT '3',
  `hobby` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `stare` varchar(255) NOT NULL,
  `pm` int(11) NOT NULL,
  `lastlogin` varchar(32) NOT NULL,
  `register` varchar(32) NOT NULL,
  `ip` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `accounts`
--

INSERT INTO `accounts` (`id`, `nick`, `password`, `email`, `numeprenume`, `posts`, `points`, `avatar`, `rank`, `hobby`, `location`, `stare`, `pm`, `lastlogin`, `register`, `ip`) VALUES
(1, 'admin', '123456', 'email@s-cms.ro', 'N/A', 1, 1, 'http://r25.imgfast.net/users/2513/71/04/52/avatars/16890-8.png', 1, 'IT, CMS, Gaming', 'C:\\system32', 'Bine, la masa :)', 0, '2016-11-16 11:11:50', '2016-11-16', '127.0.0.1');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `forums`
--

CREATE TABLE `forums` (
  `id` int(11) NOT NULL,
  `f_title` varchar(128) NOT NULL,
  `f_desc` varchar(255) NOT NULL,
  `f_topics` int(11) NOT NULL,
  `f_posts` int(11) NOT NULL,
  `f_last_post` text NOT NULL,
  `f_lastpost_date` datetime DEFAULT NULL,
  `f_lastpost_by` int(11) DEFAULT NULL,
  `f_link` varchar(244) NOT NULL DEFAULT '',
  `f_parent` int(11) NOT NULL,
  `f_locked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `forums`
--

INSERT INTO `forums` (`id`, `f_title`, `f_desc`, `f_topics`, `f_posts`, `f_last_post`, `f_lastpost_date`, `f_lastpost_by`, `f_link`, `f_parent`, `f_locked`) VALUES
(1, 'Forum Test', 'Forum test', 1, 0, 'Welcome to S-CMS.', '2016-11-16 00:00:00', 1, 'viewforum.php?forum=', 0, 0),
(2, 'Forum 2', 'This is a description of forum #2', 0, 0, 'No post here', NULL, NULL, 'viewforum.php?forum=', 0, 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Desc` varchar(32) NOT NULL,
  `colors` varchar(24) NOT NULL,
  `Leader` int(11) NOT NULL,
  `Members` int(11) NOT NULL,
  `Flags` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `groups`
--

INSERT INTO `groups` (`id`, `Name`, `Desc`, `colors`, `Leader`, `Members`, `Flags`) VALUES
(1, 'Administrator', 'Forum administrators', '    color: #E91E63;', 1, 1, 1),
(2, 'Moderators', 'Forum moderators', 'color: #009688;', -1, 0, 2),
(3, 'Members', 'Forum members', '    color: #2196F3;', -1, 0, 3);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `site_pages`
--

CREATE TABLE `site_pages` (
  `page_id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `site_pages`
--

INSERT INTO `site_pages` (`page_id`, `page_name`, `page_url`, `page_title`) VALUES
(1, 'Index Page', './', 'Index Page'),
(2, 'Memberlist', 'memberlist.php', 'Members List'),
(3, 'Groups', 'groups.php', 'Groups List'),
(4, 'Sign Up', 'index.php?action=sign_up', 'Create Account'),
(5, 'Sign In', 'index.php?action=sign_in', 'Login');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `site_settings`
--

CREATE TABLE `site_settings` (
  `site_url` varchar(255) NOT NULL,
  `site_title` varchar(128) NOT NULL,
  `site_desc` varchar(128) NOT NULL,
  `site_logo` varchar(128) DEFAULT 'style/default/images/slogo.png',
  `site_meta` varchar(128) NOT NULL,
  `site_style` varchar(128) NOT NULL DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `site_settings`
--

INSERT INTO `site_settings` (`site_url`, `site_title`, `site_desc`, `site_logo`, `site_meta`, `site_style`) VALUES
('http://127.0.0.1/S-CMS/', 'S-CMS Community Board', 'Welcome to S-CMS Board', 'style/default/images/slogo.png	', 's-cms, board, community', 'default');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `t_forum` int(11) DEFAULT NULL,
  `t_tile` varchar(255) NOT NULL,
  `t_by` int(11) NOT NULL,
  `t_text` longtext,
  `t_date` datetime DEFAULT NULL,
  `t_reply` int(11) NOT NULL,
  `t_views` int(11) NOT NULL,
  `last_reply` int(11) DEFAULT NULL,
  `last_date` varchar(35) NOT NULL,
  `t_status` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `topics`
--

INSERT INTO `topics` (`id`, `t_forum`, `t_tile`, `t_by`, `t_text`, `t_date`, `t_reply`, `t_views`, `last_reply`, `last_date`, `t_status`) VALUES
(1, 1, 'Welcome to S-CMS', 1, 'Welcome to S-CMS Board.', '2016-11-16 00:00:00', 0, 0, 1, '2016-11-16 12:10:54', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`f_title`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_pages`
--
ALTER TABLE `site_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`site_url`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `site_pages`
--
ALTER TABLE `site_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
