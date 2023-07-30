-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2023 at 02:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `lk_qualification_types`
--

CREATE TABLE `lk_qualification_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `qualification_type_en` varchar(100) NOT NULL,
  `qualification_type_ar` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lk_qualification_types`
--

INSERT INTO `lk_qualification_types` (`id`, `qualification_type_en`, `qualification_type_ar`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Research Only', 'بحث فقط', '1', '2023-07-16 12:55:53', '2023-07-16 12:55:53'),
(2, 'Subjects Only', 'مواد فقط', '2', '2023-07-16 12:55:53', '2023-07-16 12:55:53'),
(3, 'Research and Subjects', 'مشترك بحث ومواد تخصصية', '3', '2023-07-16 12:55:53', '2023-07-16 12:55:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lk_qualification_types`
--
ALTER TABLE `lk_qualification_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lk_qualification_types_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lk_qualification_types`
--
ALTER TABLE `lk_qualification_types`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
