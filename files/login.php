				<?php
				$errors = $_SESSION['errors'];
				?>
				<h1>Login</h1>
				<form action="/files/" class="centered" id="login" method="post">
					<?php if ($errors['empty']) echo '<span class="error">All fields are required.</span><br />';?>
					<?php if ($errors['db']) echo '<span class="error">You could not be logged in.</span><br />';?>
					<label for="un">Username:</label>
					<input class="borderLight padding5 rounded" id="un" name="un" placeholder="Username" required type="text" /><br />
					<label for="pw">Password:</label>
					<input class="borderLight padding5 rounded" id="pw" name="pw" placeholder="Password" required type="password" /><br />
					<input id="action" name="action" type="hidden" value="login" />
					<input class="gradientRed noBorder rounded textWhite" type="submit" value="Login" /> <input class="gradientRed noBorder rounded textWhite" type="reset" value="Reset" />
				</form>
				<?php
				unset($_SESSION['errors']);
				unset($errors);
				?>
