SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `msgs` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `em_id` int(11) NOT NULL,
  `re_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `msgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `em_id` (`em_id`);

ALTER TABLE `msgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `re_id` (`re_id`);

ALTER TABLE `msgs`
  ADD CONSTRAINT `msgs_ibfk_1` FOREIGN KEY (`em_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `msgs_ibfk_1` FOREIGN KEY (`re_id`) REFERENCES `users` (`id`);
COMMIT;
