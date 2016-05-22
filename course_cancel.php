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
	$user = $_SESSION['learner'];
	$user->set_profile();
	if (isset($_GET['id'])) {
			$sql_array = array('calendar_id' => $_SESSION['course']->calendar_id,
					   'user_id' => $user->id,
					   'status' => $status,
					   'cDate' => date('Y-m-d H:i:s'),
					   'mDate' => date('Y-m-d H:i:s'));
			$query="delete from registrations where user_id=".$user->id.
					" and calendar_id=".$_GET['id'];
//			Echo $query;
			tep_db_query($query);
		header("Location: view_my_courses.php");
		}			   

?>
