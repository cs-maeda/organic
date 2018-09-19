-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 9 朁E19 日 09:30
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
-- テーブルの構造 `sitemap_url`
--

DROP TABLE IF EXISTS `sitemap_url`;
CREATE TABLE `sitemap_url` (
  `url_id` bigint(20) UNSIGNED NOT NULL COMMENT 'URLテーブルID',
  `url` varchar(255) NOT NULL COMMENT 'サイトマップ掲載URL',
  `creator_id` smallint(5) UNSIGNED NOT NULL COMMENT '登録したクラスID',
  `ng_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:ページが存在する 1:ページが存在しない'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sitemap_url`
--
ALTER TABLE `sitemap_url`
  ADD PRIMARY KEY (`url_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sitemap_url`
--
ALTER TABLE `sitemap_url`
  MODIFY `url_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'URLテーブルID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
