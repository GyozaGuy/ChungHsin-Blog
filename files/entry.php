				<?php
				if (!empty($_GET['entry'])) {
					$entryId = $_GET['entry'];
					$entry = getEntry($entryId);
					if (!empty($entry)) {
						if ($_SESSION['errors']['deleteentry'])
							echo '<div class="centered textRed">'.$_SESSION['errors']['deleteentry'].'</div>';
						?>
						<h1><?php echo $entry['title'];?></h1>
						<h3><?php echo $entry['postdate'];?></h3>
						<p class="entry"><?php echo $entry['content'];?></p>
						<p class="floatRight">Posted by <a href="/?user=<?php echo $entry['username'];?>"><?php echo $entry['username'];?></a><?php if ($user['rights'] >= 4) echo ' | <a href="/files/?action=deleteentry&id='.$entry['id'].'">Delete</a>';?></p><br /><br />
						<a name="comments"></a>
						<h2>Comments</h2>
						<div class="rounded" id="comments">
							<?php
							$comments = getComments($entryId);
							if (!empty($comments)) {
								$perPage = 10;
								$numComments = count($comments);
								$numPages = ceil($numComments / $perPage);
								$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
								$start = ($page - 1) * $perPage;
								if ($numPages > 1 && $page <= $numPages) {
									echo '<br /><div class="centered textWhite">Page: ';
									if ($page > 1)
										echo "<a href=\"/?entry=$entryId&amp;page=".($page - 1)."#comments\">&lt;</a> ";
									for ($i = 1; $i <= $numPages; $i++)
										echo ($page == $i) ? "<a class=\"curPage\" href=\"/?entry=$entryId&amp;page=$i#comments\">$i</a> " : "<a href=\"/?entry=$entryId&amp;page=$i#comments\">$i</a> ";
									if ($page < $numPages)
										echo "<a href=\"/?entry=$entryId&amp;page=".($page + 1)."#comments\">&gt;</a> ";
									echo '</div><br />';
								}
								$finish = $start + $perPage;
								for ($i = $start; $i < $finish; $i++) {
									if (!empty($comments[$i])) {
										?>
										<div class="comment padding5">
											<div class="padding5 textWhite userInfo">
												<img alt="<?php echo $comments[$i]['un'];?>'s Avatar" src="<?php echo $comments[$i]['avatar'];?>" /><br />
												<a href="/?user=<?php echo $comments[$i]['un'];?>"><?php echo $comments[$i]['un'];?></a><br />
												Posted <?php echo $comments[$i]['postdate'];?>
											</div>
											<div class="content padding5 rounded">
												<b><?php echo $comments[$i]['title'];?></b><br /><br />
												<?php echo $comments[$i]['content'];?>
											</div>
										</div>
										<?php
										if ($user['rights'] >= 3) {
											echo '<div class="floatRight padding5"><a class="textRed" href="/?deletecomment='.$comments[$i]['id'].'&amp;entryId='.$entry['id'].'">Delete Comment</a></div><br /><br />';
										}
									}
								}
								if ($numPages > 1 && $page <= $numPages) {
									echo '<br /><div class="centered textWhite">Page: ';
									if ($page > 1)
										echo "<a href=\"/?entry=$entryId&amp;page=".($page - 1)."#comments\">&lt;</a> ";
									for ($i = 1; $i <= $numPages; $i++)
										echo ($page == $i) ? "<a class=\"curPage\" href=\"/?entry=$entryId&amp;page=$i#comments\">$i</a> " : "<a href=\"/?entry=$entryId&amp;page=$i#comments\">$i</a> ";
									if ($page < $numPages)
										echo "<a href=\"/?entry=$entryId&amp;page=".($page + 1)."#comments\">&gt;</a> ";
									echo '</div><br />';
								}
							} else
								echo '<div class="centered comment padding5 textWhite">There are no comments.</div>';
							if (!empty($user)) {
								?>
								<div class="comment padding5">
									<div class="padding5 textWhite userInfo">
										<img alt="<?php echo $user['un'];?>'s Avatar" src="<?php echo $user['avatar'];?>" /><br />
										<a href="/?user=<?php echo $user['un'];?>"><?php echo $user['un'];?></a>
									</div>
									<form action="/files/" class="alignTop noMargin noPadding tableCell" id="commentForm" method="post" name="commentForm">
										<div class="floatRight"><input class="gradientRed noBorder rounded" type="submit" value="Add Comment" /> <input class="gradientRed noBorder rounded" type="reset" value="Reset" /></div>
										<input id="id" name="id" type="hidden" value="<?php echo $entry['id'];?>" />
										<input autocomplete="off" class="borderSimple padding5 rounded" id="title" name="title" placeholder="Comment Title" required type="text" /><br />
										<textarea class="borderSimple padding5 rounded" id="content" maxlength="500" name="content" placeholder="Enter your comment here..." required></textarea><br />
										<input id="action" name="action" type="hidden" value="newcomment" />
									</form>
								</div>
								<?php
							}
							?>
							<a name="bottom"></a>
						</div>
						<?php
					} else {
						echo 'An error has occurred.';
					}
				} else {
					header('Location: /');
					exit;
				}
				unset($_SESSION['errors']);
				?>
