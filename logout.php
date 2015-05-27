<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	if (isset($_SESSION['learner'])) {
		unset($_SESSION['learner']);
		session_destroy();
		header("Location: login.php");
	}
	else
	{
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'leftmenu.php');
?>