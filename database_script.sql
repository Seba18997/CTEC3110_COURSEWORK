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


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(128) NOT NULL,
  `wsdl` varchar(512) NOT NULL,
  `wsdl_username` varchar(64) NOT NULL,
  `wsdl_password` varchar(64) NOT NULL,
  `wsdl_messagecounter` int(11) NOT NULL,
  `db_host` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `db_port` int(11) NOT NULL,
  `db_user` varchar(64) NOT NULL,
  `db_userpassword` varchar(64) NOT NULL,
  `db_charset` varchar(64) NOT NULL,
  `db_collation` varchar(64) NOT NULL,
  `doctrine_driver` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`id`, `app_name`, `wsdl`, `wsdl_username`, `wsdl_password`, `wsdl_messagecounter`, `db_host`, `db_name`, `db_port`, `db_user`, `db_userpassword`, `db_charset`, `db_collation`, `doctrine_driver`) VALUES
(1,	'M2MAPP',	'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',	'19_Sebastian',	'passXDword123',	75,	'localhost',	'coursework',	3306,	'p3tuser',	'password',	'utf8',	'utf8_unicode_ci',	'pdo_mysql');

DROP TABLE IF EXISTS `switch`;
CREATE TABLE `switch` (
  `id` int(4) NOT NULL DEFAULT 1,
  `switch1` varchar(32) NOT NULL,
  `switch2` varchar(32) NOT NULL,
  `switch3` varchar(32) NOT NULL,
  `switch4` varchar(32) NOT NULL,
  `fan` varchar(32) NOT NULL,
  `heater` varchar(64) NOT NULL,
  `keypad` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `switch` (`id`, `switch1`, `switch2`, `switch3`, `switch4`, `fan`, `heater`, `keypad`) VALUES
(1,	'on',	'on',	'off',	'on',	'backward',	'4',	'7');

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `auto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_data` (`auto_id`, `user_name`, `email`, `password`, `role`, `timestamp`) VALUES
(99,	'admin',	'admin@admin.com',	'$2y$12$3OrihKFHRXIUFcTn7gouEul5XpYqT/D4NaNW8R8wHtku74QYAk9Lu',	'admin',	'2020-01-02 17:11:37');
