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

	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');


	// algorith to determine this user's courses

	//$user = $_SESSION['admin_user'];
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
	if (isset($_GET['activate'])) {
		if ($_GET['activate']==1)  {
			tep_activate_user($user->id);
		}
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
													<a href="mailto:<?php echo $user->username; ?>"><span class="subtitle2"><?php echo $user->username; ?></span></a>&nbsp;&nbsp;&nbsp;
													(<a href="edit_profile.php?id=<?php echo $user->id; ?>">Edit Profile</a>&nbsp;|&nbsp;
													<a href="javascript:open_new_window('add_note.php?user_id=<?php echo $user->id; ?>');">Add Note</a>&nbsp;|&nbsp;
													<a href="all_courses.php?user_id=<?php echo $user->id; ?>">Register for a Course</a>
													<?php 
													if (tep_get_activation($user->username)==1) {
													?>
														&nbsp;|&nbsp;<a href="view_profile.php?id=<?php echo $user->id; ?>&activate=1">Activate User</a>
													<?php
													}
													?>
													)
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
													<?php echo $user->firstname.' '.$user->lastname; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													Hospital name:
												</td>
												<td class="right">
													<?php echo $user->hospital_name; ?>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td class="left">
													Secondary E-Mail:
												</td>
												<td class="right">
													<a href="mailto:<?php echo $user->email2; ?>"><?php echo $user->email2; ?></a>
												</td>
											</tr>
											<tr>
												<td class="left">
													Home Phone:
												</td>
												<td class="right">
													<?php echo $user->home_telephone; ?>
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
											<tr>
												<td class="left">
													Mobile Phone:
												</td>
												<td class="right">
													<?php echo $user->mobile_telephone; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													Bleep:
												</td>
												<td class="right">
													<?php echo $user->bleep; ?>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td class="left">
													Address Line 1:
												</td>
												<td class="right">
													<?php echo $user->address_line1; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													Address Line 2:
												</td>
												<td class="right">
													<?php echo $user->address_line2; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													City:
												</td>
												<td class="right">
													<?php echo $user->city; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													County:
												</td>
												<td class="right">
													<?php echo $user->county; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													Postcode:
												</td>
												<td class="right">
													<?php echo $user->postcode; ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													Country:
												</td>
												<td class="right">
													<?php echo $user->country; ?>
												</td>
											</tr>

										</table>
									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Registration Details:</h4>
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Job Title:
												</td>
												<td class="right">
													<?php $job_title  =($user->job_title_id == 0) ? 'None' : tep_get_name(TABLE_JOBS, $user->job_title_id);
													echo $job_title; ?>
												</td>
											</tr>
											<tr>
												<td width="30%"  class="left">
													Specialty:
												</td>
												<td class="right">
													<?php $specialty = ($user->specialty_id == 0) ? 'None' : tep_get_name(TABLE_SPECIALTIES, $user->specialty_id); ?>
													<?php echo $specialty; ?>
												</td>
											</tr>
											<tr>
												<td width="30%"  class="left">
													Secondary Specialty:
												</td>
												<td class="right">
													<?php $specialty = ($user->specialty2_id == 0) ? 'None' : tep_get_name(TABLE_SPECIALTIES, $user->specialty2_id); ?>
													<?php echo $specialty; ?>
												</td>
											</tr>
											<tr>
												<td width="30%" class="left">
													Band:
												</td>
												<td class="right">
													<?php $band = ($user->band == 0) ? 'None' : tep_get_name(TABLE_BANDS, $user->band); ?>
													<?php echo $band; ?>
												</td>
											</tr>
											<tr>
												<td>&nbsp;

												</td>
											</tr>
											<tr>
												<td class="left">
													GMC Registration:
												</td>
												<td class="right">
													<?php $gmc_reg = ($user->gmc_reg == 0) ? 'None' : $user->gmc_reg; ?>
													<?php echo $gmc_reg; ?>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td class="left">
													Diet:
												</td>
												<td class="right">
													<?php $diet = ($user->diet == 0) ? 'None' : tep_get_name(TABLE_DIET, $user->diet); ?>
													<?php echo $diet; ?>
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
												<td class="head">
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
													<td colspan="5" class="head">Instructor Schedule</td>
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
																if ($d < date("Y-m-d")) {
																	echo "<font color='red'>".tep_swap_dates($d)."</font>";
																}
																else
																{
																	echo tep_swap_dates($d).'<br>';
																}
															}
														?>
														</td>
														<td class="<?php echo $class; ?>"><a href="course_registrations.php?id=<?php echo $b['id']; ?>"><?php echo tep_get_course_name(tep_get_course_id($b['id'])); ?></a></td>
														<td class="<?php echo $class; ?>"><?php
															foreach ($b['instructors'] as $h=>$i) {
																if ($i != $instructor->id) {
																	$o_instructor = new instructor(tep_get_username($i));
																	$o_instructor->set_profile();
																	echo $o_instructor->firstname.' '.$o_instructor->lastname,'<br>';
																}
															}
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
					<tr>
						<td>
							<table width="100%">
								<tr>
									<td class="hright" colspan="2"><span class="head">Notes:</span></td>
								</tr>
								<?php
									$notes = tep_get_user_notes($user->id);
									//var_dump($notes);
									foreach ($notes as $a=>$b) {
										$note = new note($b);
										$scheduled = new scheduled(tep_get_course_id($note->calendar_id));
										$scheduled->set_calendar_vars($note->calendar_id);
										$user = new user(tep_get_username($note->admin_id));
										$user->set_profile();
										?>
											<tr>
												<td class="hright" width="50%"><?php if ($note->calendar_id != '0') { echo 'Course: '.$scheduled->name.' '.tep_swap_dates($scheduled->start_date); }?></td>
												<td class="hleft"><?php echo 'Created by '.$user->firstname.' '.$user->lastname.' on '.$note->cDate; ?></td>
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