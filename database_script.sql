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

/* test value: */

INSERT INTO `messages` (`id`, `source`, `destination`, `date`, `type`, `message`) VALUES (1, 447817814149, 447817814149, '17/12/2019 11:18:10', 'SMS', 'test_message');

