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
  `source` bigint(16) NOT NULL,
  `destination` bigint(16) NOT NULL,
  `date` varchar(32) NOT NULL,
  `type` varchar(8) NOT NULL,
  `message` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `token` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(16) NOT NULL,
  `password` varchar(256) NOT NULL,
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


