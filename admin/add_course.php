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

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}



	if (isset($_POST['add_course']) && tep_validate_entry($_POST['name']) && tep_unique_course($_POST['name'], $_POST['center'], $_POST['type'], $_POST['category'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level, $_POST['center'], $_POST['type'])) {
			$sql_array = array("name" => prepare_input($_POST['name']),
					   "description" => prepare_input($_POST['description']),
					   "category" => prepare_input($_POST['category']),
					   "type" => prepare_input($_POST['type']),
					   "center" => prepare_input($_POST['center']),
					   "min_instructors" => prepare_input($_POST['min_instructors']),
					   "min_attendance"=> prepare_input($_POST['min_attendance']),
					   "max_attendance"=> prepare_input($_POST['max_attendance']),
					   "default_start_time" => $_POST['start_hour'].':'.$_POST['start_minute'],
					   "default_end_time" => $_POST['end_hour'].':'.$_POST['end_minute'],
					   "cDate"=> date("Y-m-d H:i:s"),
					   "mDate"=> date("Y-m-d H:i:s"));
			tep_db_perform(TABLE_COURSES, $sql_array);
			$course_id = mysql_insert_id();

			//tep_create_folder($name, $_POST['center'], $_POST['type'], $course_id);
			header("Location: edit_requirements.php?id=$course_id");
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}

	}

	$action = $_GET['action'];
	switch ($action) {
		case 'delete': if (tep_validate_user($_SESSION['admin_user'])) {
			       		tep_delete_entry(TABLE_COURSES, $_GET['id']);
			       		tep_delete_requirements($_GET['id']);
			       		// delete scheduled courses
			       		// delete registered entries
			       		$query = "select id from calendar where course_id = '".$_GET['id']."'";
			       		$result = tep_db_query($query);
			       		while ($row = tep_db_fetch_array($result)) {
			       			tep_delete_entry(TABLE_CALENDAR, $row['id']);
			       			$query1 = "delete from registrations where calendar_id = '".$row['id']."'";
			       			$result1 = tep_db_query($query1);
			       		}
			       }
			       else
			       {
			       		$access_error = true;
			       		$error = PERMISSION_ERROR;
			       }
			       break;
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
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Courses</td>
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
										<h4>Current Courses</h4>
										<?php
											//order by type, center, category (order_value) courses (order_value)
										?>
										<table width="100%">
										<?php
											//display current courses
											$course_array = tep_get_courses();
											if (empty($course_array)) {
											?>
												<tr>
													<td class="right">
													<?php
														echo 'There are no courses registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{

												foreach ($course_array as $a => $b) {
													if ($b['center'] != $temp_center) {
														$temp_center = $b['center'];
														$temp_type = '';
														$temp_cat = '';
														echo '<tr><td class="hright" colspan="2"><span class="head"><font color="blue">Centre: '.tep_get_name(TABLE_CENTERS, $temp_center).'</font></span></td></tr>';
													}
													if ($b['type'] != $temp_type) {
														$temp_type = $b['type'];
														$temp_cat = '';
														echo '<tr><td class="h2right" colspan="2"><span class="head">Course Type: '.tep_get_name(TABLE_COURSE_TYPES, $temp_type).'</span></td></tr>';
													}
													if ($b['category'] != $temp_cat) {
														$temp_cat = $b['category'];
														echo '<tr><td class="h3right" colspan="2"><span class="head">Category: '.tep_get_name(TABLE_COURSE_CATEGORIES, $temp_cat).'</span></td></tr>';
													}
													echo '<tr><td class="left" width="30%"><a href="view_course.php?id='.$b['id'].'">'.$b['name'].'</a></td>';
													?>
													<td class="left">
														<a href="edit_course.php?id=<?php echo $b['id'] ?>">Edit</a>&nbsp;|&nbsp;<a href="add_course.php?action=delete&id=<?php echo $b['id'] ?>">Delete</a>
													</td>
													<?php
												}
											}
										?>
										</table>
										<h4>Add a Course</h4>
										<form action="add_course.php" name="add_course" method="POST">
										<table width="100%">
											<tr>
												<td class="left" width="30%">Select Course Type:</td>
												<td class="right"><?php echo tep_build_radios(TABLE_COURSE_TYPES, 'type'); ?>
											</tr>
											<tr>
												<td class="left">Select Centre</td>
												<td class="right"><?php echo tep_build_radios(TABLE_CENTERS, 'center'); ?>
											</tr>
											<tr>
												<td class="left">Select Category</td>
												<td class="right"><?php echo tep_build_radios(TABLE_COURSE_CATEGORIES, 'category'); ?>
											</tr>
											<tr>
												<td colspan="2">&nbsp;</td>
											</tr>

											<tr>
												<td width="30%" class="left">
													Course Name:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left" valign="top">
													Description:
												</td>
												<td class="right">
													<textarea name="description" cols="60" rows="10" class="textbox1"></textarea>
												</td>
											</tr>
											<tr>
												<td class="left">
													Minimum Instructors:
												</td>
												<td class="right">
													<input name="min_instructors" type="text" size="4" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Minimum Attendance:
												</td>
												<td class="right">
													<input name="min_attendance" type="text" size="4" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Maximum Attendance:
												</td>
												<td class="right">
													<input name="max_attendance" type="text" size="4" class="textbox1">
											</td>
											</tr>
											<tr>
												<td class="left">
													<?php
														$hour = array();
														$minute = array();
														for ($i=0;$i < 24; $i++) {
															$hour[] = $i;
														}
														for ($j=0; $j < 60; $j+=5) {
															$minute[] = $j;
														}
													?>
													Default Start Time:
												</td>
												<td class="right">
													<select name='start_hour' class="textbox1">
													<?php
													foreach ($hour as $a=>$b) {
														if (strlen($b) == '1') {
															$b = '0'.$b;
														}
														echo '<option value="'.$b.'">'.$b.'</option>';
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
														echo '<option value="'.$y.'">'.$y.'</option>';
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left">
													Default End Time:
												</td>
												<td class="right">
													<select name='end_hour' class="textbox1">
													<?php
													foreach ($hour as $a=>$b) {
														if (strlen($b) == '1') {
															$b = '0'.$b;
														}
														echo '<option value="'.$b.'">'.$b.'</option>';
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
														echo '<option value="'.$y.'">'.$y.'</option>';
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
													<input name="add_course" type="submit" value="Next" class="submit3">
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
