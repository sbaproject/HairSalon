-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 15, 2020 lúc 10:07 AM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hair_salon`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_course`
--

CREATE TABLE `t_course` (
  `co_id` int(11) NOT NULL,
  `co_sh_id` int(11) DEFAULT NULL,
  `co_name` varchar(200) DEFAULT NULL,
  `co_opt1` int(11) DEFAULT NULL,
  `co_opt2` int(11) DEFAULT NULL,
  `co_opt3` int(11) DEFAULT NULL,
  `co_opt4` int(11) DEFAULT NULL,
  `co_opt5` int(11) DEFAULT NULL,
  `co_text` varchar(200) DEFAULT NULL,
  `co_del_flg` int(11) DEFAULT NULL,
  `co_date` datetime DEFAULT NULL,
  `co_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_course`
--

INSERT INTO `t_course` (`co_id`, `co_sh_id`, `co_name`, `co_opt1`, `co_opt2`, `co_opt3`, `co_opt4`, `co_opt5`, `co_text`, `co_del_flg`, `co_date`, `co_update`) VALUES
(36, 1, '345', 33, 32, 32, 32, 32, NULL, 0, '2020-03-27 09:55:19', '2020-03-30 10:33:15'),
(37, 1, 'dang thai ngoc thachdang thai ngoc thach', 34, 32, 36, 32, 32, NULL, 0, '2020-03-27 11:49:07', '2020-03-27 12:08:41'),
(38, 1, 'asdasd', 35, 32, 32, 32, 32, NULL, 0, '2020-03-27 14:49:10', '2020-03-27 15:41:01'),
(39, 1, 'asdasd', 35, 32, 32, 32, 32, NULL, 0, '2020-03-27 14:49:10', '2020-03-27 15:40:57'),
(40, 1, 'qwfqwf', 32, 32, 32, 32, 32, 'qwfqwf', 0, '2020-03-27 14:49:17', '2020-03-27 15:40:51'),
(41, 1, 'qwfqwf', 33, 32, 32, 32, 32, NULL, 0, '2020-03-27 14:49:22', '2020-03-27 14:49:22'),
(42, 1, 'qwfqwf', 34, 32, 32, 32, 32, 'qwfqw', 0, '2020-03-27 14:49:28', '2020-03-27 14:49:28'),
(43, 1, 'qwfqwf', 34, 32, 32, 32, 32, 'qwfqwf', 0, '2020-03-27 14:49:33', '2020-03-27 14:49:33'),
(44, 1, 'qwfqwf', 35, 32, 32, 32, 32, NULL, 0, '2020-03-27 14:49:36', '2020-03-27 15:03:22'),
(45, 1, 'qwfqwf', 33, 32, 32, 32, 32, 'qwfq', 0, '2020-03-27 14:49:41', '2020-03-27 14:49:41'),
(46, 1, 'wqfqw', 33, 32, 32, 32, 32, 'asascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasasc', 0, '2020-03-27 14:49:45', '2020-03-27 15:39:55'),
(47, 1, '1231123112311231123112311231123112311231123112311231123112311231123112311231123112311231123112311231', 33, NULL, NULL, NULL, NULL, NULL, 0, '2020-04-01 09:58:31', '2020-04-01 09:58:31'),
(48, 1, 'svvvvvvvvvvvvvvvvvsvvvvvvvvvvvvvvvvvsvvvvvvvvvvvvvvvvvsvvvvvvvvvvvvvvvvvsvvvvvvvvvvvvvvvvvsvvvvvvvvv', NULL, 35, NULL, NULL, NULL, NULL, 0, '2020-04-01 10:33:45', '2020-04-01 10:33:45'),
(49, 1, 'コンボ１', 47, 49, NULL, NULL, NULL, NULL, 0, '2020-06-02 09:35:51', '2020-06-02 09:35:51'),
(50, 1, 'combo ok', 58, 39, 47, NULL, NULL, NULL, 0, '2020-06-02 09:36:16', '2020-06-05 11:35:54'),
(51, 2, 'Combo 1', 53, 54, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:46:35', '2020-06-02 13:48:57'),
(52, 2, 'Combo ２', 51, 50, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:47:02', '2020-06-02 13:49:08'),
(53, 2, 'Combo 3', 51, 55, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:47:26', '2020-06-02 13:49:18'),
(54, 2, 'Combo 4', 52, 50, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:48:41', '2020-06-02 13:48:41'),
(55, 2, 'Nail', 56, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:57:46', '2020-06-02 13:57:46'),
(56, 2, 'Duỗi', 55, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:58:04', '2020-06-02 13:58:04'),
(57, 2, 'Nhuộm', 50, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:58:42', '2020-06-02 13:58:42'),
(58, 2, 'Uốn', 52, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 13:59:08', '2020-06-02 13:59:08'),
(59, 2, 'cắt', 51, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 14:04:54', '2020-06-02 14:04:54'),
(60, 2, 'Gội', 53, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 14:05:13', '2020-06-02 14:05:13'),
(61, 2, 'Sấy', 54, NULL, NULL, NULL, NULL, NULL, 0, '2020-06-02 14:05:23', '2020-06-02 14:05:23'),
(62, 2, 'Combo 5', 53, 54, 56, NULL, NULL, NULL, 0, '2020-06-02 14:05:48', '2020-06-02 14:05:48'),
(63, 1, 'combo vvip', 34, 57, 57, 57, 57, NULL, 0, '2020-06-12 11:27:07', '2020-06-12 11:27:30'),
(64, 1, 'combo vvip 1', 34, 57, 58, 44, 38, 'fa', 0, '2020-06-12 11:28:12', '2020-06-12 11:28:12'),
(65, 1, 'combo ok', 33, NULL, NULL, NULL, NULL, NULL, 1, '2020-06-12 11:32:22', '2020-06-12 11:32:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_customer`
--

CREATE TABLE `t_customer` (
  `c_id` int(11) NOT NULL,
  `c_firstname` varchar(200) DEFAULT NULL,
  `c_lastname` varchar(200) DEFAULT NULL,
  `c_text` text DEFAULT NULL,
  `c_sh_id` int(11) DEFAULT NULL,
  `c_date` datetime DEFAULT NULL,
  `c_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_customer`
--

INSERT INTO `t_customer` (`c_id`, `c_firstname`, `c_lastname`, `c_text`, `c_sh_id`, `c_date`, `c_update`) VALUES
(1, 'Thach', 'Dang', '90 kg', 1, '2020-03-20 10:26:56', '2020-06-05 13:58:23'),
(2, 'HUY', 'PHAM', 'nang 59kg', 2, '2020-03-20 10:27:30', '2020-06-05 13:04:13'),
(3, 'DUY', 'NGUYEN', 'nang 50kg', 1, '2020-03-20 10:27:53', '2020-03-26 10:23:32'),
(4, 'Nguyen', 'Duy Nhat', 'võ sĩ', 1, NULL, '2020-03-20 17:47:17'),
(5, '大沢', 'Maria', NULL, 1, '2020-03-25 13:32:20', '2020-03-25 13:38:39'),
(6, 'Huy', 'Nguyen', 'test  abc bbb', 1, '2020-03-25 13:32:46', '2020-03-31 12:34:41'),
(7, 'Quynh Anh', 'Ton Nu', NULL, 2, '2020-03-25 13:41:36', NULL),
(8, 'Anh', 'Nguyen', NULL, 2, '2020-03-25 13:42:09', NULL),
(9, 'Huynhs', 'Tran Thanh', NULL, 2, '2020-03-25 15:37:08', '2020-03-25 20:35:46'),
(10, 'Hong Phuoc', 'Pham', NULL, 2, '2020-03-25 16:33:17', NULL),
(11, 'cutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutasvasva', 'cutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcut', NULL, 2, '2020-03-25 20:34:50', NULL),
(12, 'vasdv', 'asdvasd', NULL, 1, '2020-03-25 20:36:00', NULL),
(13, '123', '123', '123', 1, '2020-04-01 09:30:49', NULL),
(14, 'asdvasdv', 'advasdv', 'asdvasdv', 1, '2020-04-01 09:30:54', NULL),
(15, 'asdva', 'asvasdv', 'sdvasdv', 1, '2020-04-01 09:31:00', NULL),
(16, 'adsvasdv', 'asdvasdv', 'asdvasdv', 1, '2020-04-01 09:31:04', NULL),
(17, 'adsvasdv', 'asdvasdv', 'asdvasdv', 1, '2020-04-01 09:31:08', NULL),
(18, 'asdvasdv', 'asdvasdv', 'advasdv', 2, '2020-04-01 09:31:12', NULL),
(19, 'asdvasdv', 'asdvasdv', 'asdvadsv', 2, '2020-04-01 09:31:16', NULL),
(20, 'asdvasdv', 'asdvasdv', 'asdvasdv', 2, '2020-04-01 09:31:21', NULL),
(21, 'asdvasd', 'vasdv', 'vasdv', 2, '2020-04-01 09:31:37', NULL),
(22, 'asdvasdv', 'asdva', 'asdvsv', 1, '2020-04-01 09:31:41', NULL),
(23, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Ton Nu', 'Maria', 'うｓｄｆｈｓづｆｈｓｄｊｈｆｓｋｊｈｆｓｄｋｆｈｓｄｌｋｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆうｓｄｆｈｓづｆｈｓｄｊｈｆｓｋｊｈｆｓｄｋｆｈｓｄｌｋｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆうｓｄｆｈｓづｆｈｓｄｊｈｆｓｋｊｈｆｓｄｋｆｈｓｄｌｋｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆｆうｓｄｆｈｓづｆｈｓｄｊｈｆｓｋｊｈｆｓｄｋｆｈｓｄｌｋｆｆｆｆｆｆｆｆｆｆ', 1, '2020-06-02 09:14:11', NULL),
(25, 'Truc', 'Nguyen', NULL, 1, '2020-06-02 09:19:31', '2020-06-02 14:13:58'),
(26, 'Tien', 'Nguyen', NULL, 1, '2020-06-02 09:27:08', NULL),
(27, 'Intercontinental', 'Nguyen Van', 'adsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdasadsadasdas', 2, '2020-06-02 11:43:53', '2020-06-02 11:44:29'),
(28, 'Intercontinental', 'Nguyen Van', NULL, 2, '2020-06-02 11:43:55', NULL),
(29, 'Intercontinental１', 'Nguyen Van', 'Intercontinental１', 2, '2020-06-02 13:32:44', NULL),
(30, 'Intercontinental2', 'Nguyen Van', 'Intercontinental2', 2, '2020-06-02 13:33:03', NULL),
(31, 'Quynh Anh', 'Ton Nu', 'Intercontinental3', 2, '2020-06-02 13:33:36', '2020-06-02 14:14:13'),
(32, 'Trinh', 'Ngoc', NULL, 2, '2020-06-02 13:39:27', NULL),
(33, 'Van Dong', 'Pham', NULL, 2, '2020-06-02 13:39:57', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_option`
--

CREATE TABLE `t_option` (
  `op_id` int(11) NOT NULL,
  `op_name` varchar(200) DEFAULT NULL,
  `op_amount` double DEFAULT NULL,
  `op_shop` int(11) DEFAULT NULL,
  `op_del_flg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_option`
--

INSERT INTO `t_option` (`op_id`, `op_name`, `op_amount`, `op_shop`, `op_del_flg`) VALUES
(32, '345', 345, 1, 0),
(33, 'dang thai ngoc thach', 1213, 1, 0),
(34, 'asdvasdvasdv', 123123, 1, 0),
(35, 'asdvasdvasdv', 123123123, 1, 0),
(36, 'dang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thach', 80000000, 1, 0),
(37, 'qwfqwf', 1231, 1, 0),
(38, 'asdf', 123123, 1, 0),
(39, 'asdv', 123, 1, 0),
(40, 'adsf', 1231, 1, 0),
(41, 'asdf', 123, 1, 0),
(42, 'asdv', 123, 1, 0),
(43, 'test2', 1000000, 1, 0),
(44, '123', 123, 1, 0),
(45, '123', 123, 1, 0),
(46, 'qqq', 123, 1, 0),
(47, 'カット', 1500, 1, 0),
(48, 'シャンプー', 800, 1, 0),
(49, 'パーマ', 5000, 1, 0),
(50, 'Nhuộm', 300000, 2, 0),
(51, 'Cắt', 150000, 2, 0),
(52, 'Uốn', 400000, 2, 0),
(53, 'Gội', 50000, 2, 0),
(54, 'Sấy', 50000, 2, 0),
(55, 'Duỗi', 300000, 2, 0),
(56, 'Nail', 100000, 2, 0),
(57, 'test', 100000, 1, 0),
(58, 'shave', 10000, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_sales`
--

CREATE TABLE `t_sales` (
  `s_id` int(11) NOT NULL,
  `s_c_id` int(11) DEFAULT NULL,
  `s_money` double DEFAULT NULL,
  `s_pay` int(11) DEFAULT NULL,
  `s_text` varchar(200) DEFAULT NULL,
  `s_sh_id` int(11) DEFAULT NULL,
  `s_del_flg` int(11) DEFAULT NULL,
  `s_saleoff_flg` int(1) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `s_date` datetime DEFAULT NULL,
  `s_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_sales`
--

INSERT INTO `t_sales` (`s_id`, `s_c_id`, `s_money`, `s_pay`, `s_text`, `s_sh_id`, `s_del_flg`, `s_saleoff_flg`, `sale_date`, `s_date`, `s_update`) VALUES
(132, 1, 2593, 0, NULL, 1, 0, 0, '2020-06-02 00:00:00', '2020-06-02 09:29:14', '2020-06-02 12:50:05'),
(133, 25, 6500, 1, NULL, 1, 0, 0, '2020-06-02 00:00:00', '2020-06-02 10:43:23', '2020-06-02 12:50:00'),
(134, 25, 5500, 0, NULL, 1, 0, 0, '2020-06-02 00:00:00', '2020-06-02 10:53:27', '2020-06-02 12:49:55'),
(135, 1, 1213, 0, NULL, 1, 0, 0, '2020-06-01 00:00:00', '2020-06-02 10:57:10', '2020-06-02 12:49:48'),
(136, 25, 6000, 0, NULL, 1, 0, 0, '2020-05-30 00:00:00', '2020-06-02 11:02:10', '2020-06-02 11:02:10'),
(137, 26, 1000, 0, NULL, 1, 0, 0, '2020-06-02 00:00:00', '2020-06-02 11:08:49', '2020-06-02 12:49:44'),
(138, 3, 110746, 1, 'duy12', 1, 0, 0, '2020-06-02 00:00:00', '2020-06-02 11:09:23', '2020-06-05 15:51:35'),
(139, 7, 1395000, 0, NULL, 2, 1, 1, '2020-06-02 00:00:00', '2020-06-02 13:52:46', '2020-06-02 14:06:04'),
(140, 7, 1395000, 0, NULL, 2, 1, 1, '2020-06-02 00:00:00', '2020-06-02 13:52:53', '2020-06-02 14:06:25'),
(141, 7, 1395000, 0, NULL, 2, 1, 1, '2020-06-02 00:00:00', '2020-06-02 13:52:57', '2020-06-02 14:06:10'),
(142, 7, 1395000, 0, NULL, 2, 1, 1, '2020-06-02 00:00:00', '2020-06-02 13:53:10', '2020-06-02 14:06:21'),
(143, 7, 1395000, 0, NULL, 2, 1, 1, '2020-06-02 00:00:00', '2020-06-02 13:53:43', '2020-06-02 14:06:17'),
(144, 7, 1395000, 0, NULL, 2, 0, 1, '2020-06-02 00:00:00', '2020-06-02 13:54:54', '2020-06-02 13:54:54'),
(145, 7, 1500010, 0, NULL, 2, 0, 0, '2020-06-02 00:00:00', '2020-06-02 13:55:53', '2020-06-02 13:55:53'),
(146, 7, 1950000, 0, NULL, 2, 0, 0, '2020-06-02 00:00:00', '2020-06-02 13:56:15', '2020-06-02 13:56:15'),
(147, 2, 90000, 0, NULL, 2, 0, 1, '2020-06-02 00:00:00', '2020-06-02 14:00:19', '2020-06-02 14:00:19'),
(148, 32, 1000000, 0, NULL, 2, 0, 0, '2020-06-02 00:00:00', '2020-06-02 14:04:30', '2020-06-02 14:04:30'),
(149, 33, 135000, 1, NULL, 2, 0, 1, '2020-04-30 00:00:00', '2020-06-02 14:09:40', '2020-06-02 14:11:34'),
(150, 33, 150000, 0, NULL, 2, 0, 0, '2020-06-02 00:00:00', '2020-06-02 14:10:15', '2020-06-02 14:10:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_salesdetails`
--

CREATE TABLE `t_salesdetails` (
  `s_id` int(11) NOT NULL,
  `s_co_id` int(11) NOT NULL,
  `s_co_num` int(11) NOT NULL,
  `s_opt1` int(11) DEFAULT NULL,
  `s_opts1` int(11) DEFAULT NULL,
  `s_opt2` int(11) DEFAULT NULL,
  `s_opts2` int(11) DEFAULT NULL,
  `s_opt3` int(11) DEFAULT NULL,
  `s_opts3` int(11) DEFAULT NULL,
  `s_opt4` int(11) DEFAULT NULL,
  `s_opts4` int(11) DEFAULT NULL,
  `s_opt5` int(11) DEFAULT NULL,
  `s_opts5` int(11) DEFAULT NULL,
  `s_money` double DEFAULT NULL,
  `s_date` datetime DEFAULT NULL,
  `s_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_salesdetails`
--

INSERT INTO `t_salesdetails` (`s_id`, `s_co_id`, `s_co_num`, `s_opt1`, `s_opts1`, `s_opt2`, `s_opts2`, `s_opt3`, `s_opts3`, `s_opt4`, `s_opts4`, `s_opt5`, `s_opts5`, `s_money`, `s_date`, `s_update`) VALUES
(132, 0, 1, 0, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2593, '2020-06-02 09:29:14', '2020-06-02 12:50:06'),
(133, 49, 1, 47, 44, 49, 31, NULL, NULL, NULL, NULL, NULL, NULL, 6500, '2020-06-02 10:43:23', '2020-06-02 12:50:01'),
(134, 0, 1, 0, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2500, '2020-06-02 10:53:27', '2020-06-02 12:49:56'),
(134, 9999, 2, 9999, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3000, '2020-06-02 10:53:27', '2020-06-02 12:49:57'),
(135, 47, 1, 33, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1213, '2020-06-02 10:57:10', '2020-06-02 12:49:49'),
(136, 9999, 1, 9999, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6000, '2020-06-02 11:02:10', '2020-06-02 11:02:10'),
(137, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1000, '2020-06-02 11:08:49', '2020-06-02 12:49:45'),
(138, 0, 5, 0, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80000, '2020-06-05 15:51:35', '2020-06-05 15:51:35'),
(138, 49, 3, 47, 43, 49, 41, NULL, NULL, NULL, NULL, NULL, NULL, 6500, '2020-06-05 15:51:35', '2020-06-05 15:51:35'),
(138, 50, 2, 58, 31, 39, 41, 47, 41, NULL, NULL, NULL, NULL, 11623, '2020-06-05 15:51:35', '2020-06-05 15:51:35'),
(138, 50, 4, 58, 41, 39, 35, 47, 44, NULL, NULL, NULL, NULL, 11623, '2020-06-05 15:51:35', '2020-06-05 15:51:35'),
(138, 9999, 1, 9999, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1000, '2020-06-05 15:51:35', '2020-06-05 15:51:35'),
(139, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:52:47', '2020-06-02 13:52:48'),
(139, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:52:46', '2020-06-02 13:52:47'),
(139, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:52:49', '2020-06-02 13:52:50'),
(139, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:52:48', '2020-06-02 13:52:49'),
(140, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:52:54', '2020-06-02 13:52:55'),
(140, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:52:53', '2020-06-02 13:52:54'),
(140, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:52:56', '2020-06-02 13:52:57'),
(140, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:52:55', '2020-06-02 13:52:56'),
(141, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:52:58', '2020-06-02 13:52:59'),
(141, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:52:57', '2020-06-02 13:52:58'),
(141, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:53:00', '2020-06-02 13:53:01'),
(141, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:52:59', '2020-06-02 13:53:00'),
(142, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:53:11', '2020-06-02 13:53:12'),
(142, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:53:10', '2020-06-02 13:53:11'),
(142, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:53:13', '2020-06-02 13:53:14'),
(142, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:53:12', '2020-06-02 13:53:13'),
(143, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:53:44', '2020-06-02 13:53:45'),
(143, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:53:43', '2020-06-02 13:53:44'),
(143, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:53:46', '2020-06-02 13:53:47'),
(143, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:53:45', '2020-06-02 13:53:46'),
(144, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:54:55', '2020-06-02 13:54:56'),
(144, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:54:54', '2020-06-02 13:54:55'),
(144, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:54:57', '2020-06-02 13:54:58'),
(144, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:54:56', '2020-06-02 13:54:57'),
(145, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:55:54', '2020-06-02 13:55:55'),
(145, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:55:53', '2020-06-02 13:55:54'),
(145, 54, 3, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:55:56', '2020-06-02 13:55:57'),
(145, 9999, 4, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:55:55', '2020-06-02 13:55:56'),
(146, 0, 1, 0, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 13:56:16', '2020-06-02 13:56:17'),
(146, 51, 2, 53, 42, 54, 43, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 13:56:15', '2020-06-02 13:56:16'),
(146, 52, 3, 51, 33, 50, 32, NULL, NULL, NULL, NULL, NULL, NULL, 450000, '2020-06-02 13:56:19', '2020-06-02 13:56:20'),
(146, 54, 4, 52, 30, 50, 31, NULL, NULL, NULL, NULL, NULL, NULL, 700000, '2020-06-02 13:56:18', '2020-06-02 13:56:19'),
(146, 9999, 5, 9999, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '2020-06-02 13:56:17', '2020-06-02 13:56:18'),
(147, 51, 1, 53, 41, 54, 40, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 14:00:19', '2020-06-02 14:00:20'),
(148, 51, 1, 53, 31, 54, 31, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 14:04:33', '2020-06-02 14:04:34'),
(148, 55, 2, 56, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100000, '2020-06-02 14:04:30', '2020-06-02 14:04:31'),
(148, 56, 3, 55, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 300000, '2020-06-02 14:04:31', '2020-06-02 14:04:32'),
(148, 57, 4, 50, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 300000, '2020-06-02 14:04:32', '2020-06-02 14:04:33'),
(148, 9999, 5, 9999, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000, '2020-06-02 14:04:34', '2020-06-02 14:04:35'),
(149, 59, 1, 51, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 150000, '2020-06-02 14:09:40', '2020-06-02 14:11:35'),
(150, 59, 1, 51, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 150000, '2020-06-02 14:10:15', '2020-06-02 14:10:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_shop`
--

CREATE TABLE `t_shop` (
  `sh_id` int(11) NOT NULL,
  `sh_name` varchar(200) DEFAULT NULL,
  `sh_date` datetime DEFAULT NULL,
  `sh_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_shop`
--

INSERT INTO `t_shop` (`sh_id`, `sh_name`, `sh_date`, `sh_update`) VALUES
(1, 'THAI VAN LUNG', '2020-03-20 10:22:40', '2020-03-20 10:22:41'),
(2, 'InterContinental', '2020-03-20 10:22:51', '2020-03-20 10:22:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_staff`
--

CREATE TABLE `t_staff` (
  `s_id` int(11) NOT NULL,
  `s_firstname` varchar(200) DEFAULT NULL,
  `s_lastname` varchar(200) DEFAULT NULL,
  `s_shop` int(11) DEFAULT NULL,
  `s_charge` varchar(200) DEFAULT NULL,
  `s_text` varchar(200) DEFAULT NULL,
  `s_del_flg` int(11) DEFAULT NULL,
  `s_date` datetime DEFAULT NULL,
  `s_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_staff`
--

INSERT INTO `t_staff` (`s_id`, `s_firstname`, `s_lastname`, `s_shop`, `s_charge`, `s_text`, `s_del_flg`, `s_date`, `s_update`) VALUES
(30, 'asd', 'asd', 1, 'asd', NULL, 0, '2020-03-27 09:50:13', '2020-03-27 09:50:13'),
(31, 'continental', 'inter', 2, 'asd', 'asd', 0, '2020-03-27 09:50:26', '2020-06-02 09:19:20'),
(32, 'asd', 'asd', 1, 'asd', NULL, 0, '2020-03-27 09:50:32', '2020-03-27 09:50:32'),
(33, 'asd', 'asd', 1, 'asd', NULL, 0, '2020-03-27 09:50:37', '2020-03-27 09:50:37'),
(34, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:42', '2020-03-27 09:50:42'),
(35, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:46', '2020-03-27 09:50:46'),
(36, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:51', '2020-03-27 09:50:51'),
(37, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:55', '2020-03-27 09:50:55'),
(38, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:51:00', '2020-03-27 09:51:00'),
(39, 'asc', 'asc', 1, 'asc', 'asc', 0, '2020-03-27 09:51:05', '2020-03-27 09:51:05'),
(40, 'asc', 'asc', 1, 'asc', 'asc', 0, '2020-03-27 09:51:12', '2020-03-27 09:51:12'),
(41, 'van A', 'nguyen', 1, 'dang thai ngoc thach', NULL, 0, '2020-03-27 11:49:46', '2020-06-02 09:18:45'),
(42, 'Shimaya', 'Taka', 1, 'カット', NULL, 0, '2020-06-02 09:29:12', '2020-06-02 09:29:12'),
(43, 'Van Lung', 'Thai', 1, 'パーマ', NULL, 0, '2020-06-02 09:30:13', '2020-06-02 09:30:13'),
(44, 'Phan', 'Duy', 1, 'Cut', NULL, 0, '2020-06-02 09:31:00', '2020-06-05 10:34:39'),
(45, 'Nguyen', 'Duy', 1, 'ahah', NULL, 0, '2020-06-12 11:29:35', '2020-06-12 11:29:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_user`
--

CREATE TABLE `t_user` (
  `u_id` int(11) NOT NULL,
  `u_user` varchar(200) DEFAULT NULL,
  `u_pw` varchar(200) DEFAULT NULL,
  `u_name` varchar(200) DEFAULT NULL,
  `u_address` varchar(200) DEFAULT NULL,
  `u_shop` int(11) DEFAULT NULL,
  `u_date` datetime DEFAULT NULL,
  `u_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_user`
--

INSERT INTO `t_user` (`u_id`, `u_user`, `u_pw`, `u_name`, `u_address`, `u_shop`, `u_date`, `u_update`) VALUES
(1, 'admin', 'admin', 'タイバンルン店', 'HCM', 1, '2020-03-20 10:17:23', '2020-03-20 10:17:25'),
(2, 'admin2', 'admin2', 'Intercontinental支店', 'HCM', 2, '2020-03-20 10:18:13', '2020-03-20 10:18:15');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `t_course`
--
ALTER TABLE `t_course`
  ADD PRIMARY KEY (`co_id`);

--
-- Chỉ mục cho bảng `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Chỉ mục cho bảng `t_option`
--
ALTER TABLE `t_option`
  ADD PRIMARY KEY (`op_id`);

--
-- Chỉ mục cho bảng `t_sales`
--
ALTER TABLE `t_sales`
  ADD PRIMARY KEY (`s_id`);

--
-- Chỉ mục cho bảng `t_salesdetails`
--
ALTER TABLE `t_salesdetails`
  ADD PRIMARY KEY (`s_id`,`s_co_id`,`s_co_num`);

--
-- Chỉ mục cho bảng `t_shop`
--
ALTER TABLE `t_shop`
  ADD PRIMARY KEY (`sh_id`);

--
-- Chỉ mục cho bảng `t_staff`
--
ALTER TABLE `t_staff`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `s_shop` (`s_shop`);

--
-- Chỉ mục cho bảng `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `t_course`
--
ALTER TABLE `t_course`
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `t_option`
--
ALTER TABLE `t_option`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT cho bảng `t_shop`
--
ALTER TABLE `t_shop`
  MODIFY `sh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `t_staff`
--
ALTER TABLE `t_staff`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `t_user`
--
ALTER TABLE `t_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
