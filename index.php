<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	if (!isset($_SESSION['learner'])) {
		header("Location: login.php");
	}
	// template for page build

	include(INCLUDES . 'header.php');
	//include(INCLUDES . 'leftmenu.php');
	include(INCLUDES . 'front_header.php');
?>


<!--MAIN TABLE STARTS HERE--->
<TABLE width="780" cellspacing="0" cellpadding="0" border="0"align="center" bgcolor="#ffffff" valign='top'>

	<tr><td colspan="2">
		<p class="fronttitle">Welcome to your home page</p>
		</td>
	</tr>
	<tr>
	    
	    
		<td class="textbox" width="50%">	
			<span class="frontsubtitle">View Schedules</span><br>
			From here, you can <a href="view_schedule.php">view the scheduled courses</a>, to see all the courses assigned to you and their available dates. This should be your starting point for enrolling yourself on your assigned courses.
		</td>

		
		<!--
		<td class="textbox" width="50%">	
			<span class="frontsubtitle">Your Courses</span><br>
			In the top menubar is the link to <a href="view_my_courses.php">My Courses</a> which will give you a list of all the courses you have been enrolled on, and the outstanding courses you still need to complete. There is a link at the top of this page to print it for your reference.
		</td>
		-->
		
		<td class="textbox">
			<span class="frontsubtitle">My Details</span><br />
			You can update your details at any time by visiting the	<a href="view_profile.php">My Details</a> page.
		</td>

    </tr>

    <!--
    <tr>
			
		<td class="textbox">
			<span class="frontsubtitle">My Trips</span><br />
			You can check your trip information at any time by visiting the	<a href="view_projects.php">View Trips</a> page.
		</td>
	</tr>
		-->
</table>
<!--MAIN TABLE ENDS HERE--->



</body>
</html>
<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

