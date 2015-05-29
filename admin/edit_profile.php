<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	$user = new user(tep_get_username($_GET['id']));
	$user->set_profile();

	//include(FUNCTIONS . 'sessions.php');
	if (!tep_logged_in()) {
		header("Location: login.php");
	}
	if (isset($_POST['profile'])) {
		//validate and record
		$error = tep_validate_add_user('profile');
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

			if ($_POST['admin'] == '0') {
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
			if (tep_validate_user($_SESSION['admin_user'], $access_level, $_POST['center'], $_POST['type'])) {
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
						   "email2" => $_POST['email2'],
						   "title" => $_POST['title'],
						   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "hospital_name" => $_POST['hosp_name'],
						   "address_line1" => $_POST['addr1'],
						   "address_line2" => $_POST['addr2'],
						   "city" => $_POST['city'],
						   "county" => $_POST['county'],
						   "postcode" => $_POST['postcode'],
						   "country" => $_POST['country'],
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"),
						   "mobile" => $_POST['mobile'],
						   "home_telephone" => $_POST['home_tel'],
						   "mobile_telephone" => $_POST['mobile_tel'],
						   "bleep" => $_POST['bleep'],
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
				tep_db_perform(TABLE_PROFILES, $sql_array, 'update', "user_id='$user->id'");

				header("Location: view_profile.php?id=$user->id");
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
								$admin_user = new user($_SESSION['admin_user']->username);
								if ($admin_user->admin=='1' && $admin_user->center=='0' && $admin_user->type=='0') {
								?>
								<tr>
									<td colspan="2">
								</tr>
								<!-- adding the admin part of form -->

								<tr>
									<td align="left">
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
													<option value="0" <?php if ($user->admin =='0') echo 'SELECTED';?>>No</option>
													<option value="1" <?php if ($user->admin =='1') echo 'SELECTED';?>>Yes</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left">
													Centre:
												</td>
												<td class="right">
													<?php echo tep_build_dropdown(TABLE_CENTERS, 'center', false, '1','', true, $user->center); ?>&nbsp;* For administrative purposes only
												</td>
											</tr>
											<tr>
												<td class="left">
													Department:
												</td>
												<td class="right">
													<?php echo tep_build_dropdown(TABLE_COURSE_TYPES, 'type', false, '1','', true, $user->type); ?>&nbsp;* For administrative purposes only
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<?php
								}
								?>
								<tr>
									<td colspan="2" align="left">
										<h4>Instructor Options</h4>
									</td>
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
													<?php
													if ($user->instructor == '1') {
														$instructor = new instructor(tep_get_username($_GET['id']));
														$instructor->instructor_attributes();
													}
													?>
													<option value="0" <?php if ($user->instructor == '0') echo 'SELECTED'; ?>>No</option>
													<option value="1" <?php if ($user->instructor == '1') echo 'SELECTED'; ?>>Yes</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left" align="right">Photo:</td>
												<td class="right"><input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
																	<input name="photo" type="file" class="textbox1">&nbsp;&nbsp;&nbsp;Leave blank to keep current.</td>
											</tr>
											<tr>
												<td class="left" align="right">Qualifications:</td>
												<td class="right"><input name="qualifications" type="text" class="textbox1" value="<?php echo $instructor->qualifications; ?>"/></td>
											</tr>
										</table>
									</td>
								</tr>
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
													Username/E-Mail Address:
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
												<td width="30%" class="left">
													Title:
												</td>
												<td class="right">
													<INPUT TYPE=RADIO NAME="title" VALUE="mr" <?php if ($user->title=='mr') echo 'CHECKED';?>>Mr.&nbsp;
													<INPUT TYPE=RADIO NAME="title" VALUE="mrs" <?php if ($user->title=='mrs') echo 'CHECKED';?>>Mrs.&nbsp;
													<INPUT TYPE=RADIO NAME="title" VALUE="dr" <?php if ($user->title=='dr') echo 'CHECKED';?>>Dr.&nbsp;
													<INPUT TYPE=RADIO NAME="title" VALUE="miss" <?php if ($user->title=='miss') echo 'CHECKED';?>>Miss.&nbsp;
													<INPUT TYPE=RADIO NAME="title" VALUE="ms" <?php if ($user->title=='ms') echo 'CHECKED';?>>Ms.&nbsp;
													<INPUT TYPE=RADIO NAME="title" VALUE="prof" <?php if ($user->title=='prof') echo 'CHECKED';?>>Prof.&nbsp;
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
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
													Hospital Name:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="hosp_name" size="40" value="<?php echo $user->hospital_name ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Address line 1:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="addr1" size="40" value="<?php echo $user->address_line1; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Address line 2:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="addr2" size="40" value="<?php echo $user->address_line2; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													City:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="city" value="<?php echo $user->city; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													County:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="county" value="<?php echo $user->county; ?>">
													&nbsp;<span class="required"></span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Postcode:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="postcode" value="<?php echo $user->postcode; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Country:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="country" value="<?php echo $user->country; ?>">
													&nbsp;<span class="required"></span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Secondary E-Mail:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="email2" value="<?php echo $user->email2; ?>">
													&nbsp;(If different from Username)
												</td>
											</tr>
											<tr>
												<td class="left">
													Work Tel:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="mobile" value="<?php echo $user->mobile; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Home Tel:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="home_tel" value="<?php echo $user->home_telephone; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Mobile Tel:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="mobile_tel" value="<?php echo $user->mobile_telephone; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Bleep:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="bleep" value="<?php echo $user->bleep; ?>">
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
													Specialty:
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
													Secondary Specialty:
												</td>
												<td class="right">
													<!-- <input type="text" name="specialty" value="<?php echo $_POST['specialty'] ?>">-->
													<?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty2', false, '1', '', true, $user->specialty2_id); ?>
													<!-- needs to become dropdown generated from database -->
													<!-- &nbsp;<span class="required">*</span> -->
												</td>
											</tr>
											<tr>
												<td class="left">
													Band:
												</td>
												<td class="right">
													<!-- <input type="text" name="band" value="<?php echo $_POST['band'] ?>"> -->
													<?php echo tep_build_dropdown(TABLE_BANDS, 'band', false, '1', '', true, $user->band); ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													GMC/NMC/etc Reg No:
												</td>
												<td class="right">
													<!-- necessary when applying for ATLS -->
													<input type="text" name="gmc_reg" value="<?php echo $user->gmc_reg; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Special Dietery Requirements:
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
