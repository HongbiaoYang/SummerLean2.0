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
	if (isset($_REQUEST['course_id'])) {
		$course_id = $_REQUEST['course_id'];
	}

	if (isset($_POST['add_instructor'])) {
		$sched = new scheduled($_GET['id']);
		$sched->set_calendar_vars($_GET['calendar_id']);
		$calendar_id = $_GET['calendar_id'];
		$sched->instructors[] = $_POST['instructor'];
		$sql_array = array("instructors" => serialize($sched->instructors));
		tep_db_perform(TABLE_CALENDAR, $sql_array, 'update', "id = '$calendar_id'");
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
		$end_date = date('Y').'-'.date('m').'-'.$range;
	}
	// building the where clause for the SQL to filter out results

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
		case 'delete':  if (tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['course_id']))) {
					tep_delete_entry(TABLE_CALENDAR, $_GET['id']);
					// TODO:
					//need to remove registrations for this course
					// this option has been removed from the UI since scheduled instances should not be deleted
				}
				else
				{
					$access_error = true;
					$error = PERMISSION_ERROR;
				}
				break;
		case 'cancel': if (tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['course_id']))) {
					tep_cancel_course($_GET['id']);

				}
				else
				{
					$access_error = true;
					$error = PERMISSION_ERROR;
				}
				break;
	}
	$schedule_array = array();
	if (strlen($where_clause)>0)   {
		$query = "SELECT " .
				"ca.id, " .
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
				"FROM " .
				"calendar as ca left join courses as c on (ca.course_id = c.id) " .
				"WHERE ".$where_clause." " .
						"ORDER BY " .
						"ca.start_date, " .
						"c.center, " .
						"c.type, " .
						"ca.start_time, " .
						"c.name";
	}
	else
	{
		$query = "SELECT " .
				"ca.id, " .
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
				"FROM calendar as ca left join courses as c on (ca.course_id = c.id) " .
				"ORDER BY " .
				"ca.start_date, " .
				"c.center, " .
				"c.type, " .
				"ca.start_time, " .
				"c.name";
	}
	$result = tep_db_query($query);

	while ($row = tep_db_fetch_array($result)) {
		//TODO: need to manipulate all dates
		//var_dump(unserialize($row['dates']));
		foreach (unserialize($row['dates']) as $a=>$date) {
			//echo $date;
			if ($date >= $start_date && $date <= $end_date) {
				$schedule_array[] = array('date' => $date,
											'course_id' => $row['course_id'],
											'id' => $row['id']);
			}
		}
	}
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
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing Schedule</td>
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
													<form name="filter" action="view_instructor_schedule.php" method="post">
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
												<td class="left"><a href="view_instructor_schedule.php">Reset</a></td>
												<td class="left"><input type="submit" name="filter" class="submit3" value="Filter"></td>
												</form>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Schedule:&nbsp;&nbsp;<?php echo tep_swap_dates($start_date); ?>&nbsp;to&nbsp;<?php echo tep_swap_dates($end_date);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="view_instructor_schedule.php?month=previous&start_date=<?php echo $start_date; ?>&center=<?php echo $center; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&course_id=<?php echo $course_id; ?>"> < Previous</a>&nbsp;|&nbsp;<a href="view_instructor_schedule.php?month=next&start_date=<?php echo $start_date; ?>&center=<?php echo $center; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&course_id=<?php echo $course_id; ?>">Next ></a></h4>
									</td>
								</tr>
								<?php
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
									<td>
										<table width="100%">
											<?php
											$date_temp = '';
											$center_temp = '';
											$type_temp = '';
											foreach ($schedule_array as $x=>$y) {
												$scheduled = new scheduled(tep_get_course_id($y['id']));
												$scheduled->set_calendar_vars($y['id']);
												if ($date_temp != $y['date']) {
													$date_temp = $y['date'];
													?>
													<tr><td colspan="7"></td></tr>
													<tr>
														<td class="hright" width="3%"><span class="head">ID</td></td>
														<td class="hleft"  width="20%"><span class="head"><?php echo date("l", mktime(0,0,0,substr($date_temp,5,2),substr($date_temp,-2,2),substr($date_temp,0,4))); ?></span></td>
														<td class="hright" width="15%"><span class="head"><?php echo tep_swap_dates($y['date']); ?></font></td>

													<?php
													$center_temp = '';
													$type_temp = '';
												}
												else
												{
													?>
													<tr>
														<td class="left"></td>
														<td class="right"></td>
													<?php
												}
												if ($center_temp != $scheduled->center) {
													$center_temp = $scheduled->center;
													?>
														<td class="hleft" width="20%">Venue:</td>
														<td class="hright" width="15%"><span class="head"><?php echo tep_get_name(TABLE_CENTERS, $scheduled->center); ?></font></td>
													<?php
													$type_temp = '';
												}
												else
												{
													?>
													<td class="right"></td>
													<td class="right"></td>
													<?php
												}
												if ($type_temp != $scheduled->type) {
													$type_temp = $scheduled->type;
													?>
														<td class="hleft" width="10%">Type:</td>
														<td class="hright" width="20%"><span class="head"><?php echo tep_get_name(TABLE_COURSE_TYPES, $scheduled->type); ?></font></td>
													</tr>
													<?php
												}
												else
												{
														?>
														<td class="left" width="10%"></td>
														<td class="right" width="20%"></td>
													</tr>
													<?php
												}
												$num_instructors = tep_get_num_instructors($scheduled);
												if ($num_instructors < $scheduled->min_instructors) {
													$class = 'eright';
													$lclass = 'eleft';
												}
												else
												{
													$class = 'right';
													$lclass = 'left';
												}
												?>
												<tr>
													<td class="<?php echo $class;?>"><a name="<?php echo $scheduled->calendar_id; ?>"><?php echo $scheduled->calendar_id; ?></td>
													<td class="<?php echo $class;?>"><?php echo '<a href="course_registrations.php?id='.$scheduled->calendar_id.'">'.$scheduled->name; ?></a></td>
													<td class="<?php echo $class;?>">Minimum Instructors:</td>
													<td class="<?php echo $class;?>">&nbsp;&nbsp;&nbsp;<?php echo $scheduled->min_instructors; ?></td>
													<td class="<?php echo $lclass;?>" colspan="2"><?php
													//add list of current instructors
													if (is_array($scheduled->instructors)) {
														foreach ($scheduled->instructors as $h=>$i) {
															echo '<a href="view_profile.php?id='.$i.'">'.tep_get_instructor_name($i).'</a>&nbsp;&nbsp;&nbsp;<br>';
														}
													}
													else
													{
														echo "None&nbsp;&nbsp;&nbsp;";
													}
													?>
													</td>
													<td class="<?php echo $class;?>">
														<form name="add_instructor" action="view_instructor_schedule.php?calendar_id=<?php echo $scheduled->calendar_id; ?>&id=<?php echo $scheduled->id; ?>&start_date=<?php echo $start_date; ?>#<?php echo $scheduled->calendar_id; ?>" method="post">
														<?php echo tep_build_instructor_dropdown('instructor'); ?><input name="add_instructor" type="submit" class="slim_button" value="Add Instructor"></td>
														</form>
													</td>
												</tr>
												<?php
											}
											?>
										</table>
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