-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 13 2021 г., 14:47
-- Версия сервера: 5.7.25
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_task_02`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasklist`
--

CREATE TABLE `tasklist` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `description` text,
  `status` tinyint(3) NOT NULL,
  `redact` tinyint(1) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasklist`
--

INSERT INTO `tasklist` (`id`, `user_name`, `email`, `description`, `status`, `redact`, `created_at`, `updated_at`) VALUES
(1, 'test 1', 'test@mail.test', 'test job', 0, NULL, '2021-03-13', '2021-03-13'),
(2, 'test 2', 'test2@mail.test', 'test job', 1, NULL, '2021-03-13', '2021-03-13'),
(3, 'test 3', 'test3@mail.test', 'test', 0, NULL, '2021-03-13', '2021-03-13'),
(4, 'test 3', 'test3@mail.test', 'test test redact admin', 1, 1, '2021-03-13', '2021-03-13'),
(5, 'test 3', 'test3@mail.test', 'test test 2', 0, NULL, '2021-03-13', '2021-03-13'),
(6, 'test 3', 'test3@mail.test', 'test test redact admin 2', 0, NULL, '2021-03-13', '2021-03-13'),
(7, 'test 3', 'test3@mail.test', 'test test redact admin 3', 1, 1, '2021-03-13', '2021-03-13'),
(8, 'test 3', 'test3@mail.test', 'test test redact admin 4', 0, NULL, '2021-03-13', '2021-03-13'),
(9, 'test 3', 'test3@mail.test', 'test test redact admin 5', 1, 1, '2021-03-13', '2021-03-13');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasklist`
--
ALTER TABLE `tasklist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasklist`
--
ALTER TABLE `tasklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
