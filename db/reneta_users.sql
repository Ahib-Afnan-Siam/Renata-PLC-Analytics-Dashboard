-- phpMyAdmin SQL Dump
-- version 5.2.2-1.fc42
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2025 at 06:38 PM
-- Server version: 10.11.11-MariaDB
-- PHP Version: 8.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reneta_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_edits`
--

CREATE TABLE `customer_edits` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `income` int(11) DEFAULT NULL,
  `submitted_by` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_edits`
--

INSERT INTO `customer_edits` (`id`, `customer_id`, `name`, `division`, `gender`, `age`, `marital_status`, `income`, `submitted_by`, `status`, `submitted_at`) VALUES
(1, 0, 'Anna', 'Rajshahi', 'Female', 48, 'Single', 0, 'unknown', 'rejected', '2025-05-27 17:33:35'),
(2, 0, 'Anni', 'Rajshahi', 'Female', 48, 'Single', 0, 'unknown', 'rejected', '2025-05-27 19:52:26'),
(3, 0, 'Anna', 'Rajshahi', 'Female', 48, 'Single', 0, 'unknown', 'rejected', '2025-05-27 20:20:11'),
(4, 0, 'Anna', 'Rajshahi', 'Female', 48, 'Single', 0, 'unknown', 'rejected', '2025-05-27 21:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `message`, `link`, `seen`, `created_at`) VALUES
(1, 'edit_request', 'Edit request submitted for customer: Anna', 'pending-edits.php', 1, '2025-05-27 20:20:11'),
(2, 'edit_request', 'Edit request submitted for customer: Anna', 'pending-edits.php', 1, '2025-05-27 21:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'John', 'admin@example.com', '$2y$12$KpmSlhsgMHACsxbFwm/rx.CWkl0UbaI9MwCYUGKMd.I4OWsvfxUha', 'admin'),
(2, 'Sarah', 'sales@example.com', '$2y$12$r6B4PrFACksCIvLlgZh9LuURrcHYqNRJVnIoV9Dogc3dZbsvZphJS', 'sales'),
(3, 'Alice', 'manager@example.com', '$2y$12$OYbVHWLJW2jxsLnZ0fA72OWp7qkAG80Xi3c5I7b668.lJR.8Ktf66', 'manager'),
(4, 'ahib', 'ahib@example.com', '$2y$12$lXQaGt7MJyXKlgudeYiGUePkBiYhOq4UCcW4yHJxO9nNwQallhD3a', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_edits`
--
ALTER TABLE `customer_edits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_edits`
--
ALTER TABLE `customer_edits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
