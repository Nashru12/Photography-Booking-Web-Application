-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2023 at 10:30 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ketawariangstudio`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `package_id`, `customer_name`, `phone_number`, `address`, `event_date`, `booking_date`, `status`, `id`) VALUES
(47, 1, 'MUHAMMAD NASHRUL BIN HAMZAH', '0136604918', 'No.1671,Jalan Bayu 9,Taman Seri Bayu 2', '2023-09-23', '2023-06-06 16:40:24', 'Completed', 1),
(48, 5, 'Soon Kou Tong', '01424244261', 'Dewan Kelemak', '2023-08-13', '2023-06-06 16:44:03', 'Completed', 1),
(49, 3, 'Anderson', '01983366372', 'Dewan Kuching', '2023-06-10', '2023-06-06 16:47:02', 'Completed', 21),
(50, 17, 'Muhamad Daniel', '0136604918', 'Dewan Permaisuri', '2023-09-09', '2023-06-09 17:38:54', 'Completed', 21),
(51, 18, 'Suhaimi', '0136604918', 'Dewan Taming Sari Melaka', '2023-08-12', '2023-06-09 17:43:18', 'Completed', 21),
(52, 18, 'Zafrul', '0136604918', 'Dewan Al-Rashidin', '2023-08-19', '2023-06-10 12:44:06', 'Completed', 21),
(53, 3, 'Amirul Hakim', '0193776230', 'Dewan Perdana Muar', '2023-08-31', '2023-06-28 10:56:32', 'Pending', 4),
(54, 5, 'Syahrul Ramadan', '013664732', 'Dewan Rembia', '2023-07-15', '2023-07-01 15:49:32', 'Pending', 4),
(55, 18, 'MUHAMMAD NASHRUL BIN HAMZAH', '0136604918', 'No.1671,Jalan Bayu 9,Taman Seri Bayu 2', '2023-07-09', '2023-07-02 07:17:52', 'Completed', 4),
(56, 18, 'MUHAMMAD NASHRUL BIN HAMZAH', '0136604918', 'No.1671,Jalan Bayu 9,Taman Seri Bayu 2', '2023-07-23', '2023-07-04 01:54:43', 'Pending', 4),
(57, 4, 'MUHAMMAD NASHRUL BIN HAMZAH', '0136604918', 'No.1671,Jalan Bayu 9,Taman Seri Bayu 2', '2023-07-26', '2023-07-04 02:36:38', 'Pending', 4),
(58, 18, 'MUHAMMAD NASHRUL BIN HAMZAH', '0136604918', 'No.1671,Jalan Bayu 9,Taman Seri Bayu 2', '2023-07-22', '2023-07-04 02:49:32', 'Pending', 4);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`, `status`) VALUES
(1, 'Syafiq Farhan', 'muhdnashrul655@gmail.com', 'Pakej Nikah', 'Berapakan jumlah gambar yang akan diterima mengikut pakej pilihan?', 'Resolved'),
(2, 'K.Rutish', 'ali@gmail.com', 'Other Event', 'Pihak Ketawariang Studio ada menyediakan model bagi sesi fotografi untuk produk perniagaan?', 'Resolved'),
(5, 'ali', 'muhdnashrul655@gmail.com', 'abc', '1233', 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `Emp_name` varchar(50) NOT NULL,
  `Emp_ic` varchar(50) NOT NULL,
  `Emp_phonenum` varchar(40) NOT NULL,
  `Emp_addr` varchar(250) NOT NULL,
  `Emp_state` varchar(50) NOT NULL,
  `Emp_date` date NOT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `Emp_name`, `Emp_ic`, `Emp_phonenum`, `Emp_addr`, `Emp_state`, `Emp_date`, `role`) VALUES
