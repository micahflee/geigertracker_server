<?php
require_once('helpers.php');

// load config file
if(!file_exists('config.php')) 
	error_create_config();
require_once('config.php');

// can we connect to the database?
if(!mysql_connect($c['mysql_host'], $c['mysql_username'], $c['mysql_password']))
	Helpers::error_database_connection();
if(!mysql_select_db($c['mysql_database']))
	Helpers::error_database_connection();

function db_query($q) {
	$res = mysql_query($q);
	if(!$res)	Helpers::error_database(mysql_error());
}

// add the table if it doesn't already exist
$schema = "
CREATE TABLE IF NOT EXISTS ".$c['mysql_prefix']."updates (
	id int(11) NOT NULL AUTO_INCREMENT,
	count int(11) NOT NULL,
	timestamp int(11) NOT NULL, 
	PRIMARY KEY (`id`),
	UNIQUE KEY `timestamp` (`timestamp`)
) CHARSET=utf8 ;";
db_query($schema);

// handle geiger counter updates
if(isset($_POST['count']) && isset($_POST['timestamp']) && isset($_POST['hash'])) {
	$count = (int)$_POST['count'];
	$timestamp = (int)$_POST['timestamp'];
	if($_POST['hash'] == Helpers::generate_hash($count, $timestamp)) {
		// the client knows the secret, so trust it
		db_query("INSERT IGNORE INTO ".$c['mysql_prefix']."updates (count,timestamp) VALUES('".(int)$count."', '".(int)$timestamp."')");
		exit();
	}
}

