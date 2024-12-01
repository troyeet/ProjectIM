-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 02:55 PM
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
-- Database: `management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `students_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `gender` varchar(55) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `course` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL,
  `date_of_entry` date NOT NULL DEFAULT current_timestamp(),
  `status` char(1) NOT NULL DEFAULT 'r' COMMENT 'r - regular\r\ni - irregular\r\ng - graduate',
  `user_type` char(1) NOT NULL DEFAULT 's' COMMENT 's - student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`students_id`, `student_name`, `gender`, `address`, `birth_date`, `course`, `block`, `date_of_entry`, `status`, `user_type`) VALUES
(10, 'Jeth Roy L. Delos Santos', 'Male', 'Linao, Libon, Albay', '2004-05-24', 'BSIT', 'B', '2024-11-30', 'r', 's'),
(11, 'Angelie Nerryle B. Curioso', 'Female', 'Namantao, Daraga, Albay', '2003-07-12', 'BSIT', 'B', '2024-11-30', 'r', 's'),
(12, 'John Casey Sumaoang', 'Male', 'Cabuyao, Laguna', '2005-06-26', 'BSCS', 'A', '2024-11-30', 'r', 's');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` enum('a','u') DEFAULT 'u',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `username`, `password`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '1234', 'a', '2024-11-26 00:10:30', '2024-11-30 12:36:28'),
(2, 'Jane Smith', 'jane.smith@example.com', 'janesmith', 'mypassword', 'u', '2024-11-26 00:10:30', '2024-11-26 00:10:30'),
(3, 'Alice Johnson', 'alice.johnson@example.com', 'alicej', 'alicepass', 'u', '2024-11-26 00:10:30', '2024-11-26 00:10:30'),
(4, 'froy rivera', 'froy@gmail.com', 'froi', '123123', 'u', '2024-11-26 00:29:17', '2024-11-26 00:29:17'),
(5, 'axel seva', 'axel@gmail.com', 'axel', '123123', 'u', '2024-11-29 04:00:32', '2024-11-29 04:00:32'),
(6, 'vicky minaj', 'vicky@gmail.com', 'vicky', '123123', 'u', '2024-11-30 05:54:46', '2024-11-30 05:54:46'),
(7, 'Angelie Nerryle B. Curioso', 'apol@gmail.com', 'apol', '1234', 'u', '2024-11-30 12:17:35', '2024-11-30 12:17:35'),
(8, 'John Casey Sumaoang', 'kise@gmail.com', 'kise', '1234', 'u', '2024-11-30 15:50:10', '2024-11-30 15:50:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`students_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `students_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
