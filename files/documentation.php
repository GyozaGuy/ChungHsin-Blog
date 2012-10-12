				<h1>Documentation</h1>
				<ul>
					<li><b>Feedback Mechanism</b>
						<p>
							To solve this problem, I created a new table in my database with the following specification:
						</p>
						<table style="background:#EEE;border:1px solid #000;width:600px;">
							<tr style="text-align:left;">
								<th>Column</th><th>Type</th><th>Null</th><th>Default</th><th>Other</th>
							</tr>
							<tr>
								<td>comment_id</td><td>int(11)</td><td>No</td><td>None</td><td>AUTO_INCREMENT/PRIMARY</td>
							</tr>
							<tr>
								<td>comment_title</td><td>varchar(50)</td><td>No</td><td>None</td><td>&nbsp;</td>
							</tr>
							<tr>
								<td>comment_content</td><td>varchar(500)</td><td>No</td><td>None</td><td>&nbsp;</td>
							</tr>
							<tr>
								<td>entry_id</td><td>int(11)</td><td>No</td><td>None</td><td>&nbsp;</td>
							</tr>
							<tr>
								<td>user_id</td><td>int(11)</td><td>No</td><td>None</td><td>&nbsp;</td>
							</tr>
							<tr>
								<td>comment_postdate</td><td>datetime</td><td>No</td><td>None</td><td>&nbsp;</td>
							</tr>
							<tr>
								<td>comment_editdate</td><td>timestamp</td><td>Yes</td><td>NULL</td><td>&nbsp;</td>
							</tr>
						</table>
						<p>
							The columns "entry_id" and "user_id" are foreign keys that link to the "entries" and "users" tables.
						</p>
						<p>
							When a user is logged in, they may post a comment on a blog entry.
							The comments that already exist are always visible.
							The add comment form is styled similar to the posted comments, and is located above the rest of the comments.
						</p>
						<p>
							Eventually users will be able to edit and delete their own comments, but currently only administrators can do that.
							The "content_editdate" field will be updated when a comment is edited, and there will be an indication that a comment was edited in the comment box visible to the user.
						</p>
						<p>
							Additionally, pagination is implemented for all comments, displaying 10 comments per page.
						</p>
					</li>
					<li><b>Search Capability</b>
						<p>
							I wanted the search box to look clean, so I hid the submit button.
							I will probably show it again in the future, but for now the search feature works when the user presses the "enter" key.
						</p>
						<p>
							The search function searches in the "entries" table, particularly in the "entry_content" field, using the provided search string and wildcards.
							The "entry_content" field has a "FULLTEXT" index applied to it.
							In the future I plan to expand the functionality of the search function to also return results from the comments for each entry.
						</p>
						<p>
							When viewing the search results, the search box displays the search string.
							In the future, I may add an additional larger search box directly above the search results.
						</p>
					</li>
				</ul>