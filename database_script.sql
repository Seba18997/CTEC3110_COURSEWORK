CREATE DATABASE `coursework`;

CREATE USER 'p3tuser' IDENTIFIED BY 'password';

GRANT USAGE ON *.* TO 'p3tuser'@localhost IDENTIFIED BY 'password';

GRANT ALL privileges ON `coursework`.* TO 'p3tuser'@localhost;

FLUSH PRIVILEGES;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `source` varchar(64) NOT NULL,
  `destination` varchar(64) NOT NULL,
  `date` varchar(32) NOT NULL,
  `type` varchar(8) NOT NULL,
  `message` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `switch`;
CREATE TABLE `switch` (
  `id` int(4) NOT NULL DEFAULT 1,
  `switch1` int(4) NOT NULL,
  `switch2` int(4) NOT NULL,
  `switch3` int(4) NOT NULL,
  `switch4` int(4) NOT NULL,
  `fan` varchar(32) NOT NULL,
  `heater` varchar(64) NOT NULL,
  `keypad` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(16) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `auto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


