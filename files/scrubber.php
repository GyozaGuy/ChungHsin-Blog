<?php
	/*
	 * Library of helper functions
	 */
	// Validate for strings function
	function valString($string) {
		$string = str_replace('\\', '', $string);
		return nl2br(filter_var($string, 513)); // FILTER_SANITIZE_STRING
	}
	// Validate for HTML function
	function valHTML($string) {
		$string = str_replace('\\', '', $string);
		return $string;
	}
	// Validate for numbers function
	function valNumber($number) {
		return filter_var(filter_var($number, 520, 4096), 259); // FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION, FILTER_VALIDATE_FLOAT
	}
	// Validate e-mail address function
	function valEmail($email) {
		return filter_var(filter_var($email, 517), 274); // FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_EMAIL
	}
?>