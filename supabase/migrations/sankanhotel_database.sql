-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 07:24 AM
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
-- Database: `sankanhotel_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `contact_number`, `email`, `created_at`) VALUES
(1, 'dsdsds', '21323', 'sdsd@dsds', '2025-05-08 14:55:57'),
(2, 'dsdsds', 'dsdsd', 'dsds@dds', '2025-05-09 02:14:07'),
(3, 'dsdsd', 'asasa', 'dsds@dsds', '2025-05-09 19:48:33'),
(4, 'sasas', '2323232', 'sddsd@dsdsds', '2025-05-10 02:24:51'),
(5, 'sasds', 'dsds', 'sdsds@sds', '2025-05-10 02:35:41'),
(6, 'Penisman', '123', 'Penis@man', '2025-05-13 07:16:34'),
(7, 'wolf', '09234233502', 'mamamo@gmail.com', '2025-05-14 06:24:45'),
(8, 'The Jonkler', '122121', 'Jonkening@jonk', '2025-05-21 14:11:55'),
(9, 'Jinkies', '123123123', 'Womp@womp', '2025-05-22 07:19:49'),
(10, 'Wowzer', '919919', 'Wiwiwi@email.com', '2025-06-05 05:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `payment_type_id` int(11) NOT NULL,
  `payment_name` varchar(20) NOT NULL,
  `additional_charge_percentage` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`payment_type_id`, `payment_name`, `additional_charge_percentage`, `created_at`) VALUES
(1, 'Cash', 0.00, '2025-05-08 14:54:11'),
(2, 'Check', 5.00, '2025-05-08 14:54:11'),
(3, 'Credit Card', 10.00, '2025-05-08 14:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date_reserved` date NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `num_days` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `additional_charge` decimal(10,2) DEFAULT 0.00,
  `total_bill` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `customer_id`, `room_id`, `date_reserved`, `date_from`, `date_to`, `payment_type_id`, `special_requests`, `num_days`, `subtotal`, `discount`, `additional_charge`, `total_bill`, `created_at`) VALUES
