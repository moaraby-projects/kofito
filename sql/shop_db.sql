-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2023 at 02:14 AM
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
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
(153, 77, 90, 343, 4),
(155, 77, 94, 65, 5),
(156, 77, 95, 455, 3),
(167, 80, 89, 44, 1),
(179, 70, 87, 122, 1),
(180, 70, 89, 44, 1),
(181, 70, 90, 343, 1),
(182, 70, 94, 65, 1),
(183, 70, 93, 12, 1),
(184, 70, 88, 154, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` varchar(20) NOT NULL,
  `message` varchar(10000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `number`, `message`, `date`, `user_id`) VALUES
(23, 'mohamed araby', 'moaraby1122@email.com', '0122222222', 'hi mohamed araby', '2023-08-10 05:17:53', 84);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `address_type` varchar(200) NOT NULL,
  `method` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`) VALUES
(89, 84, 'mohamed araby', '01225555555', 'moaraby@email.com', 'cairo street 12,,cairo,Egypt,10002', 'home', 'cash on delivery', 89, 44, 3, '2023-08-10 05:16:05', 'delivery'),
(90, 84, 'mohamed araby', '01225555555', 'moaraby@email.com', 'cairo street 12,,cairo,Egypt,10002', 'home', 'cash on delivery', 91, 23, 7, '2023-08-10 05:16:05', 'in progress'),
(91, 84, 'mohamed araby', '01225555555', 'moaraby@email.com', 'cairo street 12,,cairo,Egypt,10002', 'home', 'cash on delivery', 96, 333, 1, '2023-08-10 05:16:05', 'delivery'),
(92, 84, 'mohamed araby', '01225555555', 'moaraby@email.com', 'cairo street 12,,cairo,Egypt,10002', 'home', 'cash on delivery', 93, 12, 1, '2023-08-10 05:16:05', 'delivery'),
(93, 70, 'Hema Jack', '1012648537', 'mandolaptopnew@gmail.com', 'new york street 5,سسس,الدقهلية,Egypt,44937', 'home', 'cash on delivery', 87, 122, 3, '2023-08-12 01:35:01', 'canceled'),
(94, 70, 'Hema Jack', '1012648537', 'mandolaptopnew@gmail.com', 'new york street 5,سسس,الدقهلية,Egypt,44937', 'home', 'cash on delivery', 92, 42, 4, '2023-08-12 01:35:01', 'delivery'),
(95, 70, 'Hema Jack', '1012648537', 'mandolaptopnew@gmail.com', 'new york street 5,سسس,الدقهلية,Egypt,44937', 'home', 'cash on delivery', 95, 455, 4, '2023-08-12 01:35:01', 'in progress'),
(96, 70, 'Hema Jack', '1012648537', 'mandolaptopnew@gmail.com', 'new york street 5,سسس,الدقهلية,Egypt,44937', 'home', 'cash on delivery', 100, 43, 1, '2023-08-12 01:35:01', 'in progress'),
(97, 70, 'Karina Mack', '7097085478', 'test@gmail.com', 'new york street 5,,new york,United States,44937', 'home', 'cash on delivery', 90, 343, 1, '2023-08-12 01:38:57', 'in progress');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_details` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `product_details`) VALUES
(87, 'coffee beans', 122, '238_product1.jpg', ''),
(88, 'coffee beans', 154, '125_product2.jpg', ''),
(89, 'coffee beans', 44, '27_product3.jpg', ''),
(90, 'coffee beans', 343, '911_product4.jpg', ''),
(91, 'coffee Drink', 23, '326_card1.jpg', ''),
(92, 'coffee drink', 42, '149_card2.jpg', ''),
(93, 'coffee drink', 12, '246_card3.jpg', ''),
(94, 'coffee drink', 65, '51_card4.jpg', ''),
(95, 'coffee package', 455, '419_box1.jpg', ''),
(96, 'coffee package', 333, '379_box2.jpg', ''),
(100, 'Coffee Box', 43, '66_product15.png', ''),
(101, 'Coffee Box', 23, '139_product14.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_status`) VALUES
(70, 'mohamed araby', 'moaraby@email.com', '1', 'unblock'),
(71, 'magdy khattab', 'mego@gmail.com', '1', 'block'),
(72, 'mahmoud samir', 'mahmoud@gmaiil.com', '1', 'unblock'),
(73, 'youssef khaled', 'youssef@gmail.com', '1', ''),
(74, 'hatem adham', 'hatem@gmail.com', '1', ''),
(75, 'said mostafa', 'said@gmail.com', '1', ''),
(76, 'ramy salem', 'ramy@yahoo.com', '1', 'block'),
(84, 'mohamed araby', 'moaraby1122@email.com', '1', 'unblock');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
(54, 77, 88, 154),
(55, 78, 93, 12),
(58, 80, 87, 122),
(59, 80, 88, 154),
(60, 80, 90, 343),
(62, 70, 94, 65),
(63, 70, 89, 44),
(64, 70, 96, 333);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
