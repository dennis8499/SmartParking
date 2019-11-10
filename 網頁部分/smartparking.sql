-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-11-16 16:34:39
-- 伺服器版本: 10.1.16-MariaDB
-- PHP 版本： 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `smartparking`
--

-- --------------------------------------------------------

--
-- 資料表結構 `nodemcu`
--

CREATE TABLE `nodemcu` (
  `seqno` int(20) NOT NULL,
  `chipid` varchar(10) NOT NULL,
  `topic` varchar(30) NOT NULL,
  `blockno` varchar(30) NOT NULL,
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nodemcu`
--

INSERT INTO `nodemcu` (`seqno`, `chipid`, `topic`, `blockno`, `valid`) VALUES
(1, '123456', 'SmartParking/Sensor', 'TTU001', 'Y');

-- --------------------------------------------------------

--
-- 資料表結構 `owner`
--

CREATE TABLE `owner` (
  `seqno` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `blockno` varchar(20) NOT NULL,
  `profile` varchar(50) NOT NULL,
  `rentvalid` enum('Y','N') DEFAULT 'Y',
  `valid` enum('Y','N') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `owner`
--

INSERT INTO `owner` (`seqno`, `name`, `blockno`, `profile`, `rentvalid`, `valid`) VALUES
(1, '劉泓岑', 'TTU001', '大家好', 'Y', 'Y');

-- --------------------------------------------------------

--
-- 資料表結構 `parking`
--

CREATE TABLE `parking` (
  `seqno` int(20) NOT NULL,
  `parkid` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `heightlimit` varchar(5) NOT NULL,
  `gpslocation` varchar(40) NOT NULL,
  `noofblocks` varchar(30) NOT NULL,
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `parking`
--

INSERT INTO `parking` (`seqno`, `parkid`, `name`, `address`, `heightlimit`, `gpslocation`, `noofblocks`, `valid`) VALUES
(1, 'TTU', '大同大學', '台北市中山區中山北路三段40號', '190', '25.0673666,121.5212688', '20', 'Y');

-- --------------------------------------------------------

--
-- 資料表結構 `parkingblock`
--

CREATE TABLE `parkingblock` (
  `seqno` int(10) NOT NULL,
  `blockid` varchar(30) NOT NULL,
  `currentuser` varchar(20) NOT NULL,
  `time` date NOT NULL,
  `checkreservation` enum('Y','N') NOT NULL DEFAULT 'N',
  `carstate` enum('Y','N') NOT NULL DEFAULT 'N',
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `parkingblock`
--

INSERT INTO `parkingblock` (`seqno`, `blockid`, `currentuser`, `time`, `checkreservation`, `carstate`, `valid`) VALUES
(1, 'TTU001', '', '0000-00-00', 'N', 'N', 'Y');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `seqno` int(10) NOT NULL,
  `loginid` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `currentblock` varchar(10) NOT NULL,
  `nickname` varchar(10) NOT NULL,
  `lpn` varchar(10) NOT NULL,
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y',
  `currentlot` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`seqno`, `loginid`, `password`, `currentblock`, `nickname`, `lpn`, `valid`, `currentlot`) VALUES
(1, 'adminuser', '6f372c90822f7de721f3e6edc42653a746e81d90', '', '管理者', '管理者', 'Y', NULL),
(2, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '', '阿年', 'BMW-8888', 'Y', NULL);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `nodemcu`
--
ALTER TABLE `nodemcu`
  ADD PRIMARY KEY (`seqno`);

--
-- 資料表索引 `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`seqno`);

--
-- 資料表索引 `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`seqno`);

--
-- 資料表索引 `parkingblock`
--
ALTER TABLE `parkingblock`
  ADD PRIMARY KEY (`seqno`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`seqno`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `nodemcu`
--
ALTER TABLE `nodemcu`
  MODIFY `seqno` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `owner`
--
ALTER TABLE `owner`
  MODIFY `seqno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `parking`
--
ALTER TABLE `parking`
  MODIFY `seqno` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `parkingblock`
--
ALTER TABLE `parkingblock`
  MODIFY `seqno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `seqno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
