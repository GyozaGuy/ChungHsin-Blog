<?php
	session_start();
	$sv = "localhost";
	$un = "<username>";
	$pw = "<password>";
	$db = "<database>";
	$con = new mysqli($sv, $un, $pw, $db);
	if (mysqli_connect_error()) {
		header('Location: ../?e=500');
		exit;
	}
?>
