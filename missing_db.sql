-- phpMyAdmin SQL Dump
-- Database: `missing_db`

CREATE DATABASE IF NOT EXISTS `missing_db`;
USE `missing_db`;

-- --------------------------------------------------------

-- Table structure for table `missing_reports`
CREATE TABLE `missing_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency` varchar(100) NOT NULL,
  `report_location` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `floor` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
