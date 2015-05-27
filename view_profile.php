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
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');


	// algorith to determine this user's courses

	$schedule_array = array();
	$query = "select ca.id, ca.course_id, ca.start_date, ca.dates, ca.start_time, ca.end_time, ca.resources, ca.reg_online, c.center, c.type, c.name, r.id'registration_id', r.status from calendar as ca left join registrations as r on (r.calendar_id = ca.id) left join courses as c on (ca.course_id = c.id) where r.user_id = '$user->id' order by ca.start_date, c.center, c.type, ca.start_time, c.name";
	$result = tep_db_query($query);
	$courses_error = false;
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			if (date("Y-m-d", mktime(0, 0, 0, substr($row['start_date'],5,2), substr($row['start_date'],-2,2)+$row['duration']-1, substr($row['start_date'],0,4))) >= date("Y-m-d"))
				$past = false;
			else
				$past = true;

			//if ((substr($row['start_date'],5,2) == date("m") && (substr($row['start_date'],-2,2)+$row['duration']-1) >= date("d")) || (substr($row['start_date'],5,2) > date("m") && substr($row['start_date'],0,4) >= date("Y"))) {
				$schedule_array[] = array('id' => $row['id'],
							  'date' => $row['start_date'],
							  'course_id' => $row['course_id'],
							  'center' => $row['center'],
							  'type' => $row['type'],
							  'name' => $row['name'],
							  'dates' => unserialize($row['dates']),
							  'start_time' => $row['start_time'],
							  'end_time' => $row['end_time'],
							  'resources' => unserialize($row['resources']),
							  'reg_online' => $row['reg_online'],
							  'status' => $row['status'],
							  'registration_id' => $row['registration_id'],
							  'past' => $past);
		}
	}
	else
	{
		$courses_error = true; //no courses have been registered for.
	}


	// template for page build

	?>

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Profile Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing Profile</td>
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
										<table width="100%">
											<tr>
												<td class="right">
													<span class="subtitle2"><?php echo $user->username; ?>&nbsp;&nbsp;&nbsp;</span>(<a href="edit_profile.php">Edit Profile</a>)
												</td>
												<td class="left">
													<?php
													if ($user->instructor == '1') {
														$instructor = new instructor(tep_get_username($_GET['id']));
														$instructor->instructor_attributes();
														?><img src="<?php echo RELATIVE_UPLOAD_DIR."/".$instructor->photo;?>" height="90" width="70"><?php
													}
													else
														echo '&nbsp';
													?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;

									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Contact Details:</h4>
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Name:
												</td>
												<td class="right">
													<?php echo $user->firstname.' '.$user->middlename.' '.$user->lastname.' '.$user->lastname2; ?>
												</td>
											</tr>
											
										  <tr>
												<td width="30%" class="left">
													Email:
												</td>
												<td class="right">
													<?php echo $user->email; ?>
												</td>
											</tr>
											
											<tr>
												<td width="30%" class="left">
													Country:
												</td>
												<td class="right">
													<?php echo tep_get_name(TABLE_COUNTRIES, $user->country); ?>
												</td>
											</tr>
											
																					
											<tr>
												<td width="30%" class="left">
													Original Name:
												</td>
												<td class="right">
													<?php echo $user->fullname; ?>
												</td>
											</tr>
											
											<tr>
												<td width="30%" class="left">
													Net ID:
												</td>
												<td class="right">
													<?php echo $user->netid; ?>
												</td>
											</tr>
											
												<tr>
												<td width="30%" class="left">
													TNID:
												</td>
												<td class="right">
													<?php echo $user->tnid; ?>
												</td>
											</tr>
											
											<td width="30%" class="left">
													Project:
												</td>
												<td class="right">
													<?php echo tep_get_project_name($user->id); ?>
												</td>
											</tr>
											
											
											
											<tr>
												<td class="left">
													Work Phone:
												</td>
												<td class="right">
													<?php echo $user->work_telephone; ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							
								<!-- The schedule of this user -->
								<tr>
									<td>
										<table width="100%">
											<tr>
												<td class="hright">
													Course Schedule
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<table width="100%">
											<tr>
												<td class="hright">
													Date
												</td>
												<td class="hright">
													Course
												</td>
												<td class="hright">
													Centre
												</td>
												<td class="hright">
													Start Time
												</td>
												<td class="hright">
													Status
												</td>
												<td class="hright">
													Action
												</td>
											</tr>
											<?php
											$date_temp = '';
											$center_temp = '';
											$type_temp = '';
											foreach ($schedule_array as $x=>$y) {
													if ($date_temp != $y['date']) {
														$date_temp = $y['date'];
														?>
														<tr>
															<td class="right"><span class="heading"><?php if ($y['past']) { echo '<font color="orange">'; } echo $y['date'] ?></td>
														<?php
														$center_temp = '';
														$type_temp = '';
													}
													else
													{
														?><td class="right">&nbsp;</td><?php
													}
													?><td class="right"><?php echo '<a href="view_course.php?id='.$y['course_id'].'">'.$y['name']; ?></a></td><?php
													if ($center_temp != $y['center']) {
														$center_temp = $y['center'];
														?>
															<td class="right"><?php echo tep_get_name(TABLE_CENTERS, $y['center']); ?></span></td>
														<?php
														$type_temp = '';
													}
													else
													{
														?><td class="right">&nbsp;</td><?php
													}
													if ($type_temp != $y['type']) {
														$type_temp = $y['type'];
													}
													?>



														<td class="right"><?php echo substr($y['start_time'],0,5) ?></td>
														<td class="right"><?php
															if ($y['past'])
																echo '<font color="red"><a href="reporting.php?calendar_id='.$y['id'].'&user_id='.$user->id.'">Report</a></font>';
															else
																echo tep_get_name(TABLE_STATUS, $y['status']);


															?>
														</td>
														<td class="left">
															<a href="course_registrations.php?id=<?php echo $y['id']; ?>">View Details</a>
														</td>
													</tr>
													<?php
												}
											//}
											if ($courses_error) { ?>
												<tr>
													<td colspan="6" class="right">
														<font color="red">You do not yet have any courses. Use the menu to view the schedule and select courses to register for.</font>
													</td>
												</tr>
												<?php
											}
											?>
										</table>
										<!-- if user is an instructor list courses they are to instruct on here -->
										<?php
										if ($user->instructor==1) {
										?>



											<table width="100%">
												<tr>
													<td colspan="5" class="hright">Instructor Schedule</td>
												</tr>
												<tr>
													<td class="hright">Course ID</td>
													<td class="hright">Dates</td>
													<td class="hright">Course</td>
													<td class="hright">Other Instructors</td>
													<td class="hright">Cancelled</td>
												</tr>
												<?php
												//add courses instructor instructs on in here
												$instructor->get_instructor_courses();

												foreach ($instructor->courses as $a=>$b) {

													$scheduled = new scheduled(tep_get_course_id($b['id']));
													$scheduled->set_calendar_vars($b['id']);
													if ($scheduled->cancelled) {
														$class='h3right';
													}
													else
													{
														$class='right';
													}
													$dates = unserialize($b['dates']);
													?>
													<tr>
														<td class="<?php echo $class; ?>"><?php echo $b['id']; ?></td>
														<td class="<?php echo $class; ?>">
														<?php
															foreach ($dates as $c=>$d) {
																echo tep_swap_dates($d).'<br>';
															}
														?>
														</td>
														<td class="<?php echo $class; ?>"><a href="course_registrations.php?id=<?php echo $b['id']; ?>"><?php echo tep_get_course_name(tep_get_course_id($b['id'])); ?></a></td>
														<td class="<?php echo $class; ?>"><?php
															// TODO: Add instructor list here
														?>
														</td>
														<td class=<?php echo $class; ?>>
																<?php echo $scheduled->cancelled; ?>
														</td>

													</tr>
													<?php
												}
												?>

											</table>
										<?php
										}
										?>
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