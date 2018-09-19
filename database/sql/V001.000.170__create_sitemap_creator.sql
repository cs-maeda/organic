-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 9 朁E11 日 07:01
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
-- テーブルの構造 `sitemap_creator`
--

DROP TABLE IF EXISTS `sitemap_creator`;
CREATE TABLE `sitemap_creator` (
  `creator_id` smallint(5) UNSIGNED NOT NULL COMMENT 'クラスID',
  `name` varchar(255) NOT NULL COMMENT 'URL生成クラス名',
  `term` varchar(8) NOT NULL COMMENT '生成頻度',
  `term_aux` smallint(5) UNSIGNED NOT NULL COMMENT '生成頻度補助値',
  `server` varchar(64) NOT NULL COMMENT 'スキーマおよびサーバ名',
  `note` varchar(255) NOT NULL COMMENT 'クラスの守備範囲など説明'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `sitemap_creator`
--

INSERT INTO `sitemap_creator` (`creator_id`, `name`, `term`, `term_aux`, `server`, `note`) VALUES
(1, '不動産売却・不動産査定の定番', '', 0, 'www.landmarktowns.com', ''),
(2, '土地売却・土地査定の定番', '', 0, 'www.villageatblue.com', ''),
(3, 'マンション売却・マンション査定の定番', '', 0, 'www.voicesforthefive.com', ''),
(4, '家売却・家査定の定番', '', 0, 'www.ohaiapp.net', ''),
(5, '不動産相続・土地相続ガイド', '', 0, 'ww.shopa.org', ''),
(6, '不動産価格・不動産売買の相場', '', 0, 'www.iacs-icc.org', ''),
(7, '土地価格・土地価格の相場', '', 0, 'www.rhs-inc.com', ''),
(8, '地価公示価格・土地評価額がわかるサイト', '', 0, 'www.ginatonic.net', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sitemap_creator`
--
ALTER TABLE `sitemap_creator`
  ADD PRIMARY KEY (`creator_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sitemap_creator`
--
ALTER TABLE `sitemap_creator`
  MODIFY `creator_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'クラスID', AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
