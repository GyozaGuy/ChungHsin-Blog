				<?php
				if (!empty($_GET['user'])) {
					if ($_GET['user'] == $user['id'])
						$userInfo = $user;
					else
						$userInfo = getUser($_GET['user']);
					if (!empty($userInfo['id'])) {
						$errors = $_SESSION['errors'];
						if ($userInfo['id'] == $user['id']) {
							echo '<form action="/files/" enctype="multipart/form-data" method="post">';
							echo '<input id="id" name="id" type="hidden" value="'.$userInfo['id'].'" />';
						}
						if ($_SESSION['userupdated'])
							echo '<div class="centered textBlue">'.$_SESSION['userupdated'].'</div>';
						?>
						<?php
						echo ($userInfo['id'] == $user['id']) ? '<div><b>Username:</b> <input class="borderLight padding5 rounded" id="un" name="un" placeholder="Username" required type="text" value="' : '<h1>';
						echo $userInfo['un'];
						echo ($userInfo['id'] == $user['id']) ? '" /></div>' : '</h1>';
						?>
						<img alt="<?php echo $userInfo['username'];?>'s Avatar" class="avatar" src="<?php echo $userInfo['avatar'];?>" /><br />
						<?php if ($userInfo['id'] == $user['id']) echo '<b>User Image:</b> <input id="avatar" name="avatar" type="file" /><br />';?>
						<b>First Name:</b> <?php if ($userInfo['id'] == $user['id']) { echo '<input class="borderLight padding5 rounded" id="fname" name="fname" placeholder="First Name" required type="text" value="';} echo $userInfo['fname']; if ($userInfo['id'] == $user['id']) { echo '" />';}?><br />
						<b>Last Name:</b> <?php if ($userInfo['id'] == $user['id']) { echo '<input class="borderLight padding5 rounded" id="lname" name="lname" placeholder="Last Name" required type="text" value="';} echo $userInfo['lname']; if ($userInfo['id'] == $user['id']) { echo '" />';}?><br />
						<?php if ($userInfo['id'] == $user['id']) { echo '<b>E-mail:</b> <input class="borderLight padding5 rounded" id="email" name="email" placeholder="E-mail" required type="email" value="'.$userInfo['email'].'" /><br />';}?>
						<!--<b>Entries:</b> <?php echo $userInfo['entrycount'];?><br />-->
						<b>Comments:</b> <?php echo $userInfo['commentcount'];?>
						<?php
						if ($userInfo['id'] == $user['id']) {
							echo '<input id="action" name="action" type="hidden" value="updateuser" />';
							echo '<input id="user" name="user" type="hidden" value="'.$_GET['user'].'" />';
							echo '<div class="centered">'.$errors['allFields'].'<br /><input class="gradientRed noBorder rounded" type="submit" value="Save" /> <input class="gradientRed noBorder rounded" type="reset" value="Reset" /><br /><a alt="Delete Account" class="textRed" href="/?deleteuser='.$userInfo['id'].'">Delete Account</a></div>';
							echo '</form>';
						}
					} else {
						header('Location: /');
						exit;
					}
				} else {
					header('Location: /');
					exit;
				}
				unset($_SESSION['errors']);
				unset($errors);
				unset($_SESSION['userupdated']);
				?>
