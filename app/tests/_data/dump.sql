-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 28 Mars 2014 à 14:45
-- Version du serveur: 5.6.14
-- Version de PHP: 5.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `typicms`
--

-- --------------------------------------------------------

--
-- Structure de la table `typi_categories`
--

CREATE TABLE IF NOT EXISTS `typi_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `typi_categories`
--

INSERT INTO `typi_categories` (`id`, `position`, `created_at`, `updated_at`) VALUES
(1, 0, '2013-10-27 20:57:44', '2013-10-27 19:26:35'),
(2, 0, '2013-10-27 20:58:30', '2013-10-27 19:59:15'),
(3, 0, '2013-10-27 20:52:13', '2013-10-27 20:08:14'),
(4, 0, '2013-10-27 20:52:13', '2013-10-27 20:08:14');

-- --------------------------------------------------------

--
-- Structure de la table `typi_category_translations`
--

CREATE TABLE IF NOT EXISTS `typi_category_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `category_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Contenu de la table `typi_category_translations`
--

INSERT INTO `typi_category_translations` (`id`, `category_id`, `locale`, `status`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 1, 'Été', 'ete', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'nl', 1, 'Zomer', 'zomer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'en', 1, 'Summer', 'summer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'fr', 1, 'Automne', 'automne', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 'nl', 1, 'Vallen', 'vallen', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 'en', 1, 'Fall', 'fall', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 3, 'fr', 1, 'Hiver', 'hiver', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 3, 'nl', 1, 'Winter', 'winter', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 3, 'en', 1, 'Winter', 'winter', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 4, 'fr', 1, 'Printemps', 'printemps', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 4, 'nl', 1, 'Lente', 'lente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 4, 'en', 1, 'Spring', 'spring', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `typi_contacts`
--

CREATE TABLE IF NOT EXISTS `typi_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `typi_contacts`
--

INSERT INTO `typi_contacts` (`id`, `title`, `first_name`, `last_name`, `language`, `email`, `website`, `company`, `address`, `postcode`, `city`, `country`, `phone`, `mobile`, `fax`, `message`, `created_at`, `updated_at`) VALUES
(1, 'mr', 'poi', 'poi', 'fr', 'poi@poi.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poi', '2014-03-28 13:43:16', '2014-03-28 13:43:16');

-- --------------------------------------------------------

--
-- Structure de la table `typi_events`
--

CREATE TABLE IF NOT EXISTS `typi_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `typi_events`
--

INSERT INTO `typi_events` (`id`, `start_date`, `end_date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, '2013-10-24', '0000-00-00', ' 20:30', '', '2013-10-28 22:20:14', '2013-10-28 22:20:14'),
(2, '2013-11-16', '0000-00-00', ' 20:00', '', '2013-10-28 22:21:10', '2013-10-28 22:21:10'),
(3, '2013-12-20', '2014-01-09', '', '', '2013-10-28 22:22:37', '2013-10-28 22:22:37');

-- --------------------------------------------------------

--
-- Structure de la table `typi_event_translations`
--

CREATE TABLE IF NOT EXISTS `typi_event_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_translations_event_id_locale_unique` (`event_id`,`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Contenu de la table `typi_event_translations`
--

INSERT INTO `typi_event_translations` (`id`, `event_id`, `locale`, `status`, `title`, `slug`, `summary`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 1, 'Concert à la maison', 'concert-a-la-maison', '', '', '2013-10-28 22:20:14', '2013-10-28 22:20:14'),
(2, 1, 'nl', 0, '', NULL, '', '', '2013-10-28 22:20:14', '2013-10-28 22:20:14'),
(3, 1, 'en', 0, '', NULL, '', '', '2013-10-28 22:20:14', '2013-10-28 22:20:14'),
(4, 2, 'fr', 1, 'Cabaret Boite à Clous', 'cabaret-boite-a-clous', '', '', '2013-10-28 22:21:10', '2013-10-28 22:21:10'),
(5, 2, 'nl', 1, 'Boite à Clous Cabaret', 'boite-a-clous-cabaret', '', '', '2013-10-28 22:21:10', '2013-10-28 22:21:10'),
(6, 2, 'en', 0, '', NULL, '', '', '2013-10-28 22:21:10', '2013-10-28 22:21:10'),
(7, 3, 'fr', 1, 'Vacances d’hiver', 'vacances-dhiver', '', '', '2013-10-28 22:22:37', '2013-10-28 22:22:37'),
(8, 3, 'nl', 0, 'Vacancies', 'vacancies', '', '', '2013-10-28 22:22:37', '2013-10-28 22:22:37'),
(9, 3, 'en', 1, 'Holidays', 'holidays', '', '', '2013-10-28 22:22:37', '2013-10-28 22:22:37');

-- --------------------------------------------------------

--
-- Structure de la table `typi_files`
--

CREATE TABLE IF NOT EXISTS `typi_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `type` enum('a','v','d','i','o') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `mimetype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `filesize` int(10) unsigned NOT NULL,
  `download_count` int(11) NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `typi_file_translations`
--

CREATE TABLE IF NOT EXISTS `typi_file_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `alt_attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_translations_file_id_locale_unique` (`file_id`,`locale`),
  KEY `file_translations_locale_index` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `typi_groups`
--

CREATE TABLE IF NOT EXISTS `typi_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `typi_groups`
--

INSERT INTO `typi_groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '{"dashboard":1,"admin.settings.index":1,"admin.pages.index":1,"admin.pages.view":1,"admin.pages.create":1,"admin.pages.store":1,"admin.pages.edit":1,"admin.pages.sort":1,"admin.pages.destroy":1,"admin.files.index":1,"admin.files.view":1,"admin.files.create":1,"admin.files.store":1,"admin.files.edit":1,"admin.files.sort":1,"admin.files.destroy":1,"admin.news.index":1,"admin.news.view":1,"admin.news.create":1,"admin.news.store":1,"admin.news.edit":1,"admin.news.sort":1,"admin.news.destroy":1,"admin.events.index":1,"admin.events.view":1,"admin.events.create":1,"admin.events.store":1,"admin.events.edit":1,"admin.events.sort":1,"admin.events.destroy":1,"admin.categories.index":1,"admin.categories.view":1,"admin.categories.create":1,"admin.categories.store":1,"admin.categories.edit":1,"admin.categories.sort":1,"admin.categories.destroy":1,"admin.projects.index":1,"admin.projects.view":1,"admin.projects.create":1,"admin.projects.store":1,"admin.projects.edit":1,"admin.projects.sort":1,"admin.projects.destroy":1,"admin.places.index":1,"admin.places.view":1,"admin.places.create":1,"admin.places.store":1,"admin.places.edit":1,"admin.places.sort":1,"admin.places.destroy":1,"admin.menus.index":1,"admin.menus.view":1,"admin.menus.create":1,"admin.menus.store":1,"admin.menus.edit":1,"admin.menus.sort":1,"admin.menus.destroy":1,"admin.menulinks.index":1,"admin.menulinks.view":1,"admin.menulinks.create":1,"admin.menulinks.store":1,"admin.menulinks.edit":1,"admin.menulinks.sort":1,"admin.menulinks.destroy":1,"admin.users.index":1,"admin.users.view":1,"admin.users.create":1,"admin.users.store":1,"admin.users.edit":1,"admin.users.sort":1,"admin.users.destroy":1,"admin.groups.index":1,"admin.groups.view":1,"admin.groups.create":1,"admin.groups.store":1,"admin.groups.edit":1,"admin.groups.sort":1,"admin.groups.destroy":1}', '2014-03-28 13:42:39', '2014-03-28 13:42:39'),
(2, 'Public', '', '2014-03-28 13:42:39', '2014-03-28 13:42:39'),
(3, 'News', '{"dashboard":1,"admin.news.index":1,"admin.news.view":1,"admin.news.create":1,"admin.news.store":1,"admin.news.edit":1,"admin.news.sort":1,"admin.news.destroy":1}', '2014-03-28 13:42:39', '2014-03-28 13:42:39');

