-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2026 at 07:41 AM
-- Server version: 11.8.9-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u578748245_xploredatabas`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(191) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(191) DEFAULT NULL,
  `event` varchar(191) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'deleted', 'App\\Models\\Notification', 'deleted', 28, 'App\\Models\\User', 1, '{\"old\":{\"id\":28,\"title\":\"test\",\"short_detail\":\"testing\",\"image\":\"storage\\/notification\\/download-6a4babd321507_953.jpg\",\"status\":\"Active\",\"created_at\":\"2026-07-06T13:21:23.000000Z\",\"updated_at\":\"2026-07-07T06:10:21.000000Z\",\"deleted_at\":\"2026-07-07T06:10:21.000000Z\"}}', NULL, '2026-07-07 11:40:21', '2026-07-07 11:40:21'),
(2, 'default', 'updated', 'App\\Models\\Product', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"stock\":5000,\"updated_at\":\"2026-07-07T07:16:46.000000Z\"},\"old\":{\"stock\":0,\"updated_at\":\"2026-06-30T05:11:17.000000Z\"}}', NULL, '2026-07-07 12:46:46', '2026-07-07 12:46:46'),
(3, 'default', 'updated', 'App\\Models\\Product', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"stock\":8000,\"updated_at\":\"2026-07-07T07:16:57.000000Z\"},\"old\":{\"stock\":2497,\"updated_at\":\"2026-07-02T06:28:31.000000Z\"}}', NULL, '2026-07-07 12:46:57', '2026-07-07 12:46:57'),
(4, 'default', 'updated', 'App\\Models\\CustomerSurvey', 'updated', 34, 'App\\Models\\User', 1, '{\"attributes\":{\"vendor_id\":1,\"status\":\"Ongoing\",\"updated_at\":\"2026-07-07T07:51:59.000000Z\",\"assigned_at\":\"2026-07-07 13:21:59\"},\"old\":{\"vendor_id\":null,\"status\":\"Pending\",\"updated_at\":\"2026-07-07T05:18:26.000000Z\",\"assigned_at\":null}}', NULL, '2026-07-07 13:21:59', '2026-07-07 13:21:59'),
(5, 'default', 'deleted', 'App\\Models\\Customer', 'deleted', 37, 'App\\Models\\User', 1, '{\"old\":{\"id\":37,\"name\":null,\"gender\":null,\"email_id\":null,\"phone_no\":\"7619983029\",\"profile_image\":null,\"otp\":null,\"otp_sent_at\":\"2026-07-06T13:09:18.000000Z\",\"device_type\":\"android\",\"device_id\":\"android\",\"fcm_token\":\"f_y6LybJQfGP05YjLGHo-W:APA91bENLQnNTRtAFII_VikP3LzU-g_8EQJhYhFOVn4B6Zq5ER2dbDDMZp-pFY3o3po6nMRyGVa_0phujZ5ZOPh4Y5bOs-DWREj7z_h6eoi81-b4aFY8Lg4\",\"status\":\"Active\",\"created_at\":\"2026-07-06T13:09:18.000000Z\",\"updated_at\":\"2026-07-07T08:16:01.000000Z\",\"deleted_at\":\"2026-07-07T08:16:01.000000Z\"}}', NULL, '2026-07-07 13:46:01', '2026-07-07 13:46:01'),
(6, 'auth', 'Logged in', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-07 13:59:14', '2026-07-07 13:59:14'),
(7, 'default', 'updated', 'App\\Models\\User', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"remember_token\":\"9qUb2EmJaS44oD0keAxfdeBTLd8zPcBfC11q5ZERUckckggtMQW58o1I6Hvz\"},\"old\":{\"remember_token\":\"RI67e3PG0aAAc58YR281gwzZa4yNX0SPrxM1yJE2fj2xEpzDuePziWn54LnW\"}}', NULL, '2026-07-07 13:59:19', '2026-07-07 13:59:19'),
(8, 'auth', 'Logged out', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-07 13:59:19', '2026-07-07 13:59:19'),
(9, 'auth', 'Logged in', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-07 14:57:47', '2026-07-07 14:57:47'),
(10, 'auth', 'Logged in', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-13 17:07:18', '2026-07-13 17:07:18'),
(11, 'auth', 'Logged in', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-13 18:35:44', '2026-07-13 18:35:44'),
(12, 'default', 'updated', 'App\\Models\\User', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"remember_token\":\"AZsRqguS5dpgTi1ni4pX9P66og1CxgaHMprhY4jpUVnQ6K4h6D6qSvzAlkNR\"},\"old\":{\"remember_token\":\"9qUb2EmJaS44oD0keAxfdeBTLd8zPcBfC11q5ZERUckckggtMQW58o1I6Hvz\"}}', NULL, '2026-07-13 18:36:10', '2026-07-13 18:36:10'),
(13, 'auth', 'Logged out', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-13 18:36:10', '2026-07-13 18:36:10'),
(14, 'auth', 'Logged in', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-13 18:51:47', '2026-07-13 18:51:47'),
(15, 'auth', 'Logged in', NULL, NULL, NULL, 'App\\Models\\User', 1, '[]', NULL, '2026-07-13 18:57:19', '2026-07-13 18:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('xplore-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:67:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"user-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"user-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"user-delete\";s:1:\"c\";s:3:\"web\";}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"role-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"role-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:15:\"permission-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"permission-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:3:{s:1:\"a\";i:53;s:1:\"b\";s:17:\"permission-delete\";s:1:\"c\";s:3:\"web\";}i:9;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:11:\"web-setting\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:10;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:10:\"slider-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:11;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:11:\"slider-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:12;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:13:\"slider-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:13;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:19:\"course-category-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:14;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:20:\"course-category-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:15;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:22:\"course-category-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:16;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:10:\"survey-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:17;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:11:\"survey-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:18;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"survey-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:19;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:10:\"course-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:20;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:11:\"course-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:21;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:13:\"course-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:22;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:17:\"course-lesson-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:23;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:18:\"course-lesson-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:24;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:20:\"course-lesson-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:25;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:18:\"course-content-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:26;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:19:\"course-content-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:27;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:21:\"course-content-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:28;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:16:\"course-topic-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:29;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:17:\"course-topic-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:30;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:19:\"course-topic-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:31;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:7:\"faq-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:32;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:8:\"faq-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:33;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:10:\"faq-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:34;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:16:\"notification-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:35;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:17:\"notification-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:36;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:19:\"notification-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:37;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:18:\"assign-permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:20:\"customer-survey-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:39;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:13:\"customer-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:40;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:21:\"product-category-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:41;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:20:\"product-category-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:42;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:23:\"product-category-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:43;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:27:\"product-sub-category-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:44;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:25:\"product-sub-category-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:45;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:24:\"product-sub-category-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:46;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:20:\"product-brand-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:47;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:18:\"product-brand-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:48;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:17:\"product-brand-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:49;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:11:\"product-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:50;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:12:\"product-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:51;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:14:\"product-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:52;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:9:\"cart-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:53;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:18:\"product-order-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:54;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:12:\"customer-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:55;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:15:\"customer-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:56;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:10:\"vendor-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:57;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:11:\"vendor-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:58;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:13:\"vendor-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:59;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:16:\"transaction-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:60;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:22:\"course-enrollment-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:61;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:15:\"help-query-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:62;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:17:\"help-query-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:63;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:10:\"order-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:64;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:12:\"activity-log\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:7:\"cms-add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:66;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:8:\"cms-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"Manager\";s:1:\"c\";s:3:\"web\";}}}', 1784029039);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2026-07-01 15:48:55', '2026-07-01 15:48:55', NULL),
(2, 19, '2026-07-02 10:58:03', '2026-07-02 10:58:03', NULL),
(3, 22, '2026-07-04 18:43:48', '2026-07-04 18:43:48', NULL),
(4, 25, '2026-07-06 12:03:24', '2026-07-06 12:03:24', NULL),
(5, 32, '2026-07-06 16:24:11', '2026-07-06 16:24:11', NULL),
(6, 34, '2026-07-06 16:32:42', '2026-07-06 16:32:42', NULL),
(7, 35, '2026-07-06 16:47:11', '2026-07-06 16:47:11', NULL),
(8, 36, '2026-07-06 18:16:35', '2026-07-06 18:16:35', NULL),
(9, 38, '2026-07-23 13:11:42', '2026-07-23 13:11:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `variant_name` varchar(191) DEFAULT NULL,
  `category_name` varchar(191) DEFAULT NULL,
  `sub_category_name` varchar(191) DEFAULT NULL,
  `brand_name` varchar(191) DEFAULT NULL,
  `mrp_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `line_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `variant_id`, `product_name`, `variant_name`, `category_name`, `sub_category_name`, `brand_name`, `mrp_price`, `sale_price`, `quantity`, `line_total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 4, 8, 'AAC Bricks', '600x200x150 mm', 'Bricks', 'AAC Blocks', 'Wienerberger', 75.00, 70.00, 1, 70.00, '2026-07-06 12:03:32', '2026-07-06 12:03:32', NULL),
(2, 2, 4, 7, 'AAC Bricks', '600x200x100 mm', 'Bricks', 'AAC Blocks', 'Wienerberger', 55.00, 50.00, 1, 50.00, '2026-07-06 12:05:40', '2026-07-06 12:05:48', '2026-07-06 12:05:48'),
(3, 1, 4, 7, 'AAC Bricks', '600x200x100 mm', 'Bricks', 'AAC Blocks', 'Wienerberger', 55.00, 50.00, 1, 50.00, '2026-07-06 13:48:00', '2026-07-06 15:12:02', '2026-07-06 15:12:02'),
(4, 1, 4, 8, 'AAC Bricks', '600x200x150 mm', 'Bricks', 'AAC Blocks', 'Wienerberger', 75.00, 70.00, 1, 70.00, '2026-07-06 13:51:55', '2026-07-06 15:11:59', '2026-07-06 15:11:59'),
(5, 1, 5, 9, 'Concrete Bricks', 'Solid Concrete', 'Bricks', 'Concrete Blocks', 'Bharat Bricks', 18.00, 16.00, 4, 64.00, '2026-07-06 15:11:20', '2026-07-06 15:11:45', '2026-07-06 15:11:45'),
(6, 1, 5, 9, 'Concrete Bricks', 'Solid Concrete', 'Bricks', 'Concrete Blocks', 'Bharat Bricks', 18.00, 16.00, 10, 160.00, '2026-07-06 15:11:47', '2026-07-06 15:12:00', '2026-07-06 15:12:00'),
(7, 1, 5, 10, 'Concrete Bricks', 'Heavy Duty', 'Bricks', 'Concrete Blocks', 'Bharat Bricks', 22.00, 20.00, 4, 80.00, '2026-07-06 15:12:11', '2026-07-06 15:13:04', '2026-07-06 15:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pagename` enum('privacy_policy','terms_conditions','about_us','contact_us') NOT NULL,
  `heading` varchar(191) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `pagename`, `heading`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'privacy_policy', 'Privacy Policy', '<p>At <strong>Xplore Mapping Services</strong>, we are committed to protecting your privacy and safeguarding the information you share with us. This Privacy Policy explains how we collect, use, store, process, and protect your personal and business information when you use our services, products, software, applications, or communicate with us.</p>\r\n\r\n<h2>1. Information We Collect</h2>\r\n\r\n<p>We may collect information including, but not limited to:</p>\r\n\r\n<ul>\r\n	<li>Name, company name, and professional details.</li>\r\n	<li>Email address and other communication information.</li>\r\n	<li>Billing and transaction information.</li>\r\n	<li>Project-related documents, datasets, maps, images, drawings, GIS files, CAD files, survey data, and associated materials.</li>\r\n	<li>Technical information such as browser type, operating system, device information, IP address, and usage statistics.</li>\r\n	<li>Information voluntarily submitted through forms, emails, customer support, or business communications.</li>\r\n</ul>\r\n\r\n<h2>2. How We Use Your Information</h2>\r\n\r\n<p>Your information may be used for the following purposes:</p>\r\n\r\n<ul>\r\n	<li>Providing mapping, GIS, surveying, engineering, spatial analysis, and related professional services.</li>\r\n	<li>Managing customer accounts and business relationships.</li>\r\n	<li>Processing quotations, invoices, payments, and contracts.</li>\r\n	<li>Responding to inquiries and providing customer support.</li>\r\n	<li>Improving our products, services, software, and user experience.</li>\r\n	<li>Maintaining service quality, operational efficiency, and internal record keeping.</li>\r\n	<li>Detecting, preventing, and investigating fraud, unauthorized access, or misuse.</li>\r\n	<li>Complying with applicable legal, regulatory, contractual, and professional obligations.</li>\r\n</ul>\r\n\r\n<h2>3. Project Data Confidentiality</h2>\r\n\r\n<p>We recognize that mapping projects, survey information, engineering drawings, GIS databases, and client documents may contain confidential or proprietary information. All reasonable administrative, technical, and organizational safeguards are implemented to protect such information from unauthorized access, disclosure, alteration, or destruction.</p>\r\n\r\n<p>Project data remains confidential and is accessed only by authorized personnel or approved service providers who require such access to perform assigned responsibilities.</p>\r\n\r\n<h2>4. Information Sharing</h2>\r\n\r\n<p>We do not sell, rent, lease, or trade personal information or confidential project data to third parties.</p>\r\n\r\n<p>Information may be shared only under the following circumstances:</p>\r\n\r\n<ul>\r\n	<li>With trusted business partners, contractors, or service providers working on our behalf under confidentiality obligations.</li>\r\n	<li>To comply with legal requirements, judicial proceedings, or lawful governmental requests.</li>\r\n	<li>To protect our legal rights, business interests, intellectual property, customers, or the public.</li>\r\n	<li>During business restructuring, mergers, acquisitions, or asset transfers, subject to appropriate confidentiality protections.</li>\r\n</ul>\r\n\r\n<h2>5. Data Security</h2>\r\n\r\n<p>We maintain commercially reasonable administrative, physical, and technical security measures designed to protect personal information and project-related data against unauthorized access, misuse, disclosure, alteration, or accidental loss.</p>\r\n\r\n<p>These measures may include access controls, authentication procedures, secure storage, encryption where appropriate, regular monitoring, and internal security practices.</p>\r\n\r\n<p>While every reasonable effort is made to safeguard information, no electronic transmission or storage system can be guaranteed to be completely secure.</p>\r\n\r\n<h2>6. Data Retention</h2>\r\n\r\n<p>Information is retained only for as long as necessary to fulfill legitimate business purposes, contractual obligations, legal requirements, dispute resolution, auditing, recordkeeping, or enforcement of agreements.</p>\r\n\r\n<p>When information is no longer required, it is securely deleted, anonymized, or destroyed using appropriate methods.</p>\r\n\r\n<h2>7. Cookies and Similar Technologies</h2>\r\n\r\n<p>Our digital platforms may use cookies, analytics tools, and similar technologies to enhance functionality, improve user experience, analyze usage patterns, maintain security, and optimize performance.</p>\r\n\r\n<p>Users may manage browser settings to refuse or delete cookies; however, certain features may not function properly if cookies are disabled.</p>\r\n\r\n<h2>8. Third-Party Services</h2>\r\n\r\n<p>Our services may integrate with or rely upon third-party platforms, cloud infrastructure, software providers, mapping services, payment processors, or analytics providers. These third parties operate under their own privacy practices, and we encourage users to review their respective privacy policies.</p>\r\n\r\n<h2>9. User Rights</h2>\r\n\r\n<p>Subject to applicable laws, users may have the right to:</p>\r\n\r\n<ul>\r\n	<li>Request access to personal information.</li>\r\n	<li>Request correction of inaccurate information.</li>\r\n	<li>Request deletion of eligible information.</li>\r\n	<li>Request restriction of certain processing activities.</li>\r\n	<li>Object to processing where legally permitted.</li>\r\n	<li>Request a copy of information where applicable.</li>\r\n	<li>Withdraw consent where processing is based on consent.</li>\r\n</ul>\r\n\r\n<p>Requests will be handled in accordance with applicable legal and regulatory requirements.</p>\r\n\r\n<h2>10. Intellectual Property Protection</h2>\r\n\r\n<p>Any maps, GIS databases, engineering drawings, survey outputs, reports, documentation, software, graphics, methodologies, templates, and other materials developed by Xplore Mapping Services remain protected under applicable intellectual property laws unless ownership is transferred through a separate written agreement.</p>\r\n\r\n<h2>11. Children&#39;s Privacy</h2>\r\n\r\n<p>Our services are intended for businesses, professionals, institutions, and individuals capable of entering legally binding agreements. We do not knowingly collect personal information from children. If such information is identified, reasonable steps will be taken to remove it.</p>\r\n\r\n<h2>12. International Data Processing</h2>\r\n\r\n<p>Information may be processed, stored, or accessed in jurisdictions where our employees, contractors, technology providers, or cloud infrastructure operate. Appropriate safeguards are implemented to protect information regardless of processing location.</p>\r\n\r\n<h2>13. Compliance</h2>\r\n\r\n<p>We strive to comply with applicable privacy, data protection, cybersecurity, intellectual property, and information security laws and regulations governing the jurisdictions in which we conduct business.</p>\r\n\r\n<h2>14. Limitation of Liability</h2>\r\n\r\n<p>While Xplore Mapping Services implements reasonable security measures and operational safeguards, we cannot guarantee absolute protection against all cyber threats, system failures, unauthorized access, or unforeseen circumstances beyond our reasonable control.</p>\r\n\r\n<h2>15. Changes to this Privacy Policy</h2>\r\n\r\n<p>We reserve the right to modify, update, or revise this Privacy Policy at any time to reflect changes in our business operations, services, legal requirements, technology, or industry standards. Continued use of our services constitutes acceptance of the updated Privacy Policy.</p>\r\n\r\n<h2>16. Contact and Privacy Requests</h2>\r\n\r\n<p>Questions, requests relating to privacy, data protection, confidentiality, or the handling of personal information may be submitted through our official communication channels made available by Xplore Mapping Services.</p>', 'Active', '2026-07-04 07:12:47', '2026-07-04 07:13:37'),
