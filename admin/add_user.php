<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	// allows for the adition of administrators and other users.

	// following hierarchy:

	// superusers can add anyone
	// type admins can add normal users


	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	//var_dump($_SESSION['admin_user']);

	//include(FUNCTIONS . 'sessions.php');
	if (isset($_POST['register'])) {
		//validate and record
		$errors = tep_validate_add_user();

		// replace with moodle class upload.

		if (isset($_FILES['photo']['name'])) {
			//check file upload in the case of instructors
			$filename = basename($_FILES['photo']['name']);
			$filename = $_POST['firstname'].$_POST['lastname'].rand().rand().rand().'.jpg';
			$fullFilename = UPLOAD_DIR.'/'.$filename;
			if (move_uploaded_file($_FILES['photo']['tmp_name'], $fullFilename)) {
				$file_error = false;
			}
			else
			{
				$file_error = true;
			}

		}
		if (!$errors[0]) {
			if (!isset($_POST['admin'])) {
				$access_level = '3';
			}
			else if ($_POST['admin'] == '0') {
				$access_level = '3';
			}
			else if ($_POST['admin'] == '1' && $_POST['center'] == '0' && $_POST['type'] =='0') { //super user
				$access_level = '1';
			}
			else if ($_POST['admin'] == '1' && $_POST['center'] != '0') { //center admin
				$access_level = '1';
			}
			else
			{
				$access_level = '1';
			}
			//lets fill database with user
			if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
				$sql_array = array("username" => prepare_input($_POST['email']),
						   "password" => md5($_POST['password']),
						   "admin" => $_POST['admin'],
						   "center" => $_POST['center'],
						   "type" => $_POST['type'],
						   "instructor" => $_POST['instructor']);
				// enter user into users database
				tep_db_perform(TABLE_USERS, $sql_array);
				$user_id = mysql_insert_id();

				$sql_array = array("user_id" => $user_id,
						   "email" => $_POST['email'],
						   "email2" => $_POST['email2'],
						   "title" => $_POST['title'],
						   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "hospital_name" => $_POST['hosp_name'],
						   "address_line1" => $_POST['addr1'],
						   "address_line2" => $_POST['addr2'],
						   "city" => $_POST['city'],
						   "county" => $_POST['county'],
						   "country" => $_POST['country'],
						   "postcode" => $_POST['postcode'],
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"),
						   "mobile" => $_POST['mobile'],
						   "home_telephone" => $_POST['home_tel'],
						   "mobile_telephone" => $_POST['mobile_tel'],
						   "job_title_id" => $_POST['job_title'],
						   "specialty_id" => $_POST['specialty'],
						   "specialty2_id" => $_POST['specialty2'],
						   "band" => $_POST['band'],
						   "gmc_reg" => $_POST['gmc_reg'],
						   "diet" => $_POST['diet'],
						   "how_hear" => $_POST['how_hear'],
						   "qualifications" => $_POST['qualifications'],
						   "photo" => $filename,
						   "instructor" => $_POST['instructor']);

				// enter user profile details
				tep_db_perform(TABLE_PROFILES, $sql_array);
				$email = $_POST['email'];
				header("Location: all_courses.php?user_id=$user_id");
				//header("Location: view_users.php?search=true&search_term=$email");
			}
			else
			{
				$access_error = true;
				$error = PERMISSION_ERROR;
			}
		}
	}
	// template for page build


	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	//include(INCLUDES . 'leftmenu.php');
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr><td colspan=3><IMG height=10 src="images/blank.gif" width=1></td></tr>
		<tr>
			<td rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Profile Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>

			<td height="18" class="subtitle" valign="bottom" width="18%">Create profile</td>
			<td width="76%"><IMG src="images/right.gif"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan=3>&nbsp;</td>
		</tr>
		<tr>

			<td>&nbsp;</td>
			<td colspan=3> Site administrator can add other administrators and trainee profiles.</td>
		</tr>
	</TABLE>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
	<?php
	if ($access_error) {
	?>
		<tr>
			<td>
				<?php echo $error; ?>
			</td>
		</tr>
	<?php
	}
	?>
	<tr>
		<td>
			<form enctype="multipart/form-data" name="register" action="add_user.php" method="POST">
			<table width='70%' align="center">
				<?php
				if ($errors[0]) {

					var_dump($errors);
				?>
				<tr>
					<td colspan="2">
						<span class="required">The following errors has occured:
						<?php echo $errors[1]; ?></span>
					</td>
				</tr>
				<?php
				}
				$admin_user = new user($_SESSION['admin_user']->username);
				$admin_user->set_profile();
				if ($admin_user->admin=='1' && $admin_user->center=='0' && $admin_user->type=='0') {
				?>
				<tr>
					<td colspan="2">
						<h4>Administrator Options</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							<tr>
								<td width="30%" align="right" class="left">
									Administration Rights:
								</td>
								<td class="right">
									<select name="admin" class="textbox1">
									<option value="0">No</option>
									<option value="1">Yes</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Centre:
								</td>
								<td class="right">
									<?php echo tep_build_dropdown(TABLE_CENTERS, 'center'); ?>&nbsp;* For administrative purposes only
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Apartment:
								</td>
								<td class="right">
									<?php echo tep_build_dropdown(TABLE_COURSE_TYPES, 'type'); ?>&nbsp;* For administrative purposes only
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2"><h4>Instructor Options</h4></td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							<tr>
								<td width="30%" align="right" class="left">
									Instructor:
								</td>
								<td class="right">
									<select name="instructor" class="textbox1">
									<option value="0">No</option>
									<option value="1">Yes</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="left" align="right">Photo:</td>
								<td class="right"><input type="hidden" name="MAX_FILE_SIZE" value="30000" />
													<input name="photo" type="file" class="textbox1"></td>
							</tr>
							<tr>
								<td class="left" align="right">Qualifications:</td>
								<td class="right"><input name="qualifications" type="text" class="textbox1" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h4>Login Details</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							<tr>
								<td width="30%" align="right" class="left">
									Username/E-Mail Address:
								</td>
								<td class="right">
									<input type="text" class="textbox1" name="email" size="40" value="<?php echo $_POST['email'] ?>">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Password:
								</td>
								<td class="right">
									<input type="password" name="password" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Confirm Password:
								</td>
								<td class="right">
									<input type="password" name="c_password" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h4>Personal Details</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							<tr>
								<td width="30%" align="right" class="left">
									Title:
								</td>
								<td class="right">
									<INPUT TYPE=RADIO NAME="title" VALUE="mr">Mr.&nbsp;
									<INPUT TYPE=RADIO NAME="title" VALUE="mrs">Mrs.&nbsp;
									<INPUT TYPE=RADIO NAME="title" VALUE="dr">Dr.&nbsp;
									<INPUT TYPE=RADIO NAME="title" VALUE="miss">Miss.&nbsp;
									<INPUT TYPE=RADIO NAME="title" VALUE="ms">Ms.&nbsp;
									<INPUT TYPE=RADIO NAME="title" VALUE="prof">Prof.&nbsp;
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Forename:
								</td>
								<td class="right">
									<input type="text" name="firstname" value="<?php echo $_POST['firstname'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Surname:
								</td>
								<td class="right">
									<input type="text" name="lastname" value="<?php echo $_POST['lastname'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Hospital Name:
								</td>
								<td class="right">
									<input type="text" name="hosp_name" size="40" value="<?php echo $_POST['hosp_name'] ?>" class="textbox1">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h4>Contact Details</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							<tr>
								<td align="right" class="left">
								 	Address line 1:
								</td>
								<td class="right">
									<input type="text" name="addr1" size="40" value="<?php echo $_POST['addr1'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Address line 2:
								</td>
								<td class="right">
									<input type="text" name="addr2" size="40" value="<?php echo $_POST['addr2'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									City:
								</td>
								<td class="right">
									<input type="text" name="city" value="<?php echo $_POST['city'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									County:
								</td>
								<td class="right">
									<input type="text" name="county" value="<?php echo $_POST['county'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Postcode:
								</td>
								<td class="right">
									<input type="text" name="postcode" value="<?php echo $_POST['postcode'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Country:
								</td>
								<td class="right">
									<input type="text" name="country" value="<?php echo $_POST['country'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Secondary E-Mail:
								</td>
								<td class="right">
									<input type="text" name="email2" value="<?php echo $_POST['email2'] ?>" class="textbox1">&nbsp; (If different from Username)
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Work Tel:
								</td>
								<td class="right">
									<input type="text" name="mobile" value="<?php echo $_POST['mobile'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Home Tel:
								</td>
								<td class="right">
									<input type="text" name="home_tel" value="<?php echo $_POST['home_tel'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Mobile Tel:
								</td>
								<td class="right">
									<input type="text" name="mobile_tel" value="<?php echo $_POST['mobile_tel'] ?>" class="textbox1">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<h4>Course Registration Information
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							<tr>
								<td width="30%" align="right" class="left">
									Job Title/Grade:
								</td>
								<td class="right">
									<?php echo tep_build_dropdown(TABLE_JOBS, 'job_title'); ?>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Specialty:
								</td>
								<td class="right">
									<!-- <input type="text" name="specialty" value="<?php echo $_POST['specialty'] ?>"> -->
									<!-- needs to become dropdown generated from database -->
									<?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty'); ?>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Secondary Specialty:
								</td>
								<td class="right">
									<!-- <input type="text" name="specialty" value="<?php echo $_POST['specialty2'] ?>"> -->
									<!-- needs to become dropdown generated from database -->
									<?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty2'); ?>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Band:
								</td>
								<td class="right">
									<!-- <input type="text" name="band" value="<?php echo $_POST['band'] ?>"> -->
									<?php echo tep_build_dropdown(TABLE_BANDS, 'band'); ?>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									GMC/NMC/HPC Reg No:
								</td>
								<td class="right">
									<!-- necessary when applying for ATLS -->
									<input type="text" name="gmc_reg" value="<?php echo $_POST['gmc_reg'] ?>" class="textbox1">
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Special Dietery Requirements:
								</td>
								<td class="right">
									<!-- pulldown menu of vegitarian, halal, kosher -->
									<!-- <input type="text" name="diet" value="<?php echo $_POST['diet'] ?>"> -->
									<?php echo tep_build_dropdown(TABLE_DIET, 'diet'); ?>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									How did you hear about us?
								</td>
								<td class="right">
									<!-- dropdown menu of advertising, conference, word of mouth -->
									<!-- <input type="text" name="how_hear" value="<?php echo $_POST['how_hear'] ?>"> -->
									<?php echo tep_build_dropdown(TABLE_HOW_HEAR, 'diet'); ?>
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
						<input name="register" type="submit" value="Register" class="submit3">
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	</TABLE>


<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
