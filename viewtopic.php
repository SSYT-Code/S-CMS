<?php
	include_once('includes/connection.php');
	include_once('config.php');
	$db = SCMSDB();
	
	$site_pages_2 = $site_settings['title'];
	$TOPIC_ID = isset($_GET['topic']) ? $_GET['topic'] : 1;
	static $FORUM;
	static $FORUM_ID;
	static $TOPIC;
	static $AUTOR;
	static $DATE;
	static $STRING;
	
	static $AVATAR;
	static $USER;
	static $RANK;
	static $FIELDS;

	foreach ($db->query('SELECT * FROM topics WHERE id =' . $TOPIC_ID) as $row) {
		$post_rows = array(
			"id" => $row['id'],
			"forum" => $row['t_forum'],
			"title" => $row['t_tile'],
			"author" => $row['t_by'],
			"content" => $row['t_text'],
			"post_date" => $row['t_date']
		);
		
		$AUTOR = $row['t_by'];
		
		$FORUM_ID = $post_rows['id'];
		foreach ($db->query('SELECT * FROM forums WHERE id = '. $FORUM_ID .' ') as $row) {
			$FORUM = $row['f_title'];
		}
		$TOPIC = $post_rows['title'];
	}
	
	foreach ($db->query('SELECT * FROM accounts WHERE id = ' . $AUTOR) as $profile) {
		$profile_fields = array(
			'id' => $profile['id'],
			'name' => $profile['username'],
			'posts' => $profile['posts']
		);
		
		$AVATAR = '<img src="'.$profile['avatar'].'" />';
		$USER = '<a href="#">'. $profile['username'] .'</a>';
		
		foreach ($db->query('SELECT * FROM groups WHERE id = ' . $profile['rank']) as $rank) {
			$RANK = '<span style="'. $rank['colors'].'">'. $rank['Name'] .'</span>';
		}

		$FIELDS = '
			<dd><span>Active Posts: </span> '. $profile['posts'] .'</dd>
			<dd><span>Points: </span> '. $profile['points'] .'</dd>
		';
		
		if(isset($profile) != "")
		{
			if(!empty($profile['hobby']))
				$FIELDS .= '<dd><span>Hobby: </span> '. $profile['hobby'] .'</dd>';
			
			if(!empty($profile['location']))
				$FIELDS .= '<dd><span>Location: </span> '. $profile['location'] .'</dd>';
			
			if(!empty($profile['stare']))
				$FIELDS .= '<dd><span>Stare: </span> '. $profile['stare'] .'</dd>';
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
				
				<ul class="main-pages">
					<?=$site_pages;?>
				</ul>
			</div>
		</div>
		
		<div class="content" id="page_body">
		<ul>
			<li><a href="./"><?=$site_pages_2;?></a></li>
			<li><?=$FORUM;?></li>
			<li><?=$TOPIC;?></li>
		</ul>
		<div id="post-<?=$post_rows['id']; ?>" class="post row2">
			<div id="profile_<?=$post_rows['author'];?>">
				<div class="avatar">
					<?=$AVATAR;?>
					<br />
					<h4><?=$USER;?></h4>
				</div>
				<div class="rank"><?=$RANK;?></div>
				<div class="fields"><?=$FIELDS;?></div>
			</div>
			<div id="post_body">
				<div class="content">
					<div>
						<dl><?=$post_rows['content'];?></dl>
					</div>
				</div>
			</div>
		</div>
<?
	}
	include_once(CMS_THEME_PATH . 'overal_footer.html');
?>