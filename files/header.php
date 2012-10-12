<?
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/files/dbfunctions.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/lang/en.php');
	$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=big5" />
		<title><?php echo $text['title'].' | '.$text['company'];?></title>
		<link href="/files/img/chunghsinlogo.png" rel="shortcut icon" />
		<link href="/files/styles.css" rel="stylesheet" type="text/css" />
		<link href="/files/print.css" rel="stylesheet" type="text/css" media="print" />
		<!--[if IE]><link href="/files/stylesIE.css" type="text/css" /><![endif]-->
	</head>
	<body class="text12">
		<div class="borderDefault rounded" id="container">
			<header class="bold gradientRed rounded textWhite">
				<?php
				$navItems = getNavItems();
				foreach ($navItems as $n)
					echo '<a class="gradientWhite nav rounded" href="'.$n['nav_href'].'">'.$text[$n['nav_item']].'</a>';
				?>
				<div class="floatRight textRight" id="menu">
					<form action="/" id="searchBox" method="get" name="searchBox"><input class="borderLight padding5 rounded" id="search" name="search" placeholder="<?php echo $text['search'];?>" type="text" <?php if ($_GET['search']) echo 'value="'.$_GET['search'].'" ';?>/><input type="submit" /></form>
					<?php if ($user) echo '<a class="textWhite" href="/?user='.$user['un'].'">'.$user['un'].'</a>, '.$text['loggedin'].'.<br />';?>
					<?php if ($user['rights'] >= 4) echo '<a class="textWhite" href="/?p=admin">'.$text['admin'].'</a> | ';?>
					<?php if ($user['rights'] >= 2) echo '<a class="textWhite" href="/?p=newentry">'.$text['newentry'].'</a> | ';?>
					<a class="textWhite" href="/?p=log<?php echo ($user) ? 'out' : 'in';?>"><?php echo $text['log']; echo ($user) ? $text['out'] : $text['in'].'</a> | <a class="textWhite" href="/?p=register">'.$text['register'];?></a><br />
				</div>
			</header>
			<div class="gradientWhite rounded" id="content">
				<img alt="Mountains" class="rounded" src="files/img/mountains.jpg" style="width:100%;" />
