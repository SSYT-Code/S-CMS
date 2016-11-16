<?php
	include_once('includes/connection.php');

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
	global $error_msg;
	global $logged_session;
	define('SCMS_DIR', __DIR__, true);

	// Get site settings from DB
	foreach ($db->query('SELECT * FROM site_settings') as $row) {
		
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
	
	define('CMS_THEME_PATH', SCMS_DIR.'/style/'. $STYLE_PATH .'/template/');
	define('CMS_STYLE_PATH', SCMS_DIR.'/style/'. $STYLE_PATH .'/');
	
	
	// Get site pages from DB
	if(!$user->is_loggedin())
	{
		foreach ($db->query('SELECT * FROM site_pages WHERE type = 1 OR type = 2') as $row) {
			$site_pages .= '<li><a href="'. $row['page_url'] .'" alt="'. $row['page_title'] .'">'. $row['page_name'] .'</a></li>';
		}
	}
	
	if($user->is_loggedin()) {
		foreach ($db->query('SELECT * FROM site_pages WHERE type = 1 OR type = 3') as $row) {
			$site_pages .= '<li><a href="'. $row['page_url'] .'" alt="'. $row['page_title'] .'">'. $row['page_name'] .'</a></li>';
		}
	}

	// Get groups from BD
	$FORUM_GROUPS_LIST = array();
	foreach ($db->query('SELECT * FROM groups') as $row) {
		$FORUM_GROUPS_LIST[] = '<b><a style="'. $row['colors'] .'" href="/groups.php/?group='. $row['id'] .'">'. $row['Name'] .'</a></b>';
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
	
	$users_array = array();
	$logged_member = $db->query('SELECT * FROM accounts WHERE logged = 1');
	$userData = $logged_member->fetch(PDO::FETCH_OBJ);
	if($logged_member->rowCount() > 0)
	{
		$REG_USER = $logged_member->rowCount();
		$ONLINE_USERS = $logged_member->rowCount();
		
		if($ONLINE_USERS != 0)
		{
			$users_array[] .= '<a href="/memberlist.php?user='. $userData->username .'">'. $userData->username  .'</a>';
			$getUsers = implode(', ', $users_array);
			$ONLINE_USERS = '<p>Utilizatori inregistrati: '. $getUsers .'</p>';
		}
	}
	
	$ONLINE = getUsersOnline(); $NUMAR_MTO = 1;
	$TOTAL_USERS = $ONLINE + $REG_USER;
	

	$TOTAL_LOGGED = "<p>In total sunt ". $TOTAL_USERS ." utilizatori, ". $REG_USER ." inregistrati, ". $ONLINE ." vizitatori</p>";
	$MOST_ONLINE_USERS = "<p>Cei mai multi utilizatori conectati ". $NUMAR_MTO .", ". date("j F Y") ."</p>";
	
	$str = implode(', ', $FORUM_GROUPS_LIST);
	$FORUM_GROUPS = "Echipa: " . $str;
	
	$REGISTER_DATA .= '<div id="signup">
	<h3>Registration</h3>
	<form method="post" action="" name="signup">
		<label>Name</label>
		<input type="text" name="nameReg" autocomplete="off" />
		<label>Email</label>
		<input type="text" name="emailReg" autocomplete="off" />
		<label>Username</label>
		<input type="text" name="usernameReg" autocomplete="off" />
		<label>Password</label>
		<input type="password" name="passwordReg" autocomplete="off"/>
		<div class="errorMsg"><?php echo $errorMsgReg; ?></div>
		<input type="submit" class="button" name="signupSubmit" value="Signup">
	</form>
	</div>';
	define('REGISTER_DATA_FORM', $REGISTER_DATA, true);

	$LOGIN_DATA .= '<div id="login">
	<h3>Login</h3>
	<form method="post" action="" name="login">
		<label>Username or Email</label>
		<input type="text" name="usernameEmail" autocomplete="off" />
		<label>Password</label>
		<input type="password" name="password" autocomplete="off"/>
		<input type="submit" class="button" name="loginSubmit" value="Login">
	</form>
	<div class="errorMsg"><?php echo $errorMsgLogin; ?></div>
	</div>';
	define('LOGIN_DATA_FORM',$LOGIN_DATA,true);
?>