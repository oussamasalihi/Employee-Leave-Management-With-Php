-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2024 at 06:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_id` int(11) NOT NULL,
  `department_short_name` varchar(15) NOT NULL,
  `department_name` varchar(30) NOT NULL,
  `creation_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `department_short_name`, `department_name`, `creation_date`) VALUES
(1, 'HR', 'Human Resource', '2024-02-09 11:49:27'),
(2, 'IT', 'Information Technology', '2024-02-09 11:49:27'),
(3, 'OP', 'Operations', '2024-02-09 11:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(30) NOT NULL,
  `designation_description` varchar(100) NOT NULL,
  `creation_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`designation_id`, `designation_name`, `designation_description`, `creation_date`) VALUES
(1, 'IT', 'IT', '2024-02-09 12:00:21'),
(2, 'SUPERVISOR', 'SUPERVISOR', '2024-02-09 12:00:21'),
(3, 'MANAGER', 'MANAGER', '2024-02-09 12:00:21'),
(4, 'ENGINEER', 'ENGINEER', '2024-02-09 12:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `employee_id` int(11) NOT NULL,
  `employee_id_number` varchar(15) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `age` int(3) NOT NULL,
  `gender` varchar(10) NOT NULL COMMENT 'male, female',
  `email_address` varchar(50) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `department_short_name` varchar(30) NOT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `designation_name` varchar(30) NOT NULL,
  `profile_image` text DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_status` int(1) NOT NULL COMMENT '0=inactive, 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`employee_id`, `employee_id_number`, `last_name`, `first_name`, `middle_name`, `age`, `gender`, `email_address`, `contact_number`, `department_id`, `department_short_name`, `designation_id`, `designation_name`, `profile_image`, `username`, `password`, `reg_date`, `account_status`) VALUES
(1, 'emp1', 'salihi', 'oussama', '', 21, 'Male', 'salihioussama1@gmail.com', '0625081156', 1, 'IT', 1, 'MANAGER', NULL, 'oussama', '$2y$10$HAaIaLxcr/IYvxta7f6fP.nyvPFVKc0Q6hNEt1yXb3gZFUJg88Ghe', '2024-02-09 20:45:55', 1),
(2, 'Emp065', 'salihi', 'youssef', '', 31, 'Male', 'youssef@gmail.com', '0287366328', 1, 'IT', 1, 'MANAGER', NULL, 'youssef', '$2y$10$1AiqUSUeQYGN0.7lP9SKaeftTf2HrcBtEwuQL3f.Wt/Iw/fcZuHOO', '2024-02-10 09:57:28', 1),
(4, 'EMP-25811', 'salihi', 'badr', '', 30, 'Male', 'badr@gmail.com', '0625081156', NULL, 'OP', NULL, 'MANAGER', NULL, 'badr', '$2y$10$qnPsq8giM2W99BdH.A7nwedp2QB1z48x/dVJkLK4cymxTlhri3xB6', '2024-02-17 00:02:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feature_access`
--

CREATE TABLE `tbl_feature_access` (
  `access_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `access_department` int(1) NOT NULL,
  `access_designation` int(1) NOT NULL,
  `access_employee` int(1) NOT NULL,
  `access_leave_type` int(1) NOT NULL,
  `access_leave_application` int(1) NOT NULL,
  `access_sms` int(1) NOT NULL,
  `access_users` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_application`
--

CREATE TABLE `tbl_leave_application` (
  `leave_id` int(11) NOT NULL,
  `reference_number` varchar(30) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `leave_name` varchar(30) NOT NULL,
  `posting_date` date NOT NULL DEFAULT current_timestamp(),
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `leave_description` text NOT NULL,
  `leave_status` int(11) NOT NULL COMMENT '0 for pending, 1 for approve, and 2 for rejected',
  `remarks` varchar(100) DEFAULT NULL,
  `date_of_approval` date DEFAULT NULL,
  `IsRead` int(11) NOT NULL DEFAULT 0 COMMENT '0 not yet ,1 read',
  `user_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_leave_application`
--

INSERT INTO `tbl_leave_application` (`leave_id`, `reference_number`, `employee_id`, `leave_type_id`, `leave_name`, `posting_date`, `from_date`, `to_date`, `leave_description`, `leave_status`, `remarks`, `date_of_approval`, `IsRead`, `user_id`) VALUES
(2, 'REF-65708', 1, NULL, 'Sick Leave', '2024-02-14', '2024-02-14', '2024-02-14', 'maladie', 0, NULL, NULL, 1, 1),
(3, 'REF-81541', 1, NULL, 'Casual Leave	', '2024-02-14', '2024-02-14', '2024-02-14', '', 0, NULL, NULL, 1, 1),
(4, 'REF-46108', 1, NULL, 'Sick Leave', '2024-02-14', '2024-02-14', '2024-02-14', 'I\'m sick', 0, NULL, NULL, 1, 1),
(5, 'REF-66047', 1, NULL, 'Casual Leave	', '2024-02-14', '2024-02-14', '2024-02-14', 'valantine day', 2, NULL, NULL, 1, 1),
(6, 'REF-36954', 1, NULL, 'Casual Leave	', '2024-02-14', '2024-02-15', '2024-02-16', 'valantine day', 1, NULL, NULL, 1, 1),
(7, 'REF-81964', 2, NULL, 'Restricted Leave', '2024-02-16', '2024-02-17', '2024-02-18', 'Youssef Leave', 0, NULL, NULL, 1, 1),
(8, 'REF-43379', 2, NULL, 'Sick Leave', '2024-02-16', '2024-02-18', '2024-02-20', 'I\'m sick', 0, NULL, NULL, 1, 1),
(9, 'REF-21047', 4, NULL, 'Sick Leave', '2024-02-17', '2024-02-18', '2024-02-20', 'Sick ', 0, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_type`
--

CREATE TABLE `tbl_leave_type` (
  `leave_type_id` int(11) NOT NULL,
  `leave_name` varchar(30) NOT NULL,
  `leave_description` varchar(100) NOT NULL,
  `number_days_allowed` int(3) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_leave_type`
--

INSERT INTO `tbl_leave_type` (`leave_type_id`, `leave_name`, `leave_description`, `number_days_allowed`, `creation_date`) VALUES
(1, 'Casual Leave', 'Casual Leave', 3, '2024-02-12 19:40:49'),
(2, 'Restricted Leave', 'Restricted Leave', 7, '2024-02-12 19:41:34'),
(10, 'Sick Leave', 'Sick Leave', 2, '2024-02-16 18:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_setting`
--

CREATE TABLE `tbl_sms_setting` (
  `api_code` varchar(50) NOT NULL,
  `api_password` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0=enable, 1=disable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL COMMENT 'you can also use blob',
  `fullname` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_category_id` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0=active, 1=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_group`
--

CREATE TABLE `tbl_user_group` (
  `user_group_id` int(11) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `allow_add` int(1) NOT NULL COMMENT '0=can''t access 1=can access',
  `allow_edit` int(1) NOT NULL COMMENT '0=can''t access 1=can access',
  `allow_delete` int(1) NOT NULL COMMENT '0=can''t access 1=can access',
  `allow_print` int(1) NOT NULL COMMENT '0=can''t access 1=can access',
  `allow_import` int(1) NOT NULL COMMENT '0=can''t access 1=can access',
  `allow_export` int(1) NOT NULL COMMENT '0=can''t access 1=can access'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `employee_id_number` (`employee_id_number`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `tbl_leave_application`
--
ALTER TABLE `tbl_leave_application`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `tbl_leave_type`
--
ALTER TABLE `tbl_leave_type`
  ADD PRIMARY KEY (`leave_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_leave_application`
--
ALTER TABLE `tbl_leave_application`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_leave_type`
--
ALTER TABLE `tbl_leave_type`
  MODIFY `leave_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
