<?php
/*
  CourseMS
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW" />

	<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> -->
	<link rel="stylesheet" href="../stylesheet.css" type="text/css">
	<script language="javascript" type="text/javascript" src="javascript/datetimepicker.js">
	<script language="javascript">
	<!--
	function open_new_window(url, window_name)
	{
		new_window = window.open(url, window_name,'toolbar=0,menubar=0,resizable=0,dependent=0,status=0,width=780,height=700,left=25,top=25')
	}


	function jumpto(x) {
		if (document.form1.jumpmenu.value != "null") {
			document.location.href = x;
		}
	}
	-->
	</script>



	<title>Course Reservations Management Service - Administration</title>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">