				<?php
				$errors = $_SESSION['errors'];
				$values = $_SESSION['values'];
				?>
				<h1>New Entry</h1>
				<form action="/files/" class="centered" id="newentry" method="post">
					<label for="title">Title:</label>
					<input autocomplete="off" class="borderLight padding5 rounded" id="title" name="title" placeholder="Entry title" required type="text" <?php if ($values) echo 'value="'.$values['title'].'" ';?>/><br />
					<label for="content">Content:</label>
					<textarea class="borderLight padding5 rounded" id="content" name="content" placeholder="Enter entry contents here" required><?php echo $values['content'];?></textarea><br />
					<?php if ($user['rights'] >= 5) {?><label for="html">&nbsp;</label><input id="html" name="html" type="checkbox" value="html" /> Save as HTML<br /><?php }?>
					<input id="action" name="action" type="hidden" value="newentry" />
					<input class="gradientRed noBorder rounded textWhite" type="submit" value="Add Entry" /> <input class="gradientRed noBorder rounded textWhite" type="reset" value="Reset" />
				</form>
				<?php
				unset($_SESSION['errors']);
				unset($errors);
				unset($_SESSION['values']);
				unset($values);
				?>