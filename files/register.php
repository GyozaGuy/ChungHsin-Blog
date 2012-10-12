				<?php
				$errors = $_SESSION['errors'];
				$values = $_SESSION['values'];
				?>
				<h1>Register</h1>
				<form action="/files/" class="centered" id="register" method="post">
					<?php if ($errors['empty']) echo '<span class="error">All fields are required.</span><br />';?>
					<?php if ($errors['db']) echo '<span class="error">'.$errors['db'].'</span><br />';?>
					<label for="un">Username:</label>
					<input class="borderLight padding5 rounded" id="un" name="un" placeholder="Username" required type="text" <?php if ($values) echo 'value="'.$values['un'].'" ';?>/><br />
					<label for="pw1">Password:</label>
					<input class="borderLight padding5 rounded" id="pw1" name="pw1" placeholder="Password" required type="password" /><br />
					<label for="pw2">Retype Password:</label>
					<input class="borderLight padding5 rounded" id="pw2" name="pw2" placeholder="Retype Password" required type="password" /><br />
					<label for="fname">First Name:</label>
					<input class="borderLight padding5 rounded" id="fname" name="fname" placeholder="First Name" required type="text" <?php if ($values) echo 'value="'.$values['fname'].'" ';?>/><br />
					<label for="lname">Last Name:</label>
					<input class="borderLight padding5 rounded" id="lname" name="lname" placeholder="Last Name" required type="text" <?php if ($values) echo 'value="'.$values['lname'].'" ';?>/><br />
					<label for="email">E-mail:</label>
					<input class="borderLight padding5 rounded" id="email" name="email" placeholder="E-mail" required type="email" <?php if ($values) echo 'value="'.$values['email'].'" ';?>/><br />
					<input id="action" name="action" type="hidden" value="register" />
					<input class="gradientRed noBorder rounded textWhite" type="submit" value="Register" /> <input class="gradientRed noBorder rounded textWhite" type="reset" value="Reset" />
				</form>
				<?php
				unset($_SESSION['errors']);
				unset($errors);
				unset($_SESSION['values']);
				unset($values);
				?>
