-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 11:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `register_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `football_field`
--

CREATE TABLE `football_field` (
  `resever_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `tel` varchar(10) NOT NULL,
  `date_reserve` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `field_number` int(1) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'รอดำเนินการ',
  `user_id` int(11) DEFAULT NULL,
  `image_status` varchar(255) NOT NULL,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `football_field`
--

INSERT INTO `football_field` (`resever_id`, `firstname`, `lastname`, `tel`, `date_reserve`, `start_time`, `end_time`, `field_number`, `status`, `user_id`, `image_status`, `image_id`) VALUES
(127, 'test01', 'test01', '0942512902', '2023-07-27', '13:00:00', '14:00:00', 1, 'อัปโหลดสลิปแล้ว', 29, 'อัปโหลดสลิปแล้ว', 53),
(128, 'test01', 'test01', '0942512902', '2023-07-27', '19:00:00', '20:00:00', 1, 'อัปโหลดสลิปแล้ว', 29, 'อัปโหลดสลิปแล้ว', 55),
(134, 'test01', 'test01', '0942512902', '2023-07-28', '16:00:00', '17:00:00', 1, 'อัปโหลดสลิปแล้ว', 29, 'อัปโหลดสลิปแล้ว', 34),
(135, 'test01', 'test01', '0942512902', '2023-07-28', '16:00:00', '17:00:00', 3, 'อัปโหลดสลิปแล้ว', 29, 'อัปโหลดสลิปแล้ว', 54),
(136, 'ณภัทร', 'ขาวละออ', '0942512902', '2023-07-29', '10:00:00', '11:00:00', 1, 'อัปโหลดสลิปแล้ว', 33, 'อัปโหลดสลิปแล้ว', 59),
(142, 'ทดลอง', 'ครั้งที่1', '0942512902', '2023-08-14', '18:00:00', '19:00:00', 1, 'อัปโหลดสลิปแล้ว', 34, 'อัปโหลดสลิปแล้ว', 57),
(144, 'test01', 'test01', '0942512902', '2023-08-15', '17:00:00', '18:00:00', 1, 'อัปโหลดสลิปแล้ว', 29, 'รอตรวจสอบ', 51),
(145, 'test01', 'test01', '0942512902', '2023-08-15', '10:00:00', '11:00:00', 3, 'ยืนยันการจองแล้ว', 29, 'รอตรวจสอบ', 52),
(146, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2023-08-15', '22:00:00', '23:00:00', 1, 'อัปโหลดสลิปแล้ว', 30, 'รออัปโหลดสลิป', 61),
(147, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2023-08-15', '19:30:00', '20:30:00', 1, 'อัปโหลดสลิปแล้ว', 30, 'รออัปโหลดสลิป', 62),
(155, 'charnua', 'arcus', '0942512902', '2023-08-19', '15:30:00', '16:30:00', 1, 'อัปโหลดสลิปแล้ว', 36, 'รออัปโหลดสลิป', 68),
(156, 'charnua', 'arcus', '0942512902', '2023-08-19', '18:30:00', '19:30:00', 1, 'รอยืนยันการจอง', 36, 'รออัปโหลดสลิป', NULL),
(159, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2023-08-26', '11:00:00', '12:00:00', 1, 'ยืนยันการจองแล้ว', 30, 'รออัปโหลดสลิป', 70),
(160, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2023-08-26', '15:00:00', '16:00:00', 1, 'ยืนยันการจองแล้ว', 30, 'รออัปโหลดสลิป', 71),
(161, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2023-08-26', '15:00:00', '16:00:00', 2, 'อัปโหลดสลิปแล้ว', 30, 'รออัปโหลดสลิป', 75),
(162, 'ณภัทร', 'ขาวละออ', '0942512902', '2023-10-12', '10:00:00', '11:00:00', 2, 'อัปโหลดสลิปแล้ว', 33, 'รออัปโหลดสลิป', 72),
(165, 'test1', 'test1', '0942512902', '2024-03-21', '21:00:00', '22:00:00', 1, 'ยืนยันการจองแล้ว', 26, 'รออัปโหลดสลิป', 74),
(169, 'test1', 'test1', '0942512902', '2024-03-21', '18:00:00', '20:00:00', 1, 'อัปโหลดสลิปแล้ว', 26, 'รออัปโหลดสลิป', 76),
(195, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2024-03-23', '18:00:00', '19:00:00', 1, 'ยกเลิกการจอง', 30, 'รออัปโหลดสลิป', 81),
(196, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2024-03-23', '18:00:00', '19:00:00', 1, 'ยืนยันการจองแล้ว', 30, 'รออัปโหลดสลิป', 82),
(197, 'ผู้ใช้งาน', 'คนที่1', '0942512902', '2024-04-01', '16:00:00', '17:00:00', 1, 'ยกเลิกการจอง', 30, 'รออัปโหลดสลิป', 83),
(198, 'ผู้ใช้งาน', 'คนที่1', '0942512000', '2024-04-01', '16:00:00', '18:00:00', 1, 'อัปโหลดสลิปแล้ว', 30, 'รออัปโหลดสลิป', 84);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `filename`) VALUES
(1, 29, 'image_649a524abc7bc.jpg'),
(2, 29, 'image_649a716f95257.png');

-- --------------------------------------------------------

--
-- Table structure for table `imagesdb`
--

CREATE TABLE `imagesdb` (
  `image_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `image_status` varchar(255) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `resever_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imagesdb`
--

INSERT INTO `imagesdb` (`image_id`, `date`, `time`, `image`, `status`, `image_status`, `id`, `resever_id`) VALUES
(33, NULL, NULL, '1690504292_JcJxpDbrQnb2xAvwA_CP6FMhU1p4L1IUOsv6A-CVY_hFLOzCQQQn9jvNfBcJszfRbGW-DBYxO1Gb68i32dYdm-p6JkknMoIbMjAdoFtdqxo5KNW0JuOqz7xWYcLYAzcahQ7XXNlMIvOKyR-Uke5ipw==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 128),
(34, NULL, NULL, '1690515050_QrVMq0dDhj3XCjH48IQ3KYm43-Ii-jYeHAwjNr0jzW37XD-pG2qt4i1lxtGe-SDxDZ7VMNyqzGsVxh0mTJwjBHDCbkOoiPW-HJOT67QMPh5c_RXj_2CHvxusU4i8xWAlQQq1-WG3eFy_I7uXKcbEYg==.jpg', 'รอตรวจสอบ', '', 29, 134),
(35, NULL, NULL, '1690521508_QrVMq0dDhj3XCjH48IQ3KYm43-Ii-jYeHAwjNr0jzW37XD-pG2qt4i1lxtGe-SDxDZ7VMNyqzGsVxh0mTJwjBHDCbkOoiPW-HJOT67QMPh5c_RXj_2CHvxusU4i8xWAlQQq1-WG3eFy_I7uXKcbEYg==.jpg', 'รอตรวจสอบ', '', 29, 135),
(36, NULL, NULL, '1690522396_bcCEc1bLBK2QpVymsNQMIbDrFjUGlL9lZE6l7hS1jalr46FSqhlCS2_JkrFU3L0y-Os3C575vdl29m_ESgWoLLZLkxE88Zn9qauPVKW86qx29-pntLZA2gPni_Te4COe6jNu5bRgUMkvYKl3YQCxcw==.jpg', 'รอตรวจสอบ', '', 29, 128),
(37, NULL, NULL, '1690597535_0KYc2yJ-6SIiKakRqlKOdOjaj0CvgksQ5r5rk2ZB7d22CB74mG5Rwg54vdXBPU7imU3LQKGTyU-jpXWIiaazPixDmV6BwP0cPLyjtCai1AnpQAEoQc8SVDWcelYCMBOtyoEYSNdl5TIBu65cFcBv0A==.jpg', 'รอตรวจสอบ', '', 29, 127),
(38, NULL, NULL, '1690597552_0KYc2yJ-6SIiKakRqlKOdOjaj0CvgksQ5r5rk2ZB7d22CB74mG5Rwg54vdXBPU7imU3LQKGTyU-jpXWIiaazPixDmV6BwP0cPLyjtCai1AnpQAEoQc8SVDWcelYCMBOtyoEYSNdl5TIBu65cFcBv0A==.jpg', 'รอตรวจสอบ', '', 29, 128),
(39, NULL, NULL, '1690597626_TejbMZoetFa2iUxKhwSflr1kSZDism4CzKmr5CK9vVq_DVm_IiuGcM4sHOvM8svXpMAo9boIA-WtvBNKs1MbFZSFzgeUfy7xjXZJsqPXRXKeRIa5EhXYgEy03Ki_CVa6kpngZXezwyv0UN-p8nCI8Q== (1).jpg', 'รอตรวจสอบ', '', 29, 128),
(40, NULL, NULL, '1690598874_0KYc2yJ-6SIiKakRqlKOdOjaj0CvgksQ5r5rk2ZB7d22CB74mG5Rwg54vdXBPU7imU3LQKGTyU-jpXWIiaazPixDmV6BwP0cPLyjtCai1AnpQAEoQc8SVDWcelYCMBOtyoEYSNdl5TIBu65cFcBv0A==.jpg', 'รอตรวจสอบ', '', 33, 136),
(41, NULL, NULL, '1691982336_GzT4Hq19PQmOcXEoaikKDeQOhany_NH1SrlojiQRnwwfXX8Mqnd7cKGGam_vwI2Crnug3lz9mOnLM_VSBBbkTf2cEa2dABDp0JkP2xFmJGo92fOp57Rc_nOJr2WEYG-CPGAWgRoNfwFFSQkqTkXAuA==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 127),
(42, NULL, NULL, '1691982634_GzT4Hq19PQmOcXEoaikKDeQOhany_NH1SrlojiQRnwwfXX8Mqnd7cKGGam_vwI2Crnug3lz9mOnLM_VSBBbkTf2cEa2dABDp0JkP2xFmJGo92fOp57Rc_nOJr2WEYG-CPGAWgRoNfwFFSQkqTkXAuA==.jpg', 'รอตรวจสอบ', '', 33, 136),
(45, NULL, NULL, '1691986336_mUEjKrRA2OR33gMaYga0QJKUEy-FpxyRjaWXSSF6yd9Whin6yrFSFynY4nzxsOyNIhQWLvgsmxDaiBBsyg4xNMWjJ-LQdtrj87qMTOF_1iQwLY_dbN3dz56Ha7qT1_tsOObrIXWDvj3wvVZWXR7TOg==.jpg', 'รอตรวจสอบ', '', 33, 136),
(49, NULL, NULL, '1692066163_2_EavtKeFUtr5-Zk4huvPk1WQhss2SdpvhUZL1nJh_N49eTHJvB3QbbaE9fI8b4e6hFUqg0cal2sfQP1HdgXnZR2d2-L1T7siJVTICM2UsFA5IhFu-PjZ1uIR65XqWsMyoEYSNdl5TIBu65cFcBv0A==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 127),
(50, NULL, NULL, '1692070219_GzT4Hq19PQmOcXEoaikKDeQOhany_NH1SrlojiQRnwwfXX8Mqnd7cKGGam_vwI2Crnug3lz9mOnLM_VSBBbkTf2cEa2dABDp0JkP2xFmJGo92fOp57Rc_nOJr2WEYG-CPGAWgRoNfwFFSQkqTkXAuA==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 128),
(51, NULL, NULL, '1692072216_2_EavtKeFUtr5-Zk4huvPk1WQhss2SdpvhUZL1nJh_N49eTHJvB3QbbaE9fI8b4e6hFUqg0cal2sfQP1HdgXnZR2d2-L1T7siJVTICM2UsFA5IhFu-PjZ1uIR65XqWsMyoEYSNdl5TIBu65cFcBv0A==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 144),
(52, NULL, NULL, '1692073393_2_EavtKeFUtr5-Zk4huvPk1WQhss2SdpvhUZL1nJh_N49eTHJvB3QbbaE9fI8b4e6hFUqg0cal2sfQP1HdgXnZR2d2-L1T7siJVTICM2UsFA5IhFu-PjZ1uIR65XqWsMyoEYSNdl5TIBu65cFcBv0A==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 145),
(53, NULL, NULL, '1692073520_GzT4Hq19PQmOcXEoaikKDeQOhany_NH1SrlojiQRnwwfXX8Mqnd7cKGGam_vwI2Crnug3lz9mOnLM_VSBBbkTf2cEa2dABDp0JkP2xFmJGo92fOp57Rc_nOJr2WEYG-CPGAWgRoNfwFFSQkqTkXAuA==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 127),
(54, NULL, NULL, '1692073536_EBwA6gjqbl8lp92-jgG2uaMqNgSLwxqrApTymG6v7hJOCrYfsfuT2Wu8B9zcLP8c3sVTjjFVjU8GbT-P0OajIrp2tWJ90z-OnhP3ehcVpcRnxFKg6qR8rtyCRkoNSUGndWH1GW1Hzzc1ZjJIrpDCnQ==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 135),
(55, NULL, NULL, '1692073570_2_EavtKeFUtr5-Zk4huvPk1WQhss2SdpvhUZL1nJh_N49eTHJvB3QbbaE9fI8b4e6hFUqg0cal2sfQP1HdgXnZR2d2-L1T7siJVTICM2UsFA5IhFu-PjZ1uIR65XqWsMyoEYSNdl5TIBu65cFcBv0A==.jpg', 'อัปโหลดสลิปแล้ว', '', 29, 128),
(57, NULL, NULL, '1692073852_295m0e1Ikd2s1UF405gZXExS8mAy35modlIZeOQFJtiA4JfXRvryu_VN9DF8A-4Hla5vWxcsjHSE9sXtiqRGJXC62hWzVaGbH8yEpwoaeMAxX4OjHKsTU_6160tf8gQHkpngZXezwyv0UN-p8nCI8Q==.jpg', 'อัปโหลดสลิปแล้ว', '', 34, 142),
(59, NULL, NULL, '1692079346_2_EavtKeFUtr5-Zk4huvPk1WQhss2SdpvhUZL1nJh_N49eTHJvB3QbbaE9fI8b4e6hFUqg0cal2sfQP1HdgXnZR2d2-L1T7siJVTICM2UsFA5IhFu-PjZ1uIR65XqWsMyoEYSNdl5TIBu65cFcBv0A==.jpg', 'อัปโหลดสลิปแล้ว', '', 33, 136),
(61, NULL, NULL, '1692087606_GzT4Hq19PQmOcXEoaikKDeQOhany_NH1SrlojiQRnwwfXX8Mqnd7cKGGam_vwI2Crnug3lz9mOnLM_VSBBbkTf2cEa2dABDp0JkP2xFmJGo92fOp57Rc_nOJr2WEYG-CPGAWgRoNfwFFSQkqTkXAuA==.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 146),
(62, NULL, NULL, '1692087663_EBwA6gjqbl8lp92-jgG2uaMqNgSLwxqrApTymG6v7hJOCrYfsfuT2Wu8B9zcLP8c3sVTjjFVjU8GbT-P0OajIrp2tWJ90z-OnhP3ehcVpcRnxFKg6qR8rtyCRkoNSUGndWH1GW1Hzzc1ZjJIrpDCnQ==.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 147),
(68, NULL, NULL, '1692433897_inv.jpeg', 'อัปโหลดสลิปแล้ว', '', 36, 155),
(70, NULL, NULL, '1693028532_a.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 159),
(71, NULL, NULL, '1693033427_photo_2023-01-21_00-30-39.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 160),
(72, NULL, NULL, '1697084812_a.jpg', 'อัปโหลดสลิปแล้ว', '', 33, 162),
(74, NULL, NULL, '1708438485_photo_2023-11-10_08-51-01.jpg', 'อัปโหลดสลิปแล้ว', '', 26, 165),
(75, NULL, NULL, '1710163698_photo_2023-11-13_01-30-27.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 161),
(76, NULL, NULL, '1710774870_photo_2023-11-11_06-24-11.jpg', 'อัปโหลดสลิปแล้ว', '', 26, 169),
(81, NULL, NULL, '1711120578_photo_2023-11-19_01-23-32.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 195),
(82, NULL, NULL, '1711121409_photo_2023-11-13_01-30-27.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 196),
(83, NULL, NULL, '1711186327_photo_2023-11-19_01-30-19.jpg', 'อัปโหลดสลิปแล้ว', '', 30, 197),
(84, NULL, NULL, '1711189330_RobloxScreenShot20231123_061551386.png', 'อัปโหลดสลิปแล้ว', '', 30, 198);

-- --------------------------------------------------------

--
-- Table structure for table `stadium`
--

CREATE TABLE `stadium` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `dor` date NOT NULL,
  `tor` time NOT NULL,
  `stadium_id` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `urole` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `urole`, `create_at`) VALUES
(1, 'แอดมิน', 'ไอซ์', 'admin2', '$2y$10$mtxZrtx0ZNReCnxkgy1GnuzgfakhGIQgiNuqNEZgkXuFjtEC642c.', 'admin', '2023-01-05 16:20:35'),
(9, 'แอดมิน', 'อาร์ม', 'admin', '$2y$10$g6f9xuE4qfur3QA..RvEp.DadaFtcOm3CZ8OnWqVQWWW6qv0bQ1Ti', 'admin', '2023-01-16 18:54:04'),
(26, 'test1', 'test1', 'test1', '$2y$10$Xx2zK8d5AHtTXFZeuMpfI.KgrFlQlvXvV67Qyhj0hOpPlmY5YpQDW', 'user', '2023-06-04 20:53:15'),
(29, 'test', 'test', 'test', '$2y$10$i5AllX4/Qp5PWuMChmhwOufaOr8grKRF82.k4CTfBaSlXxJX7IsOq', 'user', '2023-06-26 06:50:43'),
(30, 'ผู้ใช้งาน', 'คนที่1', 'user01', '$2y$10$NeM7snY4jtISlIpvXlrMqOgfScvAFnM5eXb4V2MnGsPyF/LQk2s4e', 'user', '2023-07-21 04:57:29'),
(32, 'ณภัทร', 'วิทยากุล', 'napat', '$2y$10$/dSj7cWNf4hoGzcbSHrvXu4R3AWiRe9PCmBffXtQSfuWa.C8hAKsu', 'admin', '2023-07-22 08:06:23'),
(33, 'ณภัทร', 'ขาวละออ', 'tiwza55', '$2y$10$4p7MthhvHAZlfTBlMmr0/.rJNbVEzOPngbuy8vUPtT0gN3UuRe6Za', 'user', '2023-07-24 06:46:29'),
(34, 'ทดลอง', 'ครั้งที่1', 'todlong', '$2y$10$nLP7I7ZxqaswrtYoDAu1g.2VPphLsGU8TxjA9ammBKAKDyup4vlBK', 'user', '2023-08-14 09:06:32'),
(35, 'tod', 'long2', 'todlong2', '$2y$10$d4qdox3vBx7.W8tf8LpH1uNCWsWzXbGP1aGdCSK4spw0ztTTK4rOW', 'user', '2023-08-15 08:24:34'),
(36, 'charnua', 'arcus', 'charnua', '$2y$10$R39jSF5yrfBEkVKQI7gl/eLiX8b3b2zGQFSBFedSsH18m7Upnuoga', 'user', '2023-08-19 08:27:48'),
(37, 'super', 'kapu', 'superkapu', '$2y$10$5.ynMWLtfHdy4kGctGLsdeX84thfry.WndSZk8Frj2Uiloe0oEUyG', 'user', '2023-10-12 06:57:07'),
(38, 'test1234', 'test1234', 'test1234', '$2y$10$p0aGqBWExbmCjxyBp7dwQur3KlmOGTtNiFhv2Z4rHQHYoQ/WWBK1K', 'user', '2024-03-22 08:20:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `football_field`
--
ALTER TABLE `football_field`
  ADD PRIMARY KEY (`resever_id`),
  ADD KEY `fk_user_id_football_field` (`user_id`),
  ADD KEY `fk_image_id` (`image_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `imagesdb`
--
ALTER TABLE `imagesdb`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `fk_id` (`id`),
  ADD KEY `fk_imagesdb_resever` (`resever_id`);

--
-- Indexes for table `stadium`
--
ALTER TABLE `stadium`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `football_field`
--
ALTER TABLE `football_field`
  MODIFY `resever_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `imagesdb`
--
ALTER TABLE `imagesdb`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `stadium`
--
ALTER TABLE `stadium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `football_field`
--
ALTER TABLE `football_field`
  ADD CONSTRAINT `fk_image_id` FOREIGN KEY (`image_id`) REFERENCES `imagesdb` (`image_id`),
  ADD CONSTRAINT `fk_user_id_football_field` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `imagesdb`
--
ALTER TABLE `imagesdb`
  ADD CONSTRAINT `fk_id` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_imagesdb_resever` FOREIGN KEY (`resever_id`) REFERENCES `football_field` (`resever_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `imagesdb_ibfk_1` FOREIGN KEY (`resever_id`) REFERENCES `football_field` (`resever_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
