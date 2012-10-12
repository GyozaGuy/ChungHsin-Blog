				<?php
				require_once($_SERVER['DOCUMENT_ROOT'].'/files/scrubber.php');
				?>
				<h1>Archive</h1>
				<?php
				$rs = $con->query("SELECT entry_title FROM $db.entries");
				if ($rs->num_rows > 0) {
					$perPage = 5;
					$numEntries = $rs->num_rows;
					$numPages = ceil($numEntries / $perPage);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $perPage;
					if ($numPages > 1 && $page <= $numPages) {
						echo '<div class="centered">Page: ';
						if ($page > 1)
							echo "<a href=\"/?p=archive&amp;page=".($page - 1)."\">&lt;</a> ";
						for ($i = 1; $i <= $numPages; $i++)
							echo ($page == $i) ? "<a class=\"curPage\" href=\"/?p=archive&amp;page=$i\">$i</a> " : "<a href=\"/?p=archive&amp;page=$i\">$i</a> ";
						if ($page < $numPages)
							echo "<a href=\"/?p=archive&amp;page=".($page + 1)."\">&gt;</a> ";
						echo '</div><br />';
					}
					$rs = $con->query("SELECT e.entry_id AS id, e.entry_title AS title, e.entry_content AS content, e.entry_postdate AS postdate, u.user_username AS username FROM $db.entries e INNER JOIN $db.users u ON e.user_id = u.user_id ORDER BY e.entry_id DESC LIMIT $start, $perPage;"); // , COUNT(c.comment_id) AS commentcount LEFT JOIN $db.comments c ON e.entry_id = c.entry_id
					while ($entry = $rs->fetch_assoc()) {
						$entry['content'] = valString($entry['content']);
						?>
						<div class="entryPreview">
							<h2><?php echo $entry['postdate'].' - ';?><a href="/?entry=<?php echo $entry['id'];?>"><?php echo $entry['title'];?></a></h2>
							<p class="entry"><?php if (strlen($entry['content']) > 500) { echo substr($entry['content'], 0, 500).'...';} else { echo $entry['content'];}?></p>
							<p class="floatRight">Posted by <a href="/?user=<?php echo $entry['username'];?>"><?php echo $entry['username'];?></a> | <a href="/?entry=<?php echo $entry['id'];?>#comments"><?php //echo $entry['commentcount'];?> Comments<?php //if ((int)$entry['commentcount'] != 1) echo 's';?></a><?php if ($user['rights'] >= 4) echo ' | <a href="/files/?action=deleteentry&id='.$entry['id'].'">Delete</a>';?></p><br /><br />
						</div>
						<?php
					}
					if ($numPages > 1 && $page <= $numPages) {
						echo '<br /><div class="centered">Page: ';
						if ($page > 1)
							echo "<a href=\"/?p=archive&amp;page=".($page - 1)."\">&lt;</a> ";
						for ($i = 1; $i <= $numPages; $i++)
							echo ($page == $i) ? "<a class=\"curPage\" href=\"/?p=archive&amp;page=$i\">$i</a> " : "<a href=\"/?p=archive&amp;page=$i\">$i</a> ";
						if ($page < $numPages)
							echo "<a href=\"/?p=archive&amp;page=".($page + 1)."\">&gt;</a> ";
						echo '</div>';
					}
				} else
					echo '<div class="centered">No blog entries could be found.</div>';
				?>