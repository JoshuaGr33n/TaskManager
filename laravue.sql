-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 17, 2022 at 08:38 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravue`
--

-- --------------------------------------------------------

--
-- Table structure for table `astract__messages`
--

DROP TABLE IF EXISTS `astract__messages`;
CREATE TABLE IF NOT EXISTS `astract__messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recepient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `astract__messages`
--

INSERT INTO `astract__messages` (`id`, `title`, `sender`, `recepient`, `message`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Legend', 'jason@gmail.com', 'Admin', 'Since version 1.7, Django counts with the built-in JsonResponse class, which is a subclass of HttpResponse. Its default Content-Type header is set to application/json, which is really convenient. It also comes with a JSON encoder, so you don’t need to serialize the data before returning the response object.', 1, '2022-08-16 12:26:33', '2022-08-17 04:36:33'),
(17, 'GOAT', 'jason@gmail.com', 'Admin', 'gfgfgfgfgfgf', 1, '2022-08-16 14:26:40', '2022-08-17 04:36:12'),
(18, 'Hug', 'Admin', 'jason@gmail.com', 'hghghghghghghghggh', 0, '2022-08-16 14:33:12', '2022-08-17 07:20:36'),
(19, 'Going', 'Admin', 'fred@gmail.com', 'Coming', 0, '2022-08-16 14:33:51', '2022-08-16 14:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `astract__users`
--

DROP TABLE IF EXISTS `astract__users`;
CREATE TABLE IF NOT EXISTS `astract__users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `astract__users`
--

INSERT INTO `astract__users` (`id`, `name`, `phone`, `email`, `password`, `status`, `admin`, `created_at`, `updated_at`) VALUES
(1, 'Carl Brook', '11111111111', 'avksecurity@gmail.com', '$2y$10$qimx.vTxkPf8Iq.OQxBs7eGfwLBiVuAAyX387BDfxNeka9D1U2kri', 1, 1, '2022-08-12 10:40:38', '2022-08-12 10:40:38'),
(5, 'Jason Bond', '22222233333', 'jason@gmail.com', '$2y$10$PtoRikrVu0yn8rfpHvQePeLI7D0zvqRfd.fajBr1hbxA8fSvmVJpq', 1, 0, '2022-08-17 06:22:25', '2022-08-17 06:23:33');

-- --------------------------------------------------------



--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2022_07_11_100735_create_items_table', 1),
(2, '2022_08_11_084433_create_contacts_table', 2),
(4, '2022_08_11_162039_create_astract__users_table', 3),
(5, '2022_08_12_071152_add_status_to_astract__users_table', 4),
(6, '2022_08_12_135819_add_admin_status_to_astract__users_table', 5),
(7, '2022_08_16_093718_astract_messages', 6),
(8, '2022_08_16_101558_astract_messages', 7);

-- --------------------------------------------------------

