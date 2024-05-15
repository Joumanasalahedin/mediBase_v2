-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2024 at 05:40 AM
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
-- Database: `medibase`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('female','male','other','') DEFAULT NULL,
  `nationality` varchar(25) DEFAULT NULL,
  `address` varchar(75) DEFAULT NULL,
  `mobile_phone` varchar(25) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `license_no` varchar(10) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `birth_date`, `gender`, `nationality`, `address`, `mobile_phone`, `email`, `license_no`, `department`, `position`, `username`, `password`) VALUES
(2, 'Hania Batt', '2003-08-18', 'female', 'Egypt', NULL, NULL, 'batota.hania@gmail.com', NULL, 'Cardiology', 'Consultant', 'batota', '$2y$10$eaL5phtOVKACqwsQvMHOB.9a4ikjxGv2u4mOFfM1flDYxdNYL.0yO'),
(7, 'Lana Zamel', '1975-07-20', 'female', 'Palestine', '56 Berliner Strasse, 65974', '+491785648965', 'lana@gmail.com', '6598742C', 'Dermatology', 'Medical Doctor (MD)', 'lanlona', '$2y$10$xObdgznRNS1dYm/jq97CTu2.NKSS/y2HFtdI4FVXHwVrFM56MqwTi'),
(10, 'Retaj Batt', NULL, NULL, NULL, NULL, NULL, 'retaj.batt@gmail.com', NULL, NULL, NULL, 'dodo24', '$2y$10$DCjJdfAqji3bQ7z0wcHn1O2oUIplacfAIQBYO63vACLcOFJcbDavu'),
(12, 'Paul', NULL, NULL, NULL, NULL, NULL, 'paul@gmail.com', NULL, NULL, NULL, 'Walker', '$2y$10$hRMFk0Zt8Z/A2uC0gIxkXealYIWFM6O6BQPaWey5PXCVwlsL.CK8K'),
(13, 'Elena Walker', NULL, NULL, NULL, NULL, NULL, 'elena@gmail.com', NULL, NULL, NULL, 'elena32', '$2y$10$3SUrTlXtKRRNkLg9sDaAwuOUPmzpj8.VOqzJdPVvNxkuT7jqLy18W'),
(14, 'Joumana Elsayed', NULL, NULL, NULL, NULL, NULL, 'joumanasalahedin@gmail.com', NULL, 'Emergency', NULL, 'joumanaarafa', '$2y$10$2cBeIcE5epDcXvVqYj/Teu/1GwkH76RMkOxQTZeE7XP0rS2blIACa'),
(17, 'somb', '2000-02-15', NULL, NULL, NULL, NULL, 'somto@gmail.com', NULL, 'Obstetrics and Gynecology (OB/GYN)', NULL, 'somto', '$2y$10$i7uyjNxE/N7rcUee8O.80OV0wliqWl7W2ClDLD7NAGojfkLnumsKC'),
(18, 'Rachel Green', '1986-01-21', 'female', '', '', '', 'rachel@gmail.com', '', 'Neurology', '', 'rachel', '$2y$10$iLn75Uq8SRfGFYi9MOMu6OgOf16WB1kqnZJtlpwKByyIOhlMUWCZi');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('female','male','other','') NOT NULL,
  `nationality` varchar(25) NOT NULL,
  `health_insurance_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_phone` varchar(25) NOT NULL,
  `emergency_contact_name` varchar(50) NOT NULL,
  `emergency_contact_no` varchar(25) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `height` int(5) NOT NULL,
  `weight` int(5) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `chronic_diseases` varchar(255) DEFAULT NULL,
  `disabilities` varchar(255) DEFAULT NULL,
  `vaccines` varchar(255) DEFAULT NULL,
  `medications` varchar(255) DEFAULT NULL,
  `lab_images` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `birthdate`, `gender`, `nationality`, `health_insurance_no`, `email`, `mobile_phone`, `emergency_contact_name`, `emergency_contact_no`, `doctor_id`, `height`, `weight`, `blood_group`, `allergies`, `chronic_diseases`, `disabilities`, `vaccines`, `medications`, `lab_images`) VALUES
(1, 'Jane', 'Doe', '1985-02-14', 'female', 'Germany', 'HIN1234567890', 'janedoe@example.com', '+491234567891', 'John Doe', '+491234567892', 2, 170, 65, 'A+', 'Penicillin', 'Hypertension', 'None', 'Influenza, Tetanus', NULL, ''),
(3, 'Michael', 'Jonas', '2000-06-05', 'male', 'Germany', 'HC7468594', 'michaeljonas@gmail.com', '+491563450908', 'Katrina Jonas', '+491763408162', 2, 180, 83, 'A+', 'Bees', NULL, NULL, 'COVID-19, Tetanus', NULL, ''),
(5, 'Lukas', 'Müller', '1988-03-10', 'male', 'Switzerland', 'TK54867135', 'lukas.mueller@gmail.com', '+491234567890', 'Anna Müller', '+491658743548', 7, 180, 86, 'B+', '', 'High Cholesterol', '', 'Flu, Hepatitis B', '', 0x4e65772050617373706f72742050686f746f2e6a7067),
(6, 'Elena', 'Schmidt', '1995-06-25', 'female', 'France', 'DAK52468367', 'elena.schmidt@gmail.com', '+491234567894', 'Markus Schmidt', '+491234567895', 7, 155, 60, 'A+', '', '', '', 'Flu, Hepatitis B', 'Monoxidil', ''),
(9, 'Paul', 'Walker', '1995-01-25', 'male', 'Albania', 'TK2548973', 'paul@outlook.com', '+4935261795', 'Sophia', '+4936527497', 13, 180, 95, 'A+', '', '', '', 'COVID-19', '', ''),
(10, 'Rowaida', 'Mohammed', '2000-07-19', 'female', 'Jordan', 'HK85597165', 'rowaida@gmail.com', '+49625187855', 'Mohammed Abdelsalam', '+491234567893', 7, 163, 70, 'A+', 'Fish', 'Diabetes I', '', 'COVID-19, Tetanus', 'Insulin Shots', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`first_name`),
  ADD KEY `fk_doctor_id` (`doctor_id`),
  ADD KEY `last_name` (`last_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
