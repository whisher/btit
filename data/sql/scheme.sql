CREATE TABLE IF NOT EXISTS user (
  id INT UNSIGNED NOT NULL auto_increment,
  firstname VARCHAR(255) NOT NULL,
  surname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  username VARCHAR(255) DEFAULT NULL,
  password VARCHAR(128) NOT NULL,
  state tinyint(1) NOT NULL DEFAULT 0,
  role ENUM('admin','user') DEFAULT NULL,
  join_datetime datetime NOT NULL,
  join_ip VARCHAR(15) NOT NULL,
  referrer VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY unique_user_email (email)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS user_login (
  id INT UNSIGNED NOT NULL auto_increment,
  user_id INT UNSIGNED NOT NULL,
  login_datetime datetime NOT NULL,
  login_ip VARCHAR(15) NOT NULL,
  referrer VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;





