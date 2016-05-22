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
	$_SESSION['learner']->set_profile();
	$user = $_SESSION['learner'];
	$course_id = tep_get_course_id($_GET['id']);
	$scheduled = new scheduled($course_id);
	$scheduled->set_calendar_vars($_GET['id']);
	$calendar_id = $_GET['id'];

	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');

	if (isset($_POST['user_manage'])) {
		$outcome = tep_set_new_reg_type($_GET['user_id'], $_GET['id'], $_POST['status'], $scheduled->registered, $scheduled->waiting_list, $scheduled->max_attendance);
		if ($outcome) {
			$sql_array = array('status' => $_POST['status']);
			tep_db_perform(TABLE_REGISTRATIONS, $sql_array, 'update', "user_id = '".$_GET['user_id']."' and calendar_id='".$_GET['id']."'");
			$note = 'Status changed to:&nbsp;';
			if ($_POST['status'] == '1')
					$note .= STATUS1;
			else if ($_POST['status'] == '2')
					$note .= STATUS2;
			else if ($_POST['status'] == '3')
					$note .= STATUS3;
			else if ($_POST['status'] == '4')
					$note .= STATUS4;
			$sql_array = array('admin_id' => $_SESSION['admin_user']->id,
							  'user_id' => $_GET['user_id'],
							  'calendar_id' => $_GET['id'],
							  'description' => $note,
							  'cDate' => date('Y-m-d H:i:s'),
							  'deleted' => 0);
			tep_db_perform(TABLE_NOTES, $sql_array);
		}
		$course_id = tep_get_course_id($_GET['id']);
		$scheduled = new scheduled($course_id);
		$scheduled->set_calendar_vars($_GET['id']);
	}

	$_SESSION['scheduled'] = $scheduled;
	$user = $_SESSION['learner'];
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
			<td height="18" class="subtitle" valign="bottom" width="12%">Course Registrations</td>
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
								<tr>
									<td class="left">
										<span class="courseHeading">Start Date:</span>
									</td>
									<td class="right">
										<?php echo date("l", mktime(0,0,0,substr($scheduled->start_date,5,2),substr($scheduled->start_date,-2,2),substr($scheduled->start_date,0,4))).' '.tep_swap_dates($scheduled->start_date); ?>
									</td>
								</tr>
								<tr>
												<td class="left" width="30%">
													<span class="courseHeading">Course:</span>
												</td>
												<td class="right">
													<?php echo $scheduled->name; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Course Type:</span>
												</td>
												<td class="right">
													<?php echo tep_get_name(TABLE_COURSE_TYPES, $scheduled->type); ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Centre:</span>
												</td>
												<td class="right">
													<?php echo tep_get_name(TABLE_CENTERS, $scheduled->center); ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Category</span>
												</td>
												<td class="right">
													<?php echo tep_get_name(TABLE_COURSE_CATEGORIES, $scheduled->category); ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Description:</span>
												</td>
												<td class="right">
													<?php echo $scheduled->description; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Attendance Restrictions:</span>
												</td>
												<td class="right">
													Minimum Attendance:&nbsp;&nbsp;<?php echo $scheduled->min_attendance; ?><br>
													Maximum Attendance:&nbsp;&nbsp;<?php echo $scheduled->max_attendance; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Requirements:</span>
												</td>
												<td>
													&nbsp;
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Job Titles:</span>
												</td>
												<td class="right">
												<?php
												if (count($scheduled->job) > 0) {
													foreach ($scheduled->job as $job_id) { ?>
															<?php	echo tep_get_name(TABLE_JOBS, $job_id); ?><br>
													<?php
													}
													?></td><?php
												}
												else
												{
													?>
														None
													</td>
													<?php
												}
												?>
											<tr>
												<td class="left">
													<span class="courseHeading">Specialties:</span>
												</td>
												<td class="right">
											<?php
											if (count($scheduled->specialty) > 0) {
												foreach ($scheduled->specialty as $specialty_id) { ?>
													<?php	echo tep_get_name(TABLE_SPECIALTIES, $specialty_id).'<br>';
												}
												?></td><?php
											}
											else
											{
												?>
													None
												</td>
												<?php
											}
											?>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Bands:</span>
												</td>
												<td class="right">
											<?php
											if (count($scheduled->band) > 0) {
												foreach ($scheduled->band as $band_id) { ?>
													<?php	echo tep_get_name(TABLE_BANDS, $band_id); ?>
												<?php
												}
												?></td><?php
											}
											else
											{
												?>
													None
												</td>
												<?php
											}
											?>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Dates:</span>
												</td>
												<td class="right">
													<?php
													foreach ($scheduled->dates as $a=>$date) {
														if ($date < date("Y-m-d")) {
															echo '<font color="red">';
														}
														echo tep_swap_dates($date).'<br>';
														if ($date < date("Y-m-d")) {
															echo '</font>';
														}
													}
													?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Time:</span>
												</td>
												<td class="right">
													<?php echo $scheduled->start_time.' - '.$scheduled->end_time; ?>
												</td>
											</tr>
								<tr>
									<td colspan="2">&nbsp;

									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td><a href="course_register.php?id=<?php echo $_GET['id']; ?>&user_id=<?php echo $user->id; ?>">Register</a></td>
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
