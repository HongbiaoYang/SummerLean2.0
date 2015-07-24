<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	$error = false;
	$changed=false;
	if (isset($_SESSION['learner'])) {
//		header("Location: index.php");
	}
	if (isset($_POST['email'])) {
		$user_id=tep_db_query("select id from users where username='".$_POST['email']."'");
		$stu_index = tep_db_query("select stuindex from tbl_students where email='".$_POST['email']."' and lastname = '".$_POST['lastname']."'");
		$team_index = tep_db_query("select user_id from tbl_teamleaders where email='".$_POST['email']."' and lastname = '".$_POST['lastname']."'");
		
		if (mysql_num_rows($user_id)==0) {
			$error="Unknown email address.";
		} else if (mysql_num_rows($stu_index) == 0 && mysql_num_rows($team_index) == 0) {
		    

			
		    $error = "Email / Last name mismatch";
		}
		else {
			// $random=createRandomPassword(10);
						    
		  $word = tep_get_name_pro(TABLE_USERS, 'username', 'id', $_POST['email']);
			$password = md5($word);
			$query="update users set password='".$password."' where username='".$_POST['email']."'";
			$user_id=tep_db_query("select id from users where username='".$_POST['email']."'");
			
			$changed=true;
			tep_db_query($query);
///// Email part
    //change this to your email.
//    require_once("Mail.php");

			$to = $_POST['email'];
		  $subject = "Password Reset";
		
		    //begin of HTML message
		    $message = "<html>
						  <body bgcolor=\"#DCEEFC\">
						        Your password reset request has been actioned and your new password is <b>$word</b>.<br>
								You can use this password to login again, and you can change your password by clicking on the 'Change Password' link in the top menu bar, or by clicking on this <a href=\"".HTTP_SERVER."update_password.php\">link</a>.<br><br>
						      <br><br>".SIGNATURE."
						  </body>
						</html>";
   						//end of message
			if (!tep_email($to,$subject,$message)) $error="Email sending failed. Please contact the administrator.";								
		}				
	}
	// template for page build
 	include('includes/header.php');
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
			<TABLE width="850" cellspacing="0" cellpadding="0" border="0" align="center">
    


				<tr>
					<td valign="top" rowspan="4"><img src="images/logo.png"></td>
					<td valign="top" align='left'>
						<TABLE width="600" cellspacing="0" cellpadding="0" border="0" align="center">
							<form action="forgotten_password.php" name="recover_password" method="post">
							<?php
							If ($changed) {?>
								<tr>
									<td colspan="2">Your password has been reset and emailed to your registered email account.
									   <br><span class="required">If you don't receive any email, please contact <strong>utlean@utk.edu</strong> and request your new password</span>
									   <br><br>Click <a href="login.php">here</a> to login again.
									
									</td>
								</tr>
							<?php						
							}
							Else {
				           if ($error) { ?>
								<tr>								   
									 <td colspan="2"><font color="red"><?php echo $error; ?></font></td>
									
								</tr>
								<?php }
								else  if ($_POST['email'] != '') {
							    							  
							  ?>
					        <tr>
						   <td colspan="2"><font color="red">Your e-mail address has not been recognised on the system. Please try again or register.</font></td>
								</tr>
					        <?php							  
							  
							  }
								
								?>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
							<?php
							}
							
		    			?>
							
							<tr>
								<td colspan="2">Enter your email address to regenerate your password</td>
							</tr>
							
							<tr><td colspan = "2">&nbsp;</td></tr>
							<tr><td colspan = "2">&nbsp;</td></tr>
							
							
							<tr>	
								<td>Email address:</td><td><INPUT TYPE="text" NAME="email" class="textbox1" SIZE=35></td>
							</tr>
							
							
							
								<tr>	
								<td>Last Name:</td><td><INPUT TYPE="text" NAME="lastname" class="textbox1" SIZE=15></td>
							</tr>
							
							<tr>
								<td align="center">
									<input type="submit" name="login" value="Recover">
									
								</td></form> <td align="center"><button onclick="window.location.href='http://mydesk.desktops.utk.edu'">Return</button></td>
							</tr>
							
							
						</TABLE>
                
					</td>
				</tr>
			</TABLE>
		</td>
	</tr>
</TABLE>
			<br><br><br><br>
	</body>

</html>
<?php
	include(INCLUDES . 'footer.php');
?>