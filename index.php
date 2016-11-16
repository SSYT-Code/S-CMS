<?php
	session_start();
	include_once('config.php');
	include_once('includes/class/class.user.php');
	$user = new USER();
	$db = SCMSDB();
?>

<?php
	include_once(CMS_THEME_PATH . 'overall_header.html');
	
	if(isset($_GET['action']) && $_GET['action'] === "logout")
	{
		$db->query('UPDATE accounts SET logged = 0, lastlogin = "CURRENT_TIMESTAMP" WHERE id = ' . $_SESSION['user_session']);
		$db = null;
		session_destroy();
		unset($_SESSION['user_session']);
		echo "Ai fost delogat cu succes !";
		header('Location: ./');
	}
?>