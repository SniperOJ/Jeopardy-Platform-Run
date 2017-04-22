CREATE DATABASE `beta` /*!40100 DEFAULT CHARACTER SET utf8 */

/* Class */
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `score` int NOT NULL DEFAULT 0,
  `college` varchar (64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `registe_time` int DEFAULT 0,
  `registe_ip` varchar(16) not null,
  `salt` varchar(16) DEFAULT NULL,
  `active_code` varchar(32) DEFAULT NULL,
  `active_code_alive_time` varchar(32) DEFAULT NULL,
  `actived` tinyint NOT NULL DEFAULT 0,
  `usertype` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `challenges` (
  `challenge_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL,
  `flag` varchar(64) NOT NULL,
  `score` int NOT NULL DEFAULT 0,
  `type` ENUM('web', 'pwn', 'stego', 'misc', 'crypto', 'forensics', 'others') DEFAULT 'others',
  `online_time` int NOT NULL,
  `visit_times` int DEFAULT 0,
  `fixing` tinyint DEFAULT 0,
  `resource` varchar(512) DEFAULT NULL,
  `document` varchar(512) DEFAULT NULL,
  ``
  PRIMARY KEY (`challenge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `news` (
  `news_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `content` varchar(512) NOT NULL,
  `author_id` int NOT NULL,
  `submit_time` int NOT NULL DEFAULT 0,
  `visit_times` int DEFAULT 0,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE captcha (
    captcha_id bigint(13) unsigned NOT NULL auto_increment,
    captcha_time int(10) unsigned NOT NULL,
    ip_address varchar(45) NOT NULL,
    word varchar(20) NOT NULL,
    PRIMARY KEY `captcha_id` (`captcha_id`),
    KEY `word` (`word`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/* Verify and Active */
CREATE TABLE `reset_password` (
  `reset_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `salt` varchar(16) DEFAULT NULL,
  `reset_code` varchar(32) DEFAULT NULL,
  `reset_code_alive_time` int DEFAULT 0,
  `verified` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`reset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `reset_password` (
  `reset_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `salt` varchar(16) DEFAULT NULL,
  `reset_code` varchar(32) DEFAULT NULL,
  `reset_code_alive_time` int DEFAULT 0,
  `verified` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`reset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/* LOG */

CREATE TABLE `register_log`(

)

CREATE TABLE `login_log` (
  `login_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `login_time` int DEFAULT 0,
  `login_ip` varchar(16) not null;
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `submit_log` (
  `submit_id` int NOT NULL AUTO_INCREMENT,
  `challenge_id`int NOT NULL,
  `user_id`int NOT NULL,
  `flag` varchar(64) NOT NULL,
  `submit_time` int DEFAULT 0,
  `is_current` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`submit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `subscribe_log` (

)

CREATE TABLE `click_log` (

)
