-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2021 at 07:14 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mitraweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ms_default_sys`
--

CREATE TABLE `ms_default_sys` (
  `id` int(11) NOT NULL,
  `sys_id` varchar(20) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `value` varchar(128) NOT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_default_sys`
--

INSERT INTO `ms_default_sys` (`id`, `sys_id`, `description`, `value`, `is_active`) VALUES
(1, 'IMG000', 'default profile image', 'default.jpg', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_dept_m`
--

CREATE TABLE `ms_dept_m` (
  `dept_id` varchar(5) NOT NULL,
  `dept_name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `is_active` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ms_dept_m`
--

INSERT INTO `ms_dept_m` (`dept_id`, `dept_name`, `alias`, `is_active`) VALUES
('D000', 'ADMINISTRATOR', 'admin', 'Y'),
('D001', 'IT', 'it', 'Y'),
('D002', 'MEDICAL RECORD', 'medrec', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_menu_d_dept`
--

CREATE TABLE `ms_menu_d_dept` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `dept_id` varchar(10) NOT NULL,
  `is_active` varchar(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_menu_d_dept`
--

INSERT INTO `ms_menu_d_dept` (`id`, `menu_id`, `dept_id`, `is_active`) VALUES
(1, 'MN0005', 'D002', 'Y'),
(3, 'MN0007', 'D002', 'Y'),
(4, 'MN0006', 'D002', 'Y'),
(5, 'MN0008', 'D002', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_menu_d_role`
--

CREATE TABLE `ms_menu_d_role` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `role_id` varchar(5) NOT NULL,
  `is_active` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_menu_d_role`
--

INSERT INTO `ms_menu_d_role` (`id`, `menu_id`, `role_id`, `is_active`) VALUES
(1, 'MN0001', '1', 'Y'),
(2, 'MN0002', '1', 'Y'),
(3, 'MN0002', '2', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_menu_m`
--

CREATE TABLE `ms_menu_m` (
  `menu_id` varchar(12) NOT NULL,
  `menu_tittle` varchar(50) NOT NULL,
  `menu_tittle2` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `parent` varchar(12) DEFAULT NULL,
  `menu_order` int(11) NOT NULL,
  `menu_type` int(11) NOT NULL COMMENT '1=Header, 2=Detail',
  `dept_id` varchar(5) DEFAULT NULL,
  `is_active` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_menu_m`
--

INSERT INTO `ms_menu_m` (`menu_id`, `menu_tittle`, `menu_tittle2`, `link`, `icon`, `parent`, `menu_order`, `menu_type`, `dept_id`, `is_active`) VALUES
('MN0001', 'User', 'Pengguna', 'user', 'fas fa-users', '', 2, 1, 'D000', 'Y'),
('MN0002', 'Profile', 'Profil', 'profile', 'fas fa-id-card', '', 1, 1, '', 'Y'),
('MN0005', 'Form Application', 'Formulir', '#', 'fas fa-align-justify', '', 3, 1, 'D002', 'Y'),
('MN0006', 'Loan Form', 'Form Peminjaman', 'mr-loan', 'fas fa-sticky-note', 'MN0005', 5, 2, 'D002', 'Y'),
('MN0007', 'Report', 'Laporan', '#', 'fas fa-table', '', 4, 1, 'D002', 'Y'),
('MN0008', 'Loan Report', 'Lap. Peminjaman', 'mr-loan-rpt', 'fas fa-sticky-note', 'MN0007', 6, 2, 'D002', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_role_m`
--

CREATE TABLE `ms_role_m` (
  `role_id` varchar(5) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_role_m`
--

INSERT INTO `ms_role_m` (`role_id`, `role_name`) VALUES
('1', 'ADMINISTRATOR'),
('2', 'USER');

-- --------------------------------------------------------

--
-- Table structure for table `ms_user_d_imgprfl`
--

CREATE TABLE `ms_user_d_imgprfl` (
  `id` int(11) NOT NULL,
  `user_id` varchar(12) NOT NULL,
  `img_url` varchar(128) NOT NULL,
  `img_order` int(11) NOT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_user_d_imgprfl`
--

INSERT INTO `ms_user_d_imgprfl` (`id`, `user_id`, `img_url`, `img_order`, `is_active`) VALUES
(1, 'U21121400002', 'default.png', 1, 'Y'),
(2, 'U21121400001', 'default.png', 1, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_user_d_menu`
--

CREATE TABLE `ms_user_d_menu` (
  `id` int(11) NOT NULL,
  `user_id` varchar(12) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `is_active` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_user_d_menu`
--

INSERT INTO `ms_user_d_menu` (`id`, `user_id`, `menu_id`, `is_active`) VALUES
(1, 'U21121400002', 'MN0006', 'Y'),
(2, 'U21121400002', 'MN0002', 'Y'),
(3, 'U21121400001', 'MN0002', 'Y'),
(4, 'U21121400001', 'MN0001', 'Y'),
(5, 'U21121400002', 'MN0008', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ms_user_m`
--

CREATE TABLE `ms_user_m` (
  `user_id` varchar(12) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role_id` varchar(1) NOT NULL,
  `dept_id` varchar(10) NOT NULL,
  `created_date` date NOT NULL,
  `last_updated` date DEFAULT NULL,
  `is_active` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ms_user_m`
--

INSERT INTO `ms_user_m` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `role_id`, `dept_id`, `created_date`, `last_updated`, `is_active`) VALUES
('U21121400001', 'ADMIN', '$2a$12$xRp.g5h6Pd3neDskULMwCeOd6/M5RKkDo9f55TJ40gOrKJ5A4Lw92', 'Administrator', '', '', '1', 'D000', '2021-12-18', NULL, 'Y'),
('U21121400002', 'medrec', '$2a$12$Ue0vKHblqryGh8kTT74J/e8brSXLXKRZ1dumy76yZ9a.h/baQ3yCW', 'Medical', 'Record', '', '2', 'D002', '2021-12-21', NULL, 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ms_default_sys`
--
ALTER TABLE `ms_default_sys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_dept_m`
--
ALTER TABLE `ms_dept_m`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `ms_menu_d_dept`
--
ALTER TABLE `ms_menu_d_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_menu_d_role`
--
ALTER TABLE `ms_menu_d_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_menu_m`
--
ALTER TABLE `ms_menu_m`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `ms_role_m`
--
ALTER TABLE `ms_role_m`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `ms_user_d_imgprfl`
--
ALTER TABLE `ms_user_d_imgprfl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_user_d_menu`
--
ALTER TABLE `ms_user_d_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_user_m`
--
ALTER TABLE `ms_user_m`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ms_default_sys`
--
ALTER TABLE `ms_default_sys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ms_menu_d_dept`
--
ALTER TABLE `ms_menu_d_dept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ms_menu_d_role`
--
ALTER TABLE `ms_menu_d_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ms_user_d_imgprfl`
--
ALTER TABLE `ms_user_d_imgprfl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ms_user_d_menu`
--
ALTER TABLE `ms_user_d_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
