-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 05, 2020 lúc 01:38 PM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hairsalon20200327`
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
(46, 1, 'wqfqw', 33, 32, 32, 32, 32, 'asascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasascasasc', 0, '2020-03-27 14:49:45', '2020-03-27 15:39:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_customer`
--

CREATE TABLE `t_customer` (
  `c_id` int(11) NOT NULL,
  `c_firstname` varchar(200) DEFAULT NULL,
  `c_lastname` varchar(200) DEFAULT NULL,
  `c_text` varchar(200) DEFAULT NULL,
  `c_date` datetime DEFAULT NULL,
  `c_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_customer`
--

INSERT INTO `t_customer` (`c_id`, `c_firstname`, `c_lastname`, `c_text`, `c_date`, `c_update`) VALUES
(1, 'THACHa', 'DANG', '90 kg', '2020-03-20 10:26:56', '2020-03-25 20:38:52'),
(2, 'HUY', 'PHAM', 'nang 59kg', '2020-03-20 10:27:30', '2020-03-25 10:42:22'),
(3, 'DUY', 'NGUYEN', 'nang 50kg', '2020-03-20 10:27:53', '2020-03-26 10:23:32'),
(4, 'Nguyen', 'Duy Nhat', 'võ sĩ', NULL, '2020-03-20 17:47:17'),
(5, '大沢', 'Maria', NULL, '2020-03-25 13:32:20', '2020-03-25 13:38:39'),
(6, 'Huy', 'Nguyen', 'test  abc', '2020-03-25 13:32:46', '2020-03-25 17:00:40'),
(7, 'Quynh Anh', 'Ton Nu', NULL, '2020-03-25 13:41:36', NULL),
(8, 'Anh', 'Nguyen', NULL, '2020-03-25 13:42:09', NULL),
(9, 'Huynhs', 'Tran Thanh', NULL, '2020-03-25 15:37:08', '2020-03-25 20:35:46'),
(10, 'Hong Phuoc', 'Pham', NULL, '2020-03-25 16:33:17', NULL),
(11, 'cutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutasvasva', 'cutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcutcut', NULL, '2020-03-25 20:34:50', NULL),
(12, 'vasdv', 'asdvasd', NULL, '2020-03-25 20:36:00', NULL);

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
(42, 'asdv', 123, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_sales`
--

CREATE TABLE `t_sales` (
  `s_id` int(11) NOT NULL,
  `s_c_id` int(11) DEFAULT NULL,
  `s_co_id` int(11) DEFAULT NULL,
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
  `s_pay` int(11) DEFAULT NULL,
  `s_text` varchar(200) DEFAULT NULL,
  `s_sh_id` int(11) DEFAULT NULL,
  `s_del_flg` int(11) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `s_date` datetime DEFAULT NULL,
  `s_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `t_sales`
--

INSERT INTO `t_sales` (`s_id`, `s_c_id`, `s_co_id`, `s_opt1`, `s_opts1`, `s_opt2`, `s_opts2`, `s_opt3`, `s_opts3`, `s_opt4`, `s_opts4`, `s_opt5`, `s_opts5`, `s_money`, `s_pay`, `s_text`, `s_sh_id`, `s_del_flg`, `sale_date`, `s_date`, `s_update`) VALUES
(103, 4, 17, NULL, NULL, 8, 1, NULL, NULL, NULL, NULL, NULL, NULL, 70000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:08', '2020-04-04 08:09:31'),
(104, 1, 22, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 238000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:21', '2020-04-04 08:09:30'),
(105, 6, 11, 14, 6, 3, 21, 8, 23, NULL, NULL, NULL, NULL, 430000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:30', '2020-04-04 08:09:30'),
(106, 5, 24, 14, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 260000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:36', '2020-04-04 08:09:29'),
(107, 9, 30, 1, 24, 3, 23, 8, 24, NULL, NULL, NULL, NULL, 670000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:44', '2020-04-04 08:09:28'),
(108, 5, 27, NULL, NULL, 1, 24, NULL, NULL, NULL, NULL, NULL, NULL, 500000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:49', '2020-04-04 08:09:28'),
(109, 6, 29, 14, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 260000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:03:55', '2020-04-04 08:09:27'),
(110, 2, 17, NULL, NULL, 8, 23, NULL, NULL, NULL, NULL, NULL, NULL, 70000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:04:01', '2020-04-04 08:09:26'),
(111, 1, 26, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 238000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:04:07', '2020-04-04 08:09:25'),
(112, 8, 29, 14, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 260000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:04:13', '2020-04-04 08:09:25'),
(113, 4, 27, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 500000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:04:23', '2020-04-04 08:09:24'),
(114, 2, 24, 14, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 260000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:04:29', '2020-04-04 08:09:23'),
(115, 1, 40, 32, 33, 32, 40, 32, 41, 32, 41, 32, 37, 1725, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:09:59', '2020-04-04 08:09:22'),
(116, 5, 23, 3, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100000, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:10:05', '2020-03-27 09:11:15'),
(117, 6, 36, 32, 39, 32, 37, 32, 34, NULL, NULL, NULL, NULL, 1035, 0, NULL, 1, 0, '2020-03-27 00:00:00', '2020-03-27 09:10:10', '2020-03-27 10:12:57'),
(118, 1, 37, 34, 30, 32, 32, 36, 34, NULL, NULL, NULL, NULL, 80123468, 0, 'dang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thachdang thai ngoc thach', 1, 0, '2020-03-27 00:00:00', '2020-03-27 11:49:26', '2020-04-04 08:09:22'),
(119, 3, 41, 33, 31, 32, 35, 32, 33, 32, 41, 32, 41, 2593, 0, NULL, 1, 0, '2020-03-30 00:00:00', '2020-03-30 16:34:48', '2020-04-04 08:09:21'),
(120, 2, 39, 35, 41, 32, 30, 32, 41, 32, 31, 32, 41, 123124503, 0, NULL, 1, 0, '2020-03-30 00:00:00', '2020-03-30 16:38:34', '2020-04-04 08:09:20'),
(121, 1, 38, 35, 32, 32, 35, 32, 34, 32, 33, 32, 41, 123124503, 0, NULL, 1, 0, '2020-03-30 00:00:00', '2020-03-30 16:40:43', '2020-04-04 08:09:19'),
(122, 2, 37, 34, 30, 32, 31, 36, 39, 32, 39, 32, 37, 80124158, 0, NULL, 1, 0, '2020-03-31 00:00:00', '2020-03-31 07:36:33', '2020-04-04 08:09:18'),
(123, 5, 37, 34, 30, 32, 30, 36, 30, 32, 30, 32, 30, 80124158, 0, 'thachyey', 1, 0, '2020-08-26 00:00:00', '2020-03-31 07:37:08', '2020-04-04 08:09:16'),
(124, 1, 37, 34, 31, 32, 41, 36, 39, 32, 36, 32, 38, 80124158, 0, NULL, 1, 0, '2020-04-03 00:00:00', '2020-04-03 14:34:28', '2020-04-04 08:09:14'),
(125, 1, 36, 33, 31, 32, 33, 32, 32, 32, 35, 32, 34, 2593, 0, NULL, 1, 0, '2020-04-05 00:00:00', '2020-04-05 17:51:05', '2020-04-05 17:51:05');

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
(31, 'asd', 'as', 2, 'asd', 'asd', 0, '2020-03-27 09:50:26', '2020-03-27 09:50:26'),
(32, 'asd', 'asd', 1, 'asd', NULL, 0, '2020-03-27 09:50:32', '2020-03-27 09:50:32'),
(33, 'asd', 'asd', 1, 'asd', NULL, 0, '2020-03-27 09:50:37', '2020-03-27 09:50:37'),
(34, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:42', '2020-03-27 09:50:42'),
(35, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:46', '2020-03-27 09:50:46'),
(36, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:51', '2020-03-27 09:50:51'),
(37, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:50:55', '2020-03-27 09:50:55'),
(38, 'asd', 'asd', 1, 'asd', 'asd', 0, '2020-03-27 09:51:00', '2020-03-27 09:51:00'),
(39, 'asc', 'asc', 1, 'asc', 'asc', 0, '2020-03-27 09:51:05', '2020-03-27 09:51:05'),
(40, 'asc', 'asc', 1, 'asc', 'asc', 0, '2020-03-27 09:51:12', '2020-03-27 09:51:12'),
(41, 'dang thai ngoc thach', 'dang thai ngoc thach', 1, 'dang thai ngoc thach', NULL, 0, '2020-03-27 11:49:46', '2020-03-27 11:49:46');

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
(2, 'admin2', '1234567', 'Intercontinental支店', 'HCM', 2, '2020-03-20 10:18:13', '2020-03-20 10:18:15');

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
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `t_option`
--
ALTER TABLE `t_option`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT cho bảng `t_shop`
--
ALTER TABLE `t_shop`
  MODIFY `sh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `t_staff`
--
ALTER TABLE `t_staff`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `t_user`
--
ALTER TABLE `t_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
