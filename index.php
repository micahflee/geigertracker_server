<?php
require_once('helpers.php');

// load config file
if(!file_exists('config.php')) 
	error_create_config();
require_once('config.php');

// set up database
require_once('database.php');
$db = new Database;

// handle geiger counter updates
if(isset($_POST['count']) && isset($_POST['timestamp']) && isset($_POST['hash'])) {
	$count = (int)$_POST['count'];
	$timestamp = (int)$_POST['timestamp'];
	if($_POST['hash'] == Helpers::generate_hash($count, $timestamp)) {
		// the client knows the secret, so trust it
		$db->insert_update($count, $timestamp);
		exit();
	}
}

// now that that's all taken care of, display graphs of data
?>
<html>
<head>
<title>Geiger Tracker</title>
</head>

<body>
<h1>Geiger Tracker</h1>
</body>
</html>
