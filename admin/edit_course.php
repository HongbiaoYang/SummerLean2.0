<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	// access level 3

	$access_level = '3';
	$access_error = false;
	$course_id = $_GET['id'];


	include('includes/application_top.php');

	$course = new course($course_id);

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}



	if (isset($_POST['edit_course']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level, $_POST['center'], $_POST['type'])) {
			$sql_array = array("name" => $_POST['name'],
					   "description" => $_POST['description'],
					   "category" => $_POST['category'],
					   "type" => $_POST['type'],
					   "center" => $_POST['center'],
					   "min_instructors" => $_POST['min_instructors'],
					   "min_attendance"=>$_POST['min_attendance'],
					   "max_attendance"=>$_POST['max_attendance'],
					   "default_start_time" => $_POST['start_hour'].':'.$_POST['start_minute'],
					   "default_end_time" => $_POST['end_hour'].':'.$_POST['end_minute'],
					   "mDate"=>date("Y-m-d H:i:s"));
			tep_db_perform(TABLE_COURSES, $sql_array, 'update', "id = '$course_id'");

			header("Location: edit_requirements.php?id=$course_id&action=edit");
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}

	}

	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	//include(INCLUDES . 'tinyinc.php');
?>


	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Courses</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Edit Course</td>
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
									<td align="left">
										<h4>Edit Course</h4>
										<form action="edit_course.php?id=<?php echo $_GET['id']; ?>" name="add_course" method="POST">
										<table width="100%">
											<tr>
												<td class="left" width="30%">Select Course Type:</td>
												<td class="right"><?php echo tep_build_radios(TABLE_COURSE_TYPES, 'type', true, $course->type); ?>
											</tr>
											<tr>
												<td class="left">Select Centre</td>
												<td class="right"><?php echo tep_build_radios(TABLE_CENTERS, 'center', true, $course->center); ?>
											</tr>
											<tr>
												<td class="left">Select Category</td>
												<td class="right"><?php echo tep_build_radios(TABLE_COURSE_CATEGORIES, 'category', true, $course->category); ?>
											</tr>
											<tr>
												<td colspan="2">&nbsp;</td>
											</tr>

											<tr>
												<td width="30%" class="left">
													Course Name:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1" value="<?php echo $course->name; ?>">
												</td>
											</tr>
											<tr>
												<td class="left" valign="top">
													Description:
												</td>
												<td class="right">
													<textarea name="description" cols="60" rows="10" class="textbox1"><?php echo $course->description; ?></textarea>
												</td>
											</tr>
											<tr>
												<td class="left">
													Minimum Instructors:
												</td>
												<td class="right">
													<input name="min_instructors" type="text" size="4" class="textbox1" value="<?php echo $course->min_instructors; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Minimum Attendance:
												</td>
												<td class="right">
													<input name="min_attendance" type="text" size="4" class="textbox1" value="<?php echo $course->min_attendance; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Maximum Attendance:
												</td>
												<td class="right">
													<input name="max_attendance" type="text" size="4" class="textbox1" value="<?php echo $course->max_attendance; ?>">
											</td>
											</tr>
											<tr>
												<td class="left">
													<?php
														$default_course_start_hour = substr($course->default_start_time,0,2);
														$default_course_start_minute = substr($course->default_start_time,3,2);
														$hour = array();
														$minute = array();
														for ($i=0;$i < 24; $i++) {
															$hour[] = $i;
														}
														for ($j=0; $j < 60; $j+=5) {
															$minute[] = $j;
														}
													?>
													Start Time:
												</td>
												<td class="right">
													<select name='start_hour' class="textbox1">
													<?php
													foreach ($hour as $a=>$b) {
														if (strlen($b) == '1') {
															$b = '0'.$b;
														}
														if ($default_course_start_hour == $b) {
															echo '<option SELECTED value="'.$b.'">'.$b.'</option>';
														}
														else
														{
															echo '<option value="'.$b.'">'.$b.'</option>';
														}
													}
													?>
													</select>
													:
													<select name='start_minute' class="textbox1">
													<?php

													foreach ($minute as $x=>$y) {
														if (strlen($y) == '1') {
															$y = '0'.$y;
														}
														if ($default_course_start_minute == $y) {
															echo '<option SELECTED value="'.$y.'">'.$y.'</option>';
														}
														else
														{
															echo '<option value="'.$y.'">'.$y.'</option>';
														}
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left">
													End Time:
												</td>
												<td class="right">
													<select name='end_hour' class="textbox1">
													<?php
													$default_course_end_hour = substr($course->default_end_time,0,2);
													$default_course_end_minute = substr($course->default_end_time,3,2);
													foreach ($hour as $a=>$b) {
														if (strlen($b) == '1') {
															$b = '0'.$b;
														}
														if ($default_course_end_hour == $b) {
															echo '<option SELECTED value="'.$b.'">'.$b.'</option>';
														}
														else
														{
															echo '<option value="'.$b.'">'.$b.'</option>';
														}
													}
													?>
													</select>
													:
													<select name='end_minute' class="textbox1">
													<?php
													foreach ($minute as $x=>$y) {
														if (strlen($y) == '1') {
															$y = '0'.$y;
														}
														if ($default_course_end_minute == $y) {
															echo '<option SELECTED value="'.$y.'">'.$y.'</option>';
														}
														else
														{
															echo '<option value="'.$y.'">'.$y.'</option>';
														}
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="edit_course" type="submit" value="Next" class="submit3">
												</td>
											</tr>
										</table>
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
