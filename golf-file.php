<?php

// Create
// CREATE DATABASE d; USE d; DROP TABLE IF EXISTS `Books`; CREATE TABLE `Books` (`id` bigint(20) NOT NULL AUTO_INCREMENT, `ISBN` bigint(13) NOT NULL, `Title` varchar(255) NOT NULL, `Description` mediumtext DEFAULT NULL COMMENT 'REF: goo.gl/IapxrK ntext is NOT a MySQL Datatype.....', PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ; CREATE USER u@'%' IDENTIFIED BY 'p'; GRANT INSERT, SELECT, UPDATE, ON d.Books TO u@'%'; FLUSH PRIVILEGES;

// Load
// DELETE FROM Books; LOAD DATA INFILE '{path}/loader.csv'; INTO TABLE Books FIELDS TERMINATED BY '\t'  LINES TERMINATED BY '\n' (Title, ISBN, Description); SHOW WARNINGS;


exec('mysql -u u -p p -e select * from d.Books order by Name desc', $o, $r);

print_r($o);

print_r($r);
