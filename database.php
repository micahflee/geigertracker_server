<?php

class Database {
	function __construct() {
		global $c;

		// can we connect to the database?
		if(!mysql_connect($c['mysql_host'], $c['mysql_username'], $c['mysql_password']))
			Helpers::error_database_connection();
		if(!mysql_select_db($c['mysql_database']))
			Helpers::error_database_connection();

		// add the table if it doesn't already exist
		$schema = "
		CREATE TABLE IF NOT EXISTS ".$c['mysql_prefix']."updates (
			id int(11) NOT NULL AUTO_INCREMENT,
			count int(11) NOT NULL,
			timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) CHARSET=utf8 ;";
		$this->query($schema);
	}

	function __destruct() {
		mysql_close();
	}

	function query($q) {
		$this->res = mysql_query($q);
		if(!$this->res)	Helpers::error_database(mysql_error());
	}

	function insert_update($count, $timestamp) {
		global $c;
		$this->query("INSERT INTO ".$c['mysql_prefix']."updates (count,timestamp) VALUES('".(int)$count."', '".(int)$timestamp."')");
	}

	function sanitize($str) {
	}

}

