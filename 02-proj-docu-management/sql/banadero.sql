-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 10:12 AM
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
-- Database: `banadero`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `is_ban` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `verify_token` varchar(100) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `name`, `email`, `password`, `phone`, `role`, `is_ban`, `created_at`, `verify_token`, `token_expiration`) VALUES
(1, 'sample_name', 'staff@gmail.com', '$2y$10$36sVhSuP641a9O3RavokX.8T641BH/ZCsYfXK/bRxEF64pGBWjGUq', '09234653639', 'staff', 0, '2025-02-13', '065c6b7ca7c5c2398c4aaaf538bdb183AMSBanadero', '2025-02-19 10:14:52'),
(2, 'Secretary_User', 'ABHsecretary@gmail.com', '$2y$10$XP4EPUl0gDXyFhjdO7lHPu/uN9CwGTufrHqKuK7mu3pLgQE9UNkqu', '09090909090', 'secretary', 0, '2025-05-16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `personal_id` int(11) NOT NULL,
  `action_type` enum('insert','update') NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `performed_by` varchar(100) DEFAULT 'system',
  `length_of_years` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangaycertificate`
--

CREATE TABLE `barangaycertificate` (
  `id` int(11) NOT NULL,
  `since` int(11) NOT NULL,
  `age` int(120) NOT NULL,
  `birthday` date NOT NULL,
  `civilstatus` enum('single','married','widow','separated') NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `services` varchar(255) DEFAULT NULL,
  `personal_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `optionaluse` varchar(55) DEFAULT NULL,
  `councilor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangayclearance`
--

CREATE TABLE `barangayclearance` (
  `id` int(11) NOT NULL,
  `since` int(11) NOT NULL,
  `age` int(120) NOT NULL,
  `birthday` date NOT NULL,
  `civilstatus` enum('single','married','widow','separated') NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `services` varchar(255) DEFAULT NULL,
  `personal_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `optionaluse` varchar(55) DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangayindigency`
--

CREATE TABLE `barangayindigency` (
  `id` int(11) NOT NULL,
  `since` int(11) NOT NULL,
  `age` int(120) NOT NULL,
  `birthday` date NOT NULL,
  `civilstatus` enum('single','married','widow','separated') NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `optionaluse` varchar(55) DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangayresidency`
--

CREATE TABLE `barangayresidency` (
  `id` int(11) NOT NULL,
  `since` int(11) NOT NULL,
  `age` int(120) NOT NULL,
  `birthday` date NOT NULL,
  `civilstatus` enum('single','married','widow','separated') NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `optionaluse` varchar(55) DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buildingclearance`
--

CREATE TABLE `buildingclearance` (
  `id` int(11) NOT NULL,
  `buildingcode` varchar(20) NOT NULL,
  `floorarea` varchar(255) NOT NULL,
  `construction` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `personal_Id` int(11) NOT NULL,
  `usedfor` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `or_date` date DEFAULT NULL,
  `cedula_no` varchar(50) DEFAULT NULL,
  `issued_at` varchar(100) DEFAULT NULL,
  `issued_on` date DEFAULT NULL,
  `or_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `businessclearance`
--

CREATE TABLE `businessclearance` (
  `id` int(11) NOT NULL,
  `businesscode` varchar(20) NOT NULL,
  `businessname` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `manager` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `or_number` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `personal_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificateofgoodmoral`
--

CREATE TABLE `certificateofgoodmoral` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `usedfor` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificationofcalamity`
--

CREATE TABLE `certificationofcalamity` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `calamitytypes` varchar(255) NOT NULL,
  `calamitydate` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `purpose` varchar(25) DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificationofesc`
--

CREATE TABLE `certificationofesc` (
  `id` int(11) NOT NULL,
  `father` varchar(45) DEFAULT NULL,
  `mother` varchar(45) DEFAULT NULL,
  `child` varchar(40) NOT NULL,
  `school` varchar(50) NOT NULL,
  `residentsince` date NOT NULL,
  `purpose` varchar(25) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `personal_Id` int(11) NOT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificationoflegitimacy`
--

CREATE TABLE `certificationoflegitimacy` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `work` varchar(255) NOT NULL,
  `yearsofwork` int(11) NOT NULL,
  `usedfor` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `age` int(3) DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificationoflowincome`
--

CREATE TABLE `certificationoflowincome` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `work` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `usedfor` varchar(255) DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificationofsourceofincome`
--

CREATE TABLE `certificationofsourceofincome` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `work` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `usedfor` varchar(255) DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cohabitationletter`
--

CREATE TABLE `cohabitationletter` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `namefor` varchar(255) NOT NULL,
  `purposefor` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bornfor` date DEFAULT NULL,
  `partnerbornfor` date DEFAULT NULL,
  `yearslivein` int(11) DEFAULT 0,
  `sincedateliving` date DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `franchising`
--

CREATE TABLE `franchising` (
  `id` int(11) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `franchisingcode` varchar(50) NOT NULL,
  `drivername` varchar(255) NOT NULL,
  `license` varchar(12) NOT NULL,
  `platenumber` varchar(12) NOT NULL,
  `receiptnumber` varchar(20) NOT NULL,
  `or_number` varchar(255) NOT NULL,
  `or_date` date DEFAULT NULL,
  `cedula_no` varchar(255) NOT NULL,
  `issued_on` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `contnumber` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `length_of_years` int(3) DEFAULT NULL,
  `length_of_months` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pwdcertificate`
--

CREATE TABLE `pwdcertificate` (
  `id` int(11) NOT NULL,
  `age` int(120) NOT NULL,
  `civilstatus` enum('single','married') NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soloparentcertificate`
--

CREATE TABLE `soloparentcertificate` (
  `id` int(11) NOT NULL,
  `since` int(4) NOT NULL,
  `age` int(120) NOT NULL,
  `personal_Id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category` char(3) DEFAULT NULL,
  `children1` varchar(255) DEFAULT NULL,
  `children1_birthday` date DEFAULT NULL,
  `children2` varchar(255) DEFAULT NULL,
  `children2_birthday` date DEFAULT NULL,
  `children3` varchar(255) DEFAULT NULL,
  `children3_birthday` date DEFAULT NULL,
  `children4` varchar(255) DEFAULT NULL,
  `children4_birthday` date DEFAULT NULL,
  `councilor` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangaycertificate`
--
ALTER TABLE `barangaycertificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangayclearance`
--
ALTER TABLE `barangayclearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangayindigency`
--
ALTER TABLE `barangayindigency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangayresidency`
--
ALTER TABLE `barangayresidency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buildingclearance`
--
ALTER TABLE `buildingclearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businessclearance`
--
ALTER TABLE `businessclearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificateofgoodmoral`
--
ALTER TABLE `certificateofgoodmoral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificationofcalamity`
--
ALTER TABLE `certificationofcalamity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificationofesc`
--
ALTER TABLE `certificationofesc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificationoflegitimacy`
--
ALTER TABLE `certificationoflegitimacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificationoflowincome`
--
ALTER TABLE `certificationoflowincome`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_Id` (`personal_Id`);

--
-- Indexes for table `certificationofsourceofincome`
--
ALTER TABLE `certificationofsourceofincome`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_Id` (`personal_Id`);

--
-- Indexes for table `cohabitationletter`
--
ALTER TABLE `cohabitationletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `franchising`
--
ALTER TABLE `franchising`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pwdcertificate`
--
ALTER TABLE `pwdcertificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `soloparentcertificate`
--
ALTER TABLE `soloparentcertificate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangaycertificate`
--
ALTER TABLE `barangaycertificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangayclearance`
--
ALTER TABLE `barangayclearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangayindigency`
--
ALTER TABLE `barangayindigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangayresidency`
--
ALTER TABLE `barangayresidency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buildingclearance`
--
ALTER TABLE `buildingclearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `businessclearance`
--
ALTER TABLE `businessclearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificateofgoodmoral`
--
ALTER TABLE `certificateofgoodmoral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificationofcalamity`
--
ALTER TABLE `certificationofcalamity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificationofesc`
--
ALTER TABLE `certificationofesc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificationoflegitimacy`
--
ALTER TABLE `certificationoflegitimacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificationoflowincome`
--
ALTER TABLE `certificationoflowincome`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificationofsourceofincome`
--
ALTER TABLE `certificationofsourceofincome`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cohabitationletter`
--
ALTER TABLE `cohabitationletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `franchising`
--
ALTER TABLE `franchising`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pwdcertificate`
--
ALTER TABLE `pwdcertificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soloparentcertificate`
--
ALTER TABLE `soloparentcertificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
