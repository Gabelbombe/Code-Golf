<?php

// Sanest: Procedural
// All DB params should be in Apache conf as a SetEnv variable, see golf.conf

// Create
// CREATE DATABASE d; USE d; DROP TABLE IF EXISTS `Books`; CREATE TABLE `Books` (`id` bigint(20) NOT NULL AUTO_INCREMENT, `ISBN` bigint(13) NOT NULL, `Title` varchar(255) NOT NULL, `Description` mediumtext DEFAULT NULL COMMENT 'REF: goo.gl/IapxrK ntext is NOT a MySQL Datatype.....', PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ; CREATE USER u@'%' IDENTIFIED BY 'p'; GRANT INSERT, SELECT, UPDATE ON d.Books TO u@'%'; FLUSH PRIVILEGES;

// Load
// DELETE FROM Books; LOAD DATA INFILE '{path}/loader.csv'; INTO TABLE Books FIELDS TERMINATED BY '\t'  LINES TERMINATED BY '\n' (Title, ISBN, Description); SHOW WARNINGS;

try {
	$dbh = New \PDO('mysql:host=localhost;dbname=d', 'u', 'p');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$st = $dbh->prepare(trim('SELECT LEFT(Title, 1) AS First, Title, ISBN, Description AS Descr FROM d.Books GROUP BY First ORDER BY Title ASC'));
	$st->execute();
} catch( \PDOException $exc ) {
	Throw New \ErrorException($exc->getMessage(), (int) $exc->getCode()); // getCode returns string, if we extended with a custom exception we would be borked
}

$sort = [];
foreach($st->fetchAll(PDO::FETCH_ASSOC) AS $k => $arr) // 0 or more
{
	$arr = (['URI' => "<a href='/#{$arr['ISBN']}' alt='{$arr['Descr']}'>{$arr['Title']}</a>"] + $arr);
	$sort[$arr['First']][] = $arr;
}

// Clean it up a bit
array_walk_recursive($sort, function (&$v) { $v = htmlentities($v, ENT_HTML5|ENT_QUOTES|ENT_DISALLOWED); });
foreach (range('A','Z') AS $char) echo (isset($sort[$char])) ? "<a href='/#{$char}'>{$char}</a> &nbsp;" : "{$char} &nbsp;";
foreach($sort AS $k => $arr)
{
	echo "<a name='{$k}'>\n";
	array_walk_recursive($arr, function ($b, $a) {
		if ('uri' === strtolower($a))
		{
			echo "$b\n";
		}
	});
}