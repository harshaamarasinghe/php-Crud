-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2024 at 07:26 AM
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
-- Database: `crud_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `userauth`
--

CREATE TABLE `userauth` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userauth`
--

INSERT INTO `userauth` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', '$2y$10$78WiborTIUAELW7Ap/uAnu3D4U4lLb69DLwtAayxfesuZONejfreq');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `age` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `age`, `created_at`) VALUES
(1, 'Harsha', 'gm.harsha.amarasinghe@gmail.com', 25, '2024-05-07 09:26:08'),
(9, 'nikesha', 'nike@ni.com', 24, '2024-05-07 09:56:54'),
(12, 'Shehara', 's@s.com', 12, '2024-05-07 11:16:23'),
(14, 'Pasindu', 'p@p.com', 25, '2024-05-07 15:12:00'),
(15, 'Jeramy', 'j@j.com', 32, '2024-05-07 15:12:22'),
(20, 'Surendra', 's@sk.com', 45, '2024-05-07 15:18:48'),
(21, 'Mark', 'm@m.co', 39, '2024-05-07 16:36:06'),
(22, 'Cuban', 'mark@5r.com', 35, '2024-05-07 16:37:50'),
(23, 'West', 'w@cs.com', 46, '2024-05-07 16:38:11'),
(24, 'Shanilka', 'sn@sm.cpm', 100, '2024-05-07 17:46:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userauth`
--
ALTER TABLE `userauth`
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
-- AUTO_INCREMENT for table `userauth`
--
ALTER TABLE `userauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
