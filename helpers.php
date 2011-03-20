<?php

class Helpers {
	// generate a hash
	static function generate_hash($count, $timestamp) {
		global $c;
		return sha1($c['secret'].$count.$timestamp);
	}

	// errors
	static function error_create_config() {
		?>
		<h1>You must configure GeigerTracker before it will work</h1>
		<p>Make a copy of config-sample.php called config.php and edit it to include the correct MySQL database information and a random secret string.</p>
		<?php 
		exit();
	}

	static function error_database_connection() {
		?>
		<h1>Database connection error</h1>
		<p>I cannot connect to the MySQL database. Maybe this means config.php does not have the right MySQL settings.</p>
		<?php 
		exit();
	}

	static function error_database($error) {
		?>
		<h1>Database error</h1>
		<pre><?php echo($error); ?></pre>
		<?php 
		exit();
	}
}

