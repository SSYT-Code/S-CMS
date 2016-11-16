<?php
	include_once('includes/connection.php');
	include_once('config.php');
	global $installed;
	global $installed_form;
	
	if(isset($_GET['action']))
	{
		$installed = false;
		if($_GET['action'] === "install" && !isset($_GET['steep']))
		{
			$url = "window.location='http://127.0.0.1/S-CMS/install.php?action=install&steep=1'";
			$msg = '<center><h1>Bun venit la instalarea platformei S-CMS</h1><br />Pentru a incepe instalarea apasa pe butonul \'Install CMS\'.<br />Instalarea se efectuaza in mod automat prin automatizarea platformei ! <br /><br /> <input id="install_cms" type="submit" onclick="'. $url .'" name="install" value="Install CMS" /></center>';
			$installed_form .= $msg;
		}
		
		if(isset($_GET['steep']))
		{
			if($_GET['action'] == "install" && $_GET['steep'] == 1)
			{
				$error = "";
				// Check database
				$sql = "CREATE DATABASE IF NOT EXISTS s_cms";
				try {
					$SCMS_CONN->exec($sql);
					$url = "window.location='http://127.0.0.1/S-CMS/install.php?action=install&steep=2'";
					$error = '<center><h1>Bun venit la instalarea platformei S-CMS</h1><br />(+) S-CMS-DB created successfully <br /><br /><input id="install_cms" type="submit" onclick="'. $url .'" name="install" value="Next Steep" /></center>';
					$installed_form .= $error;
				}
				catch(PDOException $e)
				{
					$error .= "<br>" . $e->getMessage();
					echo $error;
				}
			}
		
			// Creating table
			if($_GET['action'] === "install" && $_GET['steep'] == 2)
			{
				$sql = "CREATE TABLE s_cms.accounts (
				  `id` int(11) NOT NULL,
				  `nick` varchar(32) NOT NULL,
				  `password` varchar(24) NOT NULL,
				  `email` varchar(129) NOT NULL,
				  `numeprenume` varchar(129) NOT NULL,
				  `posts` int(11) NOT NULL,
				  `points` int(11) NOT NULL,
				  `avatar` tinyint(1) NOT NULL,
				  `lastlogin` varchar(32) NOT NULL,
				  `register` varchar(32) NOT NULL,
				  `ip` varchar(16) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				
				ALTER TABLE s_cms.accounts
				  ADD PRIMARY KEY (`id`),
				  ADD UNIQUE KEY `nick` (`nick`);";
				  
				try {
					$SCMS_CONN->exec($sql);
				}
				catch(PDOException $e)
				{
					$error .= "<br>" . $e->getMessage();
				}
				
				// Table forums
				$sql = "CREATE TABLE s_cms.forums (
				  `id` int(11) NOT NULL,
				  `f_title` varchar(128) NOT NULL,
				  `f_desc` varchar(255) NOT NULL,
				  `f_topics` int(11) NOT NULL,
				  `f_posts` int(11) NOT NULL,
				  `f_last_post` text NOT NULL,
				  `f_link` varchar(244) NOT NULL DEFAULT '',
				  `f_parent` int(11) NOT NULL,
				  `f_locked` int(11) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				
				INSERT INTO s_cms.forums (`id`, `f_title`, `f_desc`, `f_topics`, `f_posts`, `f_last_post`, `f_link`, `f_parent`, `f_locked`) VALUES
				(1, 'Forum Test 1', 'This is a description of forum #1', 0, 0, 'No post here', '/viewforum.php?forum=', 0, 0),
				(2, 'Forum Test 2', 'This is a description of forum #2', 0, 0, 'No post here', '/viewforum.php?forum=', 0, 0);
				
				ALTER TABLE s_cms.forums
				  ADD PRIMARY KEY (`id`),
				  ADD UNIQUE KEY `title` (`f_title`);";
				  
				try {
					$SCMS_CONN->exec($sql);
				}
				catch(PDOException $e)
				{
					$error .= "<br>" . $e->getMessage();
				}
				
				// Table Groups
				$sql = "CREATE TABLE s_cms.groups (
				  `id` int(11) NOT NULL,
				  `Name` varchar(32) NOT NULL,
				  `Desc` varchar(32) NOT NULL,
				  `colors` varchar(24) NOT NULL,
				  `Leader` int(11) NOT NULL,
				  `Members` int(11) NOT NULL,
				  `Flags` int(11) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				
				INSERT INTO s_cms.groups (`id`, `Name`, `Desc`, `colors`, `Leader`, `Members`, `Flags`) VALUES
				(1, 'Administrator', 'Forum administrators', '    color: #E91E63;', -1, 0, 1),
				(2, 'Moderators', 'Forum moderators', 'color: #009688;', -1, 0, 2),
				(3, 'Members', 'Forum members', '    color: #2196F3;', -1, 0, 3);
				
				ALTER TABLE s_cms.groups
				  ADD PRIMARY KEY (`id`);";
				  
				try {  
					$SCMS_CONN->exec($sql);
					$url = "window.location='http://127.0.0.1/S-CMS/install.php?action=install&steep=3'";
					$error = '<center><h1>Bun venit la instalarea platformei S-CMS</h1><br /><b><font style="font-size: 14px; color: green;">(+)</font> Accounts table created<br /><br /><b><font style="font-size: 14px; color: green;">(+)</font> Forums table created</b><br /><b><font style="font-size: 14px; color: green;">(+)</font> Groups table created</b><br /><br /><input id="install_cms" type="submit" onclick="'. $url .'" name="install" value="Finish" /></center>';
					$installed_form .= $error;
					
				}
				catch(PDOException $e)
				{
					$error .= "<br>" . $e->getMessage();
				}
			}
			
			if($_GET['action'] === "install" && $_GET['steep'] == 3)
			{
				$installed = true;
				echo "Platforma este acum functionala !";
				header('Location: http://127.0.0.1/S-CMS/');
				unlink('install.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?=$site_settings['title'];?></title>
		<link rel="stylesheet" type="text/css" href="style/default/style.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="header">
			<div class="content">
				<div id="logo">
					<a href="<?=$site_settings['url'];?>">
						<img src="<?=$site_settings['logo'];?>" alt="<?=$site_settings['title'];?>" />
					</a>
				</div>
			</div>
		</div>
		
		<div class="content" id="page_body">
			<?=$installed_form;?>
			
		</div>
		
		<?php include(CMS_THEME_PATH . 'page_footer.html'); ?>