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
	
	if ($user->instructor == 1) {
	    $user = new instructor($user->username);
	} else {
	    $user->set_profile();
  }
	
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

	//Get details of all courses not yet registered
	//filter to show courses only valid for this users job title
	If (JOB_REQUIREMENTS=='true') {
		If ($where_clause>0) $where_clause .= " and ";
			$where_clause .= " requirement_type='job' and requirement_id=".$user->job_title_id;
	}
	$course_array = tep_get_courses($where_clause);
	if (empty($course_array)) {
	?>
		<tr>
			<td class="right">
			<?php
				$avail_courses= 'There are no courses available';
			?>
			</td>
		</tr>
		<?php
	}


	// template for page build

	?>

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;My Courses</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%"></td>
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
						<td><center><A HREF="javascript:window.print()">Click to Print This Page</A></center>
						</td>
					</tr>
					<tr>
						<td>
						
							<table width='100%'>
								<!-- CONTENT -->
								<!-- The schedule of this user -->
								<tr>
									<td>
										<table width="100%">
											<tr>
												<td class="hright">
													<b>Registered Courses</b>
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
															<td class="right"><span class="heading"><?php if ($y['past']) { echo '<font color="#FF9422">'; } echo $y['date'] ?></td>
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
																//echo '<font color="red"><a href="reporting.php?calendar_id='.$y['id'].'&user_id='.$user->id.'">Report</a></font>';
																echo 'Completed';
															else
																echo tep_get_name(TABLE_STATUS, $y['status']);


															?>
														</td>
														<td class="left">
															<a href="course_cancel.php?id=<?php echo $y['id']; ?>">Cancel</a>&nbsp;
															<a href="course_registrations.php?id=<?php echo $y['id']; ?>">View</a>
														</td>
													</tr>
													<?php
												}
											//}
											if ($courses_error) { ?>
												<tr>
													<td colspan="6" class="right">
														<font color="red">No courses scheduled.</font>
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

                        <!--

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
											-->
										<?php
										}
										?>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								 <tr><td>		<table width="100%">
											<tr>
												<td class="hright">
													<b>Available Courses</b>
												</td>
											</tr>
				<?php
	if (!empty($course_array))
	foreach ($course_array as $a => $b) {
		if ($b['center'] != $temp_center) {
			$temp_center = $b['center'];
			$temp_type = '';
			$temp_cat = '';
			echo '<tr><td colspan="2" class="hright"><span class="head">Centre: '.tep_get_name(TABLE_CENTERS, $temp_center).'</span></td></tr>';
		}
		if ($b['type'] != $temp_type) {
			$temp_type = $b['type'];
			$temp_cat = '';
			echo '<tr><td colspan="2" class="h2right"><span class="head">Course Type: '.tep_get_name(TABLE_COURSE_TYPES, $temp_type).'</span></td></tr>';
		}
		if ($b['category'] != $temp_cat) {
			$temp_cat = $b['category'];
			echo '<tr><td colspan="2" class="h3right"><span class="head">Category: '.tep_get_name(TABLE_COURSE_CATEGORIES, $temp_cat).'</span></td></tr>';
		}
		echo '<tr><td class="left" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<a href="view_course.php?id='.$b['id'].'">'.$b['name'].'</a></td>
				<td class="left"><a href ="view_schedule.php?action=register&id='.$user->id.'&course_id='.$b['id'].'">Register</a></td></tr>';
	}
	Else {?>	<tr>
				<td colspan="6" class="right">
					<font color="green">There are no available courses for you to register.</font>
				</td>
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
