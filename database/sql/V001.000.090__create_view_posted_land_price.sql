-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 8 朁E14 日 10:34
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
-- ビュー用の構造 `view_posted_land_price`
--

DROP VIEW IF EXISTS `view_posted_land_price`;
CREATE VIEW `view_posted_land_price`  AS  select `tbl_posted_land_price`.`tbl_posted_land_price_id` AS `tbl_posted_land_price_id`,`tbl_posted_land_price`.`year` AS `year`,`tbl_posted_land_price`.`city_id` AS `city_id`,`tbl_posted_land_price`.`longitude` AS `longitude`,`tbl_posted_land_price`.`latitude` AS `latitude`,`tbl_posted_land_price`.`land_usage` AS `land_usage`,`tbl_posted_land_price`.`address` AS `address`,`tbl_posted_land_price`.`area` AS `area`,`tbl_posted_land_price`.`price` AS `price`,`tbl_posted_land_price`.`present_situation` AS `present_situation`,`tbl_posted_land_price`.`shape` AS `shape`,`tbl_posted_land_price`.`road_situation` AS `road_situation`,`tbl_posted_land_price`.`road_direction` AS `road_direction`,`tbl_posted_land_price`.`road_width` AS `road_width`,`tbl_posted_land_price`.`peripheral_situation` AS `peripheral_situation`,`tbl_posted_land_price`.`station_name` AS `station_name`,`tbl_posted_land_price`.`station_distance` AS `station_distance`,`tbl_posted_land_price`.`use_segment` AS `use_segment`,`tbl_posted_land_price`.`city_plan` AS `city_plan`,`tbl_posted_land_price`.`building_ratio` AS `building_ratio`,`tbl_posted_land_price`.`floor_ratio` AS `floor_ratio` from `tbl_posted_land_price` where (`tbl_posted_land_price`.`year` = 2018) ;

--
-- VIEW  `view_posted_land_price`
-- Data: なし
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
