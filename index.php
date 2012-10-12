<?php
	if ($_GET['entry'])
		$p = 'entry';
	elseif ($_GET['user'])
		$p = 'user';
	elseif ($_GET['deleteuser']) {
		header('Location: /files/?action=deleteuser&id='.$_GET['deleteuser']);
		exit;
	} elseif ($_GET['deletecomment']) {
		header('Location: /files/?action=deletecomment&entryId='.$_GET['entryId'].'&commentId='.$_GET['deletecomment']);
		exit;
	} elseif ($_GET['search'])
		$p = 'search';
	elseif ($_GET['query'])
		$p = $_GET['query'];
	elseif ($_POST['p'])
		$p = $_POST['p'];
	else
		$p = $_GET['p'];
	if ($p == 'logout') {
		header('Location: /files/?action=logout');
		exit;
	} elseif (empty($p))
		$p = 'home';
	include('files/header.php');
	include("files/$p.php");
	include('files/footer.php');
?>