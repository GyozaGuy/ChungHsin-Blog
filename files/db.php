<?php
	session_start();
	$sv = "localhost";
	$un = "gyozaguy_chnghsn";
	$pw = "simple12";
	$db = "gyozaguy_chunghsin";
	$con = new mysqli($sv, $un, $pw, $db);
	if (mysqli_connect_error()) {
		header('Location: ../?e=500');
		exit;
	}
?>
