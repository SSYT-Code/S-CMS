<?php
	// session_start();
	
	function SCMSDB()
	{
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "";
		$dbname = "s-cms";
		try {
			$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
			$dbConnection->exec("set names utf8");
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		}
		catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
	
	include_once 'class/class.user.php';
	$db = SCMSDB();
	$user = new USER();
?>