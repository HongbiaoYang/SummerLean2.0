<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	//include(FUNCTIONS . 'sessions.php');
	if (tep_logged_in()) {
		header("Location: index.php");
	}
	if (isset($_POST['register'])) {
		//validate and record
		$error = tep_validate_registration();
		if (!$error[0]) {
			//lets fill database with user
			$sql_array = array("username" => $_POST['email'],
					   "password" => md5($_POST['password']),
					   "admin" => '0',
					   "center" => '0',
					   "type" => '0');
			// enter user into users database
			tep_db_perform(TABLE_USERS, $sql_array);
			$sql_array = array("user_id" => mysql_insert_id(),
					   "email" => $_POST['email'],
					   "title" => $_POST['title'],
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
					   "how_hear" => $_POST['how_hear']);
			
			// enter user profile details
			tep_db_perform(TABLE_PROFILES, $sql_array);
			$_SESSION['admin_user'] = new user($_POST['email']);
			
			require(INCLUDES . "create_account_in_sugar.inc.php");
			
			
			header("Location: index.php");
			
		}
	}
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'leftmenu.php');
?>

	<table width=<?php echo TABLE_WIDTH; ?>>
		<tr>
			<td>
				<form name="register" action="register.php" method="POST">
				<table width='100%'>
					<tr>
						<td width="60%">
							<h3>Registration</h3>
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
						<td colspan="2">
							<h4>Login Details</h4>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="100%">
								<tr>
									<td width="30%">
										E-Mail Address:
									</td>
									<td>
										<input type="text" name="email" size="40" value="<?php echo $_POST['email'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Password:
									</td>
									<td>
										<input type="password" name="password">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Confirm Password:
									</td>
									<td>
										<input type="password" name="c_password">
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
									<td width="30%">
										Title
									</td>
									<td>
										<!-- <INPUT TYPE=RADIO NAME="title" VALUE="Mr.">Mr.&nbsp;
										<INPUT TYPE=RADIO NAME="title" VALUE="Mrs.">Mrs.&nbsp;
										<INPUT TYPE=RADIO NAME="title" VALUE="Dr.">Dr.&nbsp;
										<INPUT TYPE=RADIO NAME="title" VALUE="Miss.">Miss.&nbsp;
										<INPUT TYPE=RADIO NAME="title" VALUE="Ms.">Ms.&nbsp;
										<INPUT TYPE=RADIO NAME="title" VALUE="Prof.">Prof.&nbsp; -->
										
										<?php
											echo tep_build_radios(TABLE_TITLES, 'title');
										?>
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Forename
									</td>
									<td>
										<input type="text" name="firstname" value="<?php echo $_POST['firstname'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Surname
									</td>
									<td>
										<input type="text" name="lastname" value="<?php echo $_POST['lastname'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Hospital Name
									</td>
									<td>
										<input type="text" name="hosp_name" size="40" value="<?php echo $_POST['hosp_name'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Address line 1
									</td>
									<td>
										<input type="text" name="addr1" size="40" value="<?php echo $_POST['addr1'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Address line 2
									</td>
									<td>
										<input type="text" name="addr2" size="40" value="<?php echo $_POST['addr2'] ?>">
									</td>
								</tr>
								<tr>
									<td>
										City
									</td>
									<td>
										<input type="text" name="city" value="<?php echo $_POST['city'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Postcode
									</td>
									<td>
										<input type="text" name="postcode" value="<?php echo $_POST['postcode'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Work Tel.
									</td>
									<td>
										<input type="text" name="work_tel" value="<?php echo $_POST['work_tel'] ?>">
										&nbsp;<span class="required">*</span>
									</td>
								</tr>
								<tr>
									<td>
										Home Tel.
									</td>
									<td>
										<input type="text" name="home_tel" value="<?php echo $_POST['home_tel'] ?>">
									</td>
								</tr>
								<tr>
									<td>
										Mobile Tel.
									</td>
									<td>
										<input type="text" name="mobile_tel" value="<?php echo $_POST['mobile_tel'] ?>">
									</td>
								</tr>
								<tr>
									<td>
										Bleep
									</td>
									<td>
										<input type="text" name="bleep" value="<?php echo $_POST['bleep'] ?>">
										&nbsp;<span class="required">*</span>
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
									<td width="30%">
										Job Title
									</td>
									<td>
										<!-- <input type="text" name="job_title" value="<?php echo $_POST['job_title'] ?>">-->
										<?php echo tep_build_dropdown(TABLE_JOBS, 'job_title'); ?>
										&nbsp;<span class="required">*</span>
										<!-- needs to become dropdown generated from database -->
									</td>
								</tr>
								<tr>
									<td>
										Specialty
									</td>
									<td>
										<!-- <input type="text" name="specialty" value="<?php echo $_POST['specialty'] ?>">-->
										<?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty'); ?>
										<!-- needs to become dropdown generated from database -->
										<!-- &nbsp;<span class="required">*</span> -->
									</td>
								</tr>
								<tr>
									<td>
										Band
									</td>
									<td>
										<!-- <input type="text" name="band" value="<?php echo $_POST['band'] ?>"> -->
										<?php echo tep_build_dropdown(TABLE_BANDS, 'band'); ?>
									</td>
								</tr>
								<tr>
									<td>
										GMC/NMC/etc Reg No.
									</td>
									<td>
										<!-- necessary when applying for ATLS -->
										<input type="text" name="gmc_reg" value="<?php echo $_POST['gmc_reg'] ?>">
									</td>
								</tr>
								<tr>
									<td>
										Special Dietery Requirements
									</td>
									<td>
										<!-- pulldown menu of vegitarian, halal, kosher -->
										<!-- <input type="text" name="diet" value="<?php echo $_POST['diet'] ?>"> -->
										<?php echo tep_build_dropdown(TABLE_DIET, 'diet'); ?>
									</td>
								</tr>
								<tr>
									<td>
										How did you hear about us?
									</td>
									<td>
										<!-- dropdown menu of advertising, conference, word of mouth -->
										<!-- <input type="text" name="how_hear" value="<?php echo $_POST['how_hear'] ?>"> -->
										<?php echo tep_build_dropdown(TABLE_HOW_HEAR, 'how_hear'); ?>
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
							<input name="register" type="submit" value="Register">
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
