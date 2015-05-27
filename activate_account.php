<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/



	include('includes/application_top.php');


	if (isset($_GET['activate'])) {
		//validate and record
		If (md5($_GET['email'].RANDOM_STRING)!=$_GET['security']) $errors[0]="Invalid hash.";


		if (!$errors[0]) {

			//lets fill database with user
			tep_activate_account($_GET['email']);
			$email = $_GET['email'];
			$_SESSION['learner'] = new user($_GET['email']);
			$user = $_SESSION['learner'];
			$user->set_profile();
			header("Location: index.php");
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
	}


	//include(INCLUDES . 'front_header.php');
	//include(INCLUDES . 'leftmenu.php');
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
							<?php
							if ($errors[0]) {
							?>
							<tr>
								<td>
									<span class="required">The following errors has occured:
									<?php echo $errors[1]; ?></span>
								</td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td>You have successfully activated your account. Please login to your account <a href="login.php">here</a>.</td>
							</tr>
							<?php 
							}
							?>
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
