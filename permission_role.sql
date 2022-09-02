-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2020 at 04:25 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fullhcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(168, 1, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(169, 2, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(170, 4, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(171, 5, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(172, 6, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(173, 7, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(174, 8, 13, '2018-07-18 11:15:06', '2018-07-18 11:15:06'),
(1067, 1, 6, '2018-10-18 08:19:33', '2018-10-18 08:19:33'),
(1068, 2, 6, '2018-10-18 08:19:33', '2018-10-18 08:19:33'),
(1069, 11, 6, '2018-10-18 08:19:33', '2018-10-18 08:19:33'),
(1070, 12, 6, '2018-10-18 08:19:33', '2018-10-18 08:19:33'),
(1071, 23, 6, '2018-10-18 08:19:33', '2018-10-18 08:19:33'),
(1072, 24, 6, '2018-10-18 08:19:33', '2018-10-18 08:19:33'),
(1680, 11, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1681, 12, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1682, 23, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1683, 24, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1684, 25, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1685, 8, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1686, 9, 2, '2018-11-29 11:51:56', '2018-11-29 11:51:56'),
(1687, 10, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1688, 4, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1689, 5, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1690, 6, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1691, 7, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1692, 13, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1693, 28, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1694, 29, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1695, 30, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1696, 31, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1697, 32, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1698, 33, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1699, 34, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1700, 26, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1701, 27, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(1702, 47, 2, '2018-11-29 11:51:57', '2018-11-29 11:51:57'),
(3846, 36, 4, '2018-12-04 15:05:14', '2018-12-04 15:05:14'),
(5565, 1, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5566, 2, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5567, 3, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5568, 11, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5569, 12, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5570, 23, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5571, 24, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5572, 25, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5573, 8, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5574, 9, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5575, 10, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5576, 4, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5577, 5, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5578, 6, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5579, 7, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5580, 13, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5581, 28, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5582, 29, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5583, 30, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5584, 31, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5585, 42, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5586, 60, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5587, 14, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5588, 15, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5589, 0, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5590, 17, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5591, 18, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5592, 19, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5593, 20, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5594, 21, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5595, 22, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5596, 16, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5597, 32, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5598, 33, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5599, 34, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5600, 35, 1, '2019-12-21 21:44:33', '2019-12-21 21:44:33'),
(5601, 36, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5602, 37, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5603, 38, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5604, 26, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5605, 27, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5606, 61, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5607, 62, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5608, 39, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5609, 40, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5610, 41, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5611, 43, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5612, 45, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5613, 47, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5614, 49, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5615, 51, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5616, 52, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5617, 53, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5618, 54, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5619, 55, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5620, 56, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5621, 57, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5622, 58, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5623, 59, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5624, 65, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34'),
(5625, 66, 1, '2019-12-21 21:44:34', '2019-12-21 21:44:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5626;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;