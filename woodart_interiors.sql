-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 12 2026 г., 18:38
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `woodart_interiors`
--

-- --------------------------------------------------------

--
-- Структура таблицы `craftmen`
--

CREATE TABLE `craftmen` (
  `craftman_ID` int(32) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `is_busy` tinyint(1) DEFAULT NULL,
  `login` varchar(200) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `phone_num` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Дамп данных таблицы `craftmen`
--

INSERT INTO `craftmen` (`craftman_ID`, `full_name`, `is_busy`, `login`, `pass`, `phone_num`) VALUES
(2, 'Tralalelotralala', NULL, 'genius123', '9dab6c3793634347026919a53acde631', '+77538283433');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `customer_ID` int(32) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `phone_num` varchar(200) DEFAULT NULL,
  `login` varchar(200) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`customer_ID`, `full_name`, `phone_num`, `login`, `pass`) VALUES
(3, 'Alimzhan', '+77056657246', 'alimzhan', '76e254664944768554c90c07a5fbba03');

-- --------------------------------------------------------

--
-- Структура таблицы `furnitures`
--

CREATE TABLE `furnitures` (
  `furniture_ID` int(32) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `price` int(32) DEFAULT NULL,
  `length` double DEFAULT NULL,
  `width` double DEFAULT NULL,
  `height` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Дамп данных таблицы `furnitures`
--

INSERT INTO `furnitures` (`furniture_ID`, `name`, `price`, `length`, `width`, `height`) VALUES
(1, 'Shelf', 12000, 120, 30, 30),
(3, '123', 1232, 2, 2, 2),
(4, '123', 1, 22, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE `managers` (
  `manager_ID` int(32) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `login` varchar(200) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `phone_num` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Дамп данных таблицы `managers`
--

INSERT INTO `managers` (`manager_ID`, `full_name`, `login`, `pass`, `phone_num`) VALUES
(3, 'Bro', 'admin', '21232f297a57a5a743894a0e4a801fc3', '+77473831223'),
(4, 'ali', 'brbrpatapim', 'd138768d3b5eca407f0dd579c5ca3767', '+77538283434');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `material_ID` int(32) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `price` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`material_ID`, `name`, `price`) VALUES
(1, 'Birch', 1200),
(8, '123', 123);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_ID` int(32) NOT NULL,
  `customer_ID` int(32) DEFAULT NULL,
  `furniture_ID` int(32) DEFAULT NULL,
  `material_ID` int(32) DEFAULT NULL,
  `craftman_ID` int(32) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `request_id` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `request_ID` int(32) NOT NULL,
  `customer_ID` int(32) DEFAULT NULL,
  `furniture_ID` int(32) DEFAULT NULL,
  `material_ID` int(32) DEFAULT NULL,
  `address` text NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `solvings`
--

CREATE TABLE `solvings` (
  `order_ID` int(32) NOT NULL,
  `order_date` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  `solving_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `craftmen`
--
ALTER TABLE `craftmen`
  ADD PRIMARY KEY (`craftman_ID`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Индексы таблицы `furnitures`
--
ALTER TABLE `furnitures`
  ADD PRIMARY KEY (`furniture_ID`);

--
-- Индексы таблицы `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`manager_ID`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_ID`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_ID`),
  ADD KEY `customer_ID` (`customer_ID`),
  ADD KEY `furniture_ID` (`furniture_ID`),
  ADD KEY `material_ID` (`material_ID`),
  ADD KEY `craftman_ID` (`craftman_ID`),
  ADD KEY `request_id` (`request_id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_ID`),
  ADD KEY `customer_ID` (`customer_ID`),
  ADD KEY `furniture_ID` (`furniture_ID`),
  ADD KEY `material_ID` (`material_ID`);

--
-- Индексы таблицы `solvings`
--
ALTER TABLE `solvings`
  ADD PRIMARY KEY (`order_ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `craftmen`
--
ALTER TABLE `craftmen`
  MODIFY `craftman_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `furnitures`
--
ALTER TABLE `furnitures`
  MODIFY `furniture_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `managers`
--
ALTER TABLE `managers`
  MODIFY `manager_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `material_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `request_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `solvings`
--
ALTER TABLE `solvings`
  MODIFY `order_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_ID`) REFERENCES `customers` (`customer_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`furniture_ID`) REFERENCES `furnitures` (`furniture_ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`material_ID`) REFERENCES `materials` (`material_ID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`craftman_ID`) REFERENCES `craftmen` (`craftman_ID`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_ID`);

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`customer_ID`) REFERENCES `customers` (`customer_ID`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`furniture_ID`) REFERENCES `furnitures` (`furniture_ID`),
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`material_ID`) REFERENCES `materials` (`material_ID`);

--
-- Ограничения внешнего ключа таблицы `solvings`
--
ALTER TABLE `solvings`
  ADD CONSTRAINT `solvings_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `orders` (`order_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
