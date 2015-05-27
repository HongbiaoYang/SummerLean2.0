<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
?>
<tr>
			<td width = '15%' valign="top" class="borderTable">
				<table width = '100%'>
					<tr>
						<td><div id="sectionLinks"><a href="site_admin.php">Site Configuration</a></div></td>
					</tr>
					<tr>
						<td><div id="sectionLinks"><a href="course_admin.php">Courses</a></div></td>
					</tr>
					<tr>
						<td><div id="sectionLinks"><a href="schedule_admin.php">Scheduling</a></div></td>
					</tr>
					<tr>
						<td><div id="sectionLinks"><a href="user_admin.php">Users</a></div></td>
					</tr>
					<?php
					if (isset($_SESSION['admin_user'])) {
					?>
						<tr>
							<td><div id="sectionLinks"><a href="logout.php">Logout</a></div></td>
						</tr>
					<?php
					}
					else
					{
					?>
						<tr>
							<td><div id="sectionLinks"><a href="login.php">Login</a></div></td>
						</tr>
					<?php
					}
					?>
						

				</table>
			</td>
			<td width = '70%' valign="top">