<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/files/dbfunctions.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/files/scrubber.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/files/upload.php');
	if ($_POST['action'])
		$action = $_POST['action'];
	else
		$action = $_GET['action'];
	if ($action == 'login') {
		$un = valString($_POST['un']);
		$pw = valString($_POST['pw']);
		$_SESSION['errors'] = array();
		if (empty($un) || empty($pw))
			$_SESSION['errors']['empty'] = 1;
		if ($_SESSION['errors']) {
			header('Location: /?p=login');
			exit;
		} else {
			$user = array();
			$user = login($un, sha1($pw.'mmmmsoysauce'));
			if (!empty($user['fname'])) {
				session_regenerate_id(true);
				$_SESSION['user'] = $user;
				header('Location: /');
				exit;
			} else {
				$_SESSION['errors']['db'] = 1;
				header('Location: /?p=login');
				exit;
			}
		}
	} elseif ($action == 'logout') {
		unset($_SESSION['user']);
		header('Location: /');
		exit;
	} elseif ($action == 'register') {
		// Collect and sanitize the data
		$un = valString($_POST['un']);
		$pw1 = valString($_POST['pw1']);
		$pw2 = valString($_POST['pw2']);
		$fname = valString($_POST['fname']);
		$lname = valString($_POST['lname']);
		$email = valEmail($_POST['email']);
		// Validate the data
		$errors = array();
		if (empty($un) || empty($pw1) || empty($pw2) || empty($fname) || empty($lname) || empty($email))
			$errors['allFields'] = 'All fields are required.';
		if ($pw1 != $pw2)
			$errors['password'] = 'Your passwords do not match, please try again.';
		// Check for validation errors, and send back if found
		if (!empty($errors)) {
			$_SESSION['errors'] = $errors;
			$_SESSION['values'] = array();
			$_SESSION['values']['un'] = $un;
			$_SESSION['values']['fname'] = $fname;
			$_SESSION['values']['lname'] = $lname;
			$_SESSION['values']['email'] = $email;
			header('Location: /?p=register');
			exit;
		} else { // If error free, process it
			$success = register($un, sha1($pw1.'mmmmsoysauce'), $fname, $lname, $email);
			// Check for success or failure and inform the client
			if ($success) {
				//setcookie('username', $un, time() + 3600 * 24, '/');
				$_SESSION['firstlogin'] = 1;
				header('Location: /');
				exit;
			} else {
				// TODO: fix how this works?
				$_SESSION['errors']['db'] = 'You could not be registered.  Try again or try a different username.';
				header('Location: /?p=register');
				exit;
			}
		}
	} elseif ($action == 'updateuser') {
		// Collect and sanitize the data
		$id = valNumber($_POST['id']);
		$un = valString($_POST['un']);
		$image = $_FILES['avatar'];
		$fname = valString($_POST['fname']);
		$lname = valString($_POST['lname']);
		$email = valEmail($_POST['email']);
		$page = valString($_POST['user']);
		// Validate the data
		$errors = array();
		if (empty($id) || empty($un) || empty($fname) || empty($lname) || empty($email) || empty($page))
			$errors['allFields'] = 'All fields are required.';
		// Check for validation errors, and send back if found
		if (!empty($errors)) {
			$_SESSION['errors'] = $errors;
			$_SESSION['values'] = array();
			$_SESSION['values']['un'] = $un;
			$_SESSION['values']['fname'] = $fname;
			$_SESSION['values']['lname'] = $lname;
			$_SESSION['values']['email'] = $email;
			header("Location: /?user=$page");
			exit;
		} else { // If error free, process it
			$success = updateUser($id, $un, $fname, $lname, $email);
			// Check for success or failure and inform the client
			if ($success) {
				$_SESSION['user']['un'] = $un;
				$_SESSION['user']['fname'] = $fname;
				$_SESSION['user']['lname'] = $lname;
				$_SESSION['user']['email'] = $email;
				$_SESSION['userupdated'] = 'User information has been updated.';
			} else
				$_SESSION['errors']['db'] = 1;
			if ($image['name']) {
				$filename = upload($id, $image);
				if ($filename) {
					updateAvatar($id, "/files/img/$id/$filename");
					$_SESSION['user']['avatar'] = "/files/img/$id/$filename";
				} else
					$_SESSION['errors']['image'] = 'Your user image was not updated.';
			}
			header("Location: /?user=$un");
			exit;
		}
	} elseif ($action == 'deleteuser') {
		if (!empty($_GET['id'])) {
			// Collect and sanitize the data
			$id = valNumber($_GET['id']);
			$success = deleteUser($id);
			// Check for success or failure and inform the client
			if ($success) {
				session_destroy();
				header('Location: /');
				exit;
			} else {
				$_SESSION['errors']['deleteuser'] = 'User account could not be deleted.';
				header('Location: /?user='.$_SESSION['user']['un']);
				exit;
			}
		} else {
			header('Location: /');
			exit;
		}
	} elseif ($action == 'addphoto') {
		// Collect and sanitize the data
		$photo = $_FILES['avatar'];
		// Validate the data
		$errors = array();
		if (empty($photo))
			$errors['nofile'] = 'Please select a file.';
		// Check for validation errors, and send back if found
		if (!empty($errors)) {
			$_SESSION['errors'] = $errors;
			header('Location: /?p=');
			exit;
		}
		
	} elseif ($action == 'newentry') {
		// Collect and sanitize the data
		$title = valString($_POST['title']);
		$content = ($_POST['html'] == 'html') ? valHTML($_POST['content']) : valString($_POST['content']);
		// Validate the data
		$errors = array();
		if (empty($title) || empty($content))
			$errors['allFields'] = 'All fields are required.';
		// Check for validation errors, and send back if found
		if (!empty($errors)) {
			$_SESSION['errors'] = $errors;
			$_SESSION['values'] = array();
			$_SESSION['values']['title'] = $title;
			$_SESSION['values']['content'] = $content;
			header('Location: /?p=newentry');
			exit;
		} else { // If error free, process it
			$success = newEntry($title, $content, $_SESSION['user']['id'], date('Y-m-d'));
			// Check for success or failure and inform the client
			if ($success) {
				header('Location: /');
				exit;
			} else {
				// TODO: fix how this works?
				$_SESSION['errors']['db'] = 1;
				header('Location: /?p=newentry');
				exit;
			}
		}
	} elseif ($action == 'deleteentry') {
		if (!empty($_GET['id'])) {
			// Collect and sanitize the data
			$id = valNumber($_GET['id']);
			$success = deleteEntry($id);
			// Check for success or failure and inform the client
			if ($success) {
				header('Location: /?p=archive');
				exit;
			} else {
				$_SESSION['errors']['deleteentry'] = 'Entry could not be deleted.';
				header("Location: /?entry=$id");
				exit;
			}
		} else {
			header('Location: /');
			exit;
		}
	} elseif ($action == 'newcomment') {
		// Collect and sanitize the data
		$id = valNumber($_POST['id']);
		$title = valString($_POST['title']);
		$content = valString($_POST['content']);
		// Validate the data
		$errors = array();
		if (empty($id) || empty($title) || empty($content))
			$errors['allFields'] = 'All fields are required.';
		// Check for validation errors, and send back in found
		if (!empty($errors)) {
			$_SESSION['errors'] = $errors;
			$_SESSION['values'] = array();
			$_SESSION['values']['title'] = $title;
			$_SESSION['values']['content'] = $content;
			header("Location: /?entry=$id");
			exit;
		} else { // If error free, process it
			$success = newComment($title, $content, $id, $_SESSION['user']['id'], date('Y-m-d H:i:s A'));
			// Check for success or failure and inform the client
			if ($success) {
				header("Location: /?entry=$id#bottom");
				exit;
			} else {
				$_SESSION['errors']['db'] = 'An error has occured.';
				header("Location /?entry=$id");
				exit;
			}
		}
	} elseif ($action == 'deletecomment') {
		if (!empty($_GET['entryId']) && !empty($_GET['commentId'])) {
			// Collect and sanitize the data
			$entryId = valNumber($_GET['entryId']);
			$commentId = valNumber($_GET['commentId']);
			$success = deleteComment($commentId);
			// Check for success or failure and inform the client
			if ($success) {
				header("Location: /?entry=$entryId");
				exit;
			} else {
				$_SESSION['errors']['deletecomment'] = 'Comment could not be deleted.';
				header("Location: /?entry=$entryId");
				exit;
			}
		} else {
			header('Location: /');
			exit;
		}
	} else {
		header('Location: /');
		exit;
	}
?>
