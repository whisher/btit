CREATE TABLE IF NOT EXISTS user (
  id INT UNSIGNED NOT NULL auto_increment,
  firstname VARCHAR(255) NOT NULL,
  surname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password CHAR(40) NOT NULL,
  role ENUM('admin','user') DEFAULT null,
  join_datetime datetime NOT NULL,
  join_ip VARCHAR(15) NOT NULL,
  last_login_ip VARCHAR(15) DEFAULT NULL,
  last_login_datetime DATETIME DEFAULT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY unique_user_email (email)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS user (
  id INT UNSIGNED NOT NULL auto_increment,
  firstname VARCHAR(255) NOT NULL,
  surname VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  display_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(128) NOT NULL,
  state tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY  (id),
  UNIQUE KEY unique_user_email (email)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


