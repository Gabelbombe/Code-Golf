<?php

// Create
// CREATE DATABASE d; USE d; DROP TABLE IF EXISTS `Books`; CREATE TABLE `Books` (`id` bigint(20) NOT NULL AUTO_INCREMENT, `ISBN` bigint(13) NOT NULL, `Title` varchar(255) NOT NULL, `Description` mediumtext DEFAULT NULL COMMENT 'REF: goo.gl/IapxrK ntext is NOT a MySQL Datatype.....', PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ; CREATE USER u@'%' IDENTIFIED BY 'p'; GRANT INSERT, SELECT, UPDATE ON d.Books TO u@'%'; FLUSH PRIVILEGES;

// Load
// DELETE FROM Books; LOAD DATA INFILE '{path}/loader.csv'; INTO TABLE Books FIELDS TERMINATED BY '\t'  LINES TERMINATED BY '\n' (Title, ISBN, Description); SHOW WARNINGS;

// Smallest: Finished in 363 Characters
exec('mysql -uu -pp -e"SELECT Title, ISBN FROM d.Books ORDER BY Title ASC"', $o);unset($o[0]);$a=[];foreach($o AS $k=>$v){$e=explode("\t",$v);@$a[substr(ucwords($e[0]),0,1)].="<a href='/{$e[1]}'>{$e[0]}</a><br>";}foreach(range('A','Z') AS $l){echo(isset($a[$l]))?"<a href='/#$l'>$l</a> ":"$l ";}echo'<br>';foreach($a AS $k=>$v){echo"<a name='$k'>$k</a><br>$v\n";}

// Sanest


$