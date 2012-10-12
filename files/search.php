				<h1>Search Results</h1>
				<?php
				if (!empty($_GET['search'])) {
					$query = $_GET['search'];
					$matches = getMatches($query);
					if (!empty($matches)) {
						$perPage = 5;
						$numMatches = count($matches);
						$numPages = ceil($numMatches / $perPage);
						$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
						$start = ($page - 1) * $perPage;
						if ($numPages > 1 && $page <= $numPages) {
							echo '<div class="centered">Page: ';
							if ($page > 1)
								echo "<a href=\"/?search=$query&amp;page=".($page - 1)."\">&lt;</a> ";
							for ($i = 1; $i <= $numPages; $i++)
								echo ($page == $i) ? "<a class=\"curPage\" href=\"/?search=$query&amp;page=$i\">$i</a> " : "<a href=\"/?search=$query&amp;page=$i\">$i</a> ";
							if ($page < $numPages)
								echo "<a href=\"/?search=$query&amp;page=".($page + 1)."\">&gt;</a> ";
							echo '</div><br />';
						}
						$finish = $start + $perPage;
						//$finish = ($start + (count($matches) - $page * $perPage)) + $perPage;
						//$finish = $page * $perPage;
						//$finish = $start + ($perPage - (count($matches) - $perPage));
						for ($i = $start; $i < $finish; $i++) {
							if (!empty($matches[$i])) {
								?>
								<h3><?php echo $matches[$i]['postdate'].' - ';?><a href="/?entry=<?php echo $matches[$i]['id'];?>"><?php echo $matches[$i]['title'];?></a></h3>
								<p><?php if (strlen($matches[$i]['content']) > 100) { echo substr($matches[$i]['content'], 0, 100).'...';} else { echo $matches[$i]['content'];}?></p>
								<?php
							}
						}
						if ($numPages > 1 && $page <= $numPages) {
							echo '<div class="centered">Page: ';
							if ($page > 1)
								echo "<a href=\"/?search=$query&amp;page=".($page - 1)."\">&lt;</a> ";
							for ($i = 1; $i <= $numPages; $i++)
								echo ($page == $i) ? "<a class=\"curPage\" href=\"/?search=$query&amp;page=$i\">$i</a> " : "<a href=\"/?search=$query&amp;page=$i\">$i</a> ";
							if ($page < $numPages)
								echo "<a href=\"/?search=$query&amp;page=".($page + 1)."\">&gt;</a> ";
							echo '</div><br />';
						}
					} else
						echo '<div class="centered">Your search returned no results.</div>';
				} else {
					header('Location: /');
					exit;
				}
				?>