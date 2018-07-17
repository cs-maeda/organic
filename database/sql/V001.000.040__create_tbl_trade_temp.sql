-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 7 朁E10 日 02:48
-- サーバのバージョン： 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_sumaistar`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `tbl_trade_temp`
--

DROP TABLE IF EXISTS `tbl_trade_temp`;
CREATE TABLE `tbl_trade_temp` (
  `No` varchar(5) CHARACTER SET utf8 NOT NULL,
  `class` varchar(32) CHARACTER SET utf8 NOT NULL,
  `type` int(1) DEFAULT NULL,
  `district` varchar(32) CHARACTER SET utf8 NOT NULL,
  `prefecture_id` int(2) UNSIGNED DEFAULT NULL,
  `city_id` varchar(8) CHARACTER SET utf8 NOT NULL,
  `town_id` int(9) UNSIGNED NOT NULL COMMENT '町域ID',
  `town_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `station_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `time_to_station` varchar(32) CHARACTER SET utf8 NOT NULL,
  `price` varchar(32) CHARACTER SET utf8 NOT NULL,
  `unit_price` varchar(32) CHARACTER SET utf8 NOT NULL,
  `floor_plan` varchar(32) CHARACTER SET utf8 NOT NULL,
  `area` varchar(32) CHARACTER SET utf8 NOT NULL,
  `unit_price_m2` varchar(32) CHARACTER SET utf8 NOT NULL,
  `land_shape` varchar(32) CHARACTER SET utf8 NOT NULL,
  `frontage` varchar(32) CHARACTER SET utf8 NOT NULL,
  `total_floor_area` varchar(32) CHARACTER SET utf8 NOT NULL,
  `building_age` varchar(32) CHARACTER SET utf8 NOT NULL,
  `building_structure` varchar(32) CHARACTER SET utf8 NOT NULL,
  `land_usage` varchar(32) CHARACTER SET utf8 NOT NULL,
  `purpose_usage` varchar(32) CHARACTER SET utf8 NOT NULL,
  `road_directory` varchar(32) CHARACTER SET utf8 NOT NULL,
  `road_type` varchar(32) CHARACTER SET utf8 NOT NULL,
  `road_width` varchar(32) CHARACTER SET utf8 NOT NULL,
  `city_plan` varchar(32) CHARACTER SET utf8 NOT NULL,
  `building_coverage` varchar(32) CHARACTER SET utf8 NOT NULL,
  `floor_ratio` varchar(32) CHARACTER SET utf8 NOT NULL,
  `transaction_date` varchar(32) CHARACTER SET utf8 NOT NULL,
  `remodeling` varchar(32) CHARACTER SET utf8 NOT NULL,
  `context` varchar(32) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_trade_temp`
--
ALTER TABLE `tbl_trade_temp`
  ADD KEY `town_name` (`town_name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
