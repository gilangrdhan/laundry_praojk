-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 01:08 PM
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
-- Database: `laundry_praojk`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nama_customer`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'gilang', '9090', 'karet tengsin', '2024-12-02 04:59:46', '2024-12-02 04:59:46', 0),
(3, 'tina', '1234567', 'gandaria', '2024-12-02 05:00:25', '2024-12-02 05:00:33', 0),
(4, 'yanti', '9090', 'tanah abang 15', '2024-12-02 10:58:13', '2024-12-02 10:58:13', 0),
(5, 'vierra', '1234567', 'Jl Gandaria nomer 14 ', '2024-12-02 11:10:08', '2024-12-02 11:10:08', 0),
(6, 'yono', '12345', 'Jl. Bahagia no 13', '2024-12-02 11:39:22', '2024-12-02 11:39:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama_level` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` tinyint(4) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '2024-12-02 02:02:58', '2024-12-02 04:21:35', 127),
(2, 'operator', '2024-12-02 02:04:03', '2024-12-02 02:04:03', 127),
(3, 'pimpinan', '2024-12-02 03:13:50', '2024-12-02 03:22:33', 127);

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `nama_paket`, `harga`, `deskripsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cuci dan gosok', 5000, 'ekstra pewangi', '2024-12-02 06:35:29', '2024-12-02 06:35:45', 0),
(2, 'cuci', 4500, 'tidak termasuk pewangi', '2024-12-02 06:36:06', '2024-12-02 06:36:06', 0),
(3, 'gosok', 5000, 'tidak termasuk pewangi', '2024-12-02 06:36:24', '2024-12-02 06:36:24', 0),
(4, 'Paket Besar, sprei, mantel dan jaket', 7000, 'ekstra pewangi', '2024-12-02 06:36:58', '2024-12-02 06:36:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trans_laundry_pickup`
--

CREATE TABLE `trans_laundry_pickup` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_laundry_pickup`
--

INSERT INTO `trans_laundry_pickup` (`id`, `id_order`, `id_customer`, `pickup_date`, `created_at`, `updated_at`, `note`) VALUES
(5, 0, 3, '2024-12-02', '2024-12-02 09:25:26', '2024-12-02 09:25:26', ''),
(6, 0, 1, '2024-12-02', '2024-12-02 09:27:32', '2024-12-02 09:27:32', ''),
(7, 2024, 1, '0000-00-00', '2024-12-02 09:29:00', '2024-12-02 09:29:00', ''),
(8, 2024, 3, '0000-00-00', '2024-12-02 09:30:28', '2024-12-02 09:30:28', ''),
(9, 2024, 1, '0000-00-00', '2024-12-02 09:51:47', '2024-12-02 09:51:47', ''),
(10, 2024, 1, '0000-00-00', '2024-12-02 09:53:13', '2024-12-02 09:53:13', ''),
(11, 2024, 1, '0000-00-00', '2024-12-02 09:57:59', '2024-12-02 09:57:59', ''),
(12, 2024, 3, '0000-00-00', '2024-12-02 09:59:40', '2024-12-02 09:59:40', ''),
(13, 2024, 1, '0000-00-00', '2024-12-02 10:05:00', '2024-12-02 10:05:00', ''),
(14, 2024, 1, '0000-00-00', '2024-12-02 10:11:42', '2024-12-02 10:11:42', ''),
(15, 2024, 1, '0000-00-00', '2024-12-02 10:29:16', '2024-12-02 10:29:16', ''),
(16, 2024, 3, '0000-00-00', '2024-12-02 10:44:12', '2024-12-02 10:44:12', ''),
(17, 23, 3, '2024-12-02', '2024-12-02 10:46:27', '2024-12-02 10:46:27', ''),
(18, 2024, 1, '0000-00-00', '2024-12-02 10:53:09', '2024-12-02 10:53:09', ''),
(19, 2024, 4, '0000-00-00', '2024-12-02 10:58:55', '2024-12-02 10:58:55', ''),
(20, 2024, 3, '0000-00-00', '2024-12-02 11:01:29', '2024-12-02 11:01:29', ''),
(21, 2024, 5, '0000-00-00', '2024-12-02 11:35:44', '2024-12-02 11:35:44', '');

-- --------------------------------------------------------

--
-- Table structure for table `trans_order`
--

CREATE TABLE `trans_order` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `tanggal_laundry` date NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `order_end_date` date NOT NULL,
  `order_pay` int(11) NOT NULL,
  `order_change` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_order`
--

INSERT INTO `trans_order` (`id`, `id_customer`, `no_transaksi`, `tanggal_laundry`, `order_code`, `order_date`, `status`, `order_end_date`, `order_pay`, `order_change`, `created_at`, `updated_at`, `deleted_at`) VALUES
(25, 1, 'INV02122400025', '2024-12-03', '', '0000-00-00', 1, '2024-12-06', 45000, 5000, '2024-12-02 10:52:59', '2024-12-02 10:53:09', 0),
(26, 4, 'INV02122400026', '2024-12-03', '', '0000-00-00', 1, '2024-12-12', 30000, 9000, '2024-12-02 10:58:37', '2024-12-02 10:58:55', 0),
(27, 3, 'INV02122400027', '2024-12-11', '', '0000-00-00', 1, '2024-12-18', 20000, 6000, '2024-12-02 11:00:48', '2024-12-02 11:01:29', 0),
(28, 5, 'INV02122400028', '2024-12-03', '', '0000-00-00', 1, '2024-12-31', 20000, 4000, '2024-12-02 11:10:46', '2024-12-02 11:35:44', 0),
(29, 6, 'INV02122400029', '2024-12-12', '', '0000-00-00', 0, '2024-12-11', 0, 0, '2024-12-02 11:39:42', '2024-12-02 11:39:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trans_order_detail`
--

CREATE TABLE `trans_order_detail` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_order_detail`
--

INSERT INTO `trans_order_detail` (`id`, `id_order`, `id_paket`, `qty`, `subtotal`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 5000, '', '2024-12-02 08:12:44', '2024-12-02 08:12:44'),
(2, 2, 1, 2, 10000, '', '2024-12-02 08:19:01', '2024-12-02 08:19:01'),
(3, 3, 1, 3, 15000, '', '2024-12-02 08:21:15', '2024-12-02 08:21:15'),
(4, 4, 4, 1, 7000, '', '2024-12-02 09:05:40', '2024-12-02 09:05:40'),
(5, 4, 4, 1, 7000, '', '2024-12-02 09:05:40', '2024-12-02 09:05:40'),
(6, 5, 2, 1, 4500, '', '2024-12-02 09:06:04', '2024-12-02 09:06:04'),
(7, 5, 2, 1, 4500, '', '2024-12-02 09:06:04', '2024-12-02 09:06:04'),
(8, 6, 2, 4, 18000, '', '2024-12-02 09:19:37', '2024-12-02 09:19:37'),
(9, 6, 1, 4, 20000, '', '2024-12-02 09:19:37', '2024-12-02 09:19:37'),
(10, 7, 1, 2, 10000, '', '2024-12-02 09:27:17', '2024-12-02 09:27:17'),
(11, 7, 1, 3, 15000, '', '2024-12-02 09:27:17', '2024-12-02 09:27:17'),
(12, 8, 2, 3, 13500, '', '2024-12-02 09:28:49', '2024-12-02 09:28:49'),
(13, 8, 1, 2, 10000, '', '2024-12-02 09:28:49', '2024-12-02 09:28:49'),
(14, 9, 4, 1, 7000, '', '2024-12-02 09:30:09', '2024-12-02 09:30:09'),
(15, 9, 4, 1, 7000, '', '2024-12-02 09:30:09', '2024-12-02 09:30:09'),
(16, 10, 1, 1, 5000, '', '2024-12-02 09:50:08', '2024-12-02 09:50:08'),
(17, 10, 1, 1, 5000, '', '2024-12-02 09:50:08', '2024-12-02 09:50:08'),
(18, 11, 4, 1, 7000, '', '2024-12-02 09:57:46', '2024-12-02 09:57:46'),
(19, 11, 4, 1, 7000, '', '2024-12-02 09:57:46', '2024-12-02 09:57:46'),
(20, 13, 1, 1, 5000, '', '2024-12-02 09:59:25', '2024-12-02 09:59:25'),
(21, 13, 1, 1, 5000, '', '2024-12-02 09:59:25', '2024-12-02 09:59:25'),
(22, 15, 2, 1, 4500, '', '2024-12-02 10:04:48', '2024-12-02 10:04:48'),
(23, 15, 2, 1, 4500, '', '2024-12-02 10:04:48', '2024-12-02 10:04:48'),
(24, 17, 1, 2, 10000, '', '2024-12-02 10:09:36', '2024-12-02 10:09:36'),
(25, 17, 4, 4, 28000, '', '2024-12-02 10:09:36', '2024-12-02 10:09:36'),
(26, 19, 1, 4, 20000, '', '2024-12-02 10:28:24', '2024-12-02 10:28:24'),
(27, 19, 4, 5, 35000, '', '2024-12-02 10:28:24', '2024-12-02 10:28:24'),
(28, 21, 1, 5, 25000, '', '2024-12-02 10:33:36', '2024-12-02 10:33:36'),
(29, 21, 4, 7, 49000, '', '2024-12-02 10:33:36', '2024-12-02 10:33:36'),
(30, 23, 1, 3, 15000, '', '2024-12-02 10:46:16', '2024-12-02 10:46:16'),
(31, 23, 4, 6, 42000, '', '2024-12-02 10:46:16', '2024-12-02 10:46:16'),
(32, 25, 1, 6, 30000, '', '2024-12-02 10:52:59', '2024-12-02 10:52:59'),
(33, 25, 3, 2, 10000, '', '2024-12-02 10:52:59', '2024-12-02 10:52:59'),
(34, 26, 4, 1, 7000, '', '2024-12-02 10:58:37', '2024-12-02 10:58:37'),
(35, 26, 4, 2, 14000, '', '2024-12-02 10:58:37', '2024-12-02 10:58:37'),
(36, 27, 3, 1, 5000, '', '2024-12-02 11:00:48', '2024-12-02 11:00:48'),
(37, 27, 2, 2, 9000, '', '2024-12-02 11:00:48', '2024-12-02 11:00:48'),
(38, 28, 4, 1, 7000, '', '2024-12-02 11:10:46', '2024-12-02 11:10:46'),
(39, 28, 2, 2, 9000, '', '2024-12-02 11:10:46', '2024-12-02 11:10:46'),
(40, 29, 2, 1, 4500, '', '2024-12-02 11:39:42', '2024-12-02 11:39:42'),
(41, 29, 1, 1, 5000, '', '2024-12-02 11:39:42', '2024-12-02 11:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'admin@gmail.com', '123', '2024-12-02 02:01:15', '2024-12-02 02:01:15'),
(2, 2, 'operator', 'operator@gmail.com', '123', '2024-12-02 02:32:34', '2024-12-02 02:32:34'),
(3, 3, 'pimpinan', 'pimpinan@gmail.com', '123', '2024-12-02 03:01:57', '2024-12-02 03:15:17'),
(5, 2, 'vino', 'vino@gmail.com', '123', '2024-12-02 03:23:11', '2024-12-02 03:23:11'),
(6, 3, 'ginanjar', 'ginanjar@gmail.com', '123', '2024-12-02 03:57:51', '2024-12-02 03:58:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_order`
--
ALTER TABLE `trans_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `trans_order`
--
ALTER TABLE `trans_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
