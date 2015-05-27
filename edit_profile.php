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

	//include(FUNCTIONS . 'sessions.php');
	if (isset($_POST['profile'])) {
		//validate and record
		$error = tep_validate_add_user('profile');


			//lets fill database with user
			if (isset($_SESSION['learner'])) {
				$sql_array = array("username" => $_POST['email'],
						   "admin" => $_POST['admin'],
						   "center" => $_POST['center'],
						   "type" => $_POST['type'],
						   "instructor" => $_POST['instructor']);
				// enter user into users database
				tep_db_perform(TABLE_USERS, $sql_array, 'update', "id='$user->id'");
				$user_id = mysql_insert_id();

				$sql_array = array("user_id" => $user->id,
						   "email" => $_POST['email'],
						   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "hospital_name" => $_POST['hosp_name'],
						   "address_line1" => $_POST['addr1'],
						   "address_line2" => $_POST['addr2'],
						   "city" => $_POST['city'],
						   "postcode" => $_POST['postcode'],
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"),
						   "work_telephone" => $_POST['work_tel'],
						   "home_telephone" => $_POST['home_tel'],
						   "mobile_telephone" => $_POST['mobile_tel'],
						   "bleep" => $_POST['bleep'],
						   "job_title_id" => $_POST['job_title'],
						   "specialty_id" => $_POST['specialty'],
						   "band" => $_POST['band'],
						   "gmc_reg" => $_POST['gmc_reg'],
						   "diet" => $_POST['diet'],
						   "how_hear" => $_POST['how_hear'],
						   "qualifications" => $_POST['qualifications'],
						   "photo" => $filename,
						   "instructor" => $_POST['instructor']);

				// enter user profile details
				tep_db_perform(TABLE_PROFILES, $sql_array, 'update', "user_id='$user->id'");

				header("Location: view_profile.php?id=$user->id");
			}
			else
			{
				$access_error = true;
				$error = PERMISSION_ERROR;
			}
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
							<form enctype="multipart/form-data" name="profile" action="edit_profile.php?id=<?php echo $_GET['id']; ?>" method="POST">
							<table width='100%'>
								<tr>
									<td width="60%">
										&nbsp;
									</td>
									<td>
										<span class="required">* Required fields</span>
									</td>
								</tr>
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
								<tr>
									<td colspan="2" align="left">
										<h4>Personal Details</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
							
											<tr>
												<td class="left">
													Firstname:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="firstname" value="<?php echo $user->firstname; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Surname:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="lastname" value="<?php echo $user->lastname; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Work Tel:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="work_tel" value="<?php echo $user->work_telephone; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Course Registration Information:</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Job Title:
												</td>
												<td class="right">
													<!-- <input type="text" name="job_title" value="<?php echo $_POST['job_title'] ?>">-->
													<?php echo tep_build_dropdown(TABLE_JOBS, 'job_title', false, '1', '', true, $user->job_title_id); ?>
													&nbsp;<span class="required">*</span>
													<!-- needs to become dropdown generated from database -->
												</td>
											</tr>
											<tr>
												<td class="left">
													Team:
												</td>
												<td class="right">
													<!-- <input type="text" name="specialty" value="<?php echo $_POST['specialty'] ?>">-->
													<?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty', false, '1', '', true, $user->specialty_id); ?>
													<!-- needs to become dropdown generated from database -->
													<!-- &nbsp;<span class="required">*</span> -->
												</td>
											</tr>
											<tr>
												<td class="left">
													Special Requirements:
												</td>
												<td class="right">
													<!-- pulldown menu of vegitarian, halal, kosher -->
													<!-- <input type="text" name="diet" value="<?php echo $_POST['diet'] ?>"> -->
													<?php echo tep_build_dropdown(TABLE_DIET, 'diet', false, '1', '', true, $user->diet); ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										&nbsp;
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input class="submit3" name="profile" type="submit" value="Change Profile">
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
