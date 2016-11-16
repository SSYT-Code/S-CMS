<?php
	include_once('includes/connection.php');
	include_once('config.php');
	
	static $LINK;
	static $FORUM;
	static $FORUM_DESC;
	static $VIEW;
	static $AUTHOR;
	static $AUTHOR_LP;
	static $site_pages_2;
	
	$LINK = isset($_GET['forum']) ? $_GET['forum'] : '';
	
	foreach ($SCMS_CONN->query('SELECT * FROM topics WHERE t_forum = '. $LINK .' ') as $row) {
		$forum_rows = array(
		"topic_id" => $row['id'],
		"topic_category" => $row['t_forum'],
		"topic_title" => $row['t_tile'],
		"topic_poster" => $row['t_by'],
		"topic_message" => $row['t_text'],
		"topic_post_date" => $row['t_date'],
		"topic_replyes" => $row['last_reply'],
		"topic_lp_date" => $row['last_date']
		);
		
		foreach ($SCMS_CONN->query('SELECT * FROM accounts WHERE id = ' . $forum_rows['topic_poster']) as $row) {
			$AUTHOR = '<a href="memberlist.php?user='. $row['nick'] .'">'. $row['nick'] .'</a>';
		}
		
		foreach ($SCMS_CONN->query('SELECT * FROM accounts WHERE id = ' . $forum_rows['topic_replyes']) as $row) {
			$AUTHOR_LP = '<a href="memberlist.php?user='. $row['nick'] .'">'. $row['nick'] .'</a>';
		}
	}
	
	foreach ($SCMS_CONN->query('SELECT * FROM forums WHERE id = '. $LINK .' ') as $row) {
		$FORUM = $row['f_title'];
		$FORUM_DESC = $row['f_desc'];
	}

	$site_pages_2 .= $site_settings['title'];
	
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
		</ul>
		<div id="forum_title">
			<h1><?=$FORUM;?></h1>
			<p><?=$FORUM_DESC;?></p>
		</div>
		<!-- BEGIN forum_list_wrap -->
		<div id="forum_rows">
			<?php foreach ($SCMS_CONN->query('SELECT * FROM topics WHERE t_forum = ' . $LINK) as $forum_row) { ?>
				<table class="table" id="forum_<?=$forum_row['id']; ?>">
					<tr>
						<td class="row1over">
							<h3>
								<a href="viewtopic.php?topic=<?=$forum_row['id'];?>"><?=$forum_row['t_tile'];?></a><br />
								<span>Started by <?=$AUTHOR;?> on date <?=$forum_row['t_date'];?></span>
							</h3>
						</td>
						<td class="row1"><?=$forum_row['t_reply']?> reply</td>
						<td class="row1"><?=$forum_row['t_views']?> views</td>
						<td class="row3over">Last reply by <?=$AUTHOR_LP;?><br /><?=$forum_row['last_date'];?></td>
					</tr>
				</table>
				<br />
			<?php } ?>
		</div>
		<!-- END forum_list_wrap -->
<? } 
	include_once(CMS_THEME_PATH . 'overal_footer.html');
?>