-- --------------------------------------------------------

--
-- Structure de la table `typi_menulinks`
--

CREATE TABLE IF NOT EXISTS `typi_menulinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `target` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `restricted_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `menulinks_menu_id_foreign` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Contenu de la table `typi_menulinks`
--

INSERT INTO `typi_menulinks` (`id`, `menu_id`, `page_id`, `parent`, `position`, `target`, `module_name`, `restricted_to`, `class`, `link_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 1, '', '', '', '', '', '2013-09-03 20:08:05', '2014-02-04 17:58:25'),
(2, 1, 0, 0, 7, '', 'contacts', '', 'menu-contact', '', '2013-09-03 20:08:35', '2014-03-28 12:32:30'),
(16, 1, 29, 0, 2, '', 'poi', '', '', '', '2013-09-09 21:18:49', '2014-02-04 17:58:25'),
(17, 1, 0, 0, 3, '', 'events', '', '', '', '2013-10-05 17:30:30', '2014-02-04 17:58:25'),
(18, 1, 0, 0, 5, '', 'projects', '', '', '', '2013-10-05 17:31:09', '2014-02-04 17:58:25'),
(19, 2, 0, 0, 2, '', 'contacts', '', '', '', '2013-11-02 16:20:16', '2014-03-28 12:32:46'),
(20, 2, 1, 0, 1, '', '', '', '', '', '2013-11-02 16:20:43', '2013-11-02 16:31:37'),
(21, 1, 0, 0, 4, '', 'news', '', '', '', '2013-11-08 10:14:39', '2014-02-04 17:58:25'),
(22, 3, 0, 0, 0, '_blank', '', '', 'fa fa-facebook btn-facebook', '', '2014-02-04 17:30:11', '2014-02-04 17:30:17'),
(23, 3, 0, 0, 0, '_blank', '', '', 'fa fa-twitter btn-twitter', '', '2014-02-04 17:31:35', '2014-02-04 17:31:47'),
(24, 1, 0, 0, 6, '', 'places', '', '', '', '2014-02-04 17:58:20', '2014-02-04 17:59:32');

-- --------------------------------------------------------

--
-- Structure de la table `typi_menulink_translations`
--

CREATE TABLE IF NOT EXISTS `typi_menulink_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menulink_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menulink_translations_menulink_id_locale_unique` (`menulink_id`,`locale`),
  KEY `menulink_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

--
-- Contenu de la table `typi_menulink_translations`
--

INSERT INTO `typi_menulink_translations` (`id`, `menulink_id`, `locale`, `status`, `title`, `url`, `uri`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 1, 'Accueil', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'nl', 1, 'Home', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'en', 1, 'Home', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'fr', 1, 'Contact', '', 'fr/contact', '0000-00-00 00:00:00', '2014-03-28 12:29:27'),
(5, 2, 'nl', 1, 'Contact', '', 'nl/contact', '0000-00-00 00:00:00', '2014-03-28 12:29:27'),
(6, 2, 'en', 1, 'Contact', '', 'en/contact', '0000-00-00 00:00:00', '2014-03-28 12:29:27'),
(46, 16, 'fr', 1, 'Infos', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 16, 'nl', 1, 'Info', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 16, 'en', 1, 'Info', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 17, 'fr', 1, 'Événements', '', 'fr/evenements', '2013-10-05 17:30:30', '2013-10-05 17:30:32'),
(50, 17, 'nl', 1, 'Evenementen', '', 'nl/evenementen', '2013-10-05 17:30:30', '2013-10-05 17:31:48'),
(51, 17, 'en', 1, 'Events', '', 'en/events', '2013-10-05 17:30:30', '2013-10-05 17:31:51'),
(52, 18, 'fr', 1, 'Projets', '', 'fr/projets', '2013-10-05 17:31:09', '2013-10-05 17:31:11'),
(53, 18, 'nl', 1, 'Projecten', '', 'nl/projecten', '2013-10-05 17:31:09', '2013-10-05 17:31:49'),
(54, 18, 'en', 1, 'Projects', '', 'en/projects', '2013-10-05 17:31:09', '2013-10-05 17:31:51'),
(55, 19, 'fr', 1, 'Contact', '', 'fr/contact', '2013-11-02 16:20:16', '2014-03-28 12:30:40'),
(56, 19, 'nl', 1, 'Contact', '', 'nl/contact', '2013-11-02 16:20:16', '2014-03-28 12:30:40'),
(57, 19, 'en', 1, 'Contact', '', 'en/contact', '2013-11-02 16:20:16', '2014-03-28 12:30:40'),
(58, 20, 'fr', 1, 'Accueil', '', '', '2013-11-02 16:20:43', '2013-11-02 16:20:51'),
(59, 20, 'nl', 1, 'Home', '', '', '2013-11-02 16:20:43', '2013-11-02 16:20:47'),
(60, 20, 'en', 1, 'Home', '', '', '2013-11-02 16:20:43', '2013-11-02 16:20:44'),
(61, 21, 'fr', 1, 'Actualités', '', 'fr/actualites', '2013-11-08 10:14:39', '2013-11-08 10:14:39'),
(62, 21, 'nl', 1, 'Nieuws', '', 'nl/nieuws', '2013-11-08 10:14:39', '2013-11-08 10:14:39'),
(63, 21, 'en', 1, 'News', '', 'en/news', '2013-11-08 10:14:39', '2013-11-08 10:14:39'),
(64, 22, 'fr', 1, 'Facebook', 'https://www.facebook.com/pages/Typi-Design/101975113206089', '', '2014-02-04 17:30:11', '2014-02-04 17:30:17'),
(65, 22, 'nl', 1, 'Facebook', 'https://www.facebook.com/pages/Typi-Design/101975113206089', '', '2014-02-04 17:30:11', '2014-02-04 17:30:17'),
(66, 22, 'en', 1, 'Facebook', 'https://www.facebook.com/pages/Typi-Design/101975113206089', '', '2014-02-04 17:30:11', '2014-02-04 17:30:17'),
(67, 23, 'fr', 1, 'Twitter', 'https://twitter.com/TypiDesign', '', '2014-02-04 17:31:35', '2014-02-04 17:31:47'),
(68, 23, 'nl', 1, 'Twitter', 'https://twitter.com/TypiDesign', '', '2014-02-04 17:31:35', '2014-02-04 17:31:44'),
(69, 23, 'en', 1, 'Twitter', 'https://twitter.com/TypiDesign', '', '2014-02-04 17:31:35', '2014-02-04 17:31:42'),
(70, 24, 'fr', 1, 'Adresses', '', 'fr/adresses', '2014-02-04 17:58:20', '2014-02-04 17:59:32'),
(71, 24, 'nl', 1, 'Adres', '', 'nl/adres', '2014-02-04 17:58:20', '2014-02-04 17:59:32'),
(72, 24, 'en', 1, 'Addresses', '', 'en/addresses', '2014-02-04 17:58:20', '2014-02-04 17:59:32');

-- --------------------------------------------------------

--
-- Structure de la table `typi_menus`
--

CREATE TABLE IF NOT EXISTS `typi_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `typi_menus`
--

INSERT INTO `typi_menus` (`id`, `name`, `class`, `created_at`, `updated_at`) VALUES
(1, 'main', 'nav-main nav nav-pills', '2013-09-03 20:05:21', '2014-02-17 15:25:05'),
(2, 'footer', 'nav-footer nav nav-pills pull-right', '2013-09-03 20:05:42', '2014-02-17 15:24:59'),
(3, 'social', 'nav-social list-unstyled', '2014-02-04 17:27:18', '2014-02-17 15:25:21');

-- --------------------------------------------------------

--
-- Structure de la table `typi_menu_translations`
--

CREATE TABLE IF NOT EXISTS `typi_menu_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_translations_menu_id_locale_unique` (`menu_id`,`locale`),
  KEY `menu_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Contenu de la table `typi_menu_translations`
--

INSERT INTO `typi_menu_translations` (`id`, `menu_id`, `locale`, `status`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 1, 'Principal', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'nl', 1, 'Main', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'en', 1, 'Main', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'fr', 1, 'Pied de site', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 'nl', 1, 'Footer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 'en', 1, 'Footer', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 3, 'fr', 1, 'Réseaux sociaux', '2014-02-04 17:27:18', '2014-02-04 17:35:01'),
(8, 3, 'nl', 1, 'Sociale netwerken', '2014-02-04 17:27:18', '2014-02-04 17:35:01'),
(9, 3, 'en', 1, 'Social networks', '2014-02-04 17:27:18', '2014-02-04 17:35:01');

-- --------------------------------------------------------

--
-- Structure de la table `typi_migrations`
--

CREATE TABLE IF NOT EXISTS `typi_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `typi_migrations`
--

INSERT INTO `typi_migrations` (`migration`, `batch`) VALUES
('2012_12_06_225921_migration_cartalyst_sentry_install_users', 1),
('2012_12_06_225929_migration_cartalyst_sentry_install_groups', 1),
('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot', 1),
('2012_12_06_225988_migration_cartalyst_sentry_install_throttle', 1),
('2013_08_29_174626_create_pages_table', 1),
('2013_08_31_000501_create_events_table', 1),
('2013_09_03_084147_create_menus_tables', 1),
('2013_09_21_104640_create_files_table', 1),
('2013_10_05_091611_create_projects_table', 1),
('2013_10_27_105515_create_categories_table', 1),
('2013_10_29_224632_create_settings_table', 1),
('2013_11_07_185433_create_news_table', 1),
('2014_01_13_094853_create_places_table', 1),
('2014_02_13_013804_create_tags_table', 1),
('2014_02_28_223553_create_translations_table', 1),
('2014_03_28_101553_create_contacts_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `typi_news`
--

CREATE TABLE IF NOT EXISTS `typi_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Contenu de la table `typi_news`
--

INSERT INTO `typi_news` (`id`, `date`, `created_at`, `updated_at`) VALUES
(1, '2014-03-20 11:33:00', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(2, '2014-03-20 11:33:00', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(3, '2014-03-20 11:33:00', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(4, '2014-03-20 11:33:00', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(5, '2014-03-20 11:33:00', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(6, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(7, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(8, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(9, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(10, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(11, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(12, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(13, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(14, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(15, '2014-03-20 11:33:00', '2014-03-04 11:33:38', '2014-03-04 11:33:38');

-- --------------------------------------------------------

--
-- Structure de la table `typi_news_translations`
--

CREATE TABLE IF NOT EXISTS `typi_news_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_translations_news_id_locale_unique` (`news_id`,`locale`),
  KEY `news_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Contenu de la table `typi_news_translations`
--

INSERT INTO `typi_news_translations` (`id`, `news_id`, `locale`, `status`, `title`, `slug`, `summary`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 1, 'News', 'test-de-pge', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(2, 1, 'nl', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(3, 1, 'en', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(4, 2, 'fr', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(5, 2, 'nl', 1, 'News', 'news-2', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(6, 2, 'en', 1, 'News', 'news-2', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(7, 3, 'fr', 1, 'News', 'news-2', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(8, 3, 'nl', 1, 'News', 'news-3', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(9, 3, 'en', 1, 'News', 'news-3', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(10, 4, 'fr', 1, 'News', 'news-3', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(11, 4, 'nl', 1, 'News', 'news-4', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(12, 4, 'en', 1, 'News', 'news-4', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(13, 5, 'fr', 1, 'News', 'news-4', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(14, 5, 'nl', 1, 'News', 'news-5', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(15, 5, 'en', 1, 'News', 'news-5', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:37', '2014-03-04 11:33:37'),
(16, 6, 'fr', 1, 'News', 'news-5', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(17, 6, 'nl', 1, 'News', 'news-6', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(18, 6, 'en', 1, 'News', 'news-6', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(19, 7, 'fr', 1, 'News', 'news-6', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(20, 7, 'nl', 1, 'News', 'news-7', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(21, 7, 'en', 1, 'News', 'news-7', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(22, 8, 'fr', 1, 'News', 'news-7', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(23, 8, 'nl', 1, 'News', 'news-8', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(24, 8, 'en', 1, 'News', 'news-8', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(25, 9, 'fr', 1, 'News', 'news-8', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(26, 9, 'nl', 1, 'News', 'news-9', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(27, 9, 'en', 1, 'News', 'news-9', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(28, 10, 'fr', 1, 'News', 'news-9', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(29, 10, 'nl', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(30, 10, 'en', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(31, 11, 'fr', 1, 'News', 'news-10', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(32, 11, 'nl', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(33, 11, 'en', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(34, 12, 'fr', 1, 'News', 'news-11', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(35, 12, 'nl', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(36, 12, 'en', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(37, 13, 'fr', 1, 'News', 'news-12', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(38, 13, 'nl', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(39, 13, 'en', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(40, 14, 'fr', 1, 'News', 'news-13', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(41, 14, 'nl', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(42, 14, 'en', 1, 'News', 'news-1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(43, 15, 'fr', 1, 'News', 'news-14', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(44, 15, 'nl', 1, 'News', 'news-14', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38'),
(45, 15, 'en', 1, 'News', 'news-14', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.', '2014-03-04 11:33:38', '2014-03-04 11:33:38');

-- --------------------------------------------------------

--
-- Structure de la table `typi_pages`
--

CREATE TABLE IF NOT EXISTS `typi_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meta_robots_no_index` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `meta_robots_no_follow` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `rss_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `comments_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `is_home` tinyint(4) NOT NULL DEFAULT '0',
  `css` text COLLATE utf8_unicode_ci,
  `js` text COLLATE utf8_unicode_ci,
  `template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Contenu de la table `typi_pages`
--

INSERT INTO `typi_pages` (`id`, `meta_robots_no_index`, `meta_robots_no_follow`, `position`, `parent`, `rss_enabled`, `comments_enabled`, `is_home`, `css`, `js`, `template`, `created_at`, `updated_at`) VALUES
(1, '', '', 0, 0, 0, 0, 1, '', '', '', '2013-09-03 19:57:44', '2013-09-11 18:26:35'),
(2, '', '', 0, 0, 0, 0, 0, '', '', 'contact', '2013-09-03 19:58:30', '2013-09-11 18:59:15'),
(29, '', '', 0, 0, 0, 0, 0, '', '', '', '2013-09-09 19:52:13', '2013-09-11 19:08:14');

-- --------------------------------------------------------

--
-- Structure de la table `typi_page_translations`
--

CREATE TABLE IF NOT EXISTS `typi_page_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_page_id_locale_unique` (`page_id`,`locale`),
  UNIQUE KEY `page_translations_uri_unique` (`uri`),
  KEY `page_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Contenu de la table `typi_page_translations`
--

INSERT INTO `typi_page_translations` (`id`, `page_id`, `locale`, `slug`, `uri`, `title`, `body`, `status`, `meta_title`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 'accueil', 'fr/accueil', 'Accueil', '<h2>Accueil</h2><p>Bienvenue ici.</p>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'nl', 'home', 'nl/home', 'Home', '<h2>Home</h2><p>Welkom hier.</p>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'en', 'home', 'en/home', 'Home', '<h2>Home</h2><p>Welcome here.</p>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'fr', 'contactez-nous', 'fr/contactez-nous', 'Contactez-nous', '<h2>Contactez-nous</h2><p>Typi Design <br>Rue Vanderkindere 467</p>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 'nl', 'contact-ons', 'nl/contact-ons', 'Contact-ons', '<h2>Contact-ons</h2><p>Typi Design <br>Rue Vanderkindere 467</p>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 'en', 'contact-us', 'en/contact-us', 'Contact us', '<h2>Contact us</h2><p>Typi Design <br>Rue Vanderkindere 467</p>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 29, 'fr', 'quoi-de-neuf', 'fr/quoi-de-neuf', 'Quoi de neuf ?', '<h2>Quoi de neuf ?</h2>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 29, 'nl', 'informatie', 'nl/informatie', 'Informatie', '<h2>Informatie</h2>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 29, 'en', 'info', 'en/info', 'Info', '<h2>Info</h2>', 1, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `typi_places`
--

CREATE TABLE IF NOT EXISTS `typi_places` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `places_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=69 ;

--
-- Contenu de la table `typi_places`
--

INSERT INTO `typi_places` (`id`, `title`, `slug`, `address`, `email`, `phone`, `fax`, `website`, `image`, `logo`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(50, 'École Steiner', 'ecole-steiner', 'Av. des Millepertuis, 14 - 1070 Bruxelles', '', '02 521 04 92', '', 'http://www.steinerschoolbrussel.be', NULL, NULL, '50.8135045', '4.2838474', '2014-01-19 14:29:19', '2014-01-19 14:29:19'),
(51, 'Kristoffelschool', 'kristoffelschool', 'Paterdupierreuxlaan, 29 – 3080 Tervuren', '', '', '', 'http://www.steinerschooltervuren.be', NULL, NULL, '50.8334817', '4.5308044', '2014-01-19 14:29:51', '2014-01-19 14:29:51'),
(52, 'Libre Ecole Rudolf Steiner', 'libre-ecole-rudolf-steiner', 'La Ferme Blanche, Rue de la Quenique, 18 1490 Court St Etienne', '', '010 61 20 64', '', 'http://www.ecole-steiner.be', NULL, NULL, '50.647135', '4.5863618999999', '2014-01-19 14:30:31', '2014-01-19 14:30:31'),
(53, 'École Decroly', 'ecole-decroly', 'Drève des Gendarmes, 45 - 1180 Bruxelles', '', '02 375 26 96', '', 'http://www.ecoledecroly.be', NULL, NULL, '50.7975205', '4.3792691', '2014-01-19 14:31:02', '2014-01-19 14:31:02'),
(54, 'Ecole Hamaide', 'ecole-hamaide', 'Avenue Hamoir, 31 - 1180 Bruxelles', 'hamaide@freegates.be', '02 374 78 90', '', 'http://www.ecolehamaide.be', NULL, NULL, '50.7978728', '4.3659198', '2014-01-19 14:31:53', '2014-01-19 14:31:53'),
(55, 'Clair-Vivre', 'clair-vivre', 'Av. Notre Dame, 40 - 1140 Bruxelles', 'direction@clairvivre.be', '02 247 63 65/66', '', 'http://www.clairvivre.be', NULL, NULL, '50.8708579', '4.3963941', '2014-01-19 14:32:43', '2014-01-19 14:32:43'),
(56, 'L’autre école', 'l-autre-ecole', 'Place Govaert, 1 - 1160 Bruxelles', 'paul.absil@autre-ecole.org', '02 660 72 38', '02 660 72 38', 'http://www.autre-ecole.org', NULL, NULL, '50.8209748', '4.4275588', '2014-01-19 14:33:19', '2014-01-19 14:33:40'),
(57, 'A.C. Montessori Kids', 'ac-montessori-kids', 'Route de Renipont, 4 - 1380 Ohain-Lasne', '', '02 633 66 52', '', 'http://www.acmontessorikids.com', NULL, NULL, '50.7013493', '4.4747397', '2014-01-19 14:34:37', '2014-01-19 14:34:37'),
(58, 'Montessori House Belgium', 'montessori-house-belgium', 'Rue Pergère, 117 - 1420 Braine l’Alleud', 'info@montessorihouse.net', '02 385 15 03', '', 'http://www.montessorihouse.net', NULL, NULL, '50.6918413', '4.3916243', '2014-01-19 14:35:35', '2014-01-19 14:35:35'),
(59, 'La Maison des Enfants Montessori', 'la-maison-des-enfants-montessori', 'Avenue Dolez, 458B - 1180 Bruxelles', 'catherine.vigreux@gmail.com', '02 375 61 84', '', '', NULL, NULL, '50.778884', '4.3556055', '2014-01-19 14:37:39', '2014-01-19 14:37:39'),
(60, 'The International Montessori School', 'the-international-montessori-school', 'Rotselaarlaan, 1 - 3080 Tervuren', 'montessori-tervuren@online.be', '02 767 63 60', '02 767 63 60', 'http://www.international-montessori.org', NULL, NULL, '50.8351968', '4.5278097', '2014-01-19 14:39:22', '2014-01-19 14:39:22'),
(61, 'International Montessori Children’s Centre', 'international-montessori-children-s-centre', 'Mechelsesteenweg, 79 1933 Sterrebeek', '', '02 784 27 84', '02 784 27 84', 'http://www.international-montessori.org', NULL, NULL, '50.8534156', '4.5090345', '2014-01-19 14:41:00', '2014-01-19 14:41:00'),
(62, 'International Montessori « Learning Centre »', 'international-montessori-learning-centre', 'Molenweg, 4 1970 Wezembeek-Oppem', '', '02 782 12 36', '02 782 12 36', 'http://www.international-montessori.org', NULL, NULL, '50.8537853', '4.495645', '2014-01-19 14:42:25', '2014-01-19 14:42:25'),
(63, 'International Montessori ‘Hof Kleinenberg’', 'international-montessori-hof-kleinenberg', 'Kleinenbergstraat, 97-99 1932 St. Stevens-Woluwe', 'montessori-tervuren@online.be', '02 767 63 60', '02 767 63 60', 'http://www.international-montessori.org', NULL, NULL, '50.8589568', '4.4462012', '2014-01-19 14:43:25', '2014-01-19 14:43:25'),
(64, 'The European Montessori School', 'the-european-montessori-school', 'Avenue Beau Séjour, 12 – 1410 Waterloo', '', '02 354 00 33', '02 351 50 99', '', NULL, NULL, '50.7254063', '4.3964999', '2014-01-19 14:44:17', '2014-01-19 14:44:17'),
(65, 'Singelijn', 'singelijn', 'Av. Chapelle aux Champs, 67 - 1200 Bruxelles', 'info@ecolesingelijn.be', '02 770 06 22', '02 770 03 48', 'http://www.ecolesingelijn.be', NULL, NULL, '50.8505551', '4.4437341', '2014-01-19 14:45:53', '2014-01-19 14:46:08'),
(66, 'Athénée Ganenou', 'athenee-ganenou', 'Rue du Melkriek, 3 - 1180 Bruxelles', '', '02 376 11 76', '', 'http://www.ganenou.com', NULL, NULL, '50.7876959', '4.3259826', '2014-01-19 14:46:37', '2014-01-19 14:46:37'),
(67, 'Athénée Maïmonide de Bruxelles', 'athenee-maimonide-de-bruxelles', 'Boulevard Poincaré, 67 - 1070 Bruxelles', '', '02 523 63 36', '', 'http://www.maimo.be', NULL, NULL, '50.8416101', '4.3396683', '2014-01-19 14:47:23', '2014-01-19 14:47:23'),
(68, 'École Beth Aviv', 'ecole-beth-aviv', 'Avenue Molière, 123 1190 Bruxelles', '', '02 347 37 19', '', 'http://www.beth-aviv.org', NULL, NULL, '50.816088', '4.3457602999999', '2014-01-19 14:48:02', '2014-01-19 14:48:16');

-- --------------------------------------------------------

--
-- Structure de la table `typi_place_translations`
--

CREATE TABLE IF NOT EXISTS `typi_place_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `info` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `place_translations_place_id_locale_unique` (`place_id`,`locale`),
  KEY `place_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=151 ;

--
-- Contenu de la table `typi_place_translations`
--

INSERT INTO `typi_place_translations` (`id`, `place_id`, `status`, `locale`, `info`, `created_at`, `updated_at`) VALUES
(113, 50, 1, 'fr', '', '2014-01-19 14:29:19', '2014-01-19 14:29:19'),
(114, 50, 1, 'en', '', '2014-01-19 14:29:19', '2014-01-19 14:29:19'),
(115, 51, 1, 'fr', '', '2014-01-19 14:29:51', '2014-01-19 14:29:51'),
(116, 51, 1, 'en', '', '2014-01-19 14:29:51', '2014-01-19 14:29:51'),
(117, 52, 1, 'fr', '', '2014-01-19 14:30:31', '2014-01-19 14:30:31'),
(118, 52, 1, 'en', '', '2014-01-19 14:30:31', '2014-01-19 14:30:31'),
(119, 53, 1, 'fr', '', '2014-01-19 14:31:02', '2014-01-19 14:31:02'),
(120, 53, 1, 'en', '', '2014-01-19 14:31:02', '2014-01-19 14:31:02'),
(121, 54, 1, 'fr', '', '2014-01-19 14:31:53', '2014-01-19 14:31:53'),
(122, 54, 1, 'en', '', '2014-01-19 14:31:53', '2014-01-19 14:31:53'),
(123, 55, 1, 'fr', '', '2014-01-19 14:32:43', '2014-01-19 14:32:43'),
(124, 55, 1, 'en', '', '2014-01-19 14:32:43', '2014-01-19 14:32:43'),
(125, 56, 1, 'fr', '', '2014-01-19 14:33:19', '2014-01-19 14:33:19'),
(126, 56, 1, 'en', '', '2014-01-19 14:33:19', '2014-01-19 14:33:19'),
(127, 57, 1, 'fr', 'Bilingual English-French school from 18 months to 9 years which welcomes your child to an environment adapted to his needs on a rural and secure site.', '2014-01-19 14:34:37', '2014-01-19 14:34:37'),
(128, 57, 1, 'en', 'Ecole bilingue français-anglais de 1 an 1/2 à 9 ans qui accueille vos enfants dans un environnement adapté aux besoins de chacun dans un site rural et sécurisé.', '2014-01-19 14:34:37', '2014-01-19 14:34:37'),
(129, 58, 1, 'fr', '3 classes, garderie, maternelle et primaire. De 2 à 9 ans.', '2014-01-19 14:35:35', '2014-01-19 14:35:35'),
(130, 58, 1, 'en', '3 classes, day nursery, nursery and primary. Ages 2 to 9.', '2014-01-19 14:35:35', '2014-01-19 14:35:35'),
(131, 59, 1, 'fr', 'Fondée en 1994, La Maison des Enfants Montessori accueille les enfants de 2ans 1/2 à 6 ans dans un beau cadre de verdure. Une éducation Montessori bilingue anglais/français y est appliquée dans une atmosphère familiale et internationale. L’école a pour but d’aider chaque enfant à développer ses aptitudes dans un environnement stimulant basé sur le respect de ses besoins. C’est une préparation à la vie pour la vie', '2014-01-19 14:37:39', '2014-01-19 14:37:39'),
(132, 59, 1, 'en', 'Established in 1994, The Children’s House Montessori school welcomes 2 1/2 to 6 year olds in a pleasant green setting. Bilingual English/ French Montessori education is offered in a multicultural family atmosphere. The school is organised to meet the children’s needs at each development stage and to provide a warm and secure community environment. It really is a preparation for life!', '2014-01-19 14:37:39', '2014-01-19 14:37:39'),
(133, 60, 1, 'fr', 'L’école accueille les enfants de 3 à 16 ans dans un environnement bilingue anglais-français pourvu de 2 professeurs par classe. Baccaluréat international avec en plus, pour les enfants de 11 à 16 ans le néerlandais et l’allemand. Les enfants reçoivent une approche individualisée, qui stimule la croissance et la responsabilité vis-à-vis de soi et des autres. Chaque enfant dans le Primaire et le Collège joue un instrument de musique. Accent sur un programme d’études intégré, motivation et joie dans l’étude de l’apprentissage. Activités para-scolaires et car de ramassage scolaire disponibles.International Montessori Children’s Centre.', '2014-01-19 14:39:22', '2014-01-19 14:39:22'),
(134, 60, 1, 'en', 'Catering to children aged 3 to 16 years old. Bilingual English-French environments staffed by 2 teachers per classroom. International Baccalaureate Middle School Programme with additional Dutch and German for children aged 11 to 16. Children receive an individualised approach, which stimulates personal growth and responsibility towards self and others. Every child in the Primary and Middle School plays a musical instrument. Emphasis on an integrated curriculum, motivation and joy in learning. School bus and After School Hour programme available.', '2014-01-19 14:39:22', '2014-01-19 14:39:22'),
(135, 61, 1, 'fr', 'De 2 1⁄2 ans à 6 ans. Programmes temps plein et temps partiel disponibles. Enseignement individualisé dans un environnement bilingue anglais/français, basé sur l’estime de soi et l’indépendance. Environnement protégé dans un cadre de verdure. Service de bus porte à porte disponible.', '2014-01-19 14:41:00', '2014-01-19 14:41:00'),
(136, 61, 1, 'en', 'From 2 1⁄2 to 6 years old. Part-time and full-time programmes available. Individualised education in bilingual English/French environments. Emphasis on the development of self esteem and independence. Caring environment with gardens and playground. Door-to-door bus service available.', '2014-01-19 14:41:00', '2014-01-19 14:41:00'),
(137, 62, 1, 'fr', 'Enfants de toute nationalité de 2 1⁄2 à 6 ans. Classes bilingues anglais/français avec deux enseignants par classe. Apprentissage indépendant en petit groupe. Large variété d’activités concrètes permettant aux enfants l’apprentissage de la langue. Options : violon et piano. Equipement intérieur et extérieur pour activités physiques.', '2014-01-19 14:42:25', '2014-01-19 14:42:25'),
(138, 62, 1, 'en', 'Children of all nationalities between the ages of 2 1⁄2 to 6. Attractive bilingual classrooms in English/French with 2 teachers per class. Children learn independently and in small groups. Classrooms offer a large variety of concrete activities helping children to absorb languages and concepts. Optional instruction in violin and piano. Gym and outdoor area for daily physical activities.', '2014-01-19 14:42:25', '2014-01-19 14:42:25'),
(139, 63, 1, 'fr', 'De 2 à 16 ans. Environnement bilingue anglais français dans une ferme historique datant de 1651 et rénovée de manière entièrement écologique. Large plaine de jeux extérieure. Service de bus porte à porte. Possibilité de programme après les heures de classe, jusqu’à 18h.', '2014-01-19 14:43:25', '2014-01-19 14:43:25'),
(140, 63, 1, 'en', 'From 2 to 16 years old. Bilingual English/French environments in a completely ecologically renovated historic farm built in 1651. Large outdoor play area. Door-to-door bus service. After-school programme hours available till 6 pm. International Baccalaureate Middle Year Programme (MYP) offered.', '2014-01-19 14:43:25', '2014-01-19 14:43:25'),
(141, 64, 1, 'fr', 'Ecole primaire bilingue français-anglais à partir de 18 mois.', '2014-01-19 14:44:17', '2014-01-19 14:44:17'),
(142, 64, 1, 'en', 'Bilingual English-French primary school from 18 months.', '2014-01-19 14:44:17', '2014-01-19 14:44:17'),
(143, 65, 1, 'fr', 'Structure pédagogique traditionnelle mais recherche constante de pédagogies nouvelles.', '2014-01-19 14:45:53', '2014-01-19 14:45:53'),
(144, 65, 1, 'en', 'Traditional educational structure, but with a constant search for new teaching methods. Achieves excellent results.', '2014-01-19 14:45:53', '2014-01-19 14:45:53'),
(145, 66, 1, 'fr', '', '2014-01-19 14:46:37', '2014-01-19 14:46:37'),
(146, 66, 1, 'en', '', '2014-01-19 14:46:37', '2014-01-19 14:46:37'),
(147, 67, 1, 'fr', 'De 3 mois à 18 ans.', '2014-01-19 14:47:23', '2014-01-19 14:47:23'),
(148, 67, 1, 'en', 'From 3 months to 18 years old.', '2014-01-19 14:47:23', '2014-01-19 14:47:23'),
(149, 68, 1, 'fr', 'École gardienne et primaire.', '2014-01-19 14:48:02', '2014-01-19 14:48:02'),
(150, 68, 1, 'en', 'Pre-school and primary school.', '2014-01-19 14:48:02', '2014-01-19 14:48:02');

-- --------------------------------------------------------

--
-- Structure de la table `typi_projects`
--

CREATE TABLE IF NOT EXISTS `typi_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Contenu de la table `typi_projects`
--

INSERT INTO `typi_projects` (`id`, `category_id`, `created_at`, `updated_at`) VALUES
(4, 0, '2013-10-28 08:05:08', '2013-10-28 08:05:08'),
(5, 0, '2013-10-28 08:05:14', '2013-10-28 08:05:14'),
(7, 1, '2013-10-28 08:36:25', '2013-10-28 08:36:25'),
(8, 1, '2013-10-28 08:36:32', '2013-10-28 09:18:12'),
(9, 1, '2013-10-28 08:36:58', '2013-10-28 08:36:58'),
(10, 2, '2013-10-28 08:37:13', '2013-10-28 08:37:13'),
(11, 2, '2013-10-28 08:37:18', '2013-10-28 08:37:20'),
(12, 2, '2013-10-28 08:37:24', '2013-10-28 08:37:25'),
(13, 3, '2013-10-28 08:37:40', '2013-10-28 08:37:57'),
(14, 3, '2013-10-28 08:37:44', '2013-10-28 08:37:57'),
(15, 3, '2013-10-28 08:37:50', '2013-10-28 08:37:57'),
(16, 3, '2013-10-28 08:37:55', '2013-10-28 08:37:57'),
(17, 4, '2013-10-28 08:38:16', '2013-10-28 08:38:54'),
(18, 4, '2013-10-28 08:38:21', '2013-10-28 08:38:54'),
(19, 4, '2013-10-28 08:38:34', '2013-10-28 08:38:55'),
(20, 4, '2013-10-28 08:38:52', '2013-10-28 08:38:55');

-- --------------------------------------------------------

--
-- Structure de la table `typi_project_translations`
--

CREATE TABLE IF NOT EXISTS `typi_project_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_translations_project_id_locale_unique` (`project_id`,`locale`),
  KEY `project_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Contenu de la table `typi_project_translations`
--

INSERT INTO `typi_project_translations` (`id`, `project_id`, `locale`, `status`, `title`, `slug`, `summary`, `body`, `created_at`, `updated_at`) VALUES
(19, 7, 'fr', 1, 'Sandales', 'sandales', '', '', '2013-10-28 08:36:25', '2013-10-28 08:36:25'),
(20, 7, 'nl', 0, '', NULL, '', '', '2013-10-28 08:36:25', '2013-10-28 08:36:25'),
(21, 7, 'en', 0, '', NULL, '', '', '2013-10-28 08:36:25', '2013-10-28 08:36:25'),
(22, 8, 'fr', 0, 'Cerf-volant', 'cerf-volant', '', '', '2013-10-28 08:36:32', '2013-10-28 09:18:12'),
(23, 8, 'nl', 0, '', NULL, '', '', '2013-10-28 08:36:32', '2013-10-28 08:36:32'),
(24, 8, 'en', 0, '', NULL, '', '', '2013-10-28 08:36:32', '2013-10-28 08:36:32'),
(25, 9, 'fr', 1, 'Frisbee', 'frisbee', '', '', '2013-10-28 08:36:58', '2013-10-28 08:36:58'),
(26, 9, 'nl', 0, '', NULL, '', '', '2013-10-28 08:36:58', '2013-10-28 08:36:58'),
(27, 9, 'en', 0, '', NULL, '', '', '2013-10-28 08:36:58', '2013-10-28 08:36:58'),
(28, 10, 'fr', 1, 'Rateau', 'rateau', '', '', '2013-10-28 08:37:13', '2013-10-28 08:37:13'),
(29, 10, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:13', '2013-10-28 08:37:13'),
(30, 10, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:13', '2013-10-28 08:37:13'),
(31, 11, 'fr', 1, 'Bottes', 'bottes', '', '', '2013-10-28 08:37:18', '2013-10-28 08:37:20'),
(32, 11, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:18', '2013-10-28 08:37:18'),
(33, 11, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:18', '2013-10-28 08:37:18'),
(34, 12, 'fr', 1, 'Parapluie', 'parapluie', '', '', '2013-10-28 08:37:24', '2013-10-28 08:37:25'),
(35, 12, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:24', '2013-10-28 08:37:24'),
(36, 12, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:24', '2013-10-28 08:37:24'),
(37, 13, 'fr', 1, 'Luge', 'luge', '', '', '2013-10-28 08:37:40', '2013-10-28 08:37:57'),
(38, 13, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:40', '2013-10-28 08:37:40'),
(39, 13, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:40', '2013-10-28 08:37:40'),
(40, 14, 'fr', 1, 'Ski', 'ski', '', '', '2013-10-28 08:37:44', '2013-10-28 08:37:57'),
(41, 14, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:44', '2013-10-28 08:37:44'),
(42, 14, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:44', '2013-10-28 08:37:44'),
(43, 15, 'fr', 1, 'Chasse-neige', 'chasse-neige', '', '', '2013-10-28 08:37:50', '2013-10-28 08:37:57'),
(44, 15, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:50', '2013-10-28 08:37:50'),
(45, 15, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:50', '2013-10-28 08:37:50'),
(46, 16, 'fr', 1, 'Chalet', 'chalet', '', '', '2013-10-28 08:37:55', '2013-10-28 08:37:57'),
(47, 16, 'nl', 0, '', NULL, '', '', '2013-10-28 08:37:55', '2013-10-28 08:37:55'),
(48, 16, 'en', 0, '', NULL, '', '', '2013-10-28 08:37:55', '2013-10-28 08:37:55'),
(49, 17, 'fr', 1, 'Engrais', 'engrais', '', '', '2013-10-28 08:38:16', '2013-10-28 08:38:54'),
(50, 17, 'nl', 0, '', NULL, '', '', '2013-10-28 08:38:16', '2013-10-28 08:38:16'),
(51, 17, 'en', 0, '', NULL, '', '', '2013-10-28 08:38:16', '2013-10-28 08:38:16'),
(52, 18, 'fr', 1, 'Terreau', 'terreau', '', '', '2013-10-28 08:38:21', '2013-10-28 08:38:54'),
(53, 18, 'nl', 0, '', NULL, '', '', '2013-10-28 08:38:21', '2013-10-28 08:38:21'),
(54, 18, 'en', 0, '', NULL, '', '', '2013-10-28 08:38:21', '2013-10-28 08:38:21'),
(55, 19, 'fr', 1, 'Semences', 'semences', '', '', '2013-10-28 08:38:34', '2013-10-28 08:38:55'),
(56, 19, 'nl', 0, '', NULL, '', '', '2013-10-28 08:38:34', '2013-10-28 08:38:34'),
(57, 19, 'en', 0, '', NULL, '', '', '2013-10-28 08:38:34', '2013-10-28 08:38:34'),
(58, 20, 'fr', 1, 'Nichoir', 'nichoir', '', '', '2013-10-28 08:38:52', '2013-10-28 08:38:55'),
(59, 20, 'nl', 0, '', NULL, '', '', '2013-10-28 08:38:52', '2013-10-28 08:38:52'),
(60, 20, 'en', 0, '', NULL, '', '', '2013-10-28 08:38:52', '2013-10-28 08:38:52');

-- --------------------------------------------------------

--
-- Structure de la table `typi_settings`
--

CREATE TABLE IF NOT EXISTS `typi_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `package` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'config',
  `key_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `environment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Contenu de la table `typi_settings`
--

INSERT INTO `typi_settings` (`id`, `package`, `group_name`, `key_name`, `value`, `type`, `environment`, `created_at`, `updated_at`) VALUES
(1, NULL, 'config', 'webmasterEmail', 'info@example.com', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(2, NULL, 'config', 'typekitCode', '', '', NULL, '2013-11-20 19:06:24', '2013-11-20 19:06:24'),
(3, NULL, 'config', 'googleAnalyticsCode', '', '', NULL, '2013-11-20 19:06:24', '2013-11-20 19:06:24'),
(4, NULL, 'config', 'langChooser', '1', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(5, NULL, 'fr', 'websiteTitle', 'Site web sans titre', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(6, NULL, 'fr', 'status', '1', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(7, NULL, 'nl', 'websiteTitle', 'Untitled website', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(8, NULL, 'nl', 'status', '1', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(9, NULL, 'en', 'websiteTitle', 'Untitled website', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(10, NULL, 'en', 'status', '1', '', NULL, '2013-11-20 19:06:24', '2014-03-18 11:48:01'),
(11, NULL, 'config', 'welcomeMessageURL', '', '', NULL, '2014-03-18 11:48:01', '2014-03-18 11:48:01'),
(12, NULL, 'config', 'welcomeMessage', 'Welcome to the administration panel.', '', NULL, '2014-03-18 11:48:01', '2014-03-18 11:48:01'),
(13, NULL, 'config', 'googleAnalyticsUniversalCode', '', '', NULL, '2014-03-18 11:48:01', '2014-03-18 11:48:01'),
(14, NULL, 'config', 'authPublic', NULL, '', NULL, '2014-03-18 11:48:01', '2014-03-18 11:48:01'),
(15, NULL, 'config', 'register', NULL, '', NULL, '2014-03-18 11:48:01', '2014-03-18 11:48:01'),
(16, NULL, 'config', 'adminLocale', 'en', '', NULL, '2014-03-22 11:48:01', '2014-03-22 11:48:01');

-- --------------------------------------------------------

--
-- Structure de la table `typi_taggables`
--

CREATE TABLE IF NOT EXISTS `typi_taggables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) unsigned NOT NULL,
  `taggable_id` int(10) unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `taggables_tag_id_foreign` (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Contenu de la table `typi_taggables`
--

INSERT INTO `typi_taggables` (`id`, `tag_id`, `taggable_id`, `taggable_type`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(2, 2, 11, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(3, 3, 11, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(4, 4, 11, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(5, 5, 15, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:28', '2014-02-27 10:59:28'),
(6, 6, 15, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:28', '2014-02-27 10:59:28'),
(7, 7, 15, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:28', '2014-02-27 10:59:28'),
(8, 8, 17, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:42', '2014-02-27 10:59:42'),
(9, 9, 17, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:42', '2014-02-27 10:59:42'),
(10, 10, 9, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:58', '2014-02-27 10:59:58'),
(11, 11, 9, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:58', '2014-02-27 10:59:58'),
(12, 12, 9, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 10:59:58', '2014-02-27 10:59:58'),
(13, 5, 13, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:13', '2014-02-27 11:00:13'),
(14, 7, 13, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:13', '2014-02-27 11:00:13'),
(15, 13, 13, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:13', '2014-02-27 11:00:13'),
(16, 7, 12, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:26', '2014-02-27 11:00:26'),
(17, 14, 12, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:26', '2014-02-27 11:00:26'),
(18, 15, 12, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:26', '2014-02-27 11:00:26'),
(19, 11, 20, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:52', '2014-02-27 11:00:52'),
(20, 15, 20, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:52', '2014-02-27 11:00:52'),
(21, 16, 20, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:52', '2014-02-27 11:00:52'),
(22, 17, 20, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:52', '2014-02-27 11:00:52'),
(23, 18, 20, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:00:52', '2014-02-27 11:00:52'),
(24, 15, 10, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:08', '2014-02-27 11:01:08'),
(25, 19, 10, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:08', '2014-02-27 11:01:08'),
(26, 20, 10, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:08', '2014-02-27 11:01:08'),
(27, 1, 7, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:20', '2014-02-27 11:01:20'),
(28, 2, 7, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:20', '2014-02-27 11:01:20'),
(29, 11, 7, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:20', '2014-02-27 11:01:20'),
(30, 8, 19, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:34', '2014-02-27 11:01:34'),
(31, 16, 19, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:34', '2014-02-27 11:01:34'),
(32, 21, 19, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:34', '2014-02-27 11:01:34'),
(33, 5, 14, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:52', '2014-02-27 11:01:52'),
(34, 7, 14, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:52', '2014-02-27 11:01:52'),
(35, 13, 14, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:52', '2014-02-27 11:01:52'),
(36, 22, 14, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:52', '2014-02-27 11:01:52'),
(37, 22, 13, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:01:57', '2014-02-27 11:01:57'),
(38, 8, 18, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:02:11', '2014-02-27 11:02:11'),
(39, 16, 18, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:02:11', '2014-02-27 11:02:11'),
(40, 23, 18, 'TypiCMS\\Modules\\Projects\\Models\\Project', '2014-02-27 11:02:11', '2014-02-27 11:02:11');

-- --------------------------------------------------------

--
-- Structure de la table `typi_tags`
--

CREATE TABLE IF NOT EXISTS `typi_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Contenu de la table `typi_tags`
--

INSERT INTO `typi_tags` (`id`, `tag`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'vêtement', 'vetement', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(2, 'pied', 'pied', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(3, 'semelle', 'semelle', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(4, 'chaussette', 'chaussette', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(5, 'neige', 'neige', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(6, 'vehicule', 'vehicule', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(7, 'hiver', 'hiver', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(8, 'plante', 'plante', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(9, 'azote', 'azote', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(10, 'jeu', 'jeu', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(11, 'été', 'ete', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(12, 'plein-air', 'plein-air', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(13, 'glissade', 'glissade', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(14, 'pluie', 'pluie', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(15, 'automne', 'automne', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(16, 'printemps', 'printemps', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(17, 'oiseau', 'oiseau', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(18, 'hivers', 'hivers', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(19, 'feuilles', 'feuilles', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(20, 'jardin', 'jardin', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(21, 'graine', 'graine', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(22, 'pente', 'pente', '2014-02-27 10:58:56', '2014-02-27 10:58:56'),
(23, 'engrais', 'engrais', '2014-02-27 10:58:56', '2014-02-27 10:58:56');

-- --------------------------------------------------------

--
-- Structure de la table `typi_throttle`
--

CREATE TABLE IF NOT EXISTS `typi_throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `typi_translations`
--

CREATE TABLE IF NOT EXISTS `typi_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `typi_translations`
--

INSERT INTO `typi_translations` (`id`, `group`, `key`, `created_at`, `updated_at`) VALUES
(1, 'db', 'More', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(2, 'db', 'Skip to content', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(3, 'db', 'languages.fr', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(4, 'db', 'languages.en', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(5, 'db', 'languages.nl', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(6, 'db', 'Search', '2014-02-28 21:50:19', '2014-02-28 21:50:19');

-- --------------------------------------------------------

--
-- Structure de la table `typi_translation_translations`
--

CREATE TABLE IF NOT EXISTS `typi_translation_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `translation_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `translation` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `translation_translations_translation_id_locale_unique` (`translation_id`,`locale`),
  KEY `translation_translations_locale_index` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Contenu de la table `typi_translation_translations`
--

INSERT INTO `typi_translation_translations` (`id`, `translation_id`, `locale`, `translation`, `created_at`, `updated_at`) VALUES
(1, 1, 'fr', 'En savoir plus', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(2, 1, 'en', 'More', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(3, 1, 'nl', 'Meer', '2014-02-28 21:50:51', '2014-02-28 21:50:51'),
(4, 2, 'fr', 'Aller au contenu', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(5, 2, 'en', 'Skip to content', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(6, 2, 'nl', 'Naar inhoud', '2014-02-28 21:50:51', '2014-02-28 21:50:51'),
(7, 3, 'fr', 'Français', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(8, 3, 'en', 'Français', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(9, 3, 'nl', 'Français', '2014-02-28 21:50:51', '2014-02-28 21:50:51'),
(10, 4, 'fr', 'English', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(11, 4, 'en', 'English', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(12, 4, 'nl', 'English', '2014-02-28 21:50:51', '2014-02-28 21:50:51'),
(13, 5, 'fr', 'Nederlands', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(14, 5, 'en', 'Nederlands', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(15, 5, 'nl', 'Nederlands', '2014-02-28 21:50:51', '2014-02-28 21:50:51'),
(16, 6, 'fr', 'Chercher', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(17, 6, 'en', 'Search', '2014-02-28 21:50:19', '2014-02-28 21:50:19'),
(18, 6, 'nl', 'Zoeken', '2014-02-28 21:50:51', '2014-02-28 21:50:51');

-- --------------------------------------------------------

--
-- Structure de la table `typi_users`
--

CREATE TABLE IF NOT EXISTS `typi_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `typi_users`
--

INSERT INTO `typi_users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'admin@example.com', '$2y$08$ToVNLWrqtLxrUzh7QfawfeRLc3MPM.QsXs2iZ2Xi7OOjq8rnlXMSe', '{"superuser":1}', 1, NULL, NULL, NULL, NULL, NULL, 'Typi', 'Design', '2014-03-28 13:42:39', '2014-03-28 13:42:39');

-- --------------------------------------------------------

--
-- Structure de la table `typi_users_groups`
--

CREATE TABLE IF NOT EXISTS `typi_users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `typi_users_groups`
--

INSERT INTO `typi_users_groups` (`user_id`, `group_id`) VALUES
(1, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `typi_category_translations`
--
ALTER TABLE `typi_category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `typi_categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_event_translations`
--
ALTER TABLE `typi_event_translations`
  ADD CONSTRAINT `event_translations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `typi_events` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_file_translations`
--
ALTER TABLE `typi_file_translations`
  ADD CONSTRAINT `file_translations_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `typi_files` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_menulinks`
--
ALTER TABLE `typi_menulinks`
  ADD CONSTRAINT `menulinks_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `typi_menus` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_menulink_translations`
--
ALTER TABLE `typi_menulink_translations`
  ADD CONSTRAINT `menulink_translations_menulink_id_foreign` FOREIGN KEY (`menulink_id`) REFERENCES `typi_menulinks` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_menu_translations`
--
ALTER TABLE `typi_menu_translations`
  ADD CONSTRAINT `menu_translations_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `typi_menus` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_news_translations`
--
ALTER TABLE `typi_news_translations`
  ADD CONSTRAINT `news_translations_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `typi_news` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_page_translations`
--
ALTER TABLE `typi_page_translations`
  ADD CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `typi_pages` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_place_translations`
--
ALTER TABLE `typi_place_translations`
  ADD CONSTRAINT `place_translations_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `typi_places` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_project_translations`
--
ALTER TABLE `typi_project_translations`
  ADD CONSTRAINT `project_translations_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `typi_projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_taggables`
--
ALTER TABLE `typi_taggables`
  ADD CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `typi_tags` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `typi_translation_translations`
--
ALTER TABLE `typi_translation_translations`
  ADD CONSTRAINT `translation_translations_translation_id_foreign` FOREIGN KEY (`translation_id`) REFERENCES `typi_translations` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
