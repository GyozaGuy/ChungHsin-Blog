<?php
	// Upload an image
	function upload($id, $image) {
		$path = $_SERVER['DOCUMENT_ROOT']."/files/img/$id/";
		if (!file_exists($path))
			mkdir($path, 0777, true);
		$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
		move_uploaded_file($image['tmp_name'], $path."avatar.$ext");
		return "avatar.$ext";
	}
?>