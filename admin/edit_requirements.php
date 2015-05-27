<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	$access_level='3';

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (!tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['id']), tep_get_course_type($_GET['id']))) {
		header("Location: add_course.php");
	}
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');

	$error = false;
	$id = $_GET['id'];

	//process jobs
	if (isset($_POST['add_job'])) {
		foreach ($_POST['possible_jobs'] as $job) {
			if ($job != 0) {
				$sql_array = array("course_id" => $id,
						   "requirement_id" => $job,
						   "requirement_type" => 'job',
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"));
			}	tep_db_perform(TABLE_REQUIREMENTS, $sql_array);
		}
	}
	if (isset($_POST['remove_job'])) {
		foreach ($_POST['required_jobs'] as $req_id) {
			if ($req_id != 0) {
				$query = "delete from requirements where id = '$req_id'";
				$result = tep_db_query($query);
			}
		}
	}

	//process specialties
	if (isset($_POST['add_specialty'])) {
		foreach ($_POST['possible_specialties'] as $specialty) {
			if ($specialty != 0) {
				$sql_array = array("course_id" => $id,
						   "requirement_id" => $specialty,
						   "requirement_type" => 'specialty',
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"));
				tep_db_perform(TABLE_REQUIREMENTS, $sql_array);
			}
		}
	}
	if (isset($_POST['remove_specialty'])) {
		foreach ($_POST['required_specialties'] as $req_id) {
			if ($req_id != 0) {
				$query = "delete from requirements where id = '$req_id'";
				$result = tep_db_query($query);
			}
		}
	}
	//process bands
	if (isset($_POST['add_band'])) {
		foreach ($_POST['possible_bands'] as $band) {
			if ($band != 0) {
				$sql_array = array("course_id" => $id,
						   "requirement_id" => $band,
						   "requirement_type" => 'band',
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"));
				tep_db_perform(TABLE_REQUIREMENTS, $sql_array);
			}
		}
	}
	if (isset($_POST['remove_band'])) {
		foreach ($_POST['required_bands'] as $req_id) {
			if ($req_id != 0) {
				$query = "delete from requirements where id = '$req_id'";
				$result = tep_db_query($query);
			}
		}
	}




	$course = new course($_GET['id']);
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Course Requirements</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%"><?php echo $course->name; ?></td>
			<td width="83%"><IMG src="images/right.gif"></td>
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
							<table width='100%'>
								<!-- CONTENT -->
								<tr>
									<td>
										<h4><?php echo "Edit requirements for ".$course->name; ?></h4><br>
										Type: <?php echo tep_get_name(TABLE_COURSE_TYPES, $course->type); ?><br>
										Location: <?php echo tep_get_name(TABLE_CENTERS, $course->center); ?><br>
										Category: <?php echo tep_get_name(TABLE_COURSE_CATEGORIES, $course->category); ?><br>
									</td>
								</tr>
								<tr>
									<td>
										<form action="edit_requirements.php?id=<?php echo $_GET['id']; ?>" name="jobs" method="post">
										<table width="100%">
											<tr>
												<td width="20%">
													Required Job Titles:
												</td>
												<td width="10%">&nbsp;

												</td>
												<td width="30%">
													Registered Job Titles:
												</td>
											</tr>
											<tr>
												<td>
													<?php //build requirements allready added
													$query = "select * from requirements
														where course_id = $course->id
														and requirement_type = 'job'";
													$result = tep_db_query($query);
													$dropdown = "<select multiple='multiple' size='8' name='required_jobs[]' class='textbox1'>";
													if (tep_db_num_rows($result) > 0) {
														while ($row=tep_db_fetch_array($result)) {
															$dropdown .= "<option value='".$row['id']."'>".tep_get_name(TABLE_JOBS, $row['requirement_id'])."</option>";
														}
													}
													else
													{
														$dropdown.= "<option value='0'>Add requirements here</option>";
													}
													$dropdown .= "</select>";
													echo $dropdown;
													?>
												</td>
												<td>
													<input name="add_job" type="submit" value="< Add" class="submit3"><br><br>
													<input name="remove_job" type="submit" value="Remove >" class="submit3">
												</td>
												<td>
													<?php //build dropdown of possible job titles
													$query = "select * from jobs";
													$result = tep_db_query($query);
													$dropdown = "<select multiple='multiple' size='8' name = 'possible_jobs[]' class='textbox1'>";
													if (tep_db_num_rows($result) > 0) {
														while ($row=tep_db_fetch_array($result)) {
															//check if job is allready in required list
															$val_query = "select * from requirements where requirement_id = '".$row['id']."' and course_id ='$id' and requirement_type='job'";
															$val_result = tep_db_query($val_query);
															if (tep_db_num_rows($val_result) == 0) {
																$dropdown .= "<option value='".$row['id']."'>".$row['name']."</option>";
															}
														}
													}
													else
													{
														$dropdown .= "<option value='0'>Please add job titles to the system</option>";
													}
													$dropdown .= "</select>";
													echo $dropdown;
													//$drop
													?>
												</td>
											</tr>

										</table>
										</form>
								</tr>


								<!-- Specialty Selection -->
								<tr>
									<td>
										<form action="edit_requirements.php?id=<?php echo $_GET['id']; ?>" name="specialties" method="post">
										<table width="100%">
											<tr>
												<td width="20%">
													Required Specialties:
												</td>
												<td width="10%">&nbsp;

												</td>
												<td width="30%">
													Registered Specialties:
												</td>
											</tr>
											<tr>
												<td>
													<?php //build requirements allready added
													$query = "select * from requirements
														where course_id = $course->id
														and requirement_type = 'specialty'";
													$result = tep_db_query($query);
													$dropdown = "<select multiple='multiple' size='8' name='required_specialties[]' class='textbox1'>";
													if (tep_db_num_rows($result) > 0) {
														while ($row=tep_db_fetch_array($result)) {
															$dropdown .= "<option value='".$row['id']."'>".tep_get_name(TABLE_SPECIALTIES, $row['requirement_id'])."</option>";
														}
													}
													else
													{
														$dropdown.= "<option value='0'>Add requirements here</option>";
													}
													$dropdown .= "</select>";
													echo $dropdown;
													?>
												</td>
												<td>
													<input name="add_specialty" type="submit" value="< Add" class="submit3"><br><br>
													<input name="remove_specialty" type="submit" value="Remove >" class="submit3">
												</td>
												<td>
													<?php //build dropdown of possible specialties
													$query = "select * from specialties";
													$result = tep_db_query($query);
													$dropdown = "<select multiple='multiple' size='8' name = 'possible_specialties[]' class='textbox1'>";
													if (tep_db_num_rows($result) > 0) {
														while ($row=tep_db_fetch_array($result)) {
															//check if job is allready in required list
															$val_query = "select * from requirements where requirement_id = '".$row['id']."' and course_id ='$id' and requirement_type='specialty'";
															$val_result = tep_db_query($val_query);
															if (tep_db_num_rows($val_result) == 0) {
																$dropdown .= "<option value='".$row['id']."'>".$row['name']."</option>";
															}
														}
													}
													else
													{
														$dropdown .= "<option value='0'>Please add specialties to the system</option>";
													}
													$dropdown .= "</select>";
													echo $dropdown;
													//$drop
													?>
												</td>
											</tr>

										</table>
										</form>
								</tr>
								<!-- End Specialty Selection -->
								<!-- Band Selection -->
								<tr>
									<td>
										<form action="edit_requirements.php?id=<?php echo $_GET['id']; ?>" name="bands" method="post">
										<table width="100%">
											<tr>
												<td width="20%">
													Required Bands:
												</td>
												<td width="10%">&nbsp;

												</td>
												<td width="30%">
													Registered Bands:
												</td>
											</tr>
											<tr>
												<td>
													<?php //build requirements allready added
													$query = "select * from requirements
														where course_id = $course->id
														and requirement_type = 'band'";
													$result = tep_db_query($query);
													$dropdown = "<select multiple='multiple' size='8' name='required_bands[]' class='textbox1'>";
													if (tep_db_num_rows($result) > 0) {
														while ($row=tep_db_fetch_array($result)) {
															$dropdown .= "<option value='".$row['id']."'>".tep_get_name(TABLE_BANDS, $row['requirement_id'])."</option>";
														}
													}
													else
													{
														$dropdown.= "<option value='0'>Add requirements here</option>";
													}
													$dropdown .= "</select>";
													echo $dropdown;
													?>
												</td>
												<td>
													<input name="add_band" type="submit" value="< Add" class="submit3"><br><br>
													<input name="remove_band" type="submit" value="Remove >" class="submit3">
												</td>
												<td>
													<?php //build dropdown of possible specialties
													$query = "select * from bands";
													$result = tep_db_query($query);
													$dropdown = "<select multiple='multiple' size='8' name = 'possible_bands[]' class='textbox1'>";
													if (tep_db_num_rows($result) > 0) {
														while ($row=tep_db_fetch_array($result)) {
															//check if job is allready in required list
															$val_query = "select * from requirements where requirement_id = '".$row['id']."' and course_id ='$id' and requirement_type='band'";
															$val_result = tep_db_query($val_query);
															if (tep_db_num_rows($val_result) == 0) {
																$dropdown .= "<option value='".$row['id']."'>".$row['name']."</option>";
															}
														}
													}
													else
													{
														$dropdown .= "<option value='0'>Please add bands to the system</option>";
													}
													$dropdown .= "</select>";
													echo $dropdown;
													//$drop
													?>
												</td>
											</tr>

										</table>
										</form>
								</tr>
								<!-- End Band Selection -->
								<tr>
									<td align="center">
										<form action="view_course.php?id=<?php echo $id; ?>" method="post" name="finish">
										<input name="added" type="hidden" value="just_added">
										<input name="button" type="submit" value="Finish" class="submit3">
										</form>
									</td>
								</tr>

							</table>


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
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