(1, 1, 7, '2025-05-08', '2025-05-27', '2025-05-31', 1, 'sdsdsds', 4, 800.00, 80.00, 0.00, 720.00, '2025-05-08 14:56:51'),
(2, 1, 1, '2025-05-08', '2025-05-10', '2025-05-16', 1, '', 6, 600.00, 90.00, 0.00, 510.00, '2025-05-08 15:14:30'),
(3, 2, 8, '2025-05-09', '2025-05-23', '2025-05-31', 1, '', 8, 1600.00, 240.00, 0.00, 1360.00, '2025-05-09 02:21:47'),
(4, 3, 1, '2025-05-09', '2025-05-23', '2025-05-27', 1, '', 4, 400.00, 40.00, 0.00, 360.00, '2025-05-09 19:48:33'),
(5, 4, 3, '2025-05-10', '2025-05-21', '2025-05-25', 1, 'dsdsds', 4, 1200.00, 120.00, 0.00, 1080.00, '2025-05-10 02:24:51'),
(6, 5, 13, '2025-05-10', '2025-05-24', '2025-05-30', 1, 'dsdsds', 6, 1200.00, 180.00, 0.00, 1020.00, '2025-05-10 02:35:41'),
(8, 7, 9, '2025-05-14', '2025-05-14', '2025-05-22', 1, 'free food\r\n', 8, 4000.00, 600.00, 0.00, 3400.00, '2025-05-14 06:24:45'),
(9, 8, 1, '2025-05-21', '2025-05-21', '2025-05-22', 2, 'dddsds', 1, 100.00, 0.00, 5.00, 105.00, '2025-05-21 14:11:55'),
(10, 9, 23, '2025-05-22', '2025-05-22', '2025-05-30', 1, 'fdfdfdfdfd', 8, 8000.00, 1200.00, 0.00, 6800.00, '2025-05-22 07:19:49'),
(11, 10, 7, '2025-06-05', '2025-06-05', '2025-06-06', 1, 'Wowzer', 1, 200.00, 0.00, 0.00, 200.00, '2025-06-05 05:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_capacity_id` int(11) NOT NULL,
  `rate_per_day` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_type_id`, `room_capacity_id`, `rate_per_day`, `is_available`, `created_at`) VALUES
(1, '101', 1, 1, 100.00, 1, '2025-05-08 14:54:20'),
(2, '102', 1, 1, 100.00, 1, '2025-05-08 14:54:20'),
(3, '103', 2, 1, 300.00, 1, '2025-05-08 14:54:20'),
(4, '104', 2, 1, 300.00, 1, '2025-05-08 14:54:20'),
(5, '105', 3, 1, 500.00, 1, '2025-05-08 14:54:20'),
(6, '106', 3, 1, 500.00, 1, '2025-05-08 14:54:20'),
(7, '201', 1, 2, 200.00, 1, '2025-05-08 14:54:28'),
(8, '202', 1, 2, 200.00, 1, '2025-05-08 14:54:28'),
(9, '203', 2, 2, 500.00, 1, '2025-05-08 14:54:28'),
(10, '204', 2, 2, 500.00, 1, '2025-05-08 14:54:28'),
(11, '205', 3, 2, 800.00, 1, '2025-05-08 14:54:28'),
(12, '206', 3, 2, 800.00, 1, '2025-05-08 14:54:28'),
(13, '201', 1, 2, 200.00, 1, '2025-05-08 14:54:28'),
(14, '202', 1, 2, 200.00, 1, '2025-05-08 14:54:28'),
(15, '203', 2, 2, 500.00, 1, '2025-05-08 14:54:28'),
(16, '204', 2, 2, 500.00, 1, '2025-05-08 14:54:28'),
(17, '205', 3, 2, 800.00, 1, '2025-05-08 14:54:28'),
(18, '206', 3, 2, 800.00, 1, '2025-05-08 14:54:28'),
(19, '301', 1, 3, 500.00, 1, '2025-05-08 14:54:33'),
(20, '302', 1, 3, 500.00, 1, '2025-05-08 14:54:33'),
(21, '303', 2, 3, 750.00, 1, '2025-05-08 14:54:33'),
(22, '304', 2, 3, 750.00, 1, '2025-05-08 14:54:33'),
(23, '305', 3, 3, 1000.00, 1, '2025-05-08 14:54:33'),
(24, '306', 3, 3, 1000.00, 1, '2025-05-08 14:54:33'),
(25, '301', 1, 3, 500.00, 1, '2025-05-08 14:54:33'),
(26, '302', 1, 3, 500.00, 1, '2025-05-08 14:54:33'),
(27, '303', 2, 3, 750.00, 1, '2025-05-08 14:54:33'),
(28, '304', 2, 3, 750.00, 1, '2025-05-08 14:54:33'),
(29, '305', 3, 3, 1000.00, 1, '2025-05-08 14:54:33'),
(30, '306', 3, 3, 1000.00, 1, '2025-05-08 14:54:33'),
(31, '301', 1, 3, 500.00, 1, '2025-05-08 14:54:33'),
(32, '302', 1, 3, 500.00, 1, '2025-05-08 14:54:33'),
(33, '303', 2, 3, 750.00, 1, '2025-05-08 14:54:33'),
(34, '304', 2, 3, 750.00, 1, '2025-05-08 14:54:33'),
(35, '305', 3, 3, 1000.00, 1, '2025-05-08 14:54:33'),
(36, '306', 3, 3, 1000.00, 1, '2025-05-08 14:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `room_capacities`
--

CREATE TABLE `room_capacities` (
  `room_capacity_id` int(11) NOT NULL,
  `capacity_name` varchar(20) NOT NULL,
  `max_guests` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_capacities`
--

INSERT INTO `room_capacities` (`room_capacity_id`, `capacity_name`, `max_guests`, `created_at`) VALUES
(1, 'Single', 1, '2025-05-08 14:54:07'),
(2, 'Double', 2, '2025-05-08 14:54:07'),
(3, 'Family', 4, '2025-05-08 14:54:07');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `room_type_id` int(11) NOT NULL,
  `room_type` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`room_type_id`, `room_type`, `description`, `created_at`) VALUES
(1, 'Regular', 'Standard room with essential amenities for a comfortable stay', '2025-05-08 14:54:01'),
(2, 'De Luxe', 'Spacious room with premium amenities and elegant furnishings', '2025-05-08 14:54:01'),
(3, 'Suite', 'Luxurious suite with separate living area and exclusive amenities', '2025-05-08 14:54:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `payment_type_id` (`payment_type_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room_type_id` (`room_type_id`),
  ADD KEY `room_capacity_id` (`room_capacity_id`);

--
-- Indexes for table `room_capacities`
--
ALTER TABLE `room_capacities`
  ADD PRIMARY KEY (`room_capacity_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`room_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `payment_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `room_capacities`
--
ALTER TABLE `room_capacities`
  MODIFY `room_capacity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`payment_type_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`room_type_id`),
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`room_capacity_id`) REFERENCES `room_capacities` (`room_capacity_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
