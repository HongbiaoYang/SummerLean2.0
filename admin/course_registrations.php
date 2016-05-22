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
	$_SESSION['admin_user']->set_profile();

	$course_id = tep_get_course_id($_GET['id']);
	$scheduled = new scheduled($course_id);
	$scheduled->set_calendar_vars($_GET['id']);
	$calendar_id = $_GET['id'];

	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');

	if (isset($_POST['user_manage'])) {
		//$outcome = tep_set_new_reg_type($_GET['user_id'], $_GET['id'], $_POST['status'], $scheduled->registered, $scheduled->waiting_list, $scheduled->max_attendance);

		//if ($outcome) {

			$status_name = tep_get_name(TABLE_STATUS, $_POST['status']);
			if ($status_name == 'Cancelled') {
				$sql_array = array('status' => $_POST['status'],
									'cancelled' => '1');
			}
			else
			{
				$sql_array = array('status' => $_POST['status'],
									'cancelled' => '0');
			}
			tep_db_perform(TABLE_REGISTRATIONS, $sql_array, 'update', "user_id = '".$_GET['user_id']."' and calendar_id='".$_GET['id']."'");
			$note = 'Status changed to:&nbsp;'.tep_get_name(TABLE_STATUS, $_POST['status']);
			$sql_array = array('admin_id' => $_SESSION['admin_user']->id,
							  'user_id' => $_GET['user_id'],
							  'calendar_id' => $_GET['id'],
							  'description' => $note,
							  'cDate' => date('Y-m-d H:i:s'),
							  'deleted' => 0);
			tep_db_perform(TABLE_NOTES, $sql_array);
		//}
		$course_id = tep_get_course_id($_GET['id']);
		$scheduled = new scheduled($course_id);
		$scheduled->set_calendar_vars($_GET['id']);
	}

	$_SESSION['scheduled'] = $scheduled;
	$user = $_SESSION['admin_user'];
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
										<?php echo date("l", mktime(0,0,0,substr($scheduled->start_date,5,2),substr($scheduled->start_date,-2,2),substr($scheduled->start_date,0,4))).' '.tep_swap_dates($scheduled->start_date); ?>&nbsp;&nbsp;<a href="edit_schedule_attributes.php?calendar_id=<?php echo $_GET['id']; ?>&id=<?php echo $course_id; ?>">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="course_registrations.php?id=<?php echo $_GET['id']; ?>#users">Registered Users</a>&nbsp;|&nbsp;<a href="javascript:open_new_window('add_note.php?cal_id=<?php echo $scheduled->calendar_id; ?>');">Add Note</a>
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
													<?php	echo tep_get_name(TABLE_SPECIALTIES, $specialty_id);
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
											<!-- HERE COMES THE BLOCK OF LEARNER STATUSES AS DETERMINED BY THE STATUS TABLE -->
											<tr>
												<td class="left"><span class="courseHeading">Learner Status:</span></td>
												<td class="right">&nbsp;</td>
											</tr>
											<?php
											$status_array = tep_get_status();
											foreach ($status_array as $r=>$s) {
												?>
												<tr>
													<td class="left"><?php echo tep_get_name(TABLE_STATUS, $s['id']); ?></td>
													<td class="right"><?php echo tep_get_status_amount($s['id'], $scheduled->calendar_id); ?></td>
												</tr>
												<?php
											}
											?>
											<tr>
												<td class="left">
													<span class="courseHeading">Cancelled:</span>
												</td>
												<td class="right">
													<?php $cancelled_text = ($scheduled->cancelled == 0) ? 'This course has not been cancelled. | <a href="view_schedule.php?action=cancel&id='.$scheduled->calendar_id.'">Cancel</a>' : '<font color="red">This course has been cancelled</font> | <a href="view_schedule.php?action=reschedule&id='.$scheduled->calendar_id.'">Reverse Cancellation</a>';
													echo $cancelled_text;
													?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<span class="courseHeading">Instructors</span>
												</td>
												<td class="right">
													<?php
													if (is_array($scheduled->instructors)) {
														foreach ($scheduled->instructors as $h=>$i) {
															echo '<a href="view_profile.php?id='.$i.'">'.tep_get_instructor_name($i).'</a><br>';
														}
													}
													else
													{
														echo "None";
													}
													?>
												</td>
											</tr>
								<tr>
									<td colspan="2">&nbsp;

									</td>
								</tr>
							</table>
							<?php
							//if ($scheduled->start_date > date('Y-m-d')) { //manage users options
							?>
							<table width="100%">
								<tr>
									<td colspan="2"><h4><a name="users">&nbsp;</a>Manage Users for this Course</h4>&nbsp;<a href="select_trainee.php?calendar_id=<?php echo $_GET['id']; ?>">Add Trainee</a></td>
								</tr>
								<tr>

									<td>
									<?php
										$users = array();
										$users = tep_get_registered_users($_GET['id']); //get registered users for this scheduled course
										if (count($users) > 0) {
											// create downloadable csv file format: coursename_year_month_day.csv
											// disabled for now
											// $export_filename = tep_userexport($course_id, $users, $calendar_id);
											foreach ($users as $v => $u) {
												//$reg_user = new user(tep_get_username($u['user_id']));
												?>
												<tr>
													<form name="user_manage" action="course_registrations.php?id=<?php echo $_GET['id'];?>&user_id=<?php echo $u['user_id']?>#users" method="post">
													<td class="right">
														<?php
															$user = new user(tep_get_username($u['user_id']));
															$user->set_profile();
															echo '<a href="view_profile.php?id='.$u['user_id'].'">'.$user->firstname.' '.$user->lastname.'</a>'; ?>
													</td>
													<td class="right">
													<?php
														echo tep_get_name(TABLE_STATUS, $u['status']);
													?>
													</td>
													<td class="left">
														<?php
														echo tep_build_dropdown(TABLE_STATUS, 'status', false, 1, '', false, '', 'name', '--Select--', 'id');
														?>
													</td>
													<td class="left">
														<input name="user_manage" type="submit" class="submit3" value="Submit" />
													</td>
													<?php
														$user_id = $u['user_id'];
														$cal_id = $_GET['id'];
													?>
													<td class="left"><input type="submit" value="Add Note" class="submit3" onClick="open_new_window('add_note.php?<?php echo 'user_id='.$user_id.'&cal_id='.$cal_id;?>', 'Add Note');"></td>
													</form>
												</tr>
											<?php
											}
											// put export link here
											?>
											<tr>
												<td colspan="5" class="left"><a href="download_export.php?filename=<?php echo $export_filename; ?>">Export Users</a></td>
											</tr>
											<?php
										}
										else
										{
										?>
											None
										<?php
										}
										?>

									</td>
								</tr>
							</table>
							<?php
							//}
							//else		// reporting options
							//{
							if ($scheduled->start_date < date('Y-m-d')) {
								$users = array();
								$users = tep_get_registered_users($_GET['id']);
								?>

								<table width="100%">
									<tr>
										<td colspan="2"><h4><a name="users">&nbsp;</a>Manage Reporting for this Course</h4><br /><a href="course_attendance.php?calendar_id=<?phpEcho $_GET['id'];?>">Click here to edit</a></td>
									</tr>
									<tr>
										<td>
										<table width="100%">
										<?php
											if (count($users) > 0) {
												foreach ($users as $v=>$u) {
													$user = new user(tep_get_username($u['user_id']));
													$report = new report($scheduled->calendar_id, $user->id);
													$user->set_profile();
													?>
													<tr>
														<td class="right" width="30%"><?php echo '<a href="view_profile.php?id='.$user->id.'" title="'.$user->firstname.' '.$user->lastname.', '.$user->hospital_name.'">'.$user->username.'</a>'; ?></td>
														<td class="right" width="15%"><?php if ($report->attended == 1) echo 'Attended'; elseif ($report->attended == 2) echo 'Not Attended'; elseif ($report->attended == 3) echo 'ILL'; else echo 'N/A'; ?></td>
													</tr>
													<?php
												}

											}
											else
											{
												?>
												None
												<?php
											}
											?>
										</table>
										</td>
									</tr>
								</table>
								<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<table width="100%">
								<tr>
									<td class="hright" colspan="2"><span class="head">Notes:</span></td>
								</tr>
								<?php
									$notes = tep_get_calendar_notes($scheduled->calendar_id);
									//var_dump($notes);
									foreach ($notes as $a=>$b) {
										$note = new note($b);
										$user = new user(tep_get_username($note->user_id));
										$user->set_profile();



										$admin_user = new user(tep_get_username($note->admin_id));
										$admin_user->set_profile();
										?>
											<tr>
												<td class="hright" width="50%"><?php if ($note->user_id != '0') { echo 'User: <span class="head">'.$user->firstname.' '.$user->lastname.'</span>'; }?></td>
												<td class="hleft"><?php echo 'Created by '.$admin_user->firstname.' '.$admin_user->lastname.' on '.$note->cDate; ?></td>
											</tr>
											<tr>
												<td class="right" colspan="2"><?php echo $note->description; ?></td>
											</tr>
										<?php
									}
									?>
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
