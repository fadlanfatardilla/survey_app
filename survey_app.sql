-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 23, 2024 at 04:22 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `survey_id` int DEFAULT NULL,
  `answer` text NOT NULL,
  `answered_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `survey_id`, `answer`, `answered_by`, `created_at`) VALUES
(1, 1, 'Ini Jawaban Klarifikasi', 2, '2024-08-14 12:32:44'),
(2, 2, 'Ini Jawaban Survey baru', 2, '2024-08-15 06:42:10'),
(3, 10, 'Ini jawaban dari Apaan', 2, '2024-08-20 14:53:29'),
(4, 12, 'Oke sekarang tanggal 22 Agustus 2024', 2, '2024-08-22 03:56:46'),
(5, 4, 'Ini jawaban survey baru', 2, '2024-08-22 04:21:15'),
(6, 5, 'dijawab', 2, '2024-08-22 04:28:15'),
(7, 9, 'dijawab lagi', 2, '2024-08-22 04:28:55'),
(8, 8, 'jawaban baru', 2, '2024-08-22 04:29:59'),
(9, 13, 'ini jawaban lah', 2, '2024-08-22 04:32:34'),
(10, 14, 'jawaban coba', 2, '2024-08-23 15:28:59'),
(11, 15, 'jawaban coba lagi', 2, '2024-08-23 16:03:36'),
(12, 17, 'makasih lia atas survey nya', 2, '2024-08-23 16:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `title`, `description`, `created_by`, `created_at`) VALUES
(1, 'Klarifikasi', 'Ini adalah Klarifikasi', 1, '2024-08-14 12:30:52'),
(2, 'Survey baru', 'Ini adalah survey baru', 1, '2024-08-15 03:54:46'),
(3, 'Survey baru', 'Ini adalah survey baru', 1, '2024-08-15 03:54:52'),
(4, 'Survey baru', 'Ini adalah survey baru', 1, '2024-08-15 03:54:54'),
(5, 'Survey baru', 'Ini adalah survey baru', 1, '2024-08-15 03:54:55'),
(7, 'Apa', 'Ini apa', 1, '2024-08-15 03:57:38'),
(8, 'baru', 'baru', 1, '2024-08-15 05:45:45'),
(9, 'Survey terbaru', 'baru banget', 1, '2024-08-15 05:50:37'),
(10, 'Apaan', 'Ini Deskripsi Apaan', 1, '2024-08-20 14:52:37'),
(11, 'New Survey', 'Ini adalah deskripsi dari new survey', 1, '2024-08-21 08:55:52'),
(12, 'New Date', 'Now 22 Agustus 2024', 1, '2024-08-22 03:55:36'),
(13, 'surveyyy', 'surveyy dongg', 1, '2024-08-22 04:31:51'),
(14, 'coba', 'ini coba coba', 1, '2024-08-23 15:16:26'),
(15, 'coba lagi', 'ini coba lagi', 1, '2024-08-23 15:17:39'),
(16, 'coba lagi', 'ini coba lagi', 1, '2024-08-23 15:17:43'),
(17, 'ini survey', 'ini survey baru dari lia', 7, '2024-08-23 16:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'fadlan', '$2y$10$aK2zq5Txn96afcAIOL5E0e0eQgTc3bW.PS..hAItu4i.mkYzxLhAa', 'client', '2024-08-14 12:10:04'),
(2, 'tes', '$2y$10$omfH4aDQ3h2YSVBQ6CPqSOUWxUIMzmgHzceWRLvDwoH05y6Lgan1K', 'admin', '2024-08-14 12:10:49'),
(3, 'adi', '$2y$10$/5t5YtA1mrRsLevvZ7YX1u1yvuh/jNd0qI7J4bbsJRGb287tDSatK', 'client', '2024-08-15 03:11:22'),
(5, 'rudi', '$2y$10$EZhtQZ/wDigukEdlNpLrmuq7jbx9tIKyaD4kUwUpGoCCin.ybHKee', 'client', '2024-08-20 14:56:45'),
(6, 'ika', '$2y$10$b3Nmn.kQsRpo/MnoAjvoy.ewku2nQaSJ4fl6xit8AkMgfigVa3i.y', 'admin', '2024-08-20 14:58:46'),
(7, 'lia', '$2y$10$tEkUgrwmjUi5s8Ix/wquKOl26GXNdSaURAVnx9zEe1vl9NOGScDS.', 'client', '2024-08-23 16:04:59'),
(8, 'coba', '$2y$10$rE..PA0tOSOH2pjeuUYnMeA0oG/vsi84JGiHXy6K/GoDyK5GAjaey', 'client', '2024-08-23 16:20:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `answered_by` (`answered_by`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`answered_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
