<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	$to = $_GET['username'];
    $subject = "Account Activation";

    //begin of HTML message
    $message = "<html>
  <body bgcolor=\"#DCEEFC\">
  		Dear ".$_GET['title']." ".$_GET['first']." ".$_GET['last'].",<br><br>
        You have been sent this email to confirm your identity. To activate your account, please click on this <a href=\"".HTTP_SERVER."/activate_account.php?email=$to&activate=1&security=".md5($_GET['username'].RANDOM_STRING)."\">link</a>.<br><br>
      <br><br>".SIGNATURE."
  </body>
</html>";
   //end of message
	// $to="jacques.malan@gmail.com";
    If (!tep_email($to,$subject,$message)) $error="Email sending failed. Please contact the administrator.";
?>
<html>
<head>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW" />
	<link rel="stylesheet" href="access.css" type="text/css">
	
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
	<script language="javascript" type="text/javascript" src="javascript/datetimepicker.js">-->
	<title>Course Reservations Management Service</title>
</head>
<body>
<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" height="100%">
		<tr>
			<td valign="TOP">
			<TABLE width="800" cellspacing="0" cellpadding="0" border="0" align="center">

				<tr>
					<td valign="top"><img src="images/logo.png"></td>
					<td valign="top" align='left'>
						<TABLE width="400" cellspacing="0" cellpadding="0" border="0" align="center">
							<tr>
								<td>An email has been sent to your registered email account to confirm your identity. To activate your account, please click on the link provided in the email.</td>
							
							</tr>
							<tr>
								<?php echo $message; ?>
							</tr>
						</TABLE>

					</td>
				</tr>
			</TABLE>
		</td></tr>
			<br><br><br><br>
	</body>

</html>
<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

