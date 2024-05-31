-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 31 Μάη 2024 στις 19:18:58
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `task_manager`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `list_id`, `user_id`, `status`, `created_at`) VALUES
(7, 'δσ', 2, 1, 'Pending', '2024-05-30 21:32:52'),
(15, 'test2', 8, 7, 'Pending', '2024-05-31 16:54:52'),
(21, 'hh', 13, 10, 'In Progress', '2024-05-31 17:07:55');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `task_lists`
--

CREATE TABLE `task_lists` (
  `id` int(11) NOT NULL,
  `list_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `task_lists`
--

INSERT INTO `task_lists` (`id`, `list_name`, `user_id`) VALUES
(2, 'Kostas', 1),
(5, 't', 1),
(8, 'test', 7),
(10, 'test1', 8),
(11, 't', 9),
(13, 'test', 10);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `simplepush_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `simplepush_key`) VALUES
(1, 'kostas', 'Zografos', 'kostas', '$2y$10$dzF3WT9HKjkdpPNX9WnRa.QDeoykCsazR3R2kTU9dHmLkIvl7Hwty', 'kostas1@gmail.com', 'mPtBMa'),
(2, 'dim', 'dim', 'dim', '$2y$10$p2Ho5KSLsb0ltvpK3wvoIOCT0PagY7sUkOdqmFBg.676AtKWMOO6m', 'dim@gmail.com', '123'),
(4, 'dsf', 'wer', 'lol', '$2y$10$8wC9lUc8y/7LX1ZXSTf0legcuJMhcx6lrmPl/mhZC4FJWy4gK8WSS', '112@gmail.com', 'qwe'),
(5, 'df', 'we', 'ee', '$2y$10$qbw4g9noI9JdZkQh6Vm0KOaYvehavfuQuLK7/lWs68CVBG39KC5.y', '13@ga.com', '234'),
(6, 'f', 'f', 'f', '$2y$10$m/GwGDd6qjEZlw2drJPhz.gxPtGL/fmA/3nBh.7qKaIxKX27Cd51G', '123!@gma.com', '123'),
(7, 'test', 'test', 'test', '$2y$10$B5SNmVtVD5NV1KT8czyIR.dt/ZJu5ojtOj/.XeelAnhba8S/3fxnC', 'test@gmail.com', 'test'),
(8, 'test2', 'test2', 'test2', '$2y$10$2bqObV4aUy.9DmE1dcrUWOITVeQo/w3UHF5pF9OwIyv3wOZeEQlR2', 'test1@gmail.com', 'test2'),
(9, 't', 't', 't', '$2y$10$2b3W.RUAfC8Cz2JCXOKpmemZlFmkhPHqqAYGBHx.xcQ8mEaMgJd36', '1@gmail.com', 't'),
(10, 'th', 'g', 'h', '$2y$10$UGBbWXTrpnXSSYnCMX3MbuuKoABV/9/mG2MmtGn2/fAYUkjMubvSO', 'jj@gmail.com', 'test');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_id` (`list_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Ευρετήρια για πίνακα `task_lists`
--
ALTER TABLE `task_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT για πίνακα `task_lists`
--
ALTER TABLE `task_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `task_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `task_lists`
--
ALTER TABLE `task_lists`
  ADD CONSTRAINT `task_lists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
