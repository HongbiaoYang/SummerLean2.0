<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	// page to display schedule
	$access_level = '3';
	$access_error = false;

	include('includes/application_top.php');
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	$course_start_date = false;
	$min_date = false;
	if (isset($_REQUEST['course_id'])) {
		$course_id = $_REQUEST['course_id'];
	}
	if (isset($_REQUEST['course_id'])&&strlen($_REQUEST['course_id']) > 0) {
		// lets find first date of this course and jump the calendar to this date
		$t_date = date('Y-m-d');
		$query = "select min(start_date)'min_date', max(start_date)'max_date' from " .
				"calendar " .
				"where " .
				"course_id = '$course_id' and start_date > '$t_date'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			$row = tep_db_fetch_array($result);
			if (!isset($_REQUEST['month'])) {
				$course_start_date = $row['min_date'];
				$last_course_date = $row['max_date'];
			}
			$min_date = $row['min_date'];
			$max_date = $row['max_date'];
			$max_date = date('Y-m-d', mktime(0,0,0, substr($max_date,5,2)+1, substr($max_date,9,2), substr($max_date,0,4)));
		}
	}
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'register') {
			$user_id = $_GET['id'];
			$user = new user(tep_get_username($user_id));
			$user->set_profile();
		}
	}
	// filter
	$where_array = array();
	if (isset($_POST['filter'])) {
		$center = $_POST['center'];
		$type = $_POST['type'];
		$category = $_POST['category'];
		$course = $_POST['course'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		if (strlen($month) == 1)
			$month = '0'.$month;
		$year = $_POST['year'];
		$range = tep_get_month_range($month, $year);
		$start_date = $year.'-'.$month.'-01';
		$end_date = $year.'-'.$month.'-'.$range;
	}
	else if (isset($_GET['month'])||isset($_GET['start_date']))
	{
		$start_date = $_GET['start_date'];
		$year = substr($start_date,0,4);
		$month = substr($start_date,5,2);
		if ($_GET['month'] == 'previous') {
			$start_date = date('Y-m-d', mktime(0,0,0,$month-1,1,$year));
		}
		else if ($_GET['month'] == 'next') {
			$start_date = date('Y-m-d', mktime(0,0,0,$month+1,1,$year));
		}
		$month = substr($start_date,5,2);
		$year = substr($start_date,0,4);
		$range = tep_get_month_range($month, $year);
		$end_date = date('Y-m-d', mktime(0,0,0,$month, $range, $year));

		$center = $_GET['center'];
		$category = $_GET['category'];
		$type = $_GET['type'];
	}
	else
	{
		$range = tep_get_month_range(date('m'),date('Y'));
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		$start_date = date('Y').'-'.date('m').'-01';
		$end_year = date('Y');
		$end_date = $end_year.'-'.date('m').'-'.$range;
	}
	// building the where clause for the SQL to filter out results
	if ($course_start_date) {
		$start_date = substr($course_start_date,0,4).'-'.substr($course_start_date,5,2).'-01';
		$month = substr($start_date,5,2);
		$year = substr($start_date,0,4);
		$range = tep_get_month_range($month, $year);
		$end_date = date('Y-m-d', mktime(0,0,0,$month, $range, $year));
	}
	if ($center >= 1) {
		$where_array['center'] = $center;
	}
	if ($type >= 1) {
		$where_array['type'] = $type;
	}
	if ($category >= 1) {
		$where_array['category'] = $category;
	}
	if ($course_id >= 1) {
		$where_array['id'] = $course_id;
	}
	$counter = 0;
	foreach ($where_array as $a=>$b) {
		if ($counter == 0) {
			$where_clause = 'c.'.$a.' = '.$b;
		}
		else
		{
			$where_clause .= ' and c.'.$a.' = '.$b;
		}
		$counter++;
	}
	// end where clause
	$action = $_GET['action'];
	switch ($action) {
		case 'cancel': if (tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['course_id']))) {
						// THIS ACTION CANNOT TAKE PLACE IF USERS ARE STILL ACTIVELY REGISTERED ON THIS COURSE
						// TODO: this is where i'm at
						$calendar_id = $_GET['id'];
						$scheduled = new scheduled(tep_get_course_id($_GET['id']));
						$scheduled->set_calendar_vars($_GET['id']);
						if (count($scheduled->users) > 0) {
							$require_error = true;
							$error = "You have to cancel or reschedule all current candidates on this course to cancel it. <a href='course_registrations.php?id=".$calendar_id."'>Return to Course Registrations</a>";
						}
						else
						{

							tep_cancel_course($_GET['id']);
							header("Location: course_registrations.php?id=$calendar_id");
						}
				}
				else
				{
					$access_error = true;
					$error = PERMISSION_ERROR;
				}
				break;
			case 'reschedule': if (tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['course_id']))) {
									tep_reschedule_course($_GET['id']);
								}
								else
								{
									$access_error = true;
									$error = PERMISSION_ERROR;
								}
								break;
	}
	$schedule_array = array();
	if (strlen($where_clause)>0) {
		$query = "select ca.id, " .
				"ca.course_id, " .
				"ca.start_date, " .
				"ca.start_time, " .
				"ca.end_time, " .
				"ca.dates, " .
				"ca.resources, " .
				"ca.cancelled, " .
				"c.center, " .
				"c.type, " .
				"c.name " .
				"from calendar as ca " .
				"left join " .
				"courses as c " .
				"on (ca.course_id = c.id) " .
				"where ".$where_clause." " .
				"order by " .
				"ca.start_date, " .
				"c.center, " .
				"c.type, " .
				"ca.start_time, " .
				"c.name";
	}
	else
	{
		$query = "select ca.id, " .
				"ca.course_id, " .
				"ca.start_date, " .
				"ca.start_time, " .
				"ca.end_time, " .
				"ca.dates, " .
				"ca.resources, " .
				"ca.cancelled, " .
				"c.center, " .
				"c.type, " .
				"c.name " .
				"from calendar as ca " .
				"left join " .
				"courses as c on (ca.course_id = c.id) " .
				"order by " .
				"ca.start_date, " .
				"c.center, " .
				"c.type, " .
				"ca.start_time, " .
				"c.name";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		foreach (unserialize($row['dates']) as $a=>$date) {
			if ($min_date) {
					$schedule_array[] = array(	'date' => $date,
												'course_id' => $row['course_id'],
												'id' => $row['id'],
												'cancelled' => $row['cancelled']);
			}
			else
			{
					$schedule_array[] = array(	'date' => $date,
												'course_id' => $row['course_id'],
												'id' => $row['id'],
												'cancelled' => $row['cancelled']);
			}
		}
	}
	$course_start_date = $row['min_date'];
	$last_course_date = $row['max_date'];
	function cmp($a, $b) {
		return strnatcasecmp( $a['date'], $b['date'] );
	}
	usort($schedule_array, "cmp");
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
			<td class="title" height="27" colspan=3>&nbsp;Schedule</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<?php
			if (isset($_GET['action'])&&$_GET['action'] == 'register') {?>
					<td height="18" class="subtitle" valign="bottom" width="20%">Registering: <?php echo $user->firstname.' '.$user->lastname; ?></td>
				<?php
			}
			else
			{
				?><td height="18" class="subtitle" valign="bottom" width="20%">Viewing Schedule</td><?php
			}
			?>
			<td width="83%"><IMG src="images/right.gif"></td>
		</tr>
	</TABLE>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="middle">
				<!-- main content starts here -->
				<table width="90%" align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<table width='100%'>
								<!-- CONTENT -->
								<?php
								if ($access_error||$require_error) {
								?>
									<tr>
										<td><font color="red">
											<?php echo $error; ?></font>
										</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td>
										<table width="100%">
											<tr>
												<?php
												if (isset($_GET['action'])) {
													?><form name="filter" action="view_schedule.php?action=<?php echo $_GET['action']; ?>&course_id=<?php echo $_GET['course_id']; ?>&id=<?php echo $_GET['id']; ?>" method="post"><?php
												}
												else
												{
												?>
													<form name="filter" action="view_schedule.php" method="post">
												<?php
												}
												?>
												<td class="left">Venue:</td><td class="right"><?php echo tep_build_dropdown(TABLE_CENTERS, center, false, 1, '', true, $_REQUEST['center']); ?></td>
												<td class="left">Type:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_TYPES, type, false, 1, '', true, $_REQUEST['type']); ?></td>
												<td class="left">Category:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_CATEGORIES, category, false, 1, '', true, $_REQUEST['category']); ?></td>
												<td class="left">Course:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSES, course_id, false, 1, '', true, $_REQUEST['course_id']); ?></td>
											</tr>
											<tr>
												<td class="left">Year:</td><td class="right"><?php echo tep_build_date_dropdown('year','year', $year, $month, $day, 8,5); //build_date_dropdown(menu_name, type: year/month/day, selected_date, lead_in, lead_out)
												?></td>
												<td class="left">Month:</td><td class="right"><?php echo tep_build_date_dropdown('month','month', $year, $month, $day); //no lead in or lead out options
												?></td>
												<td class="left">&nbsp;</td>
												<td class="right">&nbsp;</td>
												<td class="left"><a href="view_schedule.php">Reset</a></td>
												<td class="left"><input type="submit" name="filter" class="submit3" value="Filter"></td>
												</form>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="left">
										<table width="100%">
											<tr>
												<td width="80%">
													<h4>Schedule:&nbsp;&nbsp;<?php echo tep_swap_dates($start_date); ?>&nbsp;to&nbsp;<?php echo tep_swap_dates($end_date);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<a href="view_schedule.php?month=previous&start_date=<?php echo $start_date; ?>&center=<?php echo $center; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&action=<?php echo $_GET['action']; ?>&id=<?php echo $_GET['id'] ?>&course_id=<?php echo $_REQUEST['course_id']; ?>"> < Previous</a>&nbsp;|&nbsp;<a href="view_schedule.php?month=next&start_date=<?php echo $start_date; ?>&center=<?php echo $center; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&action=<?php echo $_GET['action']; ?>&id=<?php echo $_GET['id'] ?>&course_id=<?php echo $_REQUEST['course_id']; ?>">Next ></a></h4>
												</td>
												<td>
													<a href="view_instructor_schedule.php?start_date=<?php echo $start_date; ?>">Instructor Schedule</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<?php
								if (isset($_GET['action'])) {
									if ($_GET['action'] == 'register') {
										?>
										<tr>
											<td class="hright"><font size="2px">Select a course to register user: <b><?php echo $user->firstname.' '.$user->lastname; ?></b>. Click <a href="view_schedule.php">here</a> to return to viewing the normal schedule.</font></td>
										</tr>
										<?php
									}
								}
								if (count($schedule_array) == 0) { ?>
									<tr>
										<td class="right">
											There are no scheduled courses.
										</td>
									</tr>
								<?php
								}
								?>
					<tr>
						<td colspan=3 align=right></td>
					</tr>
				</table>
			</tr>
		</td>
		</table>
		<table width="90%" align="center">
			<tr>
				<td><?php echo tep_schedule_calendar(substr($start_date,0,4), substr($start_date,5,2), $schedule_array); ?></td>
			</tr>
		</table>
		<?php
		// add other instances of a course if action = register or course_id is set
		if (isset($_REQUEST['course_id']) && strlen($_REQUEST['course_id']) > 0) {
		?>
			<table width="90%" align="center">
				<tr>
					<td class="hright" colspan="4"><span class="head">All dates for <?php echo tep_get_name(TABLE_COURSES, $_REQUEST['course_id']); ?>:</span></td>
				</tr>
				<tr>
					<td class="hcenter" width="4%"><span class="head">ID</span></td>
					<td class="hleft" width="25%"><span class="head">Start Date:</span></td>
					<td class="hleft" width="25%"><span class="head">Course Name</span></td>
					<td class="hleft" width="25%"><span class="head">Action</span></td>
				</tr>
				<?php
				$temp_id = 0;
				if (count($schedule_array) == 0) {
					?>
					<tr>
						<td class="right" colspan="4">No future courses scheduled.</td>
					</tr>
					<?php
				}
				else
				{
					foreach ($schedule_array as $a => $b) {
						if ($b['date'] > date('Y-m-d') && $b['id'] != $temp_id) {

							$temp_id = $b['id'];
							?>
							<tr>
								<td class="left"><?php echo $b['id']; ?></td>
								<td class="left"><?php echo $b['date']; ?></td>
								<td class="left"><?php echo tep_get_name(TABLE_COURSES, $b['course_id']); ?></td>
								<?php
								if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'register') {
								?>
									<td class="left"><a href="course_register.php?id=<?php echo $b['id']; ?>&user_id=<?php echo $_REQUEST['id']; ?>">Register</a></td>
								<?php
								}
								else
								{
								?>
									<td class="left"><a href="course_registrations.php?id=<?php echo $b['id']; ?>">View Details</a></td>
								<?php
								}
								?>

							</tr>
							<?php
						}
					}
				}
				?>
			</table>
		<?php
		}
		?>
	</td>
</tr>
</TABLE>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'wide_footer.php');
?>
