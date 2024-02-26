SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `descr` varchar(1024) DEFAULT 'Sin descripcion.',
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(5,	'pepe',	'pepe@gmail.com',	'9a45f7fca7261712',	'2023-10-26 01:35:44',	0),
(6,	'Altokeso',	'altokeso23@gmail.com',	'9a45f7fca7261712',	'2023-10-26 01:36:06',	0),
(7,	'Grser',	'Isaacxino407@gmail.com',	'a0953ddc9e2605b6',	'2023-10-27 00:45:49',	0),
(8,	'dsa',	'asd@gmail.com',	'9a45f7fca7261712',	'2023-10-28 17:36:24',	0),
(9,	'jaime',	'jaimito@gmail.com',	'9a45f7fca7261712',	'2023-10-28 17:36:44',	0);


INSERT INTO `msgs` (`id`, `em_id`, `re_id`, `text`, `created_at`) VALUES
(4,	6,	5,	'asd',	'2023-10-27 19:01:56'),
(5,	6,	5,	'Holaaa',	'2023-10-27 20:17:39'),
(6,	5,	6,	'Hola',	'2023-10-28 17:42:55'),
(7,	6,	7,	'Hola',	'2023-10-28 17:42:56'),
(8,	5,	7,	'Hola',	'2023-10-28 17:42:57'),
(9,	5,	6,	'Hola',	'2023-10-28 17:42:58'),
(10,	5,	8,	'Hola',	'2023-10-28 17:49:48'),
(11,	8,	5,	'Hola',	'2023-10-28 17:49:49'),
(12,	6,	5,	'Nacho se la re come',	'2023-10-28 20:08:47'),
(13,	6,	5,	'asdasd',	'2023-10-28 20:09:11'),
(14,	6,	5,	'aaaa',	'2023-10-28 22:06:55'),
(15,	6,	5,	'ella durmio...',	'2023-10-28 22:08:32'),
(16,	6,	7,	'Grser se la come',	'2023-10-28 22:12:35'),
(17,	6,	7,	'holaaaa',	'2023-10-28 22:13:29'),
(18,	7,	6,	'Come me las bolas',	'2023-10-28 22:23:23'),
(19,	6,	7,	'cuando quieras bb',	'2023-10-28 22:23:28'),
(20,	7,	6,	'QUE PIOLA',	'2023-10-28 22:23:37'),
(21,	6,	7,	'piola es tu choton',	'2023-10-28 22:23:46'),
(22,	7,	6,	'uh ke rico',	'2023-10-28 22:23:56'),
(23,	7,	6,	'Comela',	'2023-10-28 23:24:18'),
(24,	6,	7,	'Sos tan pero tan puto',	'2023-10-29 22:56:38'),
(25,	6,	7,	'y gay',	'2023-10-29 22:56:58'),
(26,	6,	7,	'sexooo',	'2023-10-29 23:04:05'),
(27,	6,	7,	'Mi mama me mima',	'2023-10-29 23:19:33'),
(28,	6,	5,	'Habia una ves truz',	'2023-11-09 01:21:47'),
(29,	6,	5,	'jajajaja',	'2023-11-09 01:21:53'),
(30,	6,	5,	'aaa',	'2023-11-09 01:22:45');

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

