<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/files/db.php';
	// Load navigation items
	function getNavItems() {
		global $con;
		global $db;
		$rs = $con->query("SELECT nav_item, nav_href FROM $db.nav;");
		if ($rs->num_rows > 0) {
			$navItems = array();
			while ($row = $rs->fetch_assoc()) {
				$navItems[] = $row;
			}
			return $navItems;
		} else
			return 0;
	}
	// Get latest entry
	function getLatestEntry() {
		global $con;
		global $db;
		$rs = $con->query("SELECT e.entry_id AS id, e.entry_title AS title, e.entry_image AS image, e.entry_content AS content, e.entry_postdate AS postdate, u.user_username AS username, COUNT(c.comment_id) AS commentcount FROM $db.entries e INNER JOIN $db.users u ON e.user_id = u.user_id LEFT JOIN $db.comments c ON e.entry_id = c.entry_id WHERE e.entry_id = (SELECT MAX(entry_id) FROM $db.entries);");
		if ($rs->num_rows > 0) {
			$entry = array();
			$entry = $rs->fetch_assoc();
			return $entry;
		} else
			return 0;
	}
	// Get specified entry
	function getEntry($id) {
		global $con;
		global $db;
		$rs = $con->query("SELECT e.entry_id AS id, e.entry_title AS title, e.entry_image AS image, e.entry_content AS content, u.user_username AS username, e.entry_postdate AS postdate FROM $db.entries e INNER JOIN $db.users u ON e.user_id = u.user_id WHERE e.entry_id = $id;");
		if ($rs->num_rows > 0) {
			$entry = array();
			$entry = $rs->fetch_assoc();
			return $entry;
		} else
			return 0;
	}
	function newEntry($title, $content, $id, $date) {
		global $con;
		global $db;
		// Prepared statement starts here
		$sql = "INSERT INTO $db.entries (entry_title, entry_content, user_id, entry_postdate) VALUES (?, ?, ?, ?);";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('ssis', $title, $content, $id, $date);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Delete specified entry
	function deleteEntry($id) {
		global $con;
		global $db;
		$sql = "DELETE FROM $db.entries WHERE entry_id = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Get comments for specified entry
	function getComments($id) {
		global $con;
		global $db;
		$rs = $con->query("SELECT c.comment_id AS id, c.comment_title AS title, c.comment_content AS content, u.user_username AS un, u.user_avatar AS avatar, c.comment_postdate AS postdate FROM $db.comments c INNER JOIN $db.users u ON c.user_id = u.user_id WHERE c.entry_id = $id ORDER BY c.comment_id ASC;");
		if ($rs->num_rows > 0) {
			$comments = array();
			while ($comment = $rs->fetch_assoc())
				$comments[] = $comment;
			return $comments;
		} else
			return 0;
	}
	// Add comment to specified entry
	function newComment($title, $content, $entryId, $userId, $date) {
		global $con;
		global $db;
		$sql = "INSERT INTO $db.comments (comment_title, comment_content, entry_id, user_id, comment_postdate) VALUES (?, ?, ?, ?, ?);";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('ssiis', $title, $content, $entryId, $userId, $date);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Deletes a specified comment
	function deleteComment($id) {
		global $con;
		global $db;
		$sql = "DELETE FROM $db.comments WHERE comment_id = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Return matches for a specified search query
	function getMatches($query) {
		global $con;
		global $db;
		$rs = $con->query("SELECT entry_id AS id, entry_title AS title, entry_content AS content, entry_postdate AS postdate FROM $db.entries WHERE entry_content LIKE ('%$query%') ORDER BY entry_id DESC;");
		if ($rs->num_rows > 0) {
			$matches = array();
			while ($match = $rs->fetch_assoc())
				$matches[] = $match;
			return $matches;
		} else
			return 0;
	}
	// Get information for specified user
	function getUser($un) {
		global $con;
		global $db;
		$sql = "SELECT u.user_id, u.user_fname, u.user_lname, u.user_email, u.user_avatar, COUNT(c.comment_id) AS commentcount FROM $db.users u LEFT JOIN $db.comments c ON u.user_id = c.user_id WHERE user_username = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('s', $un);
			$stmt->execute();
			$stmt->bind_result($id, $fname, $lname, $email, $avatar, $commentcount);
			$user = array();
			$stmt->fetch();
			$user['id'] = $id;
			$user['un'] = $un;
			$user['fname'] = $fname;
			$user['lname'] = $lname;
			$user['email'] = $email;
			$user['avatar'] = $avatar;
			$user['commentcount'] = $commentcount;
			$stmt->close();
		}
		if (!empty($user))
			return $user;
		else
			return 0;
	}
	// Update user information
	function updateUser($id, $un, $fname, $lname, $email) {
		global $con;
		global $db;
		$sql = "UPDATE $db.users SET user_username = ?, user_fname = ?, user_lname = ?, user_email = ? WHERE user_id = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('ssssi', $un, $fname, $lname, $email, $id);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Update user image
	function updateAvatar($id, $image) {
		global $con;
		global $db;
		$sql = "UPDATE $db.users SET user_avatar = ? WHERE user_id = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('si', $image, $id);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Delete user information
	function deleteUser($id) {
		global $con;
		global $db;
		$sql = "DELETE FROM $db.users WHERE user_id = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
		}
		return wrapUp($rowschanged);
	}
	// Login user
	function login($un, $pw) {
		global $con;
		global $db;
		$sql = "SELECT user_id, user_fname, user_lname, user_email, user_avatar, user_rights FROM $db.users WHERE user_username = ? AND user_password = ?;";
		if ($stmt = $con->prepare($sql)) {
			$stmt->bind_param('ss', $un, $pw);
			$stmt->execute();
			$stmt->bind_result($id, $fname, $lname, $email, $avatar, $rights);
			$user = array();
			$stmt->fetch();
			$user['id'] = $id;
			$user['un'] = $un;
			$user['fname'] = $fname;
			$user['lname'] = $lname;
			$user['email'] = $email;
			$user['avatar'] = $avatar;
			$user['rights'] = $rights;
			$stmt->close();
		}
		if (!empty($user))
			return $user;
		else
			return 0;
	}
	function register($un, $pw, $fname, $lname, $email) {
        global $con;
		global $db;
        // Prepared statement starts here
        $sql = "INSERT INTO $db.users (user_username, user_password, user_fname, user_lname, user_email) VALUES (?, ?, ?, ?, ?);";
		if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param('sssss', $un, $pw, $fname, $lname, $email);
            $stmt->execute();
			$rowschanged = $con->affected_rows;
			$stmt->close();
        }
		return wrapUp($rowschanged);
    }
	function wrapUp($rowschanged) {
		if ($rowschanged == 1)
            return 1;
        else
            return 0;
	}
?>
