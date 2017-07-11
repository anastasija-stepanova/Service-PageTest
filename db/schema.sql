CREATE DATABASE sites_testing_data
  DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `api_key` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `raw_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` iNT(11) NOT NULL ,
  `json_data` MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `test_info` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `test_info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `test_id` VARCHAR(255) NOT NULL,
  `test_url` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `from_place` VARCHAR(255) NOT NULL,
  `completed` INT(11) NOT NULL,
  `tester_dns` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `url_sites` (
  `id` INT(11) NOT NULL  AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `site_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `average_result` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` VARCHAR(255) NOT NULL,
  `type_view` TINYINT(4) NOT NULL,
  `load_time` INT(11) NOT NULL,
  `ttfb` INT(11) NOT NULL,
  `bytes_out` INT(11) NOT NULL,
  `bytes_out_doc` INT(11) NOT NULL,
  `bytes_in` INT(11) NOT NULL,
  `bytes_in_doc` INT(11) NOT NULL,
  `connections` INT(11) NOT NULL,
  `requests` INT(11) NOT NULL,
  `requests_full` INT(11) NOT NULL,
  `requests_doc` INT(11) NOT NULL,
  `response_200` INT(11) NOT NULL,
  `response_400` INT(11) NOT NULL,
  `response_other` INT(11) NOT NULL,
  `render` INT(11) NOT NULL,
  `fully_loaded` INT(11) NOT NULL,
  `doc_time` INT(11) NOT NULL,
  `dom_time` INT(11) NOT NULL,
  `image_total` INT(11) NOT NULL,
  `base_page_redirects` INT(11) NOT NULL,
  `optimization_checked` INT(11) NOT NULL,
  `dom_elements` INT(11) NOT NULL,
  `page_speed_version` INT(11) NOT NULL,
  `title_time` INT(11) NOT NULL,
  `load_event_start` INT(11) NOT NULL,
  `load_event_end` INT(11) NOT NULL,
  `dom_content_loaded_event_start` INT(11) NOT NULL,
  `dom_content_loaded_event_end` INT(11) NOT NULL,
  `last_visual_change` INT(11) NOT NULL,
  `first_paint` INT(11) NOT NULL,
  `dom_interactive` INT(11) NOT NULL,
  `dom_loading` INT(11) NOT NULL,
  `base_page_ttfb` INT(11) NOT NULL,
  `visual_complete` INT(11) NOT NULL,
  `speed_index` INT(11) NOT NULL,
  `sertificate_bytes` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (test_id) REFERENCES test_info(id) ON DELETE CASCADE
) ENGINE=InnoDB;