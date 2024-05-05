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

CREATE TABLE `msgs` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `em_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(5,	'pepe',	'pepe@gmail.com',	'9a45f7fca7261712',	'2023-10-26 01:35:44',	0),
(6,	'Altokeso',	'altokeso23@gmail.com',	'9a45f7fca7261712',	'2023-10-26 01:36:06',	1),
(7,	'Grser',	'Isaacxino407@gmail.com',	'a0953ddc9e2605b6',	'2023-10-27 00:45:49',	0),
(8,	'asd',	'asd@gmail.com',	'9a45f7fca7261712',	'2023-10-28 17:36:24',	0),
(9,	'jaimito',	'jaimito@gmail.com',	'9a45f7fca7261712',	'2023-10-28 17:36:44',	0);

-- segundo lo de abajo porque tira error el hdp

ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `msgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `em_id` (`em_id`),
  ADD KEY `re_id` (`re_id`);

ALTER TABLE `msgs`
  ADD CONSTRAINT `msgs_ibfk_1` FOREIGN KEY (`em_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `msgs_ibfk_1` FOREIGN KEY (`re_id`) REFERENCES `users` (`id`);

