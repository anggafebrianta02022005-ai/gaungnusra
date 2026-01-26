-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 03:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gaung_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'image_only',
  `position` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `title`, `type`, `position`, `image`, `link`, `is_active`, `created_at`, `updated_at`) VALUES
(9, 'asxaxaasxaxasxa', 'image_only', 'sidebar_right', 'ads/01KF9BMTB98E1WX9VAJCTKSKKB.jpg', NULL, 1, '2026-01-17 11:40:39', '2026-01-18 13:09:50'),
(10, 'asxaxaasxaxasxa', 'image_only', 'header_top', 'ads/01KF9BM5SJ9ZEWWCEMS8DHR1X0.jpg', NULL, 0, '2026-01-17 11:41:01', '2026-01-18 13:13:07'),
(11, 't is a long established fact that a reader will be distracted by the', 'with_link', 'header_top', 'ads/01KF92V7QA7PFYSVNBCMJTQDFG.jpg', 'https://insidelombok.id/', 1, '2026-01-18 10:36:03', '2026-01-18 13:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:4;', 1768921951),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1768921951;', 1768921951),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:2;', 1768498600),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1768498600;', 1768498600),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1768920351),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1768920351;', 1768920351),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:76:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:7:\"view_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"view_any_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"create_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"update_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"restore_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"restore_any_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"replicate_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"reorder_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:9:\"delete_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:13:\"delete_any_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"force_delete_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:19:\"force_delete_any_ad\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"view_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"view_any_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:15:\"create_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"update_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"restore_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:20:\"restore_any_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:18:\"replicate_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:16:\"reorder_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"delete_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:19:\"delete_any_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:21:\"force_delete_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:25:\"force_delete_any_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:9:\"view_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:13:\"view_any_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:11:\"create_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:11:\"update_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:12:\"restore_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:16:\"restore_any_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:14:\"replicate_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"reorder_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:11:\"delete_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:15:\"delete_any_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:17:\"force_delete_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:21:\"force_delete_any_news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:5;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:9:\"view_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:13:\"view_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:11:\"create_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:11:\"update_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:11:\"delete_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:15:\"delete_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:20:\"widget_StatsOverview\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:23:\"widget_LatestNewsWidget\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:22:\"widget_NewsStatusChart\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:16:\"widget_NewsChart\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:46;a:4:{s:1:\"a\";i:243;s:1:\"b\";s:9:\"view_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:47;a:4:{s:1:\"a\";i:244;s:1:\"b\";s:13:\"view_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:48;a:4:{s:1:\"a\";i:245;s:1:\"b\";s:11:\"create_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:49;a:4:{s:1:\"a\";i:246;s:1:\"b\";s:11:\"update_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:50;a:4:{s:1:\"a\";i:247;s:1:\"b\";s:12:\"restore_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:51;a:4:{s:1:\"a\";i:248;s:1:\"b\";s:16:\"restore_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:52;a:4:{s:1:\"a\";i:249;s:1:\"b\";s:14:\"replicate_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:53;a:4:{s:1:\"a\";i:250;s:1:\"b\";s:12:\"reorder_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:54;a:4:{s:1:\"a\";i:251;s:1:\"b\";s:11:\"delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:55;a:4:{s:1:\"a\";i:252;s:1:\"b\";s:15:\"delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:56;a:4:{s:1:\"a\";i:253;s:1:\"b\";s:17:\"force_delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:57;a:4:{s:1:\"a\";i:254;s:1:\"b\";s:21:\"force_delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:58;a:4:{s:1:\"a\";i:255;s:1:\"b\";s:21:\"view_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:59;a:4:{s:1:\"a\";i:256;s:1:\"b\";s:25:\"view_any_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:60;a:4:{s:1:\"a\";i:257;s:1:\"b\";s:23:\"create_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:61;a:4:{s:1:\"a\";i:258;s:1:\"b\";s:23:\"update_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:62;a:4:{s:1:\"a\";i:259;s:1:\"b\";s:24:\"restore_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:63;a:4:{s:1:\"a\";i:260;s:1:\"b\";s:28:\"restore_any_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:64;a:4:{s:1:\"a\";i:261;s:1:\"b\";s:26:\"replicate_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:65;a:4:{s:1:\"a\";i:262;s:1:\"b\";s:24:\"reorder_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:66;a:4:{s:1:\"a\";i:263;s:1:\"b\";s:23:\"delete_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:67;a:4:{s:1:\"a\";i:264;s:1:\"b\";s:27:\"delete_any_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:68;a:4:{s:1:\"a\";i:265;s:1:\"b\";s:29:\"force_delete_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:69;a:4:{s:1:\"a\";i:266;s:1:\"b\";s:33:\"force_delete_any_company::profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:70;a:4:{s:1:\"a\";i:267;s:1:\"b\";s:20:\"view_company_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:71;a:4:{s:1:\"a\";i:268;s:1:\"b\";s:24:\"view_any_company_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:72;a:4:{s:1:\"a\";i:269;s:1:\"b\";s:22:\"create_company_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:73;a:4:{s:1:\"a\";i:270;s:1:\"b\";s:22:\"update_company_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:74;a:4:{s:1:\"a\";i:271;s:1:\"b\";s:22:\"delete_company_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:75;a:4:{s:1:\"a\";i:272;s:1:\"b\";s:26:\"delete_any_company_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:22:\"SuperAdminGaungRedaksi\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}}}', 1768847423);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Politik', 'politik', 1, '2026-01-10 13:01:54', '2026-01-12 21:03:02'),
(2, 'Kriminal', 'kriminal', 1, '2026-01-10 13:24:39', '2026-01-13 00:38:07'),
(4, 'Hukum', 'hukum', 1, '2026-01-13 00:38:43', '2026-01-20 08:10:25'),
(5, 'Sosial', 'sosial', 1, '2026-01-13 00:40:47', '2026-01-13 00:40:47'),
(6, 'Ekonomi', 'ekonomi', 1, '2026-01-13 00:41:20', '2026-01-13 00:41:20'),
(7, 'Kesehatan', 'kesehatan', 1, '2026-01-13 09:15:52', '2026-01-13 09:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `category_news`
--

CREATE TABLE `category_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_news`
--

INSERT INTO `category_news` (`id`, `news_id`, `category_id`) VALUES
(56, 101, 6),
(57, 102, 5),
(58, 103, 6),
(59, 104, 5),
(60, 105, 5),
(61, 106, 1),
(62, 106, 7),
(63, 107, 6),
(64, 108, 7),
(66, 109, 4),
(67, 110, 6),
(68, 111, 5),
(69, 112, 1),
(70, 112, 6),
(72, 113, 4),
(73, 114, 5),
(74, 115, 6),
(75, 101, 4),
(76, 101, 7),
(77, 101, 2),
(78, 101, 5),
(79, 101, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `name`, `description`, `address`, `logo`, `email`, `phone`, `website`, `facebook`, `instagram`, `created_at`, `updated_at`) VALUES
(2, 'Gaung Redaksi', '<p><strong>sdsdsdsdsdsds</strong></p>', 'sdsdsdsd', 'company-logo/01KFBT04Y9V5CVC6E37K0NY53A.png', 'admin@gaung.com', '089765432234', 'https://www.figma.com/site/sdBKkbqDfqWW3fBcAfxbFj/Untitled?node-id=0-1&p=f&t=xhM5kFE2yi6V9pGV-0', 'sdsdsd', 'sdsdsdsd', '2026-01-18 11:47:52', '2026-01-19 11:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_10_190341_create_categories_table', 1),
(5, '2026_01_10_190341_create_news_table', 1),
(6, '2026_01_10_190342_create_ads_table', 1),
(7, '2026_01_10_190342_create_news_category_table', 1),
(8, '2026_01_10_193730_create_permission_tables', 2),
(9, '2026_01_10_203449_add_status_and_views_to_news_table', 3),
(10, '2026_01_11_193704_add_status_to_news_table', 4),
(11, '2026_01_11_194537_add_image_to_news_table', 5),
(12, '2026_01_11_195449_add_details_to_tables', 6),
(13, '2026_01_11_200440_add_name_to_categories_table', 7),
(14, '2026_01_11_200927_fix_ads_table_structure', 8),
(15, '2026_01_13_033910_add_details_images_to_news', 9),
(16, '2026_01_13_062547_fix_category_column_name', 10),
(17, '2026_01_13_080536_create_category_news_tablev', 11),
(18, '2026_01_13_105527_create_notifications_table', 12),
(19, '2026_01_13_174326_add_title_to_ads_table', 13),
(20, '2026_01_13_174533_add_url_link_to_ads_table', 14),
(21, '2026_01_13_183907_add_details_to_ads_table', 15),
(23, '2026_01_14_161916_fix_missing_columns_in_news_table', 16),
(24, '2026_01_14_164204_fix_news_structure_final', 17),
(25, '2026_01_17_174227_change_pinned_to_pin_order_in_news', 18),
(26, '2026_01_17_175826_create_company_profiles_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_code` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `pin_order` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `journalist_code` varchar(255) NOT NULL,
  `views_count` bigint(20) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `news_code`, `title`, `subtitle`, `slug`, `status`, `pin_order`, `content`, `image`, `thumbnail`, `journalist_code`, `views_count`, `user_id`, `created_at`, `updated_at`, `published_at`) VALUES
(101, 'NEWS-101', 'Presiden Resmikan Kawasan Ekonomi Khusus Baru di NTB', 'Proyek ini diharapkan menyerap 50.000 tenaga kerja lokal dalam lima tahun kedepan.', 'presiden-resmikan-kek-baru-ntb', 'published', 1, '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image/jpeg&quot;,&quot;filename&quot;:&quot;Lombok Paradise - Pantai Selong Belanak_ Lombok\'s Gem.jpg&quot;,&quot;filesize&quot;:101386,&quot;height&quot;:1075,&quot;href&quot;:&quot;http://192.168.1.7:8000/storage/news-content/1QqI8p8LE0QnFyzNcLWUEEd1O10zCsG1XriiaBtp.jpg&quot;,&quot;url&quot;:&quot;http://192.168.1.7:8000/storage/news-content/1QqI8p8LE0QnFyzNcLWUEEd1O10zCsG1XriiaBtp.jpg&quot;,&quot;width&quot;:716}\" data-trix-content-type=\"image/jpeg\" data-trix-attributes=\"{&quot;presentation&quot;:&quot;gallery&quot;}\" class=\"attachment attachment--preview attachment--jpg\"><a href=\"http://192.168.1.7:8000/storage/news-content/1QqI8p8LE0QnFyzNcLWUEEd1O10zCsG1XriiaBtp.jpg\"><img src=\"http://192.168.1.7:8000/storage/news-content/1QqI8p8LE0QnFyzNcLWUEEd1O10zCsG1XriiaBtp.jpg\" width=\"716\" height=\"1075\"><figcaption class=\"attachment__caption\"><span class=\"attachment__name\">Lombok Paradise - Pantai Selong Belanak_ Lombok\'s Gem.jpg</span> <span class=\"attachment__size\">99.01 KB</span></figcaption></a></figure></p><h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><br></p><p><br></p>', 'news-main/01KF99DTDVV8NJ60XJAPNX4Z2T.jpg', 'news-thumbnails/01KF99DTDYKCNWSM67K6BWC78J.png', 'ADM', 5483, 1, '2026-01-18 19:29:54', '2026-01-20 10:20:27', '2026-01-18 17:00:00'),
(102, 'NEWS-102', 'Timnas Indonesia Lolos ke Piala Dunia 2026', 'Sejarah baru tercipta, Garuda muda siap terbang tinggi di kancah dunia.', 'timnas-indonesia-lolos-piala-dunia', 'published', 2, '<p>Timnas Indonesia memastikan tiket ke Piala Dunia setelah mengalahkan...</p>', 'news-main/01KF99EYWKA71NPVQ073TMZ11V.jpg', 'news-thumbnails/01KF99EYWN8KJA38X4SY498CAP.jpg', 'ADM', 12506, 1, '2026-01-18 19:29:54', '2026-01-20 09:20:18', '2026-01-18 17:00:00'),
(103, 'NEWS-103', 'Harga Emas Antam Tembus Rekor Tertinggi Sepanjang Masa', 'Kenaikan dipicu oleh ketidakstabilan ekonomi global dan pelemahan nilai tukar.', 'harga-emas-antam-rekor-tertinggi', 'published', 3, '<p>Harga emas batangan PT Aneka Tambang Tbk (Antam) kembali mencetak rekor...</p>', 'news-main/01KF99FW2N3GR8DMREBZYS528H.jpg', 'news-thumbnails/01KF99FW2QP02WDFS6W3A26JZR.jpg', 'ADM', 8902, 1, '2026-01-18 19:29:54', '2026-01-20 09:41:02', '2026-01-18 17:00:00'),
(104, 'NEWS-104', 'Waspada Cuaca Ekstrem: Hujan Lebat Diprediksi Sepekan Kedepan', 'BMKG menghimbau masyarakat pesisir untuk waspada gelombang tinggi.', 'waspada-cuaca-ekstrem-hujan-lebat', 'published', NULL, '<p>Badan Meteorologi Klimatologi dan Geofisika (BMKG) mengeluarkan peringatan dini...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 340, 1, '2026-01-18 19:29:54', '2026-01-18 19:29:54', '2026-01-18 18:29:54'),
(105, 'NEWS-105', 'Festival Kuliner Nusantara Kembali Digelar di Jakarta', 'Menghadirkan lebih dari 200 stand makanan khas dari Sabang sampai Merauke.', 'festival-kuliner-nusantara-jakarta', 'published', NULL, '<p>Pecinta kuliner wajib merapat! Festival Kuliner Nusantara kembali hadir...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 1200, 1, '2026-01-18 19:29:54', '2026-01-18 19:29:54', '2026-01-18 16:29:54'),
(106, 'NEWS-106', 'DPR Sahkan RUU Kesehatan Menjadi Undang-Undang', 'Pengesahan ini diwarnai aksi demonstrasi dari berbagai organisasi profesi.', 'dpr-sahkan-ruu-kesehatan', 'published', NULL, '<p>Dewan Perwakilan Rakyat (DPR) resmi mengesahkan Rancangan Undang-Undang...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 4500, 1, '2026-01-18 19:29:54', '2026-01-18 19:29:54', '2026-01-18 14:29:54'),
(107, 'NEWS-107', 'Startup Teknologi Lokal Raih Pendanaan Seri B', 'Suntikan dana segar sebesar 50 Juta USD akan digunakan untuk ekspansi ke Asia Tenggara.', 'startup-teknologi-raih-pendanaan', 'published', NULL, '<p>Kabar gembira datang dari industri startup tanah air...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 890, 1, '2026-01-18 19:29:54', '2026-01-18 19:29:54', '2026-01-17 19:29:54'),
(108, 'NEWS-108', 'Tips Menjaga Kesehatan Mental di Era Digital', 'Pentingnya detoks media sosial untuk keseimbangan hidup.', 'tips-jaga-kesehatan-mental', 'published', NULL, '<p>Di era serba digital ini, kesehatan mental menjadi isu yang sangat krusial...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 2303, 1, '2026-01-18 19:29:54', '2026-01-20 08:39:38', '2026-01-17 19:29:54'),
(109, 'NEWS-109', 'Polisi Bongkar Sindikat Penipuan Online Internasional', 'Kerugian korban diperkirakan mencapai ratusan miliar rupiah.', 'polisi-bongkar-sindikat-penipuan', 'published', NULL, '<p>Direktorat Tindak Pidana Siber Bareskrim Polri berhasil mengungkap...</p>', 'news-main/01KFDZDEHWMSCWNC318NP2HF2N.jpg', 'news-thumbnails/01KFDZDEHYA6XA0SJQPC7Q5TY0.png', 'ADM', 6700, 1, '2026-01-18 19:29:54', '2026-01-20 08:12:18', '2026-01-16 17:00:00'),
(110, 'NEWS-110', 'Review Smartphone Terbaru: Spesifikasi Gahar Harga Terjangkau', 'Pilihan tepat untuk para gamers dengan budget terbatas.', 'review-smartphone-terbaru', 'published', NULL, '<p>Pasar smartphone mid-range kembali memanas dengan kehadiran...</p>', 'news-main/01KF99J9YNFEVXGZ37T7XPHXKW.jpg', 'news-thumbnails/01KF99J9YQER37EM39V98Y02HX.jpg', 'ADM', 5601, 1, '2026-01-18 19:29:54', '2026-01-20 09:38:52', '2026-01-16 17:00:00'),
(111, 'NEWS-111', 'Wisata Pantai Tersembunyi di Bali yang Wajib Dikunjungi', 'Surga tersembunyi yang belum banyak dijamah wisatawan.', 'wisata-pantai-tersembunyi-bali', 'published', NULL, '<p>Bali tidak pernah kehabisan pesona. Selain Kuta dan Seminyak...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 9100, 1, '2026-01-18 19:29:54', '2026-01-18 19:29:54', '2026-01-15 19:29:54'),
(112, 'NEWS-112', 'Pemerintah Targetkan Swasembada Pangan Tahun Depan', 'Program lumbung pangan nasional akan dipercepat.', 'pemerintah-target-swasembada-pangan', 'published', NULL, '<p>Presiden menegaskan komitmennya untuk mencapai ketahanan pangan...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 1109, 1, '2026-01-18 19:29:54', '2026-01-20 09:58:44', '2026-01-15 19:29:54'),
(113, 'NEWS-113', 'Kasus Korupsi Dana Desa, Mantan Kades Ditahan', 'Pelaku diduga menyelewengkan anggaran pembangunan jalan desa.', 'korupsi-dana-desa-kades-ditahan', 'published', NULL, '<p>Kejaksaan Negeri akhirnya menahan mantan Kepala Desa...</p>', 'news-main/01KFDZC7E7R78K55GEB2EPRHSX.jpg', 'news-thumbnails/01KFDZC7E95X62J5N63TTAQTXS.jpg', 'ADM', 3216, 1, '2026-01-18 19:29:54', '2026-01-20 09:52:20', '2026-01-14 17:00:00'),
(114, 'NEWS-114', 'Tren Fashion 2026: Kembali ke Gaya Retro 90an', 'Celana cutbray dan warna neon kembali mendominasi panggung mode.', 'tren-fashion-retro-90an', 'published', NULL, '<p>Dunia fashion selalu berputar. Tahun ini, gaya retro 90-an...</p>', 'news-main/default.jpg', 'news-thumbnails/default.jpg', 'ADM', 455, 1, '2026-01-18 19:29:54', '2026-01-20 09:44:38', '2026-01-13 19:29:54'),
(115, 'NEWS-115', 'Tutorial Coding Laravel 12 untuk Pemula', 'Panduan lengkap membuat website berita dari nol sampai online.', 'tutorial-laravel-12-pemula', 'published', NULL, '<p>Laravel 12 hadir dengan fitur-fitur baru yang memudahkan developer...</p>', 'news-main/01KF99H8S64B3Z5TENRY31M38R.jpg', 'news-thumbnails/01KF99H8S8KCKPKZZ3TZPX46H8.jpg', 'ADM', 10001, 1, '2026-01-18 19:29:54', '2026-01-20 07:11:36', '2026-01-12 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(2, 'view_any_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(3, 'create_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(4, 'update_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(5, 'restore_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(6, 'restore_any_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(7, 'replicate_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(8, 'reorder_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(9, 'delete_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(10, 'delete_any_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(11, 'force_delete_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(12, 'force_delete_any_ad', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(13, 'view_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(14, 'view_any_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(15, 'create_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(16, 'update_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(17, 'restore_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(18, 'restore_any_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(19, 'replicate_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(20, 'reorder_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(21, 'delete_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(22, 'delete_any_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(23, 'force_delete_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(24, 'force_delete_any_category', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(25, 'view_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(26, 'view_any_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(27, 'create_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(28, 'update_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(29, 'restore_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(30, 'restore_any_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(31, 'replicate_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(32, 'reorder_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(33, 'delete_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(34, 'delete_any_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(35, 'force_delete_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(36, 'force_delete_any_news', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(37, 'view_role', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(38, 'view_any_role', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(39, 'create_role', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(40, 'update_role', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(41, 'delete_role', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(42, 'delete_any_role', 'web', '2026-01-10 12:38:18', '2026-01-10 12:38:18'),
(43, 'widget_StatsOverview', 'web', '2026-01-11 13:21:13', '2026-01-11 13:21:13'),
(44, 'widget_LatestNewsWidget', 'web', '2026-01-11 13:21:13', '2026-01-11 13:21:13'),
(45, 'widget_NewsStatusChart', 'web', '2026-01-11 13:21:13', '2026-01-11 13:21:13'),
(46, 'widget_NewsChart', 'web', '2026-01-11 13:21:14', '2026-01-11 13:21:14'),
(243, 'view_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(244, 'view_any_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(245, 'create_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(246, 'update_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(247, 'restore_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(248, 'restore_any_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(249, 'replicate_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(250, 'reorder_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(251, 'delete_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(252, 'delete_any_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(253, 'force_delete_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(254, 'force_delete_any_user', 'web', '2026-01-13 00:00:19', '2026-01-13 00:00:19'),
(255, 'view_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(256, 'view_any_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(257, 'create_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(258, 'update_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(259, 'restore_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(260, 'restore_any_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(261, 'replicate_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(262, 'reorder_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(263, 'delete_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(264, 'delete_any_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(265, 'force_delete_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(266, 'force_delete_any_company::profile', 'web', '2026-01-17 11:40:08', '2026-01-17 11:40:08'),
(267, 'view_company_profile', 'web', '2026-01-18 18:29:50', '2026-01-18 18:29:50'),
(268, 'view_any_company_profile', 'web', '2026-01-18 18:29:50', '2026-01-18 18:29:50'),
(269, 'create_company_profile', 'web', '2026-01-18 18:29:50', '2026-01-18 18:29:50'),
(270, 'update_company_profile', 'web', '2026-01-18 18:29:50', '2026-01-18 18:29:50'),
(271, 'delete_company_profile', 'web', '2026-01-18 18:29:50', '2026-01-18 18:29:50'),
(272, 'delete_any_company_profile', 'web', '2026-01-18 18:29:50', '2026-01-18 18:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'web', '2026-01-11 13:30:45', '2026-01-11 20:15:45'),
(5, 'SuperAdminGaungRedaksi', 'web', '2026-01-12 23:58:27', '2026-01-12 23:58:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(25, 2),
(25, 5),
(26, 2),
(26, 5),
(27, 2),
(27, 5),
(28, 2),
(28, 5),
(29, 2),
(29, 5),
(30, 2),
(30, 5),
(31, 2),
(31, 5),
(32, 2),
(32, 5),
(33, 2),
(33, 5),
(34, 2),
(34, 5),
(35, 2),
(35, 5),
(36, 2),
(36, 5),
(37, 5),
(38, 5),
(39, 5),
(40, 5),
(41, 5),
(42, 5),
(43, 5),
(44, 5),
(45, 5),
(46, 5),
(243, 5),
(244, 5),
(245, 5),
(246, 5),
(247, 5),
(248, 5),
(249, 5),
(250, 5),
(251, 5),
(252, 5),
(253, 5),
(254, 5),
(255, 5),
(256, 5),
(257, 5),
(258, 5),
(259, 5),
(260, 5),
(261, 5),
(262, 5),
(263, 5),
(264, 5),
(265, 5),
(266, 5),
(267, 5),
(268, 5),
(269, 5),
(270, 5),
(271, 5),
(272, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3AWAY1DOtjRQlRaJaz3y0BlSxtjiu30rP8SeiSpY', NULL, '192.168.1.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRzhjMHZIREFTdHdmTlVORVp5NDlIZjJQaDVOS1hiZ2M4WFI5YW9QYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xOTIuMTY4LjEuNzo4MDAwL2NhdGVnb3J5L2h1a3VtIjtzOjU6InJvdXRlIjtzOjEzOiJjYXRlZ29yeS5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768927277),
('cP9BoIlAtuKOlyHrR05MT7Wt5mOoylUHG68BJndW', 1, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiUzhGTUd5dVNCbHVkdzVZcmNWNFNXUHBqQUFSOUZ0Q3lNTmJBVGZwOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9uZXdzL3ByZXNpZGVuLXJlc21pa2FuLWtlay1iYXJ1LW50YiI7czo1OiJyb3V0ZSI7czo5OiJuZXdzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiNDMwM2RhNjM4MWYyYjRiNTcxZmY1NTljMTc2N2Y2ZDdmMDZlMDI5MDNhZTg5NzczMTdiMDEzNGQ2ZWI0MTg3YiI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1768929448),
('XnA2mmueL4LoPB56idYOs3Q4XlTuiQJwfD7bNF6I', NULL, '192.168.1.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXR0RDA2bm9XZG1qQ1RDVGdKZGFLVVVvNEZFZ0tiRFJUTzQ3TGRKYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xOTIuMTY4LjEuNzo4MDAwL25ld3MvcHJlc2lkZW4tcmVzbWlrYW4ta2VrLWJhcnUtbnRiIjtzOjU6InJvdXRlIjtzOjk6Im5ld3Muc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768929627);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Gaung Redaksi', 'admin@gaung.com', 'admin@gaung.com', NULL, '$2y$12$o2AZ21lsIylyWqdMrhhB3eRqsMKWhILkDQM6gzri12nkI0krsiXtq', 'super_admin', 'sDuVSeyNYm8ReKEj7u6VZiJwu4oP4ClL99j1s4IpWKj88vzVNhi4FHmTOvcT', '2026-01-10 12:19:16', '2026-01-19 10:23:26'),
(2, 'Angga Febrianta', 'admin1@gaung.com', 'admin1@gaung.com', NULL, '$2y$12$QlxS.80soY0DGzvuseo4ZO0a6JNhOvfbecWj/RCdtPdgYjgOjTnMK', 'admin', 'apGahbZv2Y1lQMqYjXTI372gvpZUmYvP0uu3Hwc1Ic6UAi901FU91CUtbJGm', '2026-01-12 20:20:05', '2026-01-12 20:31:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_news`
--
ALTER TABLE `category_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_news_news_id_foreign` (`news_id`),
  ADD KEY `category_news_category_id_foreign` (`category_id`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD UNIQUE KEY `news_news_code_unique` (`news_code`),
  ADD UNIQUE KEY `news_pin_order_unique` (`pin_order`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category_news`
--
ALTER TABLE `category_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_news`
--
ALTER TABLE `category_news`
  ADD CONSTRAINT `category_news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_news_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
