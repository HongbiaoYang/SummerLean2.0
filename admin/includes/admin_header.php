<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center">
		<tr>
			
			<td colspan='9' valign="top" width="450" BGCOLOR="#D0103A">
			<IMG src="../images/logo.png" align="right" style="position: relative; top: 0px;right: 0px;"></td>
		</tr>
	<!--NAVIGATION TABLE STARTS HERE -->
		<tr>
			<td class='navbar'>
				<a class='navbar' href="index.php">Home</a>
			</td>
			<td class='navbar'>
				<a class='navbar' href="site_admin.php">Site</a>
			</td>
			<td class='navbar'>
				<a class='navbar' href="user_admin.php">Profile</a>
			</td>
			<td class='navbar'>
						<A  class='navbar' href="course_admin.php">Course</a>
			</td>
			<td class='navbar'>
						<A  class='navbar' href="schedule_admin.php">Schedule</a>
			</td>

			<td class='navbar'>
						<A class='navbar' href="report_admin.php">Report</a>
			</td>
			<td class='navbar'>
				<a class='navbar' href="view_profile.php?id=<?php echo $_SESSION['admin_user']->id;?>">My account</a>
			</td>
			<td class='navbar'>
						<A class='navbar' href="update_password.php">Change Password</a>
			</td>
			<td class='navbar'>
						<a class='navbar' href="logout.php">Logout</a></td>
			</td>
		</tr>
	</TABLE>
