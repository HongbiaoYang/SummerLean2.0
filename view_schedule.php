<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	// page to display schedule
	$access_level = '3';
	$access_error = false;
	include('includes/application_top.php');
	if (!isset($_SESSION['learner'])) {
		header("Location: login.php");
	}
	$user = $_SESSION['learner'];
  $user->set_profile();

	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');

?>

<p class="center">
	<b>Updated Schedule of Second Harvest Visit,Course and Y-12 Visit. Download <a href="files/Week2.pdf"> <span class="auto-style7">HERE</span></a></b><br> 
	You can<a href="files/LESP_Schedule2016.ics"> <span class="auto-style7">download</span></a> and 
	<a href="https://commons.lbl.gov/display/google/Exporting+and+Importing+Calendars+from+Other+Google+Accounts#ExportingandImportingCalendarsfromOtherGoogleAccounts-HowtoImportintoGoogleCalendar" target="_blank">import</a> 
	the calendar into your own calendar (Google / Outlook). <br>Also, you can just click the button 
	<img alt="Click this button in the right bottom corner" " src="images/button.png"  > 
	in the right bottom of the calendar.
	<br>
	A print friendly version is also available for <a href="files/Calendar_Schedule_2016.pdf" target="_blank">download</a>.
	</p>


<h2 class="center">	
	<iframe src="https://www.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=pbuh6jrv8330uqpso9gupjlcng%40group.calendar.google.com&amp;color=%23B1440E&amp;ctz=America%2FNew_York" style=" border:solid 1px #777 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
	</h2>
<?php


	
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