(1, 'Muhammad Zafril Bin Aabu', '010217-04-0827', '019373783', 'Jasin', 'Melaka', '2023-05-10', 'Photographer'),
(8, 'Muhammad Imaduddin Bin Arifin', '010827-04-0128', '0135638831', 'Kampung Paku,Lendu', 'Melaka', '2023-04-19', 'photographer'),
(9, 'Muhammad Aidil Aizat Bin Mustafa', '010217-04-0721', '0173563772', 'Kuala Pilah', 'Negeri Sembilan', '2023-03-09', 'photographer');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `information_1` varchar(255) NOT NULL,
  `information_2` varchar(255) NOT NULL,
  `information_3` varchar(255) NOT NULL,
  `information_4` varchar(255) NOT NULL,
  `information_5` varchar(255) NOT NULL,
  `information_6` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `package_price`, `information_1`, `information_2`, `information_3`, `information_4`, `information_5`, `information_6`, `category`, `image_link`) VALUES
(1, 'Pakej Nikah (Album)', '800.00', '8X12 Crystal Album', '12X18 Photo Frame', 'Wooden USB', 'Unlimited Shoot', 'Outdoor Session', 'All Edited Photo Given', 'Wedding', 'package-wedding.jpeg'),
(2, 'Pakej Nikah (Without Album)', '500.00', '12x18 Photo Frame', 'Wooden USB', 'Unlimited Shoot', 'Outdoor Session', 'All Edited Photo Given', '-', 'Wedding', 'wedd2.jpeg'),
(3, 'Pakej Tunang', '300.00', 'Wooden USB', 'Unlimited Shoot', 'Outdoor Session', 'All Edited PhotoGiven', '-', '-', 'Wedding', 'wedd3.jpeg'),
(4, 'Pakej Nikah + Sanding', '1200.00', '10X12 Crystal Album', '12X18 Photo Frame', 'Wooden USB', 'Unlimited Shoot', 'Outdoor Session', 'All Edited Photo Given', 'Wedding', 'wedd4.jpeg'),
(5, 'Event Photoshoot', '300.00', 'Birthday', 'Hi-Tea', 'Wooden USB', 'Farewell Ceremony', 'Unlimited Shoot', 'All Edited Photo Given', 'Event', 'nabilarzali2.jpeg'),
(6, 'Others Photoshoot', '500.00', 'Talk', 'Corporate', 'Product Photoshoot', 'Unlimited Shoot', 'All Edited Photo Given', '-', 'Others', 'pancake.jpeg'),
(17, 'Testing', '10.00', 'Unlimited photoshoot', 'Wooden USB', 'Edited photo', 'Free', '-', '-', 'Wedding', 'harimerdeka.jpg'),
(18, 'Testing_Baru', '5.00', '12x18 Photo Frame', 'Unlimited Shoot', 'Wooden USB', 'All Edited PhotoGiven', '-', '-', 'Wedding', 'photo1623304648.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `sale_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `booking_id`, `amount`, `sale_date`) VALUES
(25, 47, '800.00', '2023-06-07'),
(26, 48, '300.00', '2023-06-10'),
(27, 49, '300.00', '2023-06-10'),
(28, 50, '10.00', '2023-06-10'),
(29, 51, '5.00', '2023-06-10'),
(30, 52, '5.00', '2023-07-02'),
(31, 55, '5.00', '2023-07-04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `User_email` varchar(255) NOT NULL,
  `User_pass` varchar(255) NOT NULL,
  `User_role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `User_email`, `User_pass`, `User_role`) VALUES
(1, 'ali@gmail.com', '$2y$10$apfnfo3KMxrBmpJ3fEj7wevYiHDAo2V0S8zXRLa6nA3kaEK6yLVV2', 'customer'),
(2, 'kamal@gmail.com', '$2y$10$KZQ3jQxgzpQ9vZX/rQpbNeaP/KZnJLMQ0WmU2VwvTj.MU3.NACndy', 'customer'),
(3, 'nashrul@gmail.com', '$2y$10$C2PU2szQm3bICF1Wa8rf3uc3ZVX8xLoeuQLMtVTQk9nF9HTvmz3SG', 'admin'),
(4, 'muhdnashrul655@gmail.com', '$2y$10$oa8yKD1tWjqHlx5hBZrKUuOZ/X2EEFVqJnoxiaY7JNvZvRFRn.WoO', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
