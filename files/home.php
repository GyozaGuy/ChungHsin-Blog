				<?php
				if ($_SESSION['firstlogin']) {
					echo '<h1>Thank you for registering!  Now please log in!</h1>';
					unset($_SESSION['firstlogin']);
				}
				?>
				<h1><?php echo $text['home_title'];?></h1>
				<p>
					<?php echo $text['home_desc'];?>
				</p>
				<?php
				$lastEntry = getLatestEntry();
				if (!empty($lastEntry['id'])) {
					echo '<h2><a href="/?entry='.$lastEntry['id'].'">'.$lastEntry['title'].'</a></h2>';
					echo '<h3>'.$lastEntry['postdate'].'</h3>';
					echo '<p class="entry">'.$lastEntry['content'].'</p>';
					echo '<p class="floatRight">Posted by <a href="/?user='.$lastEntry['username'].'">'.$lastEntry['username'].'</a> | <a href="/?entry='.$lastEntry['id'].'#comments">'.$lastEntry['commentcount'].' Comment';
					if ((int)$lastEntry['commentcount'] != 1)
						echo 's';
					echo '</a>';
					if ($user['rights'] >= 4)
						echo ' | <a href="/files/?action=deleteentry&id='.$lastEntry['id'].'">'.$text['delete'].'</a>';
					echo '</p><br /><br />';
				} else
					echo '<div class="centered">'.$text['noentries'].'.</div>';
				?>
