-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2021 at 10:30 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `image_gallery_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `size` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `tags` varchar(250) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `name`, `size`, `url`, `height`, `width`, `tags`, `created_at`) VALUES
(1, 'Jelly fish Photo', 3043345, 'http://www.pixworld.com/i/46443', 600, 2900, 'fish,aquatic,ocean', '2021-08-26 23:39:48'),
(2, 'Christmas Photo', 30400, 'http://www.pixworld.com/i/324023', 600, 500, 'Gift', '2021-08-26 23:42:27'),
(3, 'Zebra Photo', 30400, 'http://www.pixworld.com/i/324sr3', 800, 500, 'zoo,stripes', '2021-08-26 23:46:44'),
(5, 'Weather Photo', 30400, 'http://www.pixworld.com/i/324sr3', 800, 500, 'rain,temperature', '2021-08-27 08:09:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
