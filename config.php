<?php
	include_once('includes/connection.php');
	// Global Variable

	global $TOTAL_LOGGED;
	global $MOST_ONLINE_USERS;
	global $ONLINE_USERS;
	global $TOTAL_USERS;
	global $FORUM_LISTS;
	global $FORUM_GROUPS;
	global $FORUM_GROUPS_LIST;
	global $STYLE_PATH;
	global $REGISTER_FORM;
	global $REGISTER_DATA;
	global $LOGIN_FORM;
	global $LOGIN_DATA;
	global $site_pages;
	
	// Get site settings from DB
	foreach ($SCMS_CONN->query('SELECT * FROM site_settings') as $row) {
		
		$site_settings = array(
			'url' 		=> $row['site_url'],
			'title'		=> $row['site_title'],
			'desc'		=> $row['site_desc'],
			'logo'		=> $row['site_logo'],
			'meta'		=> $row['site_meta'],
			'style'		=> $row['site_style']
		);

		$STYLE_PATH = $row['site_style'];
	}
	
	define('CMS_THEME_PATH', 'style/'. $STYLE_PATH .'/template/');
	define('CMS_STYLE_PATH', 'style/'. $STYLE_PATH .'/');
	
	// Get site pages from DB
	foreach ($SCMS_CONN->query('SELECT * FROM site_pages') as $row) {
		$site_pages .= '<li><a href="'. $row['page_url'] .'" alt="'. $row['page_title'] .'">'. $row['page_name'] .'</a></li>';
	}
	
	// Get groups from BD
	foreach ($SCMS_CONN->query('SELECT * FROM groups') as $row) {
		$FORUM_GROUPS_LIST .= '<b><a style="'. $row['colors'] .'" href="/groups.php/?group='. $row['id'] .'">'. $row['Name'] .'</a></b> ';
	}

	function getUsersOnline() {
	   $count = 0;

	   $handle = opendir(session_save_path());
	   if ($handle == false) return -1;

	   while (($file = readdir($handle)) != false) {
		   if (ereg("^sess", $file)) $count++;
	   }
	   closedir($handle);

	   return $count;
	}
	
	$ONLINE = getUsersOnline(); $REG_USER = 0; $NUMAR_MTO = 1;
	$TOTAL_USERS = $ONLINE + $REG_USER;
	
	$TOTAL_LOGGED = "<p>In total sunt ". $TOTAL_USERS ." utilizatori, ". $REG_USER ." inregistrati, ". $ONLINE ." vizitatori</p>";
	$MOST_ONLINE_USERS = "<p>Cei mai multi utilizatori conectati ". $NUMAR_MTO .", ". date("j F Y") ."</p>";
	
	if($ONLINE_USERS != 0)
	{
		$ONLINE_USERS = '<p><a href="/memberlist.php?user=sRk7">sRk7.</a></p>';
	}
	
	$FORUM_GROUPS = "Echipa: " . $FORUM_GROUPS_LIST;
	
	if(isset($_GET['action']))
	{
		if($_GET['action'] === "sign_up")
		{
			$REGISTER_FORM = true;
			$REGISTER_DATA .= "<h1>Create Account</h1>";
		}
	}

	if(isset($_GET['action']))
	{
		if($_GET['action'] === "sign_in")
		{
			$LOGIN_FORM = true;
			$LOGIN_DATA .= "<h1>Login</h1>";
		}
	}
?>