<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

?>
	<TABLE width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr>
			<td valign="top" width = "430"><IMG src="images/topbar.gif" width="100%" height="30"></td>
			<td valign="top" width="350" Align="right" BGCOLOR="#38a1ec">
				<TABLE width="350" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td colspan="2"><IMG src="images/slash.gif"></td>
						<td><a class="up" href="view_profile.php?id=<?php echo $_SESSION['admin_user']->id;?>">My account</a>&nbsp;&nbsp;|&nbsp;&nbsp;<A class=up href="update_password.php">Update Login Credentials</a>&nbsp;&nbsp;|
						&nbsp;&nbsp;<a class=up href="logout.php">Logout</a>   </td>
					</tr>
				</TABLE>
			</td>
		</tr>
		<tr>
			<td valign="center" width="493" BGCOLOR="#ffffff"><IMG src="images/ccp_header_logo.gif" width="300px" height="80px"></td>
			<td valign="top" width="287" Align="right" BGCOLOR="#ffffff"><IMG src="images/cw_header_logo.gif" width="287" height="45"></td>
		</tr>
		<tr>
			<td valign="top" align="left" BGCOLOR="#ffffff" width="50%">
				&nbsp;&nbsp;&nbsp;&nbsp;<form name="form1">
					<select name="jumpmenu" onChange="jumpto(document.form1.jumpmenu.options[document.form1.jumpmenu.options.selectedIndex].value)">
						<option>Go To..</option>
						<option value = "add_user.php">Add User</option>
						<option value = "select_course.php">Schedule Course</option>
						<option value = "view_schedule.php">View Schedule</option>
						<option value = "view_instructor_schedule.php">View Instructor Schedule</option>
					</select>
				</form>
			</td>
			<td valign="top" align="right" BGCOLOR="#ffffff"><IMG src="images/admin-in.gif"></td>
		</tr>
	</TABLE>
	<!--NAVIGATION TABLE STARTS HERE -->
	<TABLE width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr>
			<td><IMG src="images/navbar.gif" width="100%"></td>
		</tr>
		<tr>
			<td BACKGROUND="images/nav.gif" height="24" valign="middle">
			&nbsp;&nbsp;<a href="site_admin.php">Site Management</a>&nbsp;&nbsp;|
			&nbsp;&nbsp;<a href="user_admin.php">Profile Management</a>&nbsp;&nbsp;|
			&nbsp;&nbsp;<a href="course_admin.php">Course Management</a>&nbsp;&nbsp;|
			&nbsp;&nbsp;<a href="schedule_admin.php">Schedule Management</a>&nbsp;&nbsp;|
			&nbsp;&nbsp;<a href="surveys.php">Surveys</a>&nbsp;&nbsp;|
			&nbsp;&nbsp;<a href="report_admin.php">Report</a>
			</td>
		</tr>
		<tr>
			<td><IMG src="images/navbar2.gif" width="100%"></td>
		</tr>
	</TABLE><!--NAVIGATION TABLE ENDS HERE -->