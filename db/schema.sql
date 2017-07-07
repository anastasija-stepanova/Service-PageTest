CREATE TABLE `raw_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `json_data` MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_attributes` (
  `user_id` INT(11) AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `test_info` (
  `id` INT (11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `test_id` VARCHAR(255) NOT NULL,
  `test_url` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `from_place` VARCHAR(255) NOT NULL,
  `completed` INT(11) NOT NULL,
  `tester_dns` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `list_url_sites` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `site_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `runs_result` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` VARCHAR(255) NOT NULL,
  `request_id` VARCHAR(255) NOT NULL,
  `type_run` VARCHAR(255) NOT NULL,
  `view` VARCHAR(255) DEFAULT NULL,
  `load_time` INT(11) NOT NULL,
  `ttfb` INT(11) NOT NULL,
  `bytes_out` INT(11) NOT NULL,
  `bytes_out_doc` INT(11) NOT NULL,
  `bytes_in` INT(11) NOT NULL,
  `bytes_in_doc` INT(11) NOT NULL,
  `connections` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;