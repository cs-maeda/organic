-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 7 朁E10 日 11:20
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
-- テーブルの構造 `tbl_trade_ranking`
--

DROP TABLE IF EXISTS `tbl_trade_ranking`;
CREATE TABLE `tbl_trade_ranking` (
  `tbl_trade_ranking_id` int(10) UNSIGNED NOT NULL,
  `parent_area_id` int(5) UNSIGNED NOT NULL COMMENT '親エリアID',
  `area_id` int(8) UNSIGNED NOT NULL COMMENT 'ランキングエリアID',
  `avg_price` double UNSIGNED NOT NULL COMMENT '平均価格',
  `min_price` bigint(20) UNSIGNED NOT NULL COMMENT '最低価格',
  `max_price` bigint(20) UNSIGNED NOT NULL COMMENT '最高価格',
  `station` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '駅ランキング識別子'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_trade_ranking`
--
ALTER TABLE `tbl_trade_ranking`
  ADD PRIMARY KEY (`tbl_trade_ranking_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `parent_area_id` (`parent_area_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_trade_ranking`
--
ALTER TABLE `tbl_trade_ranking`
  MODIFY `tbl_trade_ranking_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
