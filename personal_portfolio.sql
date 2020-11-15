-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2020 at 01:29 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personal_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role` varchar(15) NOT NULL DEFAULT 'Editor',
  `name` varchar(50) NOT NULL DEFAULT 'No Name Given',
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cell` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL DEFAULT 'default_photo.jpg',
  `status` varchar(8) NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_status` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `username`, `email`, `cell`, `password`, `photo`, `status`, `created_at`, `updated_at`, `deleted_status`) VALUES
(1, 'Admin', 'Superman', 'admin', 'admin@gmail.com', '01412345678', '$2y$10$IYaVP4UdWJuEPR9yZPLGGuAJ7UVssF.aJeRENO67t4JqhgTf4ba3C', 'f94100aaecdc09cd436b033ca1f9bf1b.jpg', 'Active', '2020-11-05 04:19:51', '2020-11-15 11:29:23', 'No'),
(7, 'Editor', 'Emma Charlotte Watson', 'emma_watson', 'emma@gmail.com', '01112345678', '$2y$10$le32zjons1oEe5F.fsp6GeWCAO.Ttyd.UL.5QSPXWnmeqvBbTWyGG', 'e7b115bd004aac0f17cabae5e2fca177.jpg', 'Inactive', '2020-11-15 06:02:23', '2020-11-15 06:20:44', 'No'),
(9, 'Editor', 'Adam Patrick DeVine', 'patrick_boy', 'patrick.devine@northsouth.edu', '01512345678', '$2y$10$XPrwbVf0wbI6wLWaBOz.4e9gmQzVfH8iWNCahQLbYA3si/uZmO2IO', 'b5039bea0bad9d61c91b7937d9f37a1e.jpeg', 'Inactive', '2020-11-15 06:04:52', '2020-11-15 06:21:29', 'No'),
(10, 'Editor', 'Rifat Zibraan', 'rifat124', 'rifat@aiub.edu', '01612345678', '$2y$10$HbO23gwGWSSmLSlA1qKpn.Oxi/HcIwLL1WWktHKQIHMKrWgisEdkO', 'ab2070e43b8a52301b9d863a350357f6.jpg', 'Active', '2020-11-15 06:05:50', '2020-11-15 06:22:07', 'No');

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
