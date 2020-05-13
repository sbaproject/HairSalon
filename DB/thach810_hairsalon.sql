-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th5 11, 2020 lúc 02:56 PM
-- Phiên bản máy phục vụ: 5.7.29-cll-lve
-- Phiên bản PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thach810_hairsalon`
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
  `s_saleoff_flg` int(1) DEFAULT NULL,
  `s_del_flg` int(11) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `s_date` datetime DEFAULT NULL,
  `s_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_option`
--
ALTER TABLE `t_option`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_shop`
--
ALTER TABLE `t_shop`
  MODIFY `sh_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_staff`
--
ALTER TABLE `t_staff`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_user`
--
ALTER TABLE `t_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
