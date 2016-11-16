<?php
	// database settings
	$database = array(
		'user' 		=> "root",
		'pass' 		=> "",
		'dbname'  	=> "s-cms"
	);	
	
	try {
		$SCMS_CONN = new PDO('mysql:host=localhost;dbname='. $database["dbname"] .'', $database["user"], $database["pass"]);
	}
	catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
?>
