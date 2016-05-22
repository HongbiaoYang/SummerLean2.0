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
	if (isset($_POST['filter']))
		$query = "select ca.id, ca.course_id, ca.start_date, ca.start_time, ca.end_time, ca.dates, ca.resources, ca.cancelled, c.center, c.type, c.name from calendar as ca left join courses as c on (ca.course_id = c.id) where ".$where_clause." order by ca.start_date, c.center, c.type, ca.start_time, c.name";
	else
		$query = "select ca.id, ca.course_id, ca.start_date, ca.start_time, ca.end_time, ca.dates, ca.resources, ca.cancelled, c.center, c.type, c.name from calendar as ca left join courses as c on (ca.course_id = c.id) order by ca.start_date, c.center, c.type, ca.start_time, c.name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		foreach (unserialize($row['dates']) as $a=>$date) {
			if ($date < date("Y-m-d")) {
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
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing History</td>
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
												<form name="filter" action="view_schedule.php" method="post">
												<td class="left">Venue:</td><td class="right"><?php echo tep_build_dropdown(TABLE_CENTERS, center, false, 1, '', true, $_POST['center']); ?></td>
												<td class="left">Type:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_TYPES, type, false, 1, '', true, $_POST['type']); ?></td>
												<td class="left">Category:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_CATEGORIES, category, false, 1, '', true, $_POST['category']); ?></td>
												<td class="left"><input type="submit" name="filter" class="submit3" value="Filter"></td>
												</form>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Schedule:</h4>
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
														<td class="hcenter" width="4%"><span class="head">ID</span></td>
														<td class="hleft"  width="20%"><span class="head"><?php echo date("l", mktime(0,0,0,substr($date_temp,5,2),substr($date_temp,-2,2),substr($date_temp,0,4))); ?></span></td>
														<td class="hright" width="15%"><span class="head"><?php echo tep_swap_dates($scheduled->start_date); ?></font></td>

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
														<td class="hright" width="20%"><span class="head"><?php echo tep_get_name(TABLE_COURSE_TYPES, $scheduled->type); ?></span></td>
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
												?>
												<tr>
													<td class="center"><?php echo $scheduled->calendar_id; ?></td>
													<td class="right"><?php echo '<a href="view_course.php?id='.$scheduled->id.'">'.$scheduled->name; ?></a></td>
													<td class="right"><?php
														foreach ($scheduled->dates as $a=>$date) {
															echo tep_swap_dates($date).'<br>';
														}
														?>
													</td>
													<td class="right"><?php echo substr($scheduled->start_time,0,5) ?></td>
													<td class="right">
														<?php
														if (count($scheduled->resources > 0)) {
															foreach ($scheduled->resources as $a=>$b) {
																echo tep_get_name(TABLE_RESOURCES, $b).'<br>';
															}
														}
														else
														{
															echo 'No Resources';
														}
													?>
													</td>
													<?php
													if ($_GET['action'] == 'register') {
													?>
														<td class="right"><a href="course_register.php?id=<?php echo $scheduled->calendar_id; ?>&user_id=<?php echo $_GET['id']; ?>">Register User <?php echo tep_get_username($_GET['id']); ?></a></td>
													<?php
													}
													else
													{
													?>
														<?php
														if ($scheduled->cancelled == '1') {
														?>
															<td class="right"><font color="red">Cancelled</font></td>
														<?php
														}
														else
														{
														?>
															<td class="right"><a href="reporting.php?calendar_id=<?php echo $scheduled->calendar_id; ?>">Report</a></td>
														<?php
														}
														?>
														<td class="right"><a href="course_registrations.php?id=<?php echo $scheduled->calendar_id; ?>">View Details</a></td>
													<?php
													}
													?>
												</tr>
												<?php
											}

											?>
										</table>
									</td>
								</tr>
							</table>
						<br><br>
						</td>
					</tr>
				</table>
				<table width="96%" align="center" cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td colspan=3 align=right></td>
					</tr>
				</table>
			</td>
		</tr>
	</TABLE>


<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

