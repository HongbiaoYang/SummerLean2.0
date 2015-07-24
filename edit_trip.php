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
  $user->set_choices();

	//include(FUNCTIONS . 'sessions.php');
	if (isset($_POST['profile'])) {
		
		//validate and record
//		$error = tep_validate_add_user('profile');
//
//
//			//lets fill database with user
//			if (isset($_SESSION['learner'])) {
//				$sql_array = array("username" => $_POST['email'],
//						   "admin" => $_POST['admin'],
//						   "center" => $_POST['center'],
//						   "type" => $_POST['type'],
//						   "instructor" => $_POST['instructor']);
//				// enter user into users database
//				tep_db_perform(TABLE_STUDENTS, $sql_array, 'update', "stuindex='$user->id'");
//				$user_id = mysql_insert_id();
        
    				$sql_array = array(
    				   	   "weekend1" => $_POST['weekend1'],
    						   "weekend2" => $_POST['weekend2']);    
    				// enter user profile details
    				tep_db_perform(TABLE_CHOICES, $sql_array, 'update', "stuindex='$user->id'");
    
    				header("Location: view_projects.php?id=$user->id");
		    
			}
			else
			{
				$access_error = true;
				$error = PERMISSION_ERROR;
			}
	
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Edit Profile</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</TABLE>

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="middle">
				<br><br>
				<!-- main content starts here -->
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<form enctype="multipart/form-data" name="profile" action="edit_trip.php?id=<?php echo $_GET['id']; ?>" method="POST">
							<table width='100%'>
								<tr>
									<td width="60%">
										&nbsp;
									</td>
									<td>
										<span class="required">* Required fields</span>
									</td>
								</tr>
								
								<!--
								<?php
								if ($error[0]) {
								?>
								<tr>
									<td>
										<span class="required">The following errors has occured:
										<?php echo $error[1]; ?></span>
									</td>
								</tr>
								<?php
								}

								?>
								
								
								<tr>
									<td colspan="2" align="left">
										<h4>Login Details</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													E-Mail Address:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="email" size="40" value="<?php echo $user->username; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								-->
								
								<tr>
									<td colspan="2" align="left">
										<h4>Weekend Trips:</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
							
										 <tr>
                							<td class="left" width="50%">
                								Ripley's Aquarium trip (July 18th):
                							</td>
                							<td class="right">
                							    <input type="checkbox" name="weekend1" value="1"
                							    <?php if ($user->weekend1 == 1) echo "checked";?>>
                							</td>
                						</tr>	
                						
                						<tr>
                							<td  class="left">
                								Tanger Outlet trip (July 25th):
                							</td>
                							<td class="right">
                							    <input type="checkbox" name="weekend2" value ="1" 
2                							    <?php if ($user->weekend2 == 1) echo "checked";?>>
                							</td>
                						</tr>	
											
										
								<tr>
									<td colspan="2" align="center">
										<input class="submit3" name="profile" type="submit" value="Confirm Change">
									</td>
								</tr>
							</table>
							</form>
						</td>
					</tr>

				</table>
				<br><br>
			<table width="96%" align="center" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td colspan=3 align=right></td>
				</tr>
			</table>
			<br><br>
			</td>
		</tr>
	</TABLE>
<?php
	include(INCLUDES . 'footer.php');
?>
