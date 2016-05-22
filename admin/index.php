<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	//include(INCLUDES . 'leftmenu.php');
?>







<TABLE width="780" cellspacing="0" cellpadding="0" border="0"align="center" bgcolor="#ffffff" valign='top'>

	<tr><td colspan="2">
		<p class="fronttitle">Administration Home Page</p>
		</td>
	</tr>
	<tr>
		<td class="textbox" width="50%">	
			<span class="frontsubtitle">Site Management</span><br>
			If this is a new site, start here by creating your Centers, Resources, Job Titles and Teams, as well as adding optional bits of information required for your reporting. If you would like a Google Map with the location of your center to be displayed on the front end, make sure you enter your Google Map Key here too.
		</td>
		<td class="textbox" valign="top">	
			<span class="frontsubtitle">Profile Management</span><br>
			Here you can add or remove Users, authorise Instructors and limit who registers on the site by email domain (eg: @domain.com).
		</td>
	</tr>
	<tr>
		<td class="textbox">
			<span class="frontsubtitle">Course Management</span><br />
			This section allows you to define your Courses, as well as grouping them in Course Categories and Course Types to help your users find the relevant course quicker.</td>
		<td class="textbox" valign="top">
			<span class="frontsubtitle">Reports</span><br />
			Finally, you can generate Reports to see how well your training is going.
		</td>
	</tr>
</table>
<!--MAIN TABLE ENDS HERE--->



</body>
</html>
<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
