-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 10:02 AM
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
-- Database: `lokesh`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_password`
--

CREATE TABLE `admin_password` (
  `sno` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `otp_generated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_password`
--

INSERT INTO `admin_password` (`sno`, `username`, `password`, `otp`, `otp_generated_at`, `otp_expires_at`, `otp_used`) VALUES
(1, 'admin', 3322, 27442, '2024-03-23 11:19:57', '2024-03-23 11:22:57', 0),
(2, 'chair man', 787623, 33018, '2024-03-22 01:20:16', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule`
--

CREATE TABLE `exam_schedule` (
  `id` int(6) UNSIGNED NOT NULL,
  `ht_no` int(6) UNSIGNED DEFAULT NULL,
  `reg_no` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `district` varchar(50) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_schedule`
--

INSERT INTO `exam_schedule` (`id`, `ht_no`, `reg_no`, `name`, `dob`, `district`, `exam_date`, `exam_time`) VALUES
(8, 23000001, 'TS781711796217', 'ammaji', '2003-07-24', 'kadapa', '2024-04-26', '10:00:00'),
(9, 23000002, 'TS561711450286', 'Murusu yellareddy', '2001-02-03', 'kurnool', '2024-04-02', '02:00:00');

--
-- Triggers `exam_schedule`
--
DELIMITER $$
CREATE TRIGGER `before_insert_exam_schedule` BEFORE INSERT ON `exam_schedule` FOR EACH ROW BEGIN
    DECLARE next_ht_no INT;
    SELECT COALESCE(MAX(ht_no), 0) + 1 INTO next_ht_no FROM exam_schedule;
    SET NEW.ht_no = next_ht_no;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `important_dates`
--

CREATE TABLE `important_dates` (
  `id` int(11) NOT NULL,
  `registration_opening_date` date DEFAULT NULL,
  `registration_closing_date` date DEFAULT NULL,
  `hall_ticket_release_date` date DEFAULT NULL,
  `results_release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `important_dates`
--

INSERT INTO `important_dates` (`id`, `registration_opening_date`, `registration_closing_date`, `hall_ticket_release_date`, `results_release_date`) VALUES
(1, '2024-02-25', '2024-04-30', '2024-05-01', '2024-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `reg_id` int(11) NOT NULL,
  `reg_no` varchar(255) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `fname` varchar(40) DEFAULT NULL,
  `intermediate_hallticket` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(355) DEFAULT NULL,
  `category` varchar(40) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sign` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`reg_id`, `reg_no`, `name`, `fname`, `intermediate_hallticket`, `gender`, `dob`, `address`, `category`, `image`, `sign`, `email`, `mobile`) VALUES
(1, 'TS561711450286', 'Murusu yellareddy', 'murusu', '0987732422', 'Male', '2001-02-03', 'kurnool', 'OBC', 'photo_935993384.jpeg', 'sign_869278569.jpg', 'murusu1234@gmail.com', '9063776202'),
(2, 'TS221711795995', 'ravi', 'ramakrishna', '0987765421', 'Male', '2003-02-13', 'kurnool', 'General', 'photo_218304933.jpeg', 'sign_990582612.jpg', 'ravikrishna14314@gmail.com', '8978665554'),
(3, 'TS781711796217', 'ammaji', 'babji', '1234567895', 'Male', '2003-07-24', 'kadapa', 'OBC', 'photo_569000450.jpeg', 'sign_1701056366.jpg', 'ravikrishna14314@gmail.com', '8978665554'),
(4, 'TS201711808395', 'Yellareddy', 'srinuvasulu reddy', '5987765422', 'Male', '2002-07-09', 'kurnool', 'General', 'photo_1622918674.jfif', 'sign_1920919999.jpg', 'murusu1234@gmail.com', '8987665443');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(20) DEFAULT NULL,
  `ht_no` int(15) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `maths` float DEFAULT NULL,
  `physics` float DEFAULT NULL,
  `chemistry` float DEFAULT NULL,
  `total` int(10) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `reg_no`, `ht_no`, `name`, `maths`, `physics`, `chemistry`, `total`, `rank`) VALUES
(187, 'TS701707994622', 20000001, 'lokesh', 20, 52, 55, 127, 1),
(188, 'TS671707805393', 20000002, 'lokesh', 20, 0, 4, 24, 11),
(189, 'TS441707788390', 20000003, 'lokesh', 20, 45, 55, 120, 3),
(190, 'TS721708403227', 20000004, 'madhu', 30, 30, 30, 90, 5),
(191, 'TS791707788815', 20000005, 'lokesh', 25, 36, 34, 95, 4),
(192, 'TS311707748804', 20000006, 'jyothi', 23, 33, 32, 88, 6),
(193, 'TS991708175980', 20000007, 'ramanji', 29, 34, 23, 86, 7),
(194, 'TS751709187419', 20000008, 'v ganga prasad', 45, 34, 43, 122, 2),
(195, 'TS401708058743', 20000009, 'ravi krishna', 29, 32, 4, 65, 9),
(196, 'TS811707750736', 20000010, 'lokesh', 40, 21, 4, 65, 9),
(197, 'TS241707811694', 20000011, 'sai kiran', 8, 12, 44, 64, 10),
(198, 'TS321709979978', 20000012, 'vada', 16, 33, 33, 82, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `important_dates`
--
ALTER TABLE `important_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `important_dates`
--
ALTER TABLE `important_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
