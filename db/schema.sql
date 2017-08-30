CREATE DATABASE IF NOT EXISTS page_load_statistics
  DEFAULT CHARSET=utf8;

USE page_load_statistics;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `api_key` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `wpt_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type_browser` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO `wpt_location` VALUES (1, 'Dulles_MotoG4:Moto G4 - Chrome', 'Dulles, Virginia, Moto G4 - Chrome', 1),
                                  (2, 'Dulles_MotoG4:Moto G4 - Chrome Canary', 'Dulles, Virginia, Moto G4 - Chrome Canary', 1),
                                  (3, 'Dulles_MotoG4:Moto G4 - Chrome Beta', 'Dulles, Virginia, Moto G4 - Chrome Beta', 1),
                                  (4, 'Dulles_MotoG4:Moto G4 - Chrome Dev', 'Dulles, Virginia, Moto G4 - Chrome Dev', 1),
                                  (5, 'Dulles_MotoG:Moto G - Chrome', 'Dulles, Virginia, Moto G - Chrome', 1),
                                  (6, 'Dulles_MotoG:Moto G - Chrome Canary', 'Dulles, Virginia, Moto G - Chrome Canary', 1),
                                  (7, 'Dulles_MotoG:Moto G - Chrome Beta', 'Dulles, Virginia, Moto G - Chrome Beta', 1),
                                  (8, 'Dulles_MotoG:Moto G - Chrome Dev', 'Dulles, Virginia, Moto G - Chrome Dev', 1),
                                  (9, 'Dulles:Chrome', 'Dulles, Virginia, Chrome' , 0),
                                  (10, 'Dulles:Canary', 'Dulles, Virginia, Canary', 0),
                                  (11, 'Dulles:Firefox', 'Dulles, Virginia, Firefox', 0),
                                  (12, 'Dulles:Firefox Nightly', 'Dulles, Virginia, Firefox Nightly', 0),
                                  (13, 'Dulles:Microsoft Edge', 'Dulles, Virginia, Microsoft Edge', 0),
                                  (14, 'Dulles_IE11:IE 11', 'Dulles, Virginia, IE 11', 0),
                                  (15, 'Dulles_IE10:IE 10', 'Dulles, Virginia, IE 10', 0),
                                  (16, 'Dulles_IE9:IE 9', 'Dulles, Virginia, IE 9', 0),
                                  (17, 'Dulles_Thinkpad:Chrome', 'Dulles, Virginia, Thinkpad:Chrome', 0),
                                  (18, 'Dulles_Thinkpad:Canary', 'Dulles, Virginia, Thinkpad:Canary', 0),
                                  (19, 'Dulles_Thinkpad:Firefox', 'Dulles, Virginia, Thinkpad:Firefox', 0),
                                  (20, 'Dulles_Thinkpad:Firefox Nightly', 'Dulles, Virginia, Thinkpad:Firefox Nightly', 0),
                                  (21, 'Dulles_Thinkpad:Microsoft Edge', 'Dulles, Virginia, Thinkpad:Microsoft Edge', 0),
                                  (22, 'Dulles_Thinkpad:IE 11', 'Dulles, Virginia, Thinkpad:IE 11', 0),
                                  (23, 'Dulles_Linux:Chrome', 'Dulles, Virginia, Linux:Chrome', 1),
                                  (24, 'Dulles_Linux:Chrome Beta', 'Dulles, Virginia, Linux:Chrome Beta', 1),
                                  (25, 'Dulles_Linux:Chrome Canary', 'Dulles, Virginia, Linux:Chrome Canary', 1),
                                  (26, 'Dulles_Linux:Firefox', 'Dulles, Virginia, Linux:Firefox', 1),
                                  (27, 'ec2-us-east-1:Chrome', 'US East (N. Virginia), Chrome', 0),
                                  (28, 'ec2-us-east-1:Firefox', 'US East (N. Virginia), Firefox', 0),
                                  (29, 'ec2-us-east-1:IE 11', 'US East (N. Virginia), IE 11', 0),
                                  (30, 'ec2-us-west-2:Chrome', 'US West (Oregon), Chrome', 0),
                                  (31, 'ec2-us-west-2:Firefox', 'US West (Oregon), Firefox', 0),
                                  (32, 'ec2-us-west-2:IE 11', 'US West (Oregon), IE 11', 0),
                                  (33, 'ec2-us-west-1:Chrome', 'US West (N. California), Chrome', 0),
                                  (34, 'ec2-us-west-1:Firefox', 'US West (N. California), Firefox', 0),
                                  (35, 'ec2-us-west-1:IE 11', 'US West (N. California), IE 11', 0),
                                  (36, 'ec2-sa-east-1:Chrome', 'South America (Sao Paulo), Chrome', 0),
                                  (37, 'ec2-sa-east-1:Firefox', 'South America (Sao Paulo), Firefox', 0),
                                  (38, 'ec2-sa-east-1:IE 11', 'South America (Sao Paulo), IE 11', 0),
                                  (39, 'ec2-eu-west-1:Chrome', 'EU (Ireland), Chrome', 0),
                                  (40, 'ec2-eu-west-1:Firefox', 'EU (Ireland), Firefox', 0),
                                  (41, 'ec2-eu-west-1:IE 11', 'EU (Ireland), IE 11', 0),
                                  (42, 'London_EC2:Chrome', 'United Kingdom, London, Chrome', 0),
                                  (43, 'London_EC2:Firefox', 'United Kingdom, London, Firefox', 0),
                                  (44, 'London_EC2:IE 11', 'United Kingdom, London, IE 11', 0),
                                  (45, 'ec2-eu-central-1:Chrome', 'EU (Frankfurt), Chrome', 0),
                                  (46, 'ec2-eu-central-1:Firefox', 'EU (Frankfurt), Firefox', 0),
                                  (47, 'ec2-eu-central-1:IE 11', 'EU (Frankfurt), IE 11', 0),
                                  (48, 'ap-south-1:Chrome', 'Asia Pacific (Mumbai), Chrome', 0),
                                  (49, 'ap-south-1:Chrome Beta', 'Asia Pacific (Mumbai), Chrome Beta', 0),
                                  (50, 'ap-south-1:Chrome Canary', 'Asia Pacific (Mumbai), Chrome Canary', 0),
                                  (51, 'ec2-ap-southeast-1:Chrome', 'Asia Pacific (Singapore), Chrome', 0),
                                  (52, 'ec2-ap-southeast-1:Firefox', 'Asia Pacific (Singapore), Firefox', 0),
                                  (53, 'ec2-ap-southeast-1:IE 11', 'Asia Pacific (Singapore), IE 11', 0),
                                  (54, 'ec2-ap-northeast-1:Chrome', 'Asia Pacific (Tokyo), Chrome', 0),
                                  (55, 'ec2-ap-northeast-1:Firefox', 'Asia Pacific (Tokyo), Firefox', 0),
                                  (56, 'ec2-ap-northeast-1:IE 11', 'Asia Pacific (Tokyo), IE 11', 0),
                                  (57, 'ec2-ap-southeast-2:Chrome', 'Asia Pacific (Sydney), Chrome', 0),
                                  (58, 'ec2-ap-southeast-2:Firefox', 'Asia Pacific (Sydney), Firefox', 0),
                                  (59, 'ec2-ap-southeast-2:IE 11', 'Asia Pacific (Sydney), IE 11', 0);

