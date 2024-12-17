-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 12, 2024 at 08:04 PM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u749416021_sarangpr`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_user` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_user`, `remember_token`, `created_at`, `updated_at`, `jabatan`, `pic`) VALUES
(2, 'DebbyStore', 'debbystore@guardian.my.id', '$2y$10$HuABt1CMfkayJUWcBM31NuokS/71S3rNKCJqyguoeUK5U/bx6APuy', 'Admin', NULL, '2022-09-03 22:44:40', '2022-09-03 22:44:40', 'Admin Toko', NULL),
(3, 'Jessy Store', 'jessy@guardian.my.id', '$2y$10$/nZkI.1UyytEhiPWbstL9ekch5uvQQEZHRwgogSdCfFAiEB8Q8aQa', 'Admin', NULL, '2022-09-04 00:59:55', '2022-09-04 00:59:55', 'Admin Toko', NULL),
(4, 'Guardion', 'guardion@guardian.my.id', '$2y$10$kjHo2N6.7mKBUzHd6ZfGLOlxVkxn2TN7a5mHDGgs/mSI4ursI9OBS', 'Super Admin', '0rmEkI2klJQHDFDbO4yCV97QSG0S3lQ2LVYTIJUP0DGUtxgK5kbw8YVDTs1a', '2022-09-05 07:50:33', '2022-09-05 07:50:33', 'Kepala Toko', NULL),
(7, 'Dika', 'mahardika@guardian.my.id', '$2y$10$PY0O64mKR/1YO7rKclP0busZjQ4UjwLbDyGGoTfNDn0Ihz74Rk5K.', 'Super Admin', NULL, '2022-11-16 16:27:23', '2024-04-02 01:54:49', 'Kepala Toko', NULL),
(8, 'Grace', 'grace@guardian.my.id', '$2y$10$eORyXi8AiBB2WB4dhEp6KuwyAWl5x8Es1iD15pUDTQFX809AH3/r2', 'Super Admin', '6lK4VBxMUGy1tI1nmzEUH09sHugPQWbvkiMNlyVxGG9f8T67t2zQSk5MY9SU', '2022-11-16 16:28:28', '2024-04-02 02:05:38', 'Kepala Toko', NULL),
(17, 'Azmy', 'azmy@guardian.my.id', '$2y$10$9KNwf0rOlbYdxqAgB8C8ROTASKxKysCTipmJjdK5vd4VDz/bbI.i6', 'Admin', NULL, '2023-03-26 00:23:02', '2023-03-26 00:23:02', 'Admin Toko', NULL),
(18, 'Ardan', 'ardan@guardian.my.id', '$2y$10$/0tsQ2nQgzjgiaCF9W9gkepnYrwSWSm3gB/BgCMtecW.t8V3gMON2', 'Super Admin', 'oxzTUa19rApIQMRxpbue7C8W0yd9PUqJMY9naxTN6eApI3SPHcnIXqFYDEew', '2023-03-26 00:24:13', '2023-03-26 00:24:13', 'Kepala Toko', NULL),
(20, 'Caca', 'caca@guardian.my.id', '$2y$10$aCu6NaQrsh4nkuS9jQEMK.P0WO6uczJsejLWt1S2v5r8Op1MOTQI6', 'Super Admin', NULL, '2022-11-16 16:26:44', '2022-11-16 16:26:44', 'Kepala Toko', NULL),
(21, 'Rudi', 'rudi@guardian.my.id', '$2y$10$wV4jP8XLTSi3egbh1y/zCeJIXc/Xvsr0MSfzWWJLO3qw67Nd6A9da', 'Super Admin', 'vrrD2vkr9NCHbzcS3PooQHLXy7mi1mjVC2SyrihOXI0W3nzSriMPS4ODoaHL', '2022-11-16 16:26:44', '2023-10-19 20:44:43', 'Kepala Toko', NULL),
(25, 'Lvronkaa', 'Lvronkaa@guardian.my.id', '$2y$10$fd7P4rg4zgJ08jU8PPJ/KuiYmf2owOvHlPDonvSxrpWIHGYLz8zve', 'Super Admin', NULL, '2023-08-14 12:47:06', '2023-08-14 12:47:06', 'KEPALA TOKO', 'Grace'),
(27, 'BANGKIT', 'bangkit@guardian.my.id', '$2y$10$ne/XJXOgaHFplb1Y45Xfg./1K2B1.CiZTib5lDhMF3MzJje6G2PVK', 'Super Admin', NULL, '2024-02-03 08:28:47', '2024-02-03 08:28:47', 'Ketua WhatsApp Team Jessy', 'Grace'),
(29, 'FIRDA', 'firda@guardian.my.id', '$2y$10$/piRXQtkLj4ebUI1zmTekuNEAdLS/JK6rRfTvLqzYXL6VsdjJtHku', 'User', NULL, '2024-02-19 11:17:49', '2024-04-03 07:52:00', 'ADMIN', 'Guardion'),
(30, 'Sela', 'sela@guardian.my.id', '$2y$10$N8UthXdHmitL6B06PsIgc.fpVOz8MVdjMFkU7S7vNnTSTLl57prp6', 'User', NULL, '2024-03-23 05:46:28', '2024-04-06 08:17:45', 'Admin', 'Guardion');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
