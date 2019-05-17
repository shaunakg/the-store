-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2019 at 01:00 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `item_cost` float NOT NULL,
  `item_img_url` varchar(500) NOT NULL,
  `item_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `item_name`, `item_cost`, `item_img_url`, `item_description`) VALUES
(1, 'apple_macbookpro13inch', 'Apple Macbook Pro (13 Inch Retina, 2.3 GHz dual-Core Intel Core i5, 8 GB RAM, 256 GB SSD) - Space Grey', 7500, 'https://images-na.ssl-images-amazon.com/images/I/61GJPL1hCpL._SL1500_.jpg', 'The ultimate pro notebook, MacBook Pro features faster processors, upgraded memory, the Apple T2 chip and a Retina display with True Tone technology.'),
(2, 'tesla_model-y', 'Tesla Model Y Electric Car (With Autopilot)', 150000, 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b9/Tesla_Model_Y_press_art.jpg/280px-Tesla_Model_Y_press_art.jpg', 'Model Y has a 300 mile range (EPA est.), 0-60 mph acceleration in 3.5 seconds and best-in-class storage. Order Now.'),
(3, 'microsoft_surfacebook2', 'Microsoft Surface Book 2 (13 or 15 Inch)', 3000, 'https://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RWthPI?ver=7386&q=90&m=6&h=1570&w=1920&b=%23FFFFFFFF&l=f&o=t&aim=true', 'Surface Book 2 is the most powerful Surface laptop ever; built with power and versatility to be a laptop, tablet, and portable studio all-in-one.'),
(6, 'apple_ipadpro2018', 'Apple iPad Pro (2018)', 2000, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/image/AppleInc/aos/published/images/i/pa/ipad/pro/ipad-pro-12-11-select-201810_GEO_AU?wid=870&amp;hei=1100&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1540576005865', 'Itâ€™s all new, all screen and all powerful. Completely redesigned and packed with our most advanced technology, it will make you rethink what iPad is capable of.');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `browser_token` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `api` tinyint(1) NOT NULL DEFAULT '0',
  `user_balance` int(11) NOT NULL DEFAULT '1000000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction_records`
--

CREATE TABLE `user_transaction_records` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(100) NOT NULL DEFAULT 'purchase',
  `username` varchar(100) NOT NULL,
  `item_bought` varchar(200) NOT NULL,
  `item_price` int(11) NOT NULL,
  `current_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_webmail`
--

CREATE TABLE `user_webmail` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `to_user` varchar(100) NOT NULL,
  `from_user` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `contents` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD UNIQUE KEY `browser_token` (`browser_token`);

--
-- Indexes for table `user_transaction_records`
--
ALTER TABLE `user_transaction_records`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user_webmail`
--
ALTER TABLE `user_webmail`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_transaction_records`
--
ALTER TABLE `user_transaction_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_webmail`
--
ALTER TABLE `user_webmail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
