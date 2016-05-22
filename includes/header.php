<?php

/*  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

//First check and redirect to the secure site
/*
$url=$_SERVER["SCRIPT_URI"];
$url_array=parse_url($url);

if($url_array["scheme"]!="https")
{
header("Location: https://$url_array[host]$url_array[path]");
}
*/
If (!isset($user) && !stristr($_SERVER['REQUEST_URI'],'login.php')  
					&& !stristr($_SERVER['REQUEST_URI'],'add_user.php')
					&& !stristr($_SERVER['REQUEST_URI'],'add_swb.php')
					&& !stristr($_SERVER['REQUEST_URI'],'choose_type.php')
					&& !stristr($_SERVER['REQUEST_URI'],'register_teamleader.php')
					 && !stristr($_SERVER['REQUEST_URI'],'forgotten_password.php')	
					 && !stristr($_SERVER['REQUEST_URI'],'display.php')	
					 && !stristr($_SERVER['REQUEST_URI'],'gallery.php')) { 	
		$user = $_SESSION['learner'];
		$user->set_profile();
	}
If ($_GET['access'] && !stristr($_SERVER['REQUEST_URI'],'login.php')) {
	tep_set_accessibility($user->id,$_GET['access']);
		$user = $_SESSION['learner'];
		$user->set_profile();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW" />
<?php If ($user->accessibility==1 or $_GET['access']=='true') Echo '<link rel="stylesheet" href="access.css" type="text/css">';
	Else Echo '<link rel="stylesheet" href="stylesheet.css" type="text/css">';
?>
	<script language="javascript" type="text/javascript" src="javascript/common.js"></script>

	<title>Course Reservations Management Service</title>
</head>



