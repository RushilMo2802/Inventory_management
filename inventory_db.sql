-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 08:38 AM
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
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `retailer_id`, `quantity`, `order_date`) VALUES
(1, 1, 1, 100, '2025-11-12 05:46:34'),
(2, 2, 2, 50, '2025-11-12 05:46:34'),
(3, 3, 3, 25, '2025-11-12 05:46:34'),
(4, 4, 4, 10, '2025-11-12 05:46:34'),
(5, 5, 5, 5, '2025-11-12 05:46:34'),
(6, 6, 6, 20, '2025-11-12 05:46:34'),
(7, 7, 7, 15, '2025-11-12 05:46:34'),
(8, 8, 8, 30, '2025-11-12 05:46:34'),
(11, 5, 2, 50, '2025-11-12 09:38:59'),
(12, 5, 2, 75, '2025-11-12 10:12:23'),
(13, 5, 3, 10, '2025-11-12 10:13:13'),
(14, 5, 8, 50, '2025-11-12 10:27:36'),
(15, 5, 8, 51, '2025-11-12 10:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `threshold` int(11) NOT NULL DEFAULT 100,
  `restock_amount` int(11) NOT NULL DEFAULT 500,
  `last_restock` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `threshold`, `restock_amount`, `last_restock`, `created_at`) VALUES
(1, 'Steel Bolts', 1200, 100, 500, '2025-11-12 05:46:34', '2025-11-12 00:16:34'),
(2, 'Nuts (M10)', 800, 100, 300, '2025-11-12 05:46:34', '2025-11-12 00:16:34'),
(3, 'Washers', 450, 100, 250, '2025-11-12 05:46:34', '2025-11-12 00:16:34'),
(4, 'Screws 2-inch', 200, 50, 200, '2025-11-12 05:46:34', '2025-11-12 00:16:34'),
(5, 'Aluminium Rods', 99, 25, 75, '2025-11-12 10:28:22', '2025-11-12 00:16:34'),
(6, 'Plastic Sheets', 90, 30, 100, '2025-11-12 05:46:34', '2025-11-12 00:16:34'),
(7, 'Copper Wires', 150, 50, 100, '2025-11-12 05:46:34', '2025-11-12 00:16:34'),
(8, 'Iron Pipes', 300, 100, 200, '2025-11-12 05:46:34', '2025-11-12 00:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `retailers`
--

CREATE TABLE `retailers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `retailers`
--

INSERT INTO `retailers` (`id`, `name`, `phone`, `email`, `address`, `created_at`) VALUES
(1, 'Sharma Hardware Store', '9876543210', 'sharmahardware@example.com', 'Mapusa, Goa', '2025-11-12 00:16:34'),
(2, 'Goa Industrial Supplies', '9823123456', 'goaindustrial@example.com', 'Panjim, Goa', '2025-11-12 00:16:34'),
(3, 'Elite Engineering Works', '9012345678', 'eliteworks@example.com', 'Vasco, Goa', '2025-11-12 00:16:34'),
(4, 'Universal Traders', '9123456789', 'universal@example.com', 'Margao, Goa', '2025-11-12 00:16:34'),
(5, 'Precision Tools Depot', '9988776655', 'precision@example.com', 'Porvorim, Goa', '2025-11-12 00:16:34'),
(6, 'Metal Mart', '9876501234', 'metalmart@example.com', 'Bicholim, Goa', '2025-11-12 00:16:34'),
(7, 'Techno Hardware', '8765432109', 'techno@example.com', 'Siolim, Goa', '2025-11-12 00:16:34'),
(8, 'Coastal Supplies', '9811122233', 'coastal@example.com', 'Aldona, Goa', '2025-11-12 00:16:34'),
(9, 'Prime Fasteners', '9900011223', 'primefasteners@example.com', 'Calangute, Goa', '2025-11-12 00:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `address`, `password_hash`, `created_at`) VALUES
(1, 'doctor', 'r@gmail.com', NULL, NULL, '$2y$10$WFpC/9XbG4cXlba0vWjH5OmHeXVVA5Bz6jsIkjwrtf8QR6zWJQVFS', '2025-11-13 07:32:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `retailer_id` (`retailer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retailers`
--
ALTER TABLE `retailers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `retailers`
--
ALTER TABLE `retailers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`retailer_id`) REFERENCES `retailers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