CREATE TABLE IF NOT EXISTS `domain` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `domain_name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_domain` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `domain_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`domain_id`) REFERENCES `domain`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_domain_url` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_domain_id` INT(11) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_domain_id`) REFERENCES `user_domain`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_domain_location` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_domain_id` INT(11) NOT NULL,
  `wpt_location_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_domain_id`) REFERENCES `user_domain`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`wpt_location_id`) REFERENCES `wpt_location`(`id`) ON DELETE CASCADE
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
  FOREIGN KEY (`url_id`) REFERENCES `user_domain_url` (`id`) ON DELETE CASCADE,
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
  `load_time` INT(11) DEFAULT NULL,
  `ttfb` INT(11) DEFAULT NULL,
  `bytes_out` INT(11) DEFAULT NULL,
  `bytes_out_doc` INT(11) DEFAULT NULL,
  `bytes_in` INT(11) DEFAULT NULL,
  `bytes_in_doc` INT(11) DEFAULT NULL,
  `connections` INT(11) DEFAULT NULL,
  `requests` INT(11) DEFAULT NULL,
  `requests_doc` INT(11) DEFAULT NULL,
  `responses_200` INT(11) DEFAULT NULL,
  `responses_404` INT(11) DEFAULT NULL,
  `responses_other` INT(11) DEFAULT NULL,
  `render_time` INT(11) DEFAULT NULL,
  `fully_loaded` INT(11) DEFAULT NULL,
  `doc_time` INT(11) DEFAULT NULL,
  `dom_elements` INT(11) DEFAULT NULL,
  `title_time` INT(11) DEFAULT NULL,
  `load_event_start` INT(11) DEFAULT NULL,
  `load_event_end` INT(11) DEFAULT NULL,
  `dom_content_loaded_event_start` INT(11) DEFAULT NULL,
  `dom_content_loaded_event_end` INT(11) DEFAULT NULL,
  `first_paint` INT(11) DEFAULT NULL,
  `dom_interactive` INT(11) DEFAULT NULL,
  `dom_loading` INT(11) DEFAULT NULL,
  `visual_complete` INT(11) DEFAULT NULL,
  `completed_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `test_info`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;