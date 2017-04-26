CREATE DATABASE IF NOT EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login`.`users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';


ALTER TABLE `login`.`users` ADD taste varchar(64) COMMENT 'user''s taste';
ALTER TABLE `login`.`users` ADD favourite varchar(64) COMMENT 'user''s favourite';
ALTER TABLE `login`.`users` ADD hate varchar(64) COMMENT 'user''s hate' ;


CREATE TABLE IF NOT EXISTS `login`.`restaurants` (
  `name` VARCHAR(45) NOT NULL,
  `categories` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  `image_url` VARCHAR(45) NULL,
  `price_level` INT NULL,
  PRIMARY KEY (`name`))
ENGINE = InnoDB