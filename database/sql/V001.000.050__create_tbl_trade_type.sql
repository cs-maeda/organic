-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 7 朁E19 日 04:30
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
-- テーブルの構造 `tbl_trade_type`
--

DROP TABLE IF EXISTS `tbl_trade_type`;
CREATE TABLE `tbl_trade_type` (
  `tbl_trade_type_id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL COMMENT '種類番号',
  `caption` varchar(16) CHARACTER SET utf8 NOT NULL COMMENT '種類名称'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='売買実績データ種類テーブル';

--
-- テーブルのデータのダンプ `tbl_trade_type`
--

INSERT INTO `tbl_trade_type` (`tbl_trade_type_id`, `type`, `caption`) VALUES
(1, 1, '宅地（土地）'),
(2, 2, '宅地（土地と建物）'),
(3, 3, '中古マンション'),
(4, 4, '林地'),
(5, 5, '農地');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_trade_type`
--
ALTER TABLE `tbl_trade_type`
  ADD PRIMARY KEY (`tbl_trade_type_id`),
  ADD KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_trade_type`
--
ALTER TABLE `tbl_trade_type`
  MODIFY `tbl_trade_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