(2, 'terms_conditions', 'Terms & Conditions', '<p>Welcome to <strong>Xplore Mapping Services</strong>. These Terms &amp; Conditions govern the use of our products, services, software, applications, reports, maps, GIS solutions, surveying services, engineering solutions, and all related deliverables. By engaging our services or accessing our products, you acknowledge that you have read, understood, and agreed to these Terms &amp; Conditions.</p>\r\n\r\n<h2>1. Acceptance of Terms</h2>\r\n\r\n<p>By requesting, purchasing, accessing, or using any service provided by Xplore Mapping Services, you agree to comply with these Terms &amp; Conditions and all applicable laws and regulations.</p>\r\n\r\n<h2>2. Scope of Services</h2>\r\n\r\n<p>Xplore Mapping Services provides professional services including, but not limited to:</p>\r\n\r\n<ul>\r\n	<li>GIS Mapping and Spatial Analysis</li>\r\n	<li>Surveying and Geospatial Services</li>\r\n	<li>Digital Mapping Solutions</li>\r\n	<li>CAD Drafting and Engineering Support</li>\r\n	<li>Drone and Remote Sensing Data Processing</li>\r\n	<li>Data Conversion and Digitization</li>\r\n	<li>Custom Software and Technical Solutions</li>\r\n	<li>Consulting and Project-Based Services</li>\r\n</ul>\r\n\r\n<p>The exact scope of work shall be defined in the quotation, proposal, work order, agreement, or invoice issued for each project.</p>\r\n\r\n<h2>3. Client Responsibilities</h2>\r\n\r\n<p>The client agrees to:</p>\r\n\r\n<ul>\r\n	<li>Provide complete, accurate, and lawful project information.</li>\r\n	<li>Supply all required documents, datasets, drawings, and approvals necessary for project execution.</li>\r\n	<li>Review deliverables within a reasonable period.</li>\r\n	<li>Provide timely feedback and approvals.</li>\r\n	<li>Ensure that all submitted content does not violate any third-party rights or applicable laws.</li>\r\n</ul>\r\n\r\n<h2>4. Pricing and Payments</h2>\r\n\r\n<ul>\r\n	<li>All pricing is based on the approved quotation or agreement.</li>\r\n	<li>Applicable taxes, including GST, shall be charged as required by law.</li>\r\n	<li>Payments must be made according to the agreed payment schedule.</li>\r\n	<li>Delayed payments may result in suspension of ongoing work until outstanding amounts are cleared.</li>\r\n	<li>Additional work beyond the agreed scope may incur additional charges.</li>\r\n</ul>\r\n\r\n<h2>5. Project Changes</h2>\r\n\r\n<p>Any request for modifications, additional features, revised specifications, or scope expansion after project approval may require revised pricing, additional time, and a separate agreement.</p>\r\n\r\n<h2>6. Delivery</h2>\r\n\r\n<p>Estimated delivery timelines are based on the availability of required information, approvals, and timely client cooperation. Delivery schedules may change due to technical, operational, regulatory, or unforeseen circumstances beyond reasonable control.</p>\r\n\r\n<h2>7. Intellectual Property</h2>\r\n\r\n<p>Unless otherwise agreed in writing, all methodologies, software, templates, GIS models, source code, documentation, workflows, designs, and proprietary technologies developed by Xplore Mapping Services remain our exclusive intellectual property.</p>\r\n\r\n<p>Ownership of final project deliverables will transfer only after full payment has been received, unless otherwise specified in a written agreement.</p>\r\n\r\n<h2>8. License of Use</h2>\r\n\r\n<p>Clients receive a limited, non-exclusive, non-transferable license to use delivered materials solely for their intended business or project purposes. Clients shall not reproduce, distribute, modify, sublicense, or commercially exploit our proprietary materials without prior written permission.</p>\r\n\r\n<h2>9. Confidentiality</h2>\r\n\r\n<p>Both parties agree to maintain the confidentiality of all business information, technical documents, project data, pricing, trade secrets, and proprietary information shared during the course of the engagement unless disclosure is required by applicable law.</p>\r\n\r\n<h2>10. Data Accuracy</h2>\r\n\r\n<p>Project outputs are prepared using information, datasets, and materials provided by the client or obtained from available sources. While reasonable professional standards are followed, Xplore Mapping Services does not guarantee absolute accuracy where underlying source data contains errors, omissions, or limitations.</p>\r\n\r\n<h2>11. Third-Party Services</h2>\r\n\r\n<p>Certain services may involve third-party software, APIs, cloud platforms, mapping providers, satellite imagery, payment processors, or external service providers. Their respective terms and policies shall also apply where relevant.</p>\r\n\r\n<h2>12. Prohibited Use</h2>\r\n\r\n<p>Clients shall not use our services or deliverables for:</p>\r\n\r\n<ul>\r\n	<li>Illegal or fraudulent activities.</li>\r\n	<li>Violation of intellectual property rights.</li>\r\n	<li>Unauthorized surveillance or unlawful data collection.</li>\r\n	<li>Distribution of malicious software.</li>\r\n	<li>Activities that violate applicable laws or regulations.</li>\r\n</ul>\r\n\r\n<h2>13. Warranty Disclaimer</h2>\r\n\r\n<p>All services and deliverables are provided on an &quot;as available&quot; and &quot;as delivered&quot; basis unless expressly stated otherwise in a written agreement. No warranties, express or implied, including merchantability, fitness for a particular purpose, or uninterrupted availability, are provided except where required by law.</p>\r\n\r\n<h2>14. Limitation of Liability</h2>\r\n\r\n<p>To the maximum extent permitted by applicable law, Xplore Mapping Services shall not be liable for any indirect, incidental, special, consequential, punitive, or business losses, including loss of profits, revenue, goodwill, business opportunities, or data arising from the use of our products or services.</p>\r\n\r\n<p>Our total liability, if any, shall not exceed the amount actually paid by the client for the specific service giving rise to the claim.</p>\r\n\r\n<h2>15. Indemnification</h2>\r\n\r\n<p>The client agrees to indemnify and hold harmless Xplore Mapping Services, its employees, consultants, contractors, and representatives from any claims, damages, liabilities, costs, or expenses arising from the client&#39;s misuse of services, inaccurate information provided, or violation of these Terms &amp; Conditions.</p>\r\n\r\n<h2>16. Suspension or Termination</h2>\r\n\r\n<p>We reserve the right to suspend, refuse, or terminate services without prior notice where there is non-payment, misuse of services, breach of contract, fraudulent activity, legal violations, or conduct that may adversely affect our business operations or reputation.</p>\r\n\r\n<h2>17. Force Majeure</h2>\r\n\r\n<p>Xplore Mapping Services shall not be responsible for delays or failure to perform obligations resulting from events beyond reasonable control, including natural disasters, cyber incidents, government actions, internet outages, labor disputes, pandemics, or other force majeure events.</p>\r\n\r\n<h2>18. Governing Law</h2>\r\n\r\n<p>These Terms &amp; Conditions shall be governed and interpreted in accordance with the applicable laws of the jurisdiction in which Xplore Mapping Services operates.</p>\r\n\r\n<h2>19. Severability</h2>\r\n\r\n<p>If any provision of these Terms &amp; Conditions is determined to be invalid or unenforceable, the remaining provisions shall continue in full force and effect.</p>\r\n\r\n<h2>20. Entire Agreement</h2>\r\n\r\n<p>These Terms &amp; Conditions, together with any quotation, proposal, invoice, purchase order, service agreement, or written contract, constitute the complete understanding between the client and Xplore Mapping Services regarding the services provided.</p>\r\n\r\n<h2>21. Amendments</h2>\r\n\r\n<p>Xplore Mapping Services reserves the right to revise, update, or modify these Terms &amp; Conditions at any time. Continued use of our products or services constitutes acceptance of the updated Terms &amp; Conditions.</p>', 'Active', '2026-07-04 07:14:32', '2026-07-04 07:14:32'),
(3, 'about_us', 'About Us', '<p><strong>Xplore Mapping Services</strong> is a trusted provider of innovative geospatial, mapping, surveying, engineering, and digital technology solutions. We are dedicated to delivering high-quality services that help businesses, government organizations, utilities, infrastructure developers, and institutions make informed decisions through accurate spatial data and advanced mapping technologies.</p>\r\n\r\n<p>Our mission is to transform complex geographical and technical information into reliable, efficient, and user-friendly solutions. By combining industry expertise with modern technology, we deliver precise, scalable, and cost-effective services tailored to the unique requirements of every client.</p>\r\n\r\n<h2>Our Expertise</h2>\r\n\r\n<p>We offer a comprehensive range of professional services, including:</p>\r\n\r\n<ul>\r\n	<li>Geographic Information System (GIS) Solutions</li>\r\n	<li>Digital Mapping and Cartography</li>\r\n	<li>Land Survey Data Processing</li>\r\n	<li>CAD Drafting and Engineering Support</li>\r\n	<li>Utility and Asset Mapping</li>\r\n	<li>Spatial Data Analysis and Visualization</li>\r\n	<li>Remote Sensing and Drone Data Processing</li>\r\n	<li>Data Conversion and Digitization</li>\r\n	<li>Custom GIS and Web Mapping Applications</li>\r\n	<li>Technical Consulting and Project Management</li>\r\n</ul>\r\n\r\n<h2>Our Commitment</h2>\r\n\r\n<p>At Xplore Mapping Services, quality, accuracy, and client satisfaction are at the core of everything we do. Every project is executed with a strong focus on precision, innovation, confidentiality, and timely delivery. We continuously adopt modern tools, industry best practices, and advanced technologies to ensure that our clients receive dependable and future-ready solutions.</p>\r\n\r\n<h2>Why Choose Us</h2>\r\n\r\n<ul>\r\n	<li>Experienced and skilled professionals.</li>\r\n	<li>Accurate, reliable, and high-quality deliverables.</li>\r\n	<li>Customized solutions designed for diverse industries.</li>\r\n	<li>Commitment to data security and confidentiality.</li>\r\n	<li>Modern GIS, CAD, and geospatial technologies.</li>\r\n	<li>Transparent communication and professional support.</li>\r\n	<li>Scalable services for projects of every size.</li>\r\n	<li>Timely project execution and customer-focused approach.</li>\r\n</ul>\r\n\r\n<h2>Our Vision</h2>\r\n\r\n<p>Our vision is to become a leading provider of geospatial and digital mapping solutions by delivering innovative, sustainable, and technology-driven services that empower organizations to make smarter decisions and build better infrastructure.</p>\r\n\r\n<h2>Our Mission</h2>\r\n\r\n<p>Our mission is to provide reliable, efficient, and value-driven mapping and geospatial solutions while maintaining the highest standards of professionalism, integrity, innovation, and customer satisfaction.</p>\r\n\r\n<h2>Industries We Serve</h2>\r\n\r\n<ul>\r\n	<li>Government and Public Sector</li>\r\n	<li>Infrastructure and Construction</li>\r\n	<li>Engineering and Consulting Firms</li>\r\n	<li>Utilities and Energy</li>\r\n	<li>Telecommunications</li>\r\n	<li>Real Estate and Land Development</li>\r\n	<li>Agriculture and Environmental Management</li>\r\n	<li>Transportation and Logistics</li>\r\n	<li>Educational and Research Institutions</li>\r\n	<li>Private Enterprises and Startups</li>\r\n</ul>\r\n\r\n<h2>Our Values</h2>\r\n\r\n<ul>\r\n	<li>Integrity in every project.</li>\r\n	<li>Commitment to excellence.</li>\r\n	<li>Innovation through technology.</li>\r\n	<li>Customer-first approach.</li>\r\n	<li>Continuous learning and improvement.</li>\r\n	<li>Respect for confidentiality and data security.</li>\r\n</ul>\r\n\r\n<p>At <strong>Xplore Mapping Services</strong>, we believe that accurate spatial information creates better decisions, stronger businesses, and smarter communities. We are committed to building long-term partnerships by delivering dependable services, innovative solutions, and exceptional value to every client we serve.</p>', 'Active', '2026-07-04 07:15:04', '2026-07-04 07:15:04'),
(4, 'contact_us', 'Contact Us', '<p>Thank you for your interest in <strong>Xplore Mapping Services</strong>. We value every inquiry and are committed to providing prompt, professional, and reliable assistance. Whether you have questions about our services, need a customized solution, request a quotation, or require technical support, our team is here to help.</p>\r\n\r\n<h2>How We Can Help</h2>\r\n\r\n<p>Our team is available to assist you with:</p>\r\n\r\n<ul>\r\n	<li>General inquiries about our services.</li>\r\n	<li>Project consultations and technical discussions.</li>\r\n	<li>GIS, mapping, surveying, and engineering solutions.</li>\r\n	<li>Custom software and web mapping development.</li>\r\n	<li>Quotation and proposal requests.</li>\r\n	<li>Billing and invoice-related questions.</li>\r\n	<li>Technical support and service assistance.</li>\r\n	<li>Business partnerships and collaboration opportunities.</li>\r\n</ul>\r\n\r\n<h2>Customer Support</h2>\r\n\r\n<p>Our support team is dedicated to responding to inquiries as quickly as possible. We strive to provide accurate information, professional guidance, and effective solutions to ensure a smooth and satisfactory experience for every client.</p>\r\n\r\n<h2>Project Inquiries</h2>\r\n\r\n<p>If you are planning a new project, our experts can help you determine the most suitable mapping, GIS, surveying, engineering, or digital solution based on your specific requirements. We work closely with clients to understand project objectives and deliver tailored solutions that meet technical and business needs.</p>\r\n\r\n<h2>Business Collaboration</h2>\r\n\r\n<p>We welcome opportunities to collaborate with businesses, consultants, government organizations, educational institutions, infrastructure developers, and technology partners. We believe in building long-term relationships based on trust, innovation, and mutual success.</p>\r\n\r\n<h2>Response Commitment</h2>\r\n\r\n<p>Every inquiry received through our official communication channels is handled with professionalism and confidentiality. We aim to respond promptly and provide clear, helpful, and reliable information regarding your request.</p>\r\n\r\n<h2>Privacy and Confidentiality</h2>\r\n\r\n<p>Any information you share with Xplore Mapping Services is handled responsibly and in accordance with our Privacy Policy. Project details, business information, and personal data are treated as confidential and are used only for the purpose of responding to your inquiry or delivering our services.</p>\r\n\r\n<h2>We&#39;re Ready to Assist</h2>\r\n\r\n<p>Whether you require expert geospatial solutions, mapping services, GIS consulting, engineering support, technical guidance, or project assistance, <strong>Xplore Mapping Services</strong> is committed to delivering professional service, innovative solutions, and exceptional customer support.</p>\r\n\r\n<p>We look forward to working with you and helping you achieve your project goals through reliable, accurate, and technology-driven mapping solutions.</p>', 'Active', '2026-07-04 07:16:35', '2026-07-04 07:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_name` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `short_detail` text DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_category_id`, `course_name`, `image`, `short_detail`, `duration`, `amount`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 'Land Surveying Basics', 'storage/course/download-6a3636f0842-6a44e23e1961d_717.png', 'Land measurement and surveying fundamentals.', '2 Months', 10000.00, 'Active', '2026-06-12 06:12:23', '2026-07-01 15:17:42', NULL),
(7, 2, 'GIS Fundamentals', 'storage/course/download-13-6a36367b-6a44e24d2f818_741.png', 'Introduction to GIS and spatial data.', '2 Months', 10000.00, 'Active', '2026-06-12 06:12:23', '2026-07-01 15:17:57', NULL),
(12, 3, 'Drone Pilot Training', 'storage/course/download-1-6a3634b15-6a44e2497d822_851.png', 'Basic drone flying and regulations.', '1 Month', 20000.00, 'Active', '2026-06-12 06:12:23', '2026-07-01 15:17:53', NULL),
(20, 4, 'BIM Coordination and Clash Detection', 'storage/course/download-9-6a3635787-6a44e245abad3_987.png', 'BIM coordination using Navisworks.', '1.5 Months', 14000.00, 'Active', '2026-06-12 06:12:23', '2026-07-01 15:17:49', NULL),
(21, 4, 'Advanced BIM Project Management', 'storage/course/download-6a3634731e3-6a44e241e26c1_957.png', 'Manage BIM projects professionally.', '3 Months', 25000.00, 'Active', '2026-06-12 06:12:23', '2026-07-01 15:17:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Surveying', 'Active', '2026-06-12 06:09:09', '2026-06-12 06:09:09', NULL),
(2, 'GIS', 'Active', '2026-06-12 06:09:16', '2026-06-12 06:09:16', NULL),
(3, 'Drone', 'Active', '2026-06-12 06:09:21', '2026-06-12 06:09:21', NULL),
(4, 'CAD/BIM', 'Active', '2026-06-12 06:09:29', '2026-07-04 15:18:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_contents`
--

CREATE TABLE `course_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('PDF','Video') NOT NULL,
  `name` varchar(191) NOT NULL,
  `pdf` varchar(191) DEFAULT NULL,
  `video_id` varchar(255) DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_contents`
--

INSERT INTO `course_contents` (`id`, `topic_id`, `type`, `name`, `pdf`, `video_id`, `priority`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Video', 'What is RAG ? | Completely Explained in 15 Minutes', NULL, 'Ty8gcCKuwNI', 1, 'Active', '2026-06-12 07:56:02', '2026-06-12 08:17:27', NULL),
(3, 2, 'Video', 'What is CI/CD Pipeline? | Simply Explained by Shradha Ma\'am', NULL, 'gLptmcuCx6Q', 2, 'Active', '2026-06-12 08:19:15', '2026-06-12 08:19:15', NULL),
(4, 2, 'Video', 'How To Find High Paying Jobs With AI', NULL, 'O-QuTU8LlGo', 3, 'Active', '2026-06-12 08:19:38', '2026-06-12 08:19:38', NULL),
(5, 2, 'Video', '5 Secret Ways Students Can Make Money Online in 2026', NULL, 'bwRfrQwVk-c', 3, 'Active', '2026-06-12 08:19:56', '2026-06-12 08:19:56', NULL),
(6, 2, 'Video', 'Create Your FIRST AI Agent Today !', NULL, '9LcouXH_O6g', 4, 'Active', '2026-06-12 08:20:16', '2026-06-12 08:20:16', NULL),
(7, 2, 'Video', 'Docker Vs Kubernetes | What is Docker ? | What is Kubernetes ?', NULL, 'oyjGMFzKgVQ', 6, 'Active', '2026-06-12 08:20:35', '2026-06-12 08:20:35', NULL),
(8, 2, 'PDF', 'MCP Explained for Beginners | MCP Client, MCP Server, JSON-RPC & Architecture', 'storage/course-content/blank-6a2bc210dab37_665.pdf', NULL, 1, 'Active', '2026-06-12 08:23:44', '2026-06-12 08:23:44', NULL),
(9, 2, 'PDF', 'Model Context Protocol (MCP) Explained for Beginners: AI Flight Booking Demo!', 'storage/course-content/blank-6a2bc22837c0b_127.pdf', NULL, 2, 'Active', '2026-06-12 08:24:08', '2026-06-12 08:24:08', NULL),
(10, 2, 'PDF', 'What is an API ? Simply Explained', 'storage/course-content/blank-6a2bc236c68c6_646.pdf', NULL, 3, 'Active', '2026-06-12 08:24:22', '2026-06-12 08:28:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_name` varchar(191) DEFAULT NULL,
  `course_category_name` varchar(191) DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `status` enum('pending','active','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_enrollments`
--

INSERT INTO `course_enrollments` (`id`, `customer_id`, `course_id`, `course_name`, `course_category_name`, `duration`, `amount`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 21, 'Advanced BIM Project Management', 'CAD/BIM', '3 Months', 25000.00, 'pending', 'pending', '2026-07-06 12:14:26', '2026-07-06 12:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `course_lessons`
--

CREATE TABLE `course_lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_name` varchar(191) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `mode` enum('Free','Paid') NOT NULL DEFAULT 'Free',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_lessons`
--

INSERT INTO `course_lessons` (`id`, `course_id`, `lesson_name`, `priority`, `mode`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(101, 2, 'Introduction to Surveying', 1, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 12:59:14', NULL),
(102, 2, 'Surveying Instruments', 2, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(103, 2, 'Chain Survey Method', 3, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(104, 2, 'Compass Survey Method', 4, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(105, 2, 'Field Data Collection', 5, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(126, 7, 'Introduction to GIS', 1, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(127, 7, 'Spatial Data Models', 2, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(128, 7, 'Coordinate Systems', 3, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(129, 7, 'Map Creation', 4, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(130, 7, 'GIS Project', 5, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(151, 12, 'Introduction to Drones', 1, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(152, 12, 'Drone Components', 2, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(153, 12, 'Flight Regulations', 3, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(154, 12, 'Practical Flying', 4, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(155, 12, 'Flight Assessment', 5, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(192, 20, 'Model Coordination', 2, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(193, 20, 'Navisworks Basics', 3, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(194, 20, 'Clash Detection', 4, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(195, 20, 'Coordination Project', 5, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(196, 21, 'BIM Standards', 1, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(197, 21, 'Project Planning', 2, 'Free', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(198, 21, 'Team Collaboration', 3, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(199, 21, 'Workflow Management', 4, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL),
(200, 21, 'Final BIM Project', 5, 'Paid', 'Active', '2026-06-12 06:19:44', '2026-06-12 06:19:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_topics`
--

CREATE TABLE `course_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `topic_name` varchar(191) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_topics`
--

INSERT INTO `course_topics` (`id`, `lesson_id`, `topic_name`, `priority`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 101, 'topic 1', 1, 'Active', '2026-06-12 06:36:13', '2026-06-12 06:36:13', NULL),
(2, 101, 'topic 2', 2, 'Active', '2026-06-12 07:19:59', '2026-06-12 07:19:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `phone_no` varchar(191) NOT NULL,
  `profile_image` varchar(191) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_sent_at` timestamp NULL DEFAULT NULL,
  `device_type` varchar(191) DEFAULT NULL,
  `device_id` varchar(191) DEFAULT NULL,
  `fcm_token` varchar(191) DEFAULT NULL,
  `status` enum('Pending','Active','Inactive','Blocked') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `gender`, `email_id`, `phone_no`, `profile_image`, `otp`, `otp_sent_at`, `device_type`, `device_id`, `fcm_token`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Shubham Tiwari', 'Male', 'shubhamphp@gmail.com', '7619983829', 'storage/customer/download-6a44e1b24574a_656.jpg', NULL, '2026-07-07 10:45:35', 'android', 'android', 'cDQH_FXNRaq00NcpdElx28:APA91bGdk6tfzXmyt0nK922zVMQzWAzxRk1cP7h6ekRdTiCM14X1HHbJ0KcNBVITGYl8-H6OeMSmhGKkWabLeZg1xPwZvnmImbDgfTQ3c8saTDpkJQWHi_E', 'Active', '2026-06-12 10:19:20', '2026-07-07 10:45:40', NULL),
(13, 'Shuchita', 'Male', 'shuchita@gmail.com', '1234567890', 'storage/customer/scaled-1000235778-6a32332770611_113.jpg', NULL, '2026-07-06 15:30:56', 'android', NULL, NULL, 'Active', '2026-06-17 11:08:43', '2026-07-06 15:31:15', NULL),
(19, 'Shuchita Pal', 'Male', 'shuchita@12gmail.com', '8888888888', 'storage/customer/scaled-screenshot-20-6a45f6365fc5b_633.png', NULL, '2026-08-20 17:40:05', 'android', 'android', 'eb6YahPfR3yhprG8Tyrwop:APA91bFbGPhx4kGBL3nMfbHMFIPn34Xo6zDE11EizVbCMYu42MFlc9dGg_RA5tPiugcB7Ssv5w9N8HGEA-MqotaRvjNsU5UzlujmVblSQGXI0L6BAcojcuA', 'Active', '2026-07-02 10:54:04', '2026-08-20 17:40:38', NULL),
(22, 'hello', 'Male', 'tslest@gmail.com', '9999999999', 'storage/customer/scaled-1000285557-6a4906760d797_455.jpg', NULL, '2026-07-04 18:40:44', 'android', 'android', 'dU5wFNZPSwG8BTFSdnPPo4:APA91bGL1_mnxNgsXeMiMy4rbeeu7SwB_N367mqs4heC2RXft9DLdpjgNWUFRQZa3xq0Lz9MSVgqnXzxIsaKxMxO7xb_PZGnavG1LHdqzrdKwTEtWQWt7Vw', 'Active', '2026-07-04 18:40:44', '2026-07-04 18:41:18', NULL),
(26, NULL, NULL, NULL, '1231231231', NULL, NULL, '2026-07-06 15:31:24', 'android', NULL, NULL, 'Active', '2026-07-06 15:31:24', '2026-07-06 15:32:21', NULL),
(27, NULL, NULL, NULL, '5655656565', NULL, NULL, '2026-07-06 16:00:01', 'android', NULL, NULL, 'Active', '2026-07-06 16:00:01', '2026-07-06 16:02:52', NULL),
(28, NULL, NULL, NULL, '1111111231', NULL, NULL, '2026-07-06 16:03:08', 'android', NULL, NULL, 'Active', '2026-07-06 16:03:08', '2026-07-06 16:07:32', NULL),
(29, 'Hello', 'Male', 'hello@gmail.com', '1111111111', 'storage/customer/download-6a4bae20c350a_263.jpg', NULL, '2026-07-07 10:13:53', 'android', '34b576fc5b53bd74', 'test', 'Active', '2026-07-06 16:06:55', '2026-07-07 10:13:58', NULL),
(30, NULL, NULL, NULL, '1111111333', NULL, NULL, '2026-07-06 16:07:51', 'android', NULL, NULL, 'Active', '2026-07-06 16:07:51', '2026-07-06 16:13:46', NULL),
(31, NULL, NULL, NULL, '3213132131', NULL, NULL, '2026-07-06 16:14:03', 'android', 'android', 'f_wQc7ShQ3y_BEIypFt18y:APA91bEV2_2uNry-FsFKQBxi0y9-xWKPkslvUxwyiFGllKaHzENqCG_9Ada56qqj4dJumA2tHcpB_Lh-VWs8VCHhgQivzflWD0bZxNS-pxOMh_pPL1pnOt0', 'Active', '2026-07-06 16:14:03', '2026-07-06 16:14:16', NULL),
(32, NULL, NULL, NULL, '2222222222', NULL, NULL, '2026-07-06 16:18:36', 'android', NULL, NULL, 'Active', '2026-07-06 16:18:36', '2026-07-06 16:24:18', NULL),
(33, NULL, NULL, NULL, '1313131321', NULL, NULL, '2026-07-06 16:29:38', 'android', NULL, NULL, 'Active', '2026-07-06 16:29:38', '2026-07-06 16:30:24', NULL),
(34, 'Shuchita', 'Male', 'shuchita@113gmail.com', '3213213132', 'storage/customer/scaled-screenshot-20-6a4b8b32094c0_982.png', NULL, '2026-07-06 16:30:40', 'android', NULL, NULL, 'Active', '2026-07-06 16:30:40', '2026-07-06 17:04:27', NULL),
(35, 'Explore User', 'Male', 'bxbd@2526gmail.com', '6666666666', 'storage/customer/scaled-1000240796-6a4b935ee765b_750.jpg', NULL, '2026-07-06 17:06:06', 'android', NULL, NULL, 'Active', '2026-07-06 16:38:06', '2026-07-06 18:11:06', NULL),
(36, 'Ganesha', 'Female', 'ganesh@13gmail.com', '1000000000', 'storage/customer/scaled-1000240205-6a4ba2a17dc16_284.jpg', NULL, '2026-07-06 18:11:18', 'android', NULL, NULL, 'Active', '2026-07-06 18:11:18', '2026-07-06 18:52:09', NULL),
(37, NULL, NULL, NULL, '7619983029', NULL, NULL, '2026-07-06 18:39:18', 'android', 'android', 'f_y6LybJQfGP05YjLGHo-W:APA91bENLQnNTRtAFII_VikP3LzU-g_8EQJhYhFOVn4B6Zq5ER2dbDDMZp-pFY3o3po6nMRyGVa_0phujZ5ZOPh4Y5bOs-DWREj7z_h6eoi81-b4aFY8Lg4', 'Active', '2026-07-06 18:39:18', '2026-07-07 13:46:01', '2026-07-07 13:46:01'),
(38, NULL, NULL, NULL, '7007505951', NULL, NULL, '2026-07-14 07:39:12', 'android', 'android', 'evNoHyCxQJ-7kamxj9TifZ:APA91bGnTLgHVWFjtR1ruiKHnbHaVWWGDoS2yFSUD_RKwdHL0a541DvKN4uTNQXz7dH9T39fjjti-EFbKavsZs4wh7zfSKye6un5e_wrB5T3Ja5Q-azY6uw', 'Active', '2026-07-14 07:39:12', '2026-07-14 07:39:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `address_type` enum('home','office','other') NOT NULL DEFAULT 'home',
  `address` text NOT NULL,
  `pincode` varchar(191) NOT NULL,
  `city_name` varchar(191) NOT NULL,
  `state_name` varchar(191) NOT NULL,
  `set_as_default` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `customer_id`, `address_type`, `address`, `pincode`, `city_name`, `state_name`, `set_as_default`, `created_at`, `updated_at`) VALUES
(13, 1, 'office', 'lucknow', '236538', 'lucknow', 'Uttar Pradesh', 'no', '2026-07-06 15:12:54', '2026-07-06 15:12:54'),
(16, 35, 'home', 'Munshipuliya', '225252', 'amethi', 'Lucknow', 'no', '2026-07-06 16:47:45', '2026-07-06 16:47:45'),
(17, 29, 'home', 'lucknow uttar pradesh', '123456', 'Lucknow', 'UP', 'yes', '2026-07-06 17:54:40', '2026-07-06 17:54:40'),
(18, 29, 'office', 'lucknow uttar pradesh', '123456', 'Lucknow', 'UP', 'yes', '2026-07-06 17:54:40', '2026-07-06 17:54:40'),
(20, 29, 'other', 'Test', '123456', 'Lucknow', 'Up', 'no', '2026-07-07 10:15:33', '2026-07-07 10:15:33'),
(22, 19, 'home', 'lucknow up', '123456', 'Lucknow', 'Uttar Pradesh', 'no', '2026-07-07 13:32:46', '2026-07-07 14:46:03'),
(23, 19, 'office', 'shfffffffadgjf', 'sdfdsf', 'sadfdsf', 'sdfsaf', 'yes', '2026-07-07 13:42:30', '2026-07-07 14:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `customer_surveys`
--

CREATE TABLE `customer_surveys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `survey_id` bigint(20) UNSIGNED NOT NULL,
  `survey_name` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `survey_date` date DEFAULT NULL,
  `survey_time` time DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('Pending','Ongoing','Completed','Rejected') NOT NULL DEFAULT 'Pending',
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_surveys`
--

INSERT INTO `customer_surveys` (`id`, `customer_id`, `vendor_id`, `survey_id`, `survey_name`, `amount`, `payment_status`, `latitude`, `longitude`, `survey_date`, `survey_time`, `address`, `status`, `reject_reason`, `created_at`, `updated_at`, `assigned_at`, `completed_at`) VALUES
(1, 19, NULL, 9, 'As-Built Survey', 14000.00, 'success', '26.8467', '80.9462', '2026-07-06', '15:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 12:06:50', '2026-07-06 12:06:51', NULL, NULL),
(2, 19, 1, 9, 'As-Built Survey', 14000.00, 'success', '26.846699946003863', '80.94620011746883', '2026-07-06', '15:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Ongoing', NULL, '2026-07-06 12:07:24', '2026-07-06 12:38:18', '2026-07-06 12:38:18', NULL),
(3, 1, 1, 8, 'Utility Mapping', 25000.00, 'success', '25.897303675057504', '81.94529816508293', '2026-07-07', '14:00:00', '1, Pratapgarh, Uttar Pradesh, India', 'Completed', NULL, '2026-07-06 12:09:47', '2026-07-06 12:13:49', '2026-07-06 12:10:34', '2026-07-06 12:13:49'),
(4, 13, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '15:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 12:17:20', '2026-07-06 12:17:20', NULL, NULL),
(5, 1, 1, 9, 'As-Built Survey', 14000.00, 'success', '26.846699946003863', '80.94620011746883', '2026-07-08', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Ongoing', NULL, '2026-07-06 12:34:35', '2026-07-06 12:34:50', '2026-07-06 12:34:50', NULL),
(6, 1, 1, 3, 'Construction Layout Survey', 12000.00, 'pending', '26.846699946003863', '80.94620011746883', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Ongoing', NULL, '2026-07-06 13:45:17', '2026-07-06 14:48:34', '2026-07-06 14:48:34', NULL),
(7, 1, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.846699946003863', '80.94620011746883', '2026-07-07', '10:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 13:47:49', '2026-07-06 13:47:49', NULL, NULL),
(8, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '15:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 13:49:22', '2026-07-06 13:49:22', NULL, NULL),
(9, 19, NULL, 10, '3D Laser Scanning Survey', 30000.00, 'success', '26.8467', '80.9462', '2026-07-06', '15:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 13:50:48', '2026-07-06 13:50:50', NULL, NULL),
(10, 19, NULL, 10, '3D Laser Scanning Survey', 30000.00, 'pending', '26.88532750409263', '80.9957318007946', '2026-07-06', '17:00:00', 'Near, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:03:24', '2026-07-06 15:03:24', NULL, NULL),
(11, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-08', '10:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:05:01', '2026-07-06 15:05:01', NULL, NULL),
(12, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:08:17', '2026-07-06 15:08:17', NULL, NULL),
(13, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:09:05', '2026-07-06 15:09:05', NULL, NULL),
(14, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:10:25', '2026-07-06 15:10:25', NULL, NULL),
(15, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:17:20', '2026-07-06 15:17:20', NULL, NULL),
(16, 19, NULL, 10, '3D Laser Scanning Survey', 30000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:21:11', '2026-07-06 15:21:11', NULL, NULL),
(17, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:21:43', '2026-07-06 15:21:43', NULL, NULL),
(18, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:22:26', '2026-07-06 15:22:26', NULL, NULL),
(19, 19, NULL, 10, '3D Laser Scanning Survey', 30000.00, 'pending', '26.8467', '80.9462', '2026-07-07', '09:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:25:46', '2026-07-06 15:25:46', NULL, NULL),
(20, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-07', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:32:57', '2026-07-06 15:32:57', NULL, NULL),
(21, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:38:33', '2026-07-06 15:38:33', NULL, NULL),
(22, 19, NULL, 9, 'As-Built Survey', 14000.00, 'pending', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:39:46', '2026-07-06 15:39:46', NULL, NULL),
(23, 19, NULL, 9, 'As-Built Survey', 14000.00, 'success', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:43:32', '2026-07-06 15:44:45', NULL, NULL),
(24, 19, NULL, 9, 'As-Built Survey', 14000.00, 'success', '26.8467', '80.9462', '2026-07-06', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 15:48:32', '2026-07-06 15:49:17', NULL, NULL),
(25, 35, 1, 10, '3D Laser Scanning Survey', 30000.00, 'success', '26.885408842197336', '80.9975228458643', '2026-07-06', '17:00:00', '01, Lucknow, Uttar Pradesh, India', 'Ongoing', NULL, '2026-07-06 16:47:10', '2026-07-06 16:48:46', '2026-07-06 16:48:46', NULL),
(26, 1, NULL, 7, 'Contour Survey', 16000.00, 'success', '26.846699946003863', '80.94620011746883', '2026-07-08', '11:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 17:31:47', '2026-07-06 17:31:48', NULL, NULL),
(27, 29, NULL, 10, '3D Laser Scanning Survey', 30000.00, 'pending', '26.8467', '80.9462', '2026-07-07', '14:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 17:58:38', '2026-07-06 17:58:38', NULL, NULL),
(28, 29, NULL, 10, '3D Laser Scanning Survey', 30000.00, 'pending', '26.8467', '80.9462', '2026-07-07', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 17:58:56', '2026-07-06 17:58:56', NULL, NULL),
(29, 29, 1, 10, '3D Laser Scanning Survey', 30000.00, 'success', '26.8467', '80.9462', '2026-07-08', '11:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Completed', NULL, '2026-07-06 18:00:17', '2026-07-06 18:04:33', '2026-07-06 18:01:03', '2026-07-06 18:04:33'),
(30, 1, NULL, 3, 'Construction Layout Survey', 12000.00, 'success', '26.8467', '80.9462', '2026-07-08', '14:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 18:42:23', '2026-07-06 18:42:26', NULL, NULL),
(31, 29, NULL, 9, 'As-Built Survey', 14000.00, 'success', '26.8467', '80.9462', '2026-07-08', '10:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-06 18:47:27', '2026-07-06 18:47:30', NULL, NULL),
(32, 29, NULL, 4, 'GPS/GNSS Survey', 10000.00, 'success', '26.8467', '80.9462', '2026-07-09', '15:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-07 10:14:53', '2026-07-07 10:15:38', NULL, NULL),
(33, 1, NULL, 7, 'Contour Survey', 16000.00, 'pending', '26.8467', '80.9462', '2026-07-08', '14:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-07 10:47:52', '2026-07-07 10:47:52', NULL, NULL),
(34, 1, 1, 9, 'As-Built Survey', 14000.00, 'success', '26.846699946003863', '80.94620011746883', '2026-07-07', '17:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Ongoing', NULL, '2026-07-07 10:48:24', '2026-07-07 13:21:59', '2026-07-07 13:21:59', NULL),
(35, 38, NULL, 2, 'Topographic Survey', 15000.00, 'pending', '26.846699946003863', '80.94620011746883', '2026-07-24', '09:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-07-23 13:11:42', '2026-07-23 13:11:42', NULL, NULL),
(36, 38, NULL, 3, 'Construction Layout Survey', 12000.00, 'pending', '26.846699946003863', '80.94620011746883', '2026-09-22', '10:00:00', '1A, Lucknow, Uttar Pradesh, India', 'Pending', NULL, '2026-09-21 17:30:19', '2026-09-21 17:30:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) NOT NULL,
  `answer` text NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `priority`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'What is Xplore Mapping Services?', 'Xplore Mapping Services is a company providing GIS mapping, geospatial analysis, and location-based data solutions for businesses and government organizations.', 1, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(2, 'What services does Xplore Mapping offer?', 'We offer GIS mapping, satellite data analysis, land surveying support, web mapping solutions, and custom geospatial applications.', 2, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(3, 'Do you provide custom mapping solutions?', 'Yes, we design fully customized mapping solutions based on client requirements and industry needs.', 3, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(4, 'Which industries do you serve?', 'We serve real estate, agriculture, logistics, urban planning, telecom, and government sectors.', 4, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(5, 'Can I integrate your maps into my website?', 'Yes, we provide API-based map integration for websites and applications.', 5, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(6, 'Do you use satellite data?', 'Yes, we use high-resolution satellite imagery for accurate mapping and analysis.', 6, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(7, 'Is your data real-time?', 'We provide near real-time updates depending on the project requirements and data source.', 7, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(8, 'Do you offer GIS training?', 'Yes, we provide professional GIS and mapping training programs for students and professionals.', 8, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(9, 'How accurate are your maps?', 'Our maps are highly accurate, validated using modern GIS tools and satellite datasets.', 9, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(10, 'Can you help in land surveying projects?', 'Yes, we assist in land surveying and spatial data collection using advanced GIS technologies.', 10, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(11, 'Do you provide API access?', 'Yes, we offer API access for developers to integrate mapping data into their systems.', 11, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(12, 'What software do you use?', 'We use advanced GIS tools like QGIS, ArcGIS, and custom mapping frameworks.', 12, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(13, 'Do you support mobile applications?', 'Yes, we develop mapping solutions compatible with Android and iOS applications.', 13, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(14, 'Can I track locations in real time?', 'Yes, we provide real-time tracking solutions for logistics and fleet management.', 14, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(15, 'Is your mapping data secure?', 'Yes, we follow strict data security protocols to ensure client data protection.', 15, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(16, 'Do you offer enterprise solutions?', 'Yes, we provide scalable enterprise-level GIS solutions for large organizations.', 16, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(17, 'How can I contact support?', 'You can contact our support team via email, phone, or our official website contact form.', 17, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(18, 'Do you provide consultancy services?', 'Yes, we offer GIS and geospatial consultancy services for projects of any scale.', 18, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(19, 'What is the cost of your services?', 'Pricing depends on project complexity and requirements. We provide custom quotations.', 19, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-12 09:17:18'),
(20, 'Do you work on government projects?', 'Yes, we collaborate on various government GIS and mapping projects.', 20, 'Active', NULL, '2026-06-12 09:17:18', '2026-06-29 16:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `help_queries`
--

CREATE TABLE `help_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) NOT NULL,
  `message` text DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_queries`
--

INSERT INTO `help_queries` (`id`, `customer_id`, `question`, `message`, `remark`, `created_at`, `updated_at`) VALUES
(6, 13, 'Meri property ki utility mapping ka status kya hai?', 'hi', NULL, '2026-07-02 12:22:26', '2026-07-02 12:22:26'),
(8, 1, 'Customer support se contact kaise kar sakta hoon agar mujhe additional help chahiye?', 'helloplease explain this', NULL, '2026-07-06 14:54:43', '2026-07-06 14:54:43'),
(9, 29, 'Utility mapping ke liye kaun-kaun se documents required hain?', 'Hi', NULL, '2026-07-06 18:26:24', '2026-07-06 18:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `help_questions`
--

CREATE TABLE `help_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_questions`
--

INSERT INTO `help_questions` (`id`, `question`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Meri property ki utility mapping ka status kya hai?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(2, 'Utility mapping complete hone me kitna time lagta hai?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(3, 'Survey report aur final mapping report kab milegi?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(4, 'Agar mapping report me koi issue ya error ho to kya karna hoga?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(5, 'Utility mapping ke liye kaun-kaun se documents required hain?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(6, 'Meri booking ya survey schedule ko reschedule kaise kar sakta hoon?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(7, 'Survey engineer kab site visit karega aur visit ki confirmation kaise milegi?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(8, 'Utility mapping ki pricing, quotation ya payment details kya hain?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(9, 'Kya aap underground utilities (water, gas, electric, telecom, sewer) ki mapping provide karte hain?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00'),
(10, 'Customer support se contact kaise kar sakta hoon agar mujhe additional help chahiye?', 'Active', '2026-07-01 11:46:00', '2026-07-01 11:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
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
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
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
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_27_081736_create_web_settings_table', 1),
(6, '2026_06_07_010813_create_permission_tables', 1),
(26, '0001_01_01_000000_create_users_table', 2),
(27, '2026_06_09_171446_create_sliders_table', 3),
(29, '2026_06_11_160127_create_surveys_table', 5),
(35, '2026_06_09_175332_create_course_categories_table', 6),
(36, '2026_06_11_162552_create_courses_table', 6),
(37, '2026_06_11_172537_create_course_lessons_table', 6),
(38, '2026_06_12_112453_create_course_topics_table', 6),
(39, '2026_06_12_112905_create_course_contents_table', 6),
(40, '2026_06_12_135933_create_faqs_table', 7),
(41, '2026_06_12_145048_create_notifications_table', 8),
(42, '2026_06_12_151227_create_personal_access_tokens_table', 9),
(43, '2026_06_12_151823_create_customers_table', 10),
(44, '2026_06_15_161823_create_customer_surveys_table', 11),
(45, '2026_06_16_145331_create_product_categories_table', 12),
(46, '2026_06_16_151556_create_product_brands_table', 13),
(47, '2026_06_16_153159_create_product_sub_categories_table', 14),
(48, '2026_06_16_155606_create_products_table', 15),
(49, '2026_06_16_160009_create_product_specifications_table', 16),
(50, '2026_06_16_161350_create_product_variants_table', 17),
(51, '2026_06_20_000001_create_carts_table', 18),
(52, '2026_06_20_000002_create_cart_items_table', 18),
(55, '2026_06_27_000000_create_vendors_table', 19),
(56, '2026_06_27_000000_add_vendor_and_cancel_reason_to_customer_surveys_table', 20),
(57, '2026_06_27_000001_add_assigned_at_to_customer_surveys_table', 21),
(58, '2026_06_27_101111_create_survey_chats_table', 22),
(59, '2026_06_27_130000_create_transactions_table', 23),
(60, '2026_06_27_130001_create_course_enrollments_table', 23),
(61, '2026_06_29_152600_add_status_to_course_enrollments_table', 24),
(62, '2026_06_29_153700_add_payment_status_to_customer_surveys_table', 25),
(63, '2026_07_01_000000_create_help_questions_table', 26),
(64, '2026_07_01_000001_create_help_queries_table', 27),
(65, '2026_07_02_152000_create_customer_addresses_table', 28),
(68, '2026_06_20_000003_create_product_orders_table', 29),
(69, '2026_06_20_000004_create_product_orders_items_table', 29),
(70, '2026_07_02_162000_add_fields_to_product_orders_table', 29),
(71, '2026_07_02_171000_create_orders_table', 30),
(72, '2026_07_03_151000_add_vendor_type_to_vendors_table', 31),
(73, '2026_07_03_182620_create_activity_log_table', 32),
(74, '2026_07_03_182621_add_event_column_to_activity_log_table', 32),
(75, '2026_07_03_182622_add_batch_uuid_column_to_activity_log_table', 32),
(76, '2026_07_04_123500_create_cms_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `short_detail` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `short_detail`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'System Maintenance Update', 'Our system will undergo maintenance tonight from 12 AM to 3 AM.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd249a7b48_195.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(2, 'New Feature Released', 'We have launched new mapping tools for better accuracy and speed.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd245a6b95_868.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(3, 'Service Update', 'Some services may be temporarily unavailable due to updates.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd242032ff_769.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(4, 'Welcome to Xplore Mapping', 'Thank you for choosing Xplore Mapping Services for your GIS needs.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd23e5c08e_888.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(5, 'Data Processing Completed', 'Your uploaded GIS data has been successfully processed.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd23ac8dcf_508.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(6, 'Security Update', 'We have improved system security and data protection features.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd236e51a3_183.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(7, 'New API Available', 'Developers can now use our latest mapping API v2.0.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd2333c85d_776.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(8, 'Performance Upgrade', 'Platform performance has been improved for faster map rendering.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd22f02d39_800.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(9, 'Training Program Announcement', 'New GIS training sessions will start from next week.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd22baca43_593.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(10, 'Support System Upgrade', 'Our customer support system has been upgraded for faster response.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd22835e82_329.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(11, 'Map Accuracy Improved', 'We have enhanced map accuracy using latest satellite data.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd224a6731_159.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(12, 'User Dashboard Updated', 'Your dashboard UI has been improved for better usability.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd22103421_759.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(13, 'New Region Added', 'We have expanded mapping coverage to new geographic regions.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd21d5fe4e_604.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(14, 'Scheduled Backup Completed', 'All system data backup has been successfully completed.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd21845fa8_597.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(15, 'Mobile App Update', 'New update available with improved tracking features.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd212c3164_854.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(16, 'Bug Fixes Released', 'Several minor bugs have been fixed in the platform.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd20dc9fb5_572.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(17, 'Geo Data Sync Complete', 'Your GIS data has been successfully synchronized.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd2084a95e_812.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(18, 'Analytics Feature Added', 'New analytics tools are now available in your dashboard.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd202b7018_670.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(19, 'Server Upgrade Completed', 'We have upgraded our servers for better performance.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd1f4cc0bb_730.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(20, 'Reminder: Profile Update', 'Please update your profile information for better service.', 'storage/notification/logo-1-6a27e68b6b2e6-6a2bd1f02a823_554.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', NULL),
(21, 'test', 'test', 'storage/notification/download-6a450711775f4_293.jpg', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', '2026-07-01 12:26:18'),
(22, 'hello world', 'this is a test msg ignore', 'storage/notification/pngtree-dslr-backgro-6a462b915b6f9_960.jpg', 'Active', '2026-07-06 09:30:45', '2026-07-06 09:30:45', '2026-07-03 07:14:32'),
(23, 'test', 'test', 'storage/notification/user-6a4b4e950fe0d_300.jpg', 'Active', '2026-07-06 09:30:45', '2026-07-06 18:51:11', '2026-07-06 18:51:11'),
(24, 'hello', 'hello', 'storage/notification/download-6a4b532199aa6_899.jpg', 'Active', '2026-07-06 09:30:45', '2026-07-06 18:51:10', '2026-07-06 18:51:10'),
(25, 'hello', 'goodf', 'storage/notification/chatgpt-image-jun-26-6a4b5358afdf8_568.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 18:51:09', '2026-07-06 18:51:09'),
(26, 'gfjgh', 'fhhhh', 'storage/notification/star-removebg-previe-6a4b5790104bf_468.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 18:51:08', '2026-07-06 18:51:08'),
(27, 'good', 'hgj', 'storage/notification/chatgpt-image-jun-12-6a4b58e874300_776.png', 'Active', '2026-07-06 09:30:45', '2026-07-06 18:51:07', '2026-07-06 18:51:07'),
(28, 'test', 'testing', 'storage/notification/download-6a4babd321507_953.jpg', 'Active', '2026-07-06 18:51:23', '2026-07-07 11:40:21', '2026-07-07 11:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(191) DEFAULT NULL,
  `order_type` enum('survey','product','rental_product','course') NOT NULL,
  `rel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `customer_mobile` varchar(191) DEFAULT NULL,
  `customer_email` varchar(191) DEFAULT NULL,
  `address_type` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city_name` varchar(191) DEFAULT NULL,
  `state_name` varchar(191) DEFAULT NULL,
  `pincode` varchar(15) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `order_type`, `rel_id`, `customer_id`, `customer_name`, `customer_mobile`, `customer_email`, `address_type`, `address`, `city_name`, `state_name`, `pincode`, `amount`, `notes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'XPL-20260706-RFXSQW', 'product', 1, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow up', 'Lucknow', 'Uttar Pradesh', '123456', 50.00, 'Order for product', 'success', '2026-07-06 12:05:53', '2026-07-06 12:05:53', NULL),
(2, 'XPL-20260706-B1RS2Z', 'survey', 1, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow up', 'Lucknow', 'Uttar Pradesh', '123456', 14000.00, 'Order for survey', 'success', '2026-07-06 12:06:51', '2026-07-06 12:06:51', NULL),
(3, 'XPL-20260706-4E8ETR', 'survey', 2, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow up', 'Lucknow', 'Uttar Pradesh', '123456', 14000.00, 'Order for survey', 'success', '2026-07-06 12:07:25', '2026-07-06 12:07:25', NULL),
(4, 'XPL-20260706-NX70BY', 'survey', 3, 1, 'Shubham Tiwari', '7619983829', 'shubham@gmail.com', 'other', 'lucknow up', 'Lucknow', 'Uttar Pradesh', '123456', 25000.00, 'Order for survey', 'success', '2026-07-06 12:09:48', '2026-07-06 12:09:48', NULL),
(5, 'XPL-20260706-9H1KYP', 'survey', 5, 1, 'Shubham Tiwari', '7619983829', 'shubham@gmail.com', 'other', 'lucknow up', 'Lucknow', 'Uttar Pradesh', '123456', 14000.00, 'Order for survey', 'success', '2026-07-06 12:34:35', '2026-07-06 12:34:36', NULL),
(6, 'XPL-20260706-FZEEWG', 'survey', 9, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', '95', 'hgf8j', '85', '885626', 30000.00, 'Order for survey', 'success', '2026-07-06 13:50:49', '2026-07-06 13:50:50', NULL),
(7, 'XPL-20260706-4UPXQD', 'product', 1, 1, 'Shubham Tiwari', '7619983829', 'shubham@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 50.00, 'Order for product', 'success', '2026-07-06 15:13:12', '2026-07-06 15:13:12', NULL),
(8, 'XPL-20260706-4BO6RP', 'product', 1, 1, 'Shubham Tiwari', '7619983829', 'shubham@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 50.00, 'Order for product', 'success', '2026-07-06 15:13:17', '2026-07-06 15:13:17', NULL),
(9, 'XPL-20260706-YI6HHO', 'product', 1, 1, 'Shubham Tiwari', '7619983829', 'shubham@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 50.00, 'Order for product', 'success', '2026-07-06 15:13:25', '2026-07-06 15:13:25', NULL),
(10, 'XPL-20260706-NSML3G', 'survey', 23, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow', 'amethi', 'fggggggajgd', '273562', 14000.00, 'Order for survey', 'success', '2026-07-06 15:44:44', '2026-07-06 15:44:44', NULL),
(11, 'XPL-20260706-T44C1H', 'survey', 23, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow', 'amethi', 'fggggggajgd', '273562', 14000.00, 'Order for survey', 'success', '2026-07-06 15:44:45', '2026-07-06 15:44:45', NULL),
(12, 'XPL-20260706-VKBKCY', 'survey', 23, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow', 'amethi', 'fggggggajgd', '273562', 14000.00, 'Order for survey', 'success', '2026-07-06 15:44:45', '2026-07-06 15:44:45', NULL),
(13, 'XPL-20260706-HCNBES', 'survey', 24, 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'ashfsgdf', 'dsafd', 'sdfadsf', '798574', 14000.00, 'Order for survey', 'success', '2026-07-06 15:49:16', '2026-07-06 15:49:17', NULL),
(14, 'XPL-20260706-DBWRA7', 'survey', 25, 35, 'dbdbbdn', '6666666666', 'bxbd@2526gmail.com', 'home', 'Munshipuliya', 'amethi', 'Lucknow', '225252', 30000.00, 'Order for survey', 'success', '2026-07-06 16:47:49', '2026-07-06 16:47:49', NULL),
(15, 'XPL-20260706-ESVQHM', 'survey', 26, 1, 'Shubham Tiwari', '7619983829', 'shubhamphp@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 16000.00, 'Order for survey', 'success', '2026-07-06 17:31:48', '2026-07-06 17:31:48', NULL),
(16, 'XPL-20260706-7B5AMA', 'survey', 29, 29, 'Hello', '1111111111', 'hello@gmail.com', 'office', 'lucknow uttar pradesh', 'Lucknow', 'UP', '123456', 30000.00, 'Order for survey', 'success', '2026-07-06 18:00:17', '2026-07-06 18:00:17', NULL),
(17, 'XPL-20260706-NDZJFW', 'survey', 30, 1, 'Shubham Tiwari', '7619983829', 'shubhamphp@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 12000.00, 'Order for survey', 'success', '2026-07-06 18:42:26', '2026-07-06 18:42:26', NULL),
(18, 'XPL-20260706-RJBSLA', 'survey', 31, 29, 'Hello', '1111111111', 'hello@gmail.com', 'home', 'lucknow uttar pradesh', 'Lucknow', 'UP', '123456', 14000.00, 'Order for survey', 'success', '2026-07-06 18:47:30', '2026-07-06 18:47:30', NULL),
(19, 'XPL-20260707-TM8V2D', 'survey', 32, 29, 'Hello', '1111111111', 'hello@gmail.com', 'other', 'Test', 'Lucknow', 'Up', '123456', 10000.00, 'Order for survey', 'success', '2026-07-07 10:15:37', '2026-07-07 10:15:38', NULL),
(20, 'XPL-20260707-RIFZ58', 'survey', 34, 1, 'Shubham Tiwari', '7619983829', 'shubhamphp@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 14000.00, 'Order for survey', 'success', '2026-07-07 10:48:26', '2026-07-07 10:48:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user-list', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(2, 'user-add', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(3, 'user-delete', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(4, 'role-list', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(5, 'role-add', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(6, 'role-delete', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(7, 'permission-list', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(8, 'permission-add', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(53, 'permission-delete', 'web', '2026-06-09 10:49:20', '2026-06-09 10:49:20', NULL),
(54, 'web-setting', 'web', '2026-06-09 10:49:32', '2026-06-09 10:49:32', NULL),
(55, 'slider-add', 'web', '2026-06-09 11:47:44', '2026-06-09 11:47:44', NULL),
(56, 'slider-list', 'web', '2026-06-09 11:47:52', '2026-06-09 11:47:52', NULL),
(57, 'slider-delete', 'web', '2026-06-09 11:47:58', '2026-06-09 11:47:58', NULL),
(58, 'course-category-add', 'web', '2026-06-09 12:24:58', '2026-06-09 12:24:58', NULL),
(59, 'course-category-list', 'web', '2026-06-09 12:25:04', '2026-06-09 12:25:04', NULL),
(60, 'course-category-delete', 'web', '2026-06-09 12:25:09', '2026-06-09 12:25:09', NULL),
(61, 'survey-add', 'web', '2026-06-11 10:40:18', '2026-06-11 10:40:18', NULL),
(62, 'survey-list', 'web', '2026-06-11 10:40:23', '2026-06-11 10:40:23', NULL),
(63, 'survey-delete', 'web', '2026-06-11 10:40:28', '2026-06-11 10:40:28', NULL),
(64, 'course-add', 'web', '2026-06-11 11:01:31', '2026-06-11 11:01:31', NULL),
(65, 'course-list', 'web', '2026-06-11 11:01:36', '2026-06-11 11:01:36', NULL),
(66, 'course-delete', 'web', '2026-06-11 11:01:42', '2026-06-11 11:01:42', NULL),
(67, 'course-lesson-add', 'web', '2026-06-11 11:31:15', '2026-06-11 11:31:15', NULL),
(68, 'course-lesson-list', 'web', '2026-06-11 11:31:21', '2026-06-11 12:01:33', NULL),
(69, 'course-lesson-delete', 'web', '2026-06-11 11:31:28', '2026-06-11 12:01:24', NULL),
(70, 'course-content-add', 'web', '2026-06-11 12:20:06', '2026-06-11 12:20:06', NULL),
(71, 'course-content-list', 'web', '2026-06-11 12:21:03', '2026-06-11 12:21:03', NULL),
(72, 'course-content-delete', 'web', '2026-06-11 12:21:11', '2026-06-11 12:21:11', NULL),
(73, 'course-topic-add', 'web', '2026-06-12 05:50:52', '2026-06-12 05:50:52', NULL),
(74, 'course-topic-list', 'web', '2026-06-12 05:51:00', '2026-06-12 05:51:00', NULL),
(75, 'course-topic-delete', 'web', '2026-06-12 05:51:06', '2026-06-12 05:51:06', NULL),
(76, 'faq-add', 'web', '2026-06-12 09:05:02', '2026-06-12 09:05:02', NULL),
(77, 'faq-list', 'web', '2026-06-12 09:05:08', '2026-06-12 09:05:08', NULL),
(78, 'faq-delete', 'web', '2026-06-12 09:05:15', '2026-06-12 09:05:15', NULL),
(79, 'notification-add', 'web', '2026-06-12 09:05:37', '2026-06-12 09:06:06', NULL),
(80, 'notification-list', 'web', '2026-06-12 09:05:45', '2026-06-12 09:06:08', NULL),
(81, 'notification-delete', 'web', '2026-06-12 09:05:57', '2026-06-12 09:05:57', NULL),
(82, 'assign-permissions', 'web', '2026-06-12 12:30:32', '2026-06-12 12:30:32', NULL),
(83, 'customer-survey-list', 'web', '2026-06-15 11:35:03', '2026-06-15 11:35:03', NULL),
(84, 'customer-list', 'web', '2026-06-15 11:35:08', '2026-06-15 11:35:08', NULL),
(85, 'product-category-list', 'web', '2026-06-16 09:25:36', '2026-06-16 09:25:36', NULL),
(86, 'product-category-add', 'web', '2026-06-16 09:25:42', '2026-06-16 09:25:42', NULL),
(87, 'product-category-delete', 'web', '2026-06-16 09:25:52', '2026-06-16 09:25:52', NULL),
(88, 'product-sub-category-delete', 'web', '2026-06-16 09:25:59', '2026-06-16 09:25:59', NULL),
(89, 'product-sub-category-list', 'web', '2026-06-16 09:26:05', '2026-06-16 09:26:05', NULL),
(90, 'product-sub-category-add', 'web', '2026-06-16 09:26:10', '2026-06-16 09:26:10', NULL),
(91, 'product-brand-delete', 'web', '2026-06-16 09:26:19', '2026-06-16 09:26:19', NULL),
(92, 'product-brand-list', 'web', '2026-06-16 09:26:24', '2026-06-16 09:26:24', NULL),
(93, 'product-brand-add', 'web', '2026-06-16 09:26:29', '2026-06-16 09:26:29', NULL),
(94, 'product-add', 'web', '2026-06-16 09:26:37', '2026-06-16 09:26:37', NULL),
(95, 'product-list', 'web', '2026-06-16 09:26:43', '2026-06-16 09:26:43', NULL),
(96, 'product-delete', 'web', '2026-06-16 09:26:49', '2026-06-16 09:26:49', NULL),
(97, 'cart-list', 'web', '2026-06-20 10:56:10', '2026-06-20 10:56:10', NULL),
(98, 'product-order-list', 'web', '2026-06-20 10:56:15', '2026-07-02 11:32:17', NULL),
(99, 'customer-add', 'web', '2026-06-27 07:32:56', '2026-06-27 07:32:56', NULL),
(100, 'customer-delete', 'web', '2026-06-27 07:33:02', '2026-06-27 07:33:02', NULL),
(101, 'vendor-add', 'web', '2026-06-27 07:42:27', '2026-06-27 07:42:27', NULL),
(102, 'vendor-list', 'web', '2026-06-27 07:42:35', '2026-06-27 07:42:35', NULL),
(103, 'vendor-delete', 'web', '2026-06-27 07:42:41', '2026-06-27 07:42:41', NULL),
(104, 'transaction-list', 'web', '2026-06-29 05:26:32', '2026-06-29 05:26:32', NULL),
(105, 'course-enrollment-list', 'web', '2026-06-29 09:10:32', '2026-06-29 09:10:32', NULL),
(106, 'help-query-list', 'web', '2026-07-01 11:58:12', '2026-07-01 11:58:12', NULL),
(107, 'help-query-delete', 'web', '2026-07-01 12:03:47', '2026-07-01 12:03:47', NULL),
(108, 'order-list', 'web', '2026-07-02 13:06:49', '2026-07-02 13:06:49', NULL),
(109, 'activity-log', 'web', '2026-07-03 13:00:37', '2026-07-03 13:00:37', NULL),
(110, 'cms-add', 'web', '2026-07-04 07:10:26', '2026-07-04 07:10:26', NULL),
(111, 'cms-list', 'web', '2026-07-04 07:10:31', '2026-07-04 07:10:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(9, 'App\\Models\\Customer', 1, 'login_api', '910961d470949d24d557945c72d6a2e1d7f566ad01397fa89346168e8e2d806f', '[\"*\"]', '2026-07-02 10:07:41', NULL, '2026-06-15 10:11:36', '2026-07-02 10:07:41'),
(29, 'App\\Models\\Customer', 7, '9335220709', 'cd49f3477a99ab97db8745df4c9b436ee29216a748235d2a2e587078f943743e', '[\"*\"]', '2026-06-30 17:41:33', NULL, '2026-06-19 12:06:56', '2026-06-30 17:41:33'),
(32, 'App\\Models\\Customer', 9, '7777777777', 'b18a030316761b07f47bf39108a4a6b12431a893f06020baeb17f139f56d0be1', '[\"*\"]', '2026-06-24 17:19:10', NULL, '2026-06-24 12:29:15', '2026-06-24 17:19:10'),
(45, 'App\\Models\\Customer', 5, '8888888888', '5a1392bf016f702cb2d1c4384fd8fa00593bc25bf2ea86eaf76a14babf4cf12a', '[\"*\"]', '2026-07-01 15:01:52', NULL, '2026-07-01 12:58:32', '2026-07-01 15:01:52'),
(50, 'App\\Models\\Customer', 18, '1111111111', 'ab8efee49d2d7d430cd6f9d2934c3fd446aeb4e02607305238be91462ba9ba2b', '[\"*\"]', '2026-07-01 18:58:03', NULL, '2026-07-01 18:54:42', '2026-07-01 18:58:03'),
(68, 'App\\Models\\Customer', 22, '9999999999', 'ec3ff19bb9a34bc135e24e691f3746a3a15557f11016a097121382b34fb3a6f7', '[\"*\"]', '2026-07-04 18:44:25', NULL, '2026-07-04 18:40:44', '2026-07-04 18:44:25'),
(88, 'App\\Models\\Customer', 31, '3213132131', '92c7de27ba2c227c715db9d6fc717248377c50c8617962a303ba3accb503036a', '[\"*\"]', '2026-07-06 16:14:16', NULL, '2026-07-06 16:14:03', '2026-07-06 16:14:16'),
(140, 'App\\Models\\Customer', 37, '7619983029', 'b0c36216a297cc84436a247c62f65d414b96c3d1c57e4b2aa1749937ad4f66dd', '[\"*\"]', '2026-07-06 18:39:42', NULL, '2026-07-06 18:39:18', '2026-07-06 18:39:42'),
(148, 'App\\Models\\Customer', 29, '1111111111', 'be6965e8c3182c4990ccb245a2c78447d1237b269d8561d23f7fe0673e3a818a', '[\"*\"]', '2026-07-07 10:16:30', NULL, '2026-07-07 10:13:53', '2026-07-07 10:16:30'),
(149, 'App\\Models\\Customer', 1, '7619983829', 'baadf02aaf34d48958e3248354e74f4df947512ca4606b22015e0d54039c5641', '[\"*\"]', '2026-07-07 10:52:45', NULL, '2026-07-07 10:45:35', '2026-07-07 10:52:45'),
(156, 'App\\Models\\Customer', 38, '7007505951', 'e495487d314b71b606d894b639a0b1e11b4173a8ddca8d18a2c0e4d97def6b78', '[\"*\"]', '2026-09-21 17:30:20', NULL, '2026-07-14 07:39:12', '2026-09-21 17:30:20'),
(158, 'App\\Models\\Customer', 19, '8888888888', '9358cee8af19b1f8268e4c1a559942acdbbf50105962c84195511ef3ea9850dc', '[\"*\"]', '2026-08-21 17:23:49', NULL, '2026-08-20 17:40:05', '2026-08-21 17:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` bigint(20) UNSIGNED NOT NULL,
  `product_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `has_variants` enum('Yes','No') NOT NULL DEFAULT 'No',
  `mrp_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int(10) UNSIGNED DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_category_id`, `product_sub_category_id`, `product_brand_id`, `product_name`, `description`, `has_variants`, `mrp_price`, `sale_price`, `stock`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 10, 1, 'Red Clay Bricks', '<p>High quality red clay bricks suitable for residential and commercial construction. Strong, durable and uniform in size.</p>', 'Yes', NULL, NULL, NULL, 'storage/product/download-1-6a3137a36caa1_980.jpg', 'Active', NULL, '2026-06-16 11:04:47', '2026-06-16 12:00:06'),
(3, 2, 11, 2, 'Fly Ash Bricks', '<p>Eco-friendly fly ash bricks with high strength and durability for modern construction projects.</p>', 'Yes', NULL, NULL, NULL, 'storage/product/download-10-6a31396722fb1_272.jpg', 'Active', NULL, '2026-06-16 11:51:16', '2026-06-16 12:00:41'),
(4, 2, 12, 1, 'AAC Bricks', '<p>Lightweight AAC bricks providing excellent thermal insulation and reduced structural load.</p>', 'Yes', NULL, NULL, NULL, 'storage/product/download-9-6a31394f7259f_526.jpg', 'Active', NULL, '2026-06-16 11:51:16', '2026-06-16 12:00:36'),
(5, 2, 13, 2, 'Concrete Bricks', '<p>Premium concrete bricks suitable for commercial and industrial construction.</p>', 'Yes', NULL, NULL, NULL, 'storage/product/download-8-6a313935d732f_752.jpg', 'Active', NULL, '2026-06-16 11:51:16', '2026-06-16 12:00:30'),
(6, 2, 13, 2, 'Hollow Bricks', 'Strong hollow bricks offering better insulation and reduced material consumption.', 'Yes', NULL, NULL, NULL, 'storage/product/download-11-6a31397e6abf4_696.jpg', 'Active', NULL, '2026-06-16 11:51:16', '2026-06-16 12:00:27'),
(7, 2, 14, 2, 'Interlocking Paver Brick', 'High-strength interlocking paver bricks suitable for driveways, pathways, parking areas and landscaping projects.', 'No', 35.00, 30.00, 8000, 'storage/product/download-12-6a313a8fc8cdb_479.jpg', 'Active', NULL, '2026-06-16 11:58:15', '2026-07-07 12:46:57'),
(8, 2, 12, 2, 'Bricks', 'Eco-friendly fly ash bricks with high strength and durability for modern construction projects.', 'No', 1200.00, 300.00, 5000, 'storage/product/chatgpt-image-may-25-6a3626fb49653_472.png', 'Active', NULL, '2026-06-20 11:06:59', '2026-07-07 12:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE `product_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `brand_name` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_brands`
--

INSERT INTO `product_brands` (`id`, `product_category_id`, `brand_name`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Wienerberger', 'storage/product-brand/download-5-6a311d665660f_840.jpg', 'Active', NULL, '2026-06-16 09:54:46', '2026-06-16 12:13:26'),
(2, 2, 'Bharat Bricks', 'storage/product-brand/download-6-6a311d9044ddc_769.jpg', 'Active', NULL, '2026-06-16 09:55:28', '2026-06-16 09:55:28'),
(3, 5, 'Asian Paints', 'storage/product-brand/download-6a311dc36092e_567.png', 'Active', NULL, '2026-06-16 09:56:19', '2026-06-16 09:56:19'),
(4, 5, 'Berger Paints', 'storage/product-brand/download-1-6a311dd669460_762.png', 'Active', NULL, '2026-06-16 09:56:38', '2026-06-16 09:56:38'),
(5, 5, 'Nerolac', 'storage/product-brand/download-7-6a311de80c2c8_361.jpg', 'Active', NULL, '2026-06-16 09:56:56', '2026-06-16 09:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(191) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_name`, `status`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Steel', 'Active', 'storage/product-category/download-6a31194bb3eb1_972.jpg', '2026-06-16 09:37:15', '2026-06-16 09:37:15', NULL),
(2, 'Bricks', 'Active', 'storage/product-category/download-1-6a31197d457b1_433.jpg', '2026-06-16 09:38:05', '2026-06-16 12:14:01', NULL),
(3, 'Sand', 'Active', 'storage/product-category/download-2-6a31199485a62_981.jpg', '2026-06-16 09:38:28', '2026-06-16 09:38:28', NULL),
(4, 'Tiles', 'Active', 'storage/product-category/download-3-6a3119cc95ef6_579.jpg', '2026-06-16 09:39:24', '2026-06-16 09:39:24', NULL),
(5, 'Paint', 'Active', 'storage/product-category/download-4-6a3119e5b07a8_961.jpg', '2026-06-16 09:39:49', '2026-06-16 09:39:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `customer_mobile` varchar(191) DEFAULT NULL,
  `customer_email` varchar(191) DEFAULT NULL,
  `address_type` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city_name` varchar(191) DEFAULT NULL,
  `state_name` varchar(191) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` int(11) NOT NULL DEFAULT 0,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `order_status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_mobile`, `customer_email`, `address_type`, `address`, `city_name`, `state_name`, `pincode`, `subtotal`, `tax`, `tax_percentage`, `grand_total`, `payment_status`, `order_status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ORD-20260706-HV91IZ', 19, 'Shuchita Pal', '8888888888', 'shuchita@12gmail.com', 'home', 'lucknow up', 'Lucknow', 'Uttar Pradesh', '123456', 50.00, 0.00, 0, 50.00, 'success', 'pending', '', '2026-07-06 12:05:48', '2026-07-06 15:13:25', NULL),
(2, 'ORD-20260706-QOP8H9', 1, 'Shubham Tiwari', '7619983829', 'shubham@gmail.com', 'office', 'lucknow', 'lucknow', 'Uttar Pradesh', '236538', 80.00, 0.00, 0, 80.00, 'pending', 'pending', '', '2026-07-06 15:13:04', '2026-07-06 15:13:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_orders_items`
--

CREATE TABLE `product_orders_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `variant_name` varchar(191) DEFAULT NULL,
  `category_name` varchar(191) DEFAULT NULL,
  `sub_category_name` varchar(191) DEFAULT NULL,
  `brand_name` varchar(191) DEFAULT NULL,
  `mrp_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `line_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_orders_items`
--

INSERT INTO `product_orders_items` (`id`, `order_id`, `product_id`, `variant_id`, `product_name`, `variant_name`, `category_name`, `sub_category_name`, `brand_name`, `mrp_price`, `sale_price`, `quantity`, `line_total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 4, 7, 'AAC Bricks', '600x200x100 mm', 'Bricks', 'AAC Blocks', 'Wienerberger', 55.00, 50.00, 1, 50.00, '2026-07-06 12:05:48', '2026-07-06 12:05:48', NULL),
(2, 2, 5, 10, 'Concrete Bricks', 'Heavy Duty', 'Bricks', 'Concrete Blocks', 'Bharat Bricks', 22.00, 20.00, 4, 80.00, '2026-07-06 15:13:04', '2026-07-06 15:13:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `value` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `name`, `value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Material', 'Clay', NULL, '2026-06-16 11:46:37', '2026-06-16 11:46:37'),
(2, 2, 'Color', 'Red', NULL, '2026-06-16 11:46:37', '2026-06-16 11:46:37'),
(3, 2, 'Compressive Strength', '7.5 N/mm²', NULL, '2026-06-16 11:46:37', '2026-06-16 11:46:37'),
(4, 2, 'Water Absorption', 'Less than 20%', NULL, '2026-06-16 11:46:37', '2026-06-16 11:46:37'),
(5, 2, 'Usage', 'Wall Construction', NULL, '2026-06-16 11:46:37', '2026-06-16 11:46:37'),
(6, 2, 'Shape', 'Rectangular', NULL, '2026-06-16 11:46:37', '2026-06-16 11:46:37'),
(7, 3, 'Material', 'Fly Ash', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(8, 3, 'Color', 'Grey', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(9, 3, 'Strength', '10 N/mm²', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(10, 4, 'Material', 'AAC', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(11, 4, 'Weight', 'Lightweight', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(12, 4, 'Thermal Insulation', 'Excellent', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(13, 5, 'Material', 'Concrete', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(14, 5, 'Color', 'Grey', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(15, 5, 'Usage', 'Commercial Construction', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(16, 6, 'Material', 'Concrete', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(17, 6, 'Type', 'Hollow', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(18, 6, 'Usage', 'Partition Walls', NULL, '2026-06-16 11:52:32', '2026-06-16 11:52:32'),
(19, 7, 'Material', 'Concrete', NULL, '2026-06-16 11:58:38', '2026-06-16 11:58:38'),
(20, 7, 'Color', 'Grey', NULL, '2026-06-16 11:58:38', '2026-06-16 11:58:38'),
(21, 7, 'Thickness', '60 mm', NULL, '2026-06-16 11:58:38', '2026-06-16 11:58:38'),
(22, 7, 'Usage', 'Driveway & Pathway', NULL, '2026-06-16 11:58:38', '2026-06-16 11:58:38'),
(23, 8, 'Material', 'Fly Ash', NULL, '2026-06-20 11:06:59', '2026-06-20 11:06:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_categories`
--

CREATE TABLE `product_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `sub_category_name` varchar(191) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sub_categories`
--

INSERT INTO `product_sub_categories` (`id`, `product_category_id`, `sub_category_name`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, 'Interior Paint', 'storage/product-sub-cat/download-4-6a323845de37d_719.jpg', 'Active', NULL, '2026-06-16 10:10:18', '2026-06-17 06:01:41'),
(2, 5, 'Exterior Paint', 'storage/product-sub-cat/download-3-6a323832c86ae_133.jpg', 'Active', NULL, '2026-06-16 10:10:25', '2026-06-17 06:01:22'),
(3, 5, 'Enamel Paint', 'storage/product-sub-cat/download-2-6a32381fc4395_300.jpg', 'Active', NULL, '2026-06-16 10:10:31', '2026-06-17 06:01:03'),
(4, 5, 'Primer', 'storage/product-sub-cat/download-1-6a3237ec6645d_925.jpg', 'Active', NULL, '2026-06-16 10:10:39', '2026-06-17 06:00:12'),
(5, 5, 'Waterproofing', 'storage/product-sub-cat/download-35-6a323a52d4904_942.jpg', 'Active', NULL, '2026-06-16 10:10:44', '2026-06-17 06:10:26'),
(6, 5, 'Wood Coating', 'storage/product-sub-cat/download-5-6a323853d06cf_299.jpg', 'Active', NULL, '2026-06-16 10:10:51', '2026-06-17 06:01:55'),
(7, 5, 'Metal Coating', 'storage/product-sub-cat/images-6a32386594214_488.jpg', 'Active', NULL, '2026-06-16 10:10:58', '2026-06-17 06:02:13'),
(8, 5, 'Putty', 'storage/product-sub-cat/download-6-6a323875535d5_843.jpg', 'Active', NULL, '2026-06-16 10:11:05', '2026-06-17 06:02:29'),
(9, 5, 'Specialty Paint', 'storage/product-sub-cat/download-7-6a323885dcc22_705.jpg', 'Active', NULL, '2026-06-16 10:11:14', '2026-06-17 06:02:45'),
(10, 2, 'Clay Bricks', 'storage/product-sub-cat/download-8-6a323895d4683_137.jpg', 'Active', NULL, '2026-06-16 10:11:48', '2026-06-17 06:03:01'),
(11, 2, 'Fly Ash Bricks', 'storage/product-sub-cat/download-9-6a3238a662ce5_187.jpg', 'Active', NULL, '2026-06-16 10:11:54', '2026-06-17 06:03:18'),
(12, 2, 'AAC Blocks', 'storage/product-sub-cat/download-10-6a3238b952b9a_452.jpg', 'Active', NULL, '2026-06-16 10:12:00', '2026-06-17 06:03:37'),
(13, 2, 'Concrete Blocks', 'storage/product-sub-cat/download-11-6a3238cb03002_572.jpg', 'Active', NULL, '2026-06-16 10:12:07', '2026-06-17 06:03:55'),
(14, 2, 'Paver Blocks', 'storage/product-sub-cat/download-12-6a3238dc4af20_110.jpg', 'Active', NULL, '2026-06-16 10:12:13', '2026-06-17 06:04:12'),
(15, 2, 'Refractory / Fire Bricks', 'storage/product-sub-cat/download-14-6a3238f70c341_120.jpg', 'Active', NULL, '2026-06-16 10:12:20', '2026-06-17 06:04:39'),
(16, 4, 'Floor Tiles', 'storage/product-sub-cat/download-25-6a3239b2e1575_716.jpg', 'Active', NULL, '2026-06-16 10:12:46', '2026-06-17 06:07:46'),
(17, 4, 'Wall Tiles', 'storage/product-sub-cat/download-24-6a3239a262c5f_716.jpg', 'Active', NULL, '2026-06-16 10:12:55', '2026-06-17 06:07:30'),
(18, 4, 'Vitrified Tiles', 'storage/product-sub-cat/download-23-6a323991ac198_498.jpg', 'Active', NULL, '2026-06-16 10:13:02', '2026-06-17 06:07:13'),
(19, 4, 'Parking / Outdoor Tiles', 'storage/product-sub-cat/download-22-6a32397f8ad85_204.jpg', 'Active', NULL, '2026-06-16 10:13:09', '2026-06-17 06:06:55'),
(20, 4, 'Digital Tiles', 'storage/product-sub-cat/download-21-6a323971dcff7_636.jpg', 'Active', NULL, '2026-06-16 10:13:19', '2026-06-17 06:06:41'),
(21, 4, 'Wooden Finish Tiles', 'storage/product-sub-cat/download-20-6a32396398961_909.jpg', 'Active', NULL, '2026-06-16 10:13:25', '2026-06-17 06:06:27'),
(22, 4, 'Elevation Tiles', 'storage/product-sub-cat/download-19-6a32395469be6_654.jpg', 'Active', NULL, '2026-06-16 10:13:32', '2026-06-17 06:06:12'),
(23, 4, 'Mosaic Tiles', 'storage/product-sub-cat/download-18-6a323940b1c05_447.jpg', 'Active', NULL, '2026-06-16 10:13:39', '2026-06-17 06:05:52'),
(24, 4, 'Marble / Stone Look Tiles', 'storage/product-sub-cat/download-16-6a32391b9ea49_407.jpg', 'Active', NULL, '2026-06-16 10:13:46', '2026-06-17 06:05:15'),
(25, 3, 'River Sand', 'storage/product-sub-cat/download-15-6a32390aa38ce_684.jpg', 'Active', NULL, '2026-06-16 10:14:12', '2026-06-17 06:04:58'),
(26, 3, 'M-Sand', 'storage/product-sub-cat/download-34-6a323a371d19a_546.jpg', 'Active', NULL, '2026-06-16 10:14:20', '2026-06-17 06:09:59'),
(27, 3, 'Plaster Sand', 'storage/product-sub-cat/download-33-6a323a265641a_977.jpg', 'Active', NULL, '2026-06-16 10:14:27', '2026-06-17 06:09:42'),
(28, 3, 'Concrete Sand', 'storage/product-sub-cat/download-32-6a323a1893c98_693.jpg', 'Active', NULL, '2026-06-16 10:14:33', '2026-06-17 06:09:28'),
(29, 3, 'Fill Sand', 'storage/product-sub-cat/download-31-6a323a07bc6bb_883.jpg', 'Active', NULL, '2026-06-16 10:14:41', '2026-06-17 06:09:11'),
(30, 1, 'TMT Bars', 'storage/product-sub-cat/download-30-6a3239f8940de_247.jpg', 'Active', NULL, '2026-06-16 10:15:16', '2026-06-17 06:08:56'),
(31, 1, 'Structural Steel', 'storage/product-sub-cat/download-29-6a3239e97ca2b_861.jpg', 'Active', NULL, '2026-06-16 10:15:24', '2026-06-17 06:08:41'),
(32, 1, 'Steel Pipes', 'storage/product-sub-cat/download-28-6a3239dc133df_466.jpg', 'Active', NULL, '2026-06-16 10:15:32', '2026-06-17 06:08:28'),
(33, 1, 'Steel Sheets & Plates', 'storage/product-sub-cat/download-27-6a3239cedfe36_956.jpg', 'Active', NULL, '2026-06-16 10:15:40', '2026-06-17 06:08:14'),
(34, 1, 'Wire & Mesh', 'storage/product-sub-cat/download-26-6a3239c1b4619_960.jpg', 'Active', NULL, '2026-06-16 10:15:48', '2026-06-17 06:08:01'),
(35, 1, 'Roofing Steel', 'storage/product-sub-cat/download-6a323797df26f_854.jpg', 'Active', NULL, '2026-06-16 10:15:56', '2026-06-17 05:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_name` varchar(191) DEFAULT NULL,
  `mrp_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `variant_name`, `mrp_price`, `sale_price`, `stock`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, '9 Inch Brick', 12.00, 10.50, 4998, NULL, '2026-06-16 11:04:47', '2026-07-01 18:40:13'),
(3, 2, '11 Inch Brick', 15.00, 13.50, 3000, NULL, '2026-06-16 11:45:35', '2026-06-16 11:45:35'),
(4, 2, 'Fly Ash Brick', 14.00, 12.50, 4000, NULL, '2026-06-16 11:45:35', '2026-06-16 11:45:35'),
(5, 3, '9 Inch', 12.00, 10.50, 5000, NULL, '2026-06-16 11:52:01', '2026-06-16 11:52:01'),
(6, 3, '11 Inch', 15.00, 13.50, 3495, NULL, '2026-06-16 11:52:01', '2026-07-01 18:40:12'),
(7, 4, '600x200x100 mm', 55.00, 50.00, 1971, NULL, '2026-06-16 11:52:01', '2026-07-06 12:05:48'),
(8, 4, '600x200x150 mm', 75.00, 70.00, 1492, NULL, '2026-06-16 11:52:01', '2026-07-02 11:34:24'),
(9, 5, 'Solid Concrete', 18.00, 16.00, 3998, NULL, '2026-06-16 11:52:01', '2026-06-30 13:38:00'),
(10, 5, 'Heavy Duty', 22.00, 20.00, 2496, NULL, '2026-06-16 11:52:01', '2026-07-06 15:13:04'),
(11, 6, '3 Hole Hollow', 20.00, 18.00, 2910, NULL, '2026-06-16 11:52:01', '2026-07-06 11:22:32'),
(12, 6, '4 Hole Hollow', 24.00, 22.00, 2498, NULL, '2026-06-16 11:52:01', '2026-07-02 11:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'web', '2026-06-06 19:40:51', '2026-06-06 19:40:51', NULL),
(4, 'Manager', 'web', '2026-07-03 09:20:40', '2026-07-03 09:27:18', NULL);

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
(1, 1),
(2, 1),
(4, 1),
(5, 1),
(7, 1),
(8, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(58, 4),
(59, 4),
(60, 4),
(61, 4),
(62, 4),
(63, 4),
(64, 4),
(65, 4),
(66, 4),
(67, 4),
(68, 4),
(69, 4),
(70, 4),
(71, 4),
(72, 4),
(73, 4),
(74, 4),
(75, 4),
(76, 4),
(77, 4),
(78, 4),
(79, 4),
(80, 4),
(81, 4),
(83, 4),
(84, 4),
(85, 4),
(86, 4),
(87, 4),
(88, 4),
(89, 4),
(90, 4),
(91, 4),
(92, 4),
(93, 4),
(94, 4),
(95, 4),
(96, 4),
(97, 4),
(98, 4),
(99, 4),
(100, 4),
(101, 4),
(102, 4),
(103, 4),
(104, 4),
(105, 4),
(106, 4),
(107, 4),
(108, 4),
(110, 4),
(111, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
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
('3JayVM1E6TJKtYkfrqWk6kG8dHc492r8BOcdaHKh', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHZDRFF4QkFHV2x3a0pVMmhSRFl5aTdtYmhyY1hPSklhYVlTWjhxTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789124086),
('3mLs7gbc5Ns5Mh4Un9bGoAA3wOehIG9mWAo665FL', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXhJQXY4YUtGZVpKVFoxOFdIdHNIQnk3eklrYVMyUmoxSTBiUWRZdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789884761),
('5eStybAtUQCeLIVwOBOigba64xNYbdN8zdj5JNR6', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXBUN0p4SkZja2R1WkJ2amR6eFJmdks2T2xhNzNqQUdJYUlBdG5ueCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789172585),
('7TxCcPJj2PRX7AGTtakB8sCdjo6rcnQ1oab4NARe', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGRlcHM0MUQ3UVJXWmh4aXlvaW00c0haNWVQWmJITW8wUG8zMHZZaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789799003),
('eXuUv70e3GgRV7DykhPqpJ3uSZQF4dsjJQPfZ0qr', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1M3cmlkMXJQbFBGMDRKRDRHcG5ETkJZcW1Cd0VSdExORkhGaUlBOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789609294),
('JI9fld86XxlVMCfQo1ntOg4NT6eiBfCUSp7HNRrU', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkYwSE9wcXJ1Y3Y2MVpSSnB6WDNPdnpza2dSZmVkS3VmTWw4Z2s1ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789965438),
('k0wHJtHxLr7nAfEH4NPHkBz4VF0MhVQRJBDxryUK', NULL, '35.94.107.14', 'Mozilla/5.0 (compatible; wpbot/1.4; +https://forms.gle/ajBaxygz9jSR8p8G9)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM045Q0JpSmhQbmNxanN0Vm9LbjkzNEU5VVljb3h1bUFoN0JDcDFMbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789201955),
('L8VEaf9dqSlBXAPejTOvpUE7MfZDgb5A6xUP97Bs', NULL, '2606:2040:140:a3:3952:262c:376c:c035', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1E3MEZESkVrN084TFhPMldKRFUyNnBGcDg0dnJEeE1Ha2l6aGkxVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789385475),
('lJOYFWG0TMEdEEodlBF8bFWYBPgUwWjQp6vIhpf1', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXozQWp3R0ZBUEhNVlI1NndvU1ROOEd0RkxSZzd3dzJ4RWJaTkJjUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789048095),
('mQ19AEjWHKssDOtOvTTZnRbIEIZZgI8vROnCSsT9', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYk9ialRqc0hHRThzcG1pOFk4WmFXdHZtcFRnT3RHN1V4UHpmbmxBeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789353128),
('qjbIN2l7KG4wSka8RUNlLkIPaplhjlFe6txSCKFW', NULL, '147.182.232.154', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieDBreTRoY1c5REUzQlpIbzVQUDNPcU9mV0RLUDFYejk0ekd4b212YyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789053559),
('w4wK8OoHCRSCocKgGGvd1RXAc6S0dV7uBBmnTz6n', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkhIOHgxYlA0YlRtOWtaY1hGbFJXcHBvY05jUERGb2VYUWZQSEhOSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789707894),
('WVBBX2EFiX7LmkwBARFV79XxERLWCVXZklBQCobH', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHBqb3pDUUQ2cWRXeFdibVFyRXZ1dE9GZmczandIOGVYT05oUWxMZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789467439),
('x0YunVDhIaAI22Qv70RargVaowXDCekJ2io7XTHH', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkY5MTM2RnJvTHBoYkV6RjB2S1dIcEF4MEV4cDFCbGFXRVFSREJOeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789520272),
('zZAZQjDmx6RsdlFKpSLY5KTHXCZcX4ZkCrkh1w7g', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNkE1UzE2YnZzaHVHWXY5ZkJUZVI3VmVaQkh6Wm04VFV4VFdiV0FZZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8veHBsb3JlLnNpZ25hdHVyZWl0c29mdHdhcmUuY29tIjtzOjU6InJvdXRlIjtzOjEwOiJhdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789297618);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `type`, `name`, `status`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'build', 'Build Slider', 'Active', 'storage/slider/bg-6a2c02c2b50e1_378.jpeg', '2026-06-09 12:15:03', '2026-06-12 12:59:46', NULL),
(2, 'survey', 'Survey Slider', 'Active', 'storage/slider/bg-6a2be5d44f170_295.jpeg', '2026-06-12 10:56:20', '2026-06-12 10:56:20', NULL),
(3, 'mart', 'Mart Slider', 'Active', 'storage/slider/bg-6a2be5e44f04c_481.jpeg', '2026-06-12 10:56:36', '2026-06-12 10:56:36', NULL),
(4, 'academy', 'Academy Slider', 'Active', 'storage/slider/bg-6a2be5f0e8ace_622.jpeg', '2026-06-12 10:56:48', '2026-06-12 10:56:48', NULL),
(5, 'equipment', 'Equipment', 'Active', 'storage/slider/bg-6a2be60166501_967.jpeg', '2026-06-12 10:57:05', '2026-06-12 10:58:18', NULL),
(6, 'home', 'Home Slider', 'Active', 'storage/slider/bg-6a2be632984bb_918.jpeg', '2026-06-12 10:57:54', '2026-07-03 13:16:36', NULL),
(7, 'home', 'test', 'Active', 'storage/slider/chatgpt-image-jun-13-6a48d0942db22_743.png', '2026-07-04 13:52:40', '2026-07-04 14:53:31', '2026-07-04 14:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `short_detail` text DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `name`, `short_detail`, `amount`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Land Boundary Survey', 'Identifies and marks legal property boundaries. Essential for property purchases, fencing, and ownership disputes.', 8000.00, 'storage/survey/images-2-6a4b60b82300c_416.jpg', 'Active', NULL, '2026-06-11 10:49:48', '2026-07-06 13:30:56'),
(2, 'Topographic Survey', 'Maps natural and man-made features along with elevation data. Used for construction planning and site development.', 15000.00, 'storage/survey/images-3-6a4b60cae162e_247.jpg', 'Active', NULL, '2026-06-18 11:04:19', '2026-07-06 13:31:14'),
(3, 'Construction Layout Survey', 'Marks building locations and reference points before construction begins. Ensures structures are built according to design plans.', 12000.00, 'storage/survey/images-4-6a4b60df69eeb_307.jpg', 'Active', NULL, '2026-06-18 11:04:35', '2026-07-06 13:31:35'),
(4, 'GPS/GNSS Survey', 'Uses satellite-based technology for highly accurate positioning. Suitable for infrastructure, road, and utility projects.', 10000.00, 'storage/survey/images-5-6a4b60f7bd766_180.jpg', 'Active', NULL, '2026-06-18 11:04:50', '2026-07-06 13:31:59'),
(5, 'Drone Mapping Survey', 'Captures high-resolution aerial images and creates detailed maps. Ideal for large sites, mining, and agriculture.', 20000.00, 'storage/survey/images-6-6a4b61052a077_814.jpg', 'Active', NULL, '2026-06-18 11:05:08', '2026-07-06 13:32:13'),
(6, 'GIS Mapping Service', 'Organizes spatial data into digital maps for analysis and planning. Useful for government, utilities, and businesses.', 18000.00, 'storage/survey/images-7-6a4b611ab2794_775.jpg', 'Active', NULL, '2026-06-18 11:05:28', '2026-07-06 13:32:34'),
(7, 'Contour Survey', 'Produces contour lines showing land elevation and slope. Commonly used for road design and land development.', 16000.00, 'storage/survey/images-8-6a4b6133c52ff_905.jpg', 'Active', NULL, '2026-06-18 11:05:43', '2026-07-06 13:32:59'),
(8, 'Utility Mapping', 'Detects and maps underground utilities such as water, gas, and electrical lines. Helps prevent damage during excavation.', 25000.00, 'storage/survey/images-9-6a4b613ca1d2a_312.jpg', 'Active', NULL, '2026-06-18 11:06:04', '2026-07-06 13:33:08'),
(9, 'As-Built Survey', 'Documents the final dimensions and locations of completed structures. Confirms that construction matches approved plans.', 14000.00, 'storage/survey/images-1-6a4b6098e880f_463.jpg', 'Active', NULL, '2026-06-18 11:06:21', '2026-07-06 13:30:24'),
(10, '3D Laser Scanning Survey', 'Creates accurate 3D digital models of buildings and infrastructure. Ideal for renovations, BIM, and industrial facilities.', 30000.00, 'storage/survey/images-6a4b607e43a3d_808.jpg', 'Active', NULL, '2026-06-18 11:06:39', '2026-07-06 13:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `survey_chats`
--

CREATE TABLE `survey_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_survey_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('vendor','customer') NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `attachment_path` varchar(191) DEFAULT NULL,
  `attachment_type` varchar(191) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_chats`
--

INSERT INTO `survey_chats` (`id`, `customer_survey_id`, `sender_type`, `sender_id`, `message`, `attachment_path`, `attachment_type`, `read_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'vendor', 1, 'hello', NULL, NULL, NULL, '2026-07-06 12:10:45', '2026-07-06 12:10:45', NULL),
(2, 3, 'customer', 1, NULL, 'storage/chat_attachments/nJvxL2cI400TqovTGAQc9YlA6DuatOsC7bWIU6bK.pdf', 'pdf', NULL, '2026-07-06 12:11:54', '2026-07-06 12:11:54', NULL),
(3, 3, 'vendor', 1, NULL, 'storage/chat_attachments/HurMkcRa1jqyDwQOczgNGNmY5JdEMsG3qKmTLFrn.jpg', 'image', NULL, '2026-07-06 12:12:12', '2026-07-06 12:12:12', NULL),
(4, 3, 'vendor', 1, 'hi', NULL, NULL, NULL, '2026-07-06 12:13:08', '2026-07-06 12:13:08', NULL),
(5, 5, 'vendor', 1, 'hhasdk', NULL, NULL, NULL, '2026-07-06 12:35:21', '2026-07-06 12:35:21', NULL),
(6, 5, 'vendor', 1, NULL, 'storage/chat_attachments/BYMrCXVMPH7gLYS3gdgpzhdHIyJ0mg3kicHHWji3.png', 'image', NULL, '2026-07-06 12:35:41', '2026-07-06 12:35:41', NULL),
(7, 5, 'customer', 1, 'hello', NULL, NULL, NULL, '2026-07-06 12:35:53', '2026-07-06 12:35:53', NULL),
(8, 5, 'vendor', 1, '123', 'storage/chat_attachments/6G3BmKP4GPuZNw0ioxka0xdw4ASswdbq2QytmBXO.pdf', 'pdf', NULL, '2026-07-06 12:36:13', '2026-07-06 12:36:13', NULL),
(9, 5, 'vendor', 1, 'fasfd', 'storage/chat_attachments/dVJoVdG6YOGFE25ZLNdqMfMbhganjx6Xc52YdQ7s.png', 'image', NULL, '2026-07-06 12:36:51', '2026-07-06 12:36:51', NULL),
(10, 5, 'vendor', 1, '956sdfs', NULL, NULL, NULL, '2026-07-06 12:37:02', '2026-07-06 12:37:02', NULL),
(11, 2, 'vendor', 1, 'sdafsdf', NULL, NULL, NULL, '2026-07-06 12:38:28', '2026-07-06 12:38:28', NULL),
(12, 2, 'vendor', 1, '6526', 'storage/chat_attachments/MCNBEByDMmeYtmjjTObRIvw2q2QMLFOSiZXfyqPj.png', 'image', NULL, '2026-07-06 12:39:04', '2026-07-06 12:39:04', NULL),
(13, 2, 'customer', 19, 'sghhhaj', NULL, NULL, NULL, '2026-07-06 12:49:18', '2026-07-06 12:49:18', NULL),
(14, 2, 'vendor', 1, 'asdad', NULL, NULL, NULL, '2026-07-06 12:49:51', '2026-07-06 12:49:51', NULL),
(15, 2, 'vendor', 1, 'gfhfh', NULL, NULL, NULL, '2026-07-06 13:00:50', '2026-07-06 13:00:50', NULL),
(16, 2, 'vendor', 1, 'sadsa', NULL, NULL, NULL, '2026-07-06 13:01:02', '2026-07-06 13:01:02', NULL),
(17, 25, 'customer', 35, NULL, 'storage/chat_attachments/jPrU9XvTJW1pUolBFh2ZLxHUX48EvFpyKTnJN3JI.pdf', 'pdf', NULL, '2026-07-06 16:49:03', '2026-07-06 16:49:03', NULL),
(18, 25, 'customer', 35, 'good', 'storage/chat_attachments/VN3vl7XPRFTyyOE0yN2wjZu1F6kAfa5jq09tanIl.jpg', 'image', NULL, '2026-07-06 16:49:17', '2026-07-06 16:49:17', NULL),
(19, 25, 'vendor', 1, 'hjg', NULL, NULL, NULL, '2026-07-06 16:49:39', '2026-07-06 16:49:39', NULL),
(20, 25, 'vendor', 1, 'sjkdgh', NULL, NULL, NULL, '2026-07-06 16:50:01', '2026-07-06 16:50:01', NULL),
(21, 2, 'customer', 19, 'bsbsb', NULL, NULL, NULL, '2026-07-06 16:57:22', '2026-07-06 16:57:22', NULL),
(22, 25, 'vendor', 1, 'sgdhf', NULL, NULL, NULL, '2026-07-06 16:57:57', '2026-07-06 16:57:57', NULL),
(23, 25, 'vendor', 1, 'sfdhsgf', NULL, NULL, NULL, '2026-07-06 16:58:07', '2026-07-06 16:58:07', NULL),
(24, 29, 'customer', 29, 'Hello', NULL, NULL, NULL, '2026-07-06 18:01:25', '2026-07-06 18:01:25', NULL),
(25, 29, 'vendor', 1, NULL, 'storage/chat_attachments/JfkOWF1cHaAfig2zPl6UYln0fJKh0djFJt453YCD.jpg', 'image', NULL, '2026-07-06 18:01:44', '2026-07-06 18:01:44', NULL),
(26, 29, 'vendor', 1, 'test', 'storage/chat_attachments/swEtjkEbXVsPou3pmk6PG8wBxsJFoJIyz9co6MST.jpg', 'image', NULL, '2026-07-06 18:03:15', '2026-07-06 18:03:15', NULL),
(27, 29, 'customer', 29, NULL, 'storage/chat_attachments/Ng7hDiDOJqUkL0aRpSW5KeAkiFrcz3ircON6pqBi.jpg', 'image', NULL, '2026-07-06 18:03:35', '2026-07-06 18:03:35', NULL),
(28, 29, 'customer', 29, 'Hi', NULL, NULL, NULL, '2026-07-06 18:20:15', '2026-07-06 18:20:15', NULL),
(29, 2, 'customer', 19, 'welcom xplore', 'storage/chat_attachments/rSGvC9NVyXwU2BDEbkSnTJmQGRfXx2uzcvwwJcUX.png', 'image', NULL, '2026-07-06 18:22:39', '2026-07-06 18:22:39', NULL),
(30, 2, 'vendor', 1, 'fhjh', NULL, NULL, NULL, '2026-07-06 18:31:32', '2026-07-06 18:31:32', NULL),
(31, 2, 'vendor', 1, NULL, 'storage/chat_attachments/MmTWu5zQu6E3J8jB1PhpVMuP9GV2mWIS7CNBN21B.png', 'image', NULL, '2026-07-06 18:31:53', '2026-07-06 18:31:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `txn_for` enum('survey','product','rental_product','course') DEFAULT NULL,
  `order_id` varchar(191) DEFAULT NULL,
  `razorpay_order_id` varchar(191) DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `razorpay_payment_id` varchar(191) DEFAULT NULL,
  `razorpay_signature` varchar(191) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `final_status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `razorpay_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `rel_id`, `txn_for`, `order_id`, `razorpay_order_id`, `transaction_id`, `razorpay_payment_id`, `razorpay_signature`, `amount`, `status`, `final_status`, `razorpay_payload`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 19, 1, 'product', '1', 'order_dummy_mUUFKczKqm', NULL, 'NA', 'NA', 50.00, 'success', 'success', NULL, 'Payment for product', '2026-07-06 12:05:53', '2026-07-06 12:05:53'),
(2, 19, 1, 'survey', '2', 'order_dummy_zfWqZEI1Ec', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 12:06:51', '2026-07-06 12:06:51'),
(3, 19, 2, 'survey', '3', 'order_dummy_xap88ZWwLN', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 12:07:25', '2026-07-06 12:07:25'),
(4, 1, 3, 'survey', '4', 'order_dummy_ABeOS89A9X', NULL, 'NA', 'NA', 25000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 12:09:48', '2026-07-06 12:09:48'),
(5, 1, 5, 'survey', '5', 'order_dummy_FR9rwmflJw', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 12:34:35', '2026-07-06 12:34:36'),
(6, 19, 9, 'survey', '6', 'order_dummy_AKN8TsT1Da', NULL, 'NA', 'NA', 30000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 13:50:49', '2026-07-06 13:50:50'),
(7, 1, 1, 'product', '7', 'order_dummy_wsxyEnM2En', NULL, 'NA', 'NA', 50.00, 'success', 'success', NULL, 'Payment for product', '2026-07-06 15:13:12', '2026-07-06 15:13:12'),
(8, 1, 1, 'product', '8', 'order_dummy_tDjfC4eBCo', NULL, 'NA', 'NA', 50.00, 'success', 'success', NULL, 'Payment for product', '2026-07-06 15:13:17', '2026-07-06 15:13:17'),
(9, 1, 1, 'product', '9', 'order_dummy_qZHuLR7LQr', NULL, 'NA', 'NA', 50.00, 'success', 'success', NULL, 'Payment for product', '2026-07-06 15:13:25', '2026-07-06 15:13:25'),
(10, 19, 23, 'survey', '10', 'order_dummy_CdFbvaKeGu', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 15:44:44', '2026-07-06 15:44:44'),
(11, 19, 23, 'survey', '11', 'order_dummy_B2naNC0klk', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 15:44:45', '2026-07-06 15:44:45'),
(12, 19, 23, 'survey', '12', 'order_dummy_5ZrDlMy7Gp', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 15:44:45', '2026-07-06 15:44:45'),
(13, 19, 24, 'survey', '13', 'order_dummy_x7Be1fl4tR', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 15:49:16', '2026-07-06 15:49:17'),
(14, 35, 25, 'survey', '14', 'order_dummy_vAQ80s8oOR', NULL, 'NA', 'NA', 30000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 16:47:49', '2026-07-06 16:47:49'),
(15, 1, 26, 'survey', '15', 'order_dummy_zHUclsOxur', NULL, 'NA', 'NA', 16000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 17:31:48', '2026-07-06 17:31:48'),
(16, 29, 29, 'survey', '16', 'order_dummy_5xkzLAelRp', NULL, 'mock_payment_id_123', 'mock_signature_456', 30000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 18:00:17', '2026-07-06 18:00:17'),
(17, 1, 30, 'survey', '17', 'order_dummy_KJBFrSt6R0', NULL, 'NA', 'NA', 12000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 18:42:26', '2026-07-06 18:42:26'),
(18, 29, 31, 'survey', '18', 'order_dummy_1qkeZV28DN', NULL, 'mock_payment_id_123', 'mock_signature_456', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-06 18:47:30', '2026-07-06 18:47:30'),
(19, 29, 32, 'survey', '19', 'order_dummy_5S9dPgFuHi', NULL, 'mock_payment_id_123', 'mock_signature_456', 10000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-07 10:15:37', '2026-07-07 10:15:38'),
(20, 1, 34, 'survey', '20', 'order_dummy_BJ4DJPjvhi', NULL, 'NA', 'NA', 14000.00, 'success', 'success', NULL, 'Payment for survey', '2026-07-07 10:48:26', '2026-07-07 10:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `raw_password` varchar(191) DEFAULT NULL,
  `profile_pic` varchar(191) DEFAULT NULL,
  `status` enum('Active','Inactive','Blocked') NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `raw_password`, `profile_pic`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '2026-06-09 11:18:07', '$2y$12$dLpVReIFNtlOyYUD8SW5/OueXuITYKJv2TB6Ur33Mpq7lSSoFFvG2', 'admin@123', 'storage/user/user-6a2bfa3ad89cd_161.jpg', 'Active', 'AZsRqguS5dpgTi1ni4pX9P66og1CxgaHMprhY4jpUVnQ6K4h6D6qSvzAlkNR', '2026-06-09 11:18:07', '2026-07-06 18:36:38', NULL),
(2, 'Sandeep Singh', 'manager@gmail.com', NULL, '$2y$12$q3sIn.xdXsacZ08osVSmmujlgASplhz1KQrnRg2dd89L4YbT6IDjS', 'manager@gmail.com', 'storage/user/logo-1-6a27e68b6b2e6-6a2b949dbb970_720.png', 'Active', 'kK6C7KD4dsrwfu1xDzhdsAQUtTIxBYC2bwtZCu0WnoUeYsAFmPC6MuUkyDtE', '2026-06-09 12:56:57', '2026-07-06 14:56:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email_id` varchar(191) DEFAULT NULL,
  `phone_no` varchar(191) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `profile_image` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `raw_password` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Active','Inactive','Blocked') NOT NULL DEFAULT 'Pending',
  `vendor_type` enum('survey','product','rental_product','course') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email_id`, `phone_no`, `gender`, `profile_image`, `password`, `raw_password`, `remember_token`, `status`, `vendor_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ankit Singh', 'ankit@gmail.com', '8989244234', 'Male', 'storage/vendor/download-6a3f803f7501b_922.jpg', '$2y$12$ljsAFYxAMVnQG.uREM8QGujWr3JORw5uiHXgGzxg7CNOfE214PLNC', 'ankit@123', 'uw1DpMIcvXQgL3WRdmkR5UHRr4aELy2zHTc11rWjnJqQyklAt2dmiOaH5mQv', 'Active', 'survey', '2026-06-27 07:47:48', '2026-07-06 18:37:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `email_id` varchar(200) DEFAULT NULL,
  `phone_no` varchar(10) DEFAULT NULL,
  `whatsapp_no` varchar(10) DEFAULT NULL,
  `facebook_link` varchar(191) DEFAULT NULL,
  `instagram_link` varchar(191) DEFAULT NULL,
  `twitter_link` varchar(191) DEFAULT NULL,
  `youtube_link` varchar(191) DEFAULT NULL,
  `copyright` varchar(191) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `favicon` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qr_image` varchar(191) DEFAULT NULL,
  `sign_image` varchar(191) DEFAULT NULL,
  `stamp_image` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `company_name`, `email_id`, `phone_no`, `whatsapp_no`, `facebook_link`, `instagram_link`, `twitter_link`, `youtube_link`, `copyright`, `logo`, `favicon`, `address`, `created_at`, `updated_at`, `qr_image`, `sign_image`, `stamp_image`) VALUES
(1, 'Xplore Mapping Services', 'xplore@gmail.com', '1234567890', '1234567890', 'https://www.facebook.com/', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.youtube.com/', 'All rights reserved By Xplore', 'storage/setting/logo-1-6a27e68b6b2e6-6a2b948f8a922_284.png', 'storage/setting/logo-1-6a27e68b6b2e6-6a2b948f8ad7d_834.png', 'Lucknow, Uttar Pradesh 230142', '2026-06-06 20:11:04', '2026-07-04 05:51:18', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cms_pagename_unique` (`pagename`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_course_category_id_foreign` (`course_category_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_contents`
--
ALTER TABLE `course_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_contents_topic_id_foreign` (`topic_id`);

--
-- Indexes for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_lessons_course_id_foreign` (`course_id`);

--
-- Indexes for table `course_topics`
--
ALTER TABLE `course_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_topics_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_phone_no_unique` (`phone_no`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customer_surveys`
--
ALTER TABLE `customer_surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_queries`
--
ALTER TABLE `help_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_questions`
--
ALTER TABLE `help_questions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_orders_order_number_unique` (`order_number`);

--
-- Indexes for table `product_orders_items`
--
ALTER TABLE `product_orders_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_chats`
--
ALTER TABLE `survey_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_order_id_unique` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_settings`
--
ALTER TABLE `web_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_contents`
--
ALTER TABLE `course_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_lessons`
--
ALTER TABLE `course_lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `course_topics`
--
ALTER TABLE `course_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer_surveys`
--
ALTER TABLE `customer_surveys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `help_queries`
--
ALTER TABLE `help_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `help_questions`
--
ALTER TABLE `help_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_brands`
--
ALTER TABLE `product_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_orders_items`
--
ALTER TABLE `product_orders_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `survey_chats`
--
ALTER TABLE `survey_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `web_settings`
--
ALTER TABLE `web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_course_category_id_foreign` FOREIGN KEY (`course_category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_contents`
--
ALTER TABLE `course_contents`
  ADD CONSTRAINT `course_contents_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `course_topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD CONSTRAINT `course_lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_topics`
--
ALTER TABLE `course_topics`
  ADD CONSTRAINT `course_topics_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
