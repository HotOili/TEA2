-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 11 2026 г., 11:47
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Tea`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Чёрный чай'),
(2, 'Зелёный чай'),
(3, 'Травяной чай'),
(4, 'Белый чай');

-- --------------------------------------------------------

--
-- Структура таблицы `corzina`
--

CREATE TABLE `corzina` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_tovar` int NOT NULL,
  `colvo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `grypirovca`
--

CREATE TABLE `grypirovca` (
  `id` int NOT NULL,
  `id_order` int NOT NULL,
  `id_user` int NOT NULL,
  `id_tovar` int NOT NULL,
  `colvo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ord`
--

CREATE TABLE `ord` (
  `id` int NOT NULL,
  `id_order` int NOT NULL,
  `status` varchar(50) NOT NULL,
  `id_tovar` int NOT NULL,
  `colvo` int NOT NULL,
  `reson` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `prava`
--

CREATE TABLE `prava` (
  `id` int NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `prava`
--

INSERT INTO `prava` (`id`, `role`) VALUES
(1, 'user'),
(2, 'manager'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `tovar`
--

CREATE TABLE `tovar` (
  `id` int NOT NULL,
  `img` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` int NOT NULL,
  `discription` text NOT NULL,
  `category` int NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `nalichie` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tovar`
--

INSERT INTO `tovar` (`id`, `img`, `name`, `price`, `discription`, `category`, `is_published`, `nalichie`, `created_at`) VALUES
(1, '\\public\\img\\assam.webp', 'Чай Ассам 100 г', 690, 'Крупнолистовой индийский чёрный чай из региона Ассам. Насыщенный солодовый вкус, плотный тёмно-янтарный настой. Отлично подходит для утреннего чаепития, хорошо сочетается с молоком.', 1, 1, 50, '2026-11-11 08:05:16'),
(2, '\\public\\img\\earlGrey.webp', 'Чай Эрл Грей 100 г', 640, 'Классический чёрный чай с ароматом бергамота. Мягкий цитрусовый вкус и узнаваемый свежий аромат. Заваривать 3–5 минут при температуре 95 °C.', 1, 1, 50, '2026-11-11 08:05:16'),
(3, '\\public\\img\\sencha.webp', 'Чай Сенча 100 г', 550, 'Японский зелёный чай с травянистым вкусом и лёгкой терпкостью. Богат антиоксидантами. Заваривать водой 70–80 °C, настаивать 1–2 минуты.', 2, 1, 50, '2026-11-11 08:05:16'),
(4, '\\public\\img\\jasmine.webp', 'Зелёный чай с жасмином 100 г', 590, 'Зелёный чай, ароматизированный лепестками жасмина. Нежный цветочный аромат и мягкий сладковатый вкус. Подходит для ежедневного чаепития.', 2, 1, 50, '2026-11-11 08:05:16'),
(5, '\\public\\img\\chamomile.webp', 'Ромашковый чай 50 г', 320, 'Цветки ромашки аптечной. Успокаивающий травяной напиток с мягким медовым ароматом. Рекомендуется пить вечером, заваривать 5–7 минут.', 3, 1, 50, '2026-11-11 08:05:16'),
(6, '\\public\\img\\mint.webp', 'Мятный чай 50 г', 300, 'Сушёные листья мяты перечной. Освежающий напиток с холодящим вкусом, помогает при усталости. Можно смешивать с чёрным или зелёным чаем.', 3, 1, 50, '2026-11-11 08:05:16'),
(7, '\\public\\img\\silverNeedle.webp', 'Белый чай Серебряные иглы 50 г', 1290, 'Элитный белый чай из нераскрывшихся почек чайного куста. Светлый, почти прозрачный настой с тонким цветочным вкусом. Заваривать водой 80–85 °C.', 4, 1, 50, '2026-11-11 08:05:16');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `patronymic` varchar(50) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `prava` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `corzina`
--
ALTER TABLE `corzina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`,`id_tovar`),
  ADD KEY `id_tovar` (`id_tovar`);

--
-- Индексы таблицы `grypirovca`
--
ALTER TABLE `grypirovca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`,`id_user`,`id_tovar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_tovar` (`id_tovar`);

--
-- Индексы таблицы `ord`
--
ALTER TABLE `ord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_order`,`id_tovar`),
  ADD KEY `id_tovar` (`id_tovar`);

--
-- Индексы таблицы `prava`
--
ALTER TABLE `prava`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tovar`
--
ALTER TABLE `tovar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prava` (`prava`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `corzina`
--
ALTER TABLE `corzina`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `grypirovca`
--
ALTER TABLE `grypirovca`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ord`
--
ALTER TABLE `ord`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `prava`
--
ALTER TABLE `prava`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tovar`
--
ALTER TABLE `tovar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `corzina`
--
ALTER TABLE `corzina`
  ADD CONSTRAINT `corzina_ibfk_1` FOREIGN KEY (`id_tovar`) REFERENCES `tovar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `corzina_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `grypirovca`
--
ALTER TABLE `grypirovca`
  ADD CONSTRAINT `grypirovca_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grypirovca_ibfk_2` FOREIGN KEY (`id_tovar`) REFERENCES `tovar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ord`
--
ALTER TABLE `ord`
  ADD CONSTRAINT `ord_ibfk_2` FOREIGN KEY (`id_tovar`) REFERENCES `tovar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ord_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `grypirovca` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tovar`
--
ALTER TABLE `tovar`
  ADD CONSTRAINT `tovar_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`prava`) REFERENCES `prava` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
