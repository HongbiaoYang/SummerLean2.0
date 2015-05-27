<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/


	function tep_logged_in() {
		if (isset($_SESSION['admin_user']))
			return true;
		else
			return false;
	}


?>