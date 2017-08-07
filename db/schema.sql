CREATE DATABASE IF NOT EXISTS page_load_test
  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `api_key` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_url` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `test_info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `url_id` INT(11) NOT NULL,
  `location_id` INT(11) NOT NULL,
  `test_id` VARCHAR(255) NOT NULL,
  `completed_time` DATETIME DEFAULT NULL,
  `test_status` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`url_id`) REFERENCES `user_url` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`location_id`) REFERENCES `wpt_location` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `raw_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` INT(11) NOT NULL,
  `json_data` MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `test_info` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `average_result` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` INT(11) NOT NULL,
  `type_view` TINYINT(1) NOT NULL,
  `load_time` INT(11) NOT NULL,
  `ttfb` INT(11) NOT NULL,
  `bytes_out` INT(11) NOT NULL,
  `bytes_out_doc` INT(11) NOT NULL,
  `bytes_in` INT(11) NOT NULL,
  `bytes_in_doc` INT(11) NOT NULL,
  `connections` INT(11) NOT NULL,
  `requests` INT(11) NOT NULL,
  `requests_doc` INT(11) NOT NULL,
  `responses_200` INT(11) NOT NULL,
  `responses_404` INT(11) NOT NULL,
  `responses_other` INT(11) NOT NULL,
  `render_time` INT(11) NOT NULL,
  `fully_loaded` INT(11) NOT NULL,
  `doc_time` INT(11) NOT NULL,
  `dom_elements` INT(11) NOT NULL,
  `title_time` INT(11) NOT NULL,
  `load_event_start` INT(11) NOT NULL,
  `load_event_end` INT(11) NOT NULL,
  `dom_content_loaded_event_start` INT(11) NOT NULL,
  `dom_content_loaded_event_end` INT(11) NOT NULL,
  `first_paint` INT(11) NOT NULL,
  `dom_interactive` INT(11) NOT NULL,
  `dom_loading` INT(11) NOT NULL,
  `visual_complete` INT(11) NOT NULL,
  `completed_time` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `test_info`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `wpt_location` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `location` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `type_browser` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_location` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `wpt_location_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`wpt_location_id`) REFERENCES `wpt_location`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;