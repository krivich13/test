-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 02 2021 г., 22:14
-- Версия сервера: 5.7.29-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_asset` int(11) NOT NULL,
  `id_asset` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `assets`
--

INSERT INTO `assets` (`id`, `name`, `type_asset`, `id_asset`) VALUES
(1, 'Деньги в ЕвроВорБанке', 1, 1),
(2, 'Деньги во Внешторгбанке', 1, 2),
(3, 'Деньги в кассе', 1, 3),
(4, 'Талоны на бензин от Аспека', 1, 4),
(5, 'Торговое здание, Бассейная 6', 2, 1),
(6, 'Гвозди', 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `coeff` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`, `coeff`) VALUES
(1, 'Рублей', 1),
(2, 'Долларов', 74.76);

-- --------------------------------------------------------

--
-- Структура таблицы `fields`
--

CREATE TABLE `fields` (
  `id` int(11) NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_asset_id` int(11) NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_of_values` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `fields`
--

INSERT INTO `fields` (`id`, `code`, `name`, `type_asset_id`, `type`, `table_of_values`) VALUES
(1, 'par', 'Номинал', 1, 'input', NULL),
(2, 'currency_id', 'Валюта', 1, 'select', 'currency'),
(3, 'bank_name', 'Банк', 1, 'input', NULL),
(4, 'acc_number', 'Номер счёта', 1, 'input', NULL),
(6, 'initial_cost', 'Начальная стоимость', 2, 'input', NULL),
(7, 'residual_cost', 'Остаточная стоимость', 2, 'input', NULL),
(8, 'assessed_cost', 'Оценочная стоимость', 2, 'input', NULL),
(9, 'quantity', 'Количество', 2, 'input', NULL),
(10, 'units_id', 'Единицы измерения', 2, 'select', 'units'),
(11, 'inv_number', 'Инв. номер', 2, 'input', NULL),
(12, 'date_of_man', 'Дата производства', 2, 'input', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `money`
--

CREATE TABLE `money` (
  `id` int(11) NOT NULL,
  `par` float NOT NULL,
  `currency_id` int(11) NOT NULL,
  `bank_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_number` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `money`
--

INSERT INTO `money` (`id`, `par`, `currency_id`, `bank_name`, `acc_number`) VALUES
(1, 1000, 1, 'ЕвроВорБанк', '5'),
(2, 5, 2, 'Внешторгбанк', '3'),
(3, 100, 1, 'Касса', ''),
(4, 3000, 1, 'Касса', '');

-- --------------------------------------------------------

--
-- Структура таблицы `not_money`
--

CREATE TABLE `not_money` (
  `id` int(11) NOT NULL,
  `initial_cost` float NOT NULL,
  `residual_cost` float NOT NULL,
  `assessed_cost` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `units_id` int(11) NOT NULL,
  `inv_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_man` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `not_money`
--

INSERT INTO `not_money` (`id`, `initial_cost`, `residual_cost`, `assessed_cost`, `quantity`, `units_id`, `inv_number`, `date_of_man`) VALUES
(1, 30000, 5000, 1000000, 1, 1, '7', '1970 г'),
(2, 1000, 100, 2000, 100, 2, '', '2000 г');

-- --------------------------------------------------------

--
-- Структура таблицы `types_asset`
--

CREATE TABLE `types_asset` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `types_asset`
--

INSERT INTO `types_asset` (`id`, `name`, `table_name`) VALUES
(1, 'Деньги', 'money'),
(2, 'Неденежные активы', 'not_money');

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `units`
--

INSERT INTO `units` (`id`, `name`) VALUES
(1, 'шт'),
(2, 'кг');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `money`
--
ALTER TABLE `money`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `not_money`
--
ALTER TABLE `not_money`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `types_asset`
--
ALTER TABLE `types_asset`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `money`
--
ALTER TABLE `money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `not_money`
--
ALTER TABLE `not_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `types_asset`
--
ALTER TABLE `types_asset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
