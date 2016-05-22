<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	$access_level = '3';

	include('includes/application_top.php');
	$scheduled = $_SESSION['scheduled'];

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (!tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['course_id']), tep_get_course_type($_GET['course_id']))) {
		header("Location: select_course.php");
	}
	if (isset($_POST['attr'])) {
		$_SESSION['scheduled']->set_scheduling($_POST['online_reg'], $dates = $_POST['selected_date'], $_POST['resources'], $_POST['start_hour'].':'.$_POST['start_minute'].':00', $_POST['end_hour'].':'.$_POST['end_minute'].':'.'00');
		$_SESSION['multiple'] = $_POST['multiple'];
	}
	$no_dates_error = false;

	if (isset($_POST['dates'])) {
		if ($_SESSION['multiple'] != 1) {

			if (count($_POST['selected_date']) == 0) {
				$no_dates_error = true;
			}
			else
			{
				//we need to make entries into the calendar table
					$sql_array = array("course_id" => $scheduled->id,
							   "start_date" => $_POST['selected_date'][0],
							   "start_time" => $scheduled->start_time,
							   "end_time" => $scheduled->end_time,
							   "dates" => serialize($_POST['selected_date']),
							   "resources" => serialize($scheduled->resources),
							   "reg_online" => $scheduled->online_reg,
							   "user_id" => $_SESSION['admin_user']->id,
							   "cDate" => date("Y-m-d H:i:s"),
							   "mDate" => date("Y-m_d H:i:s"));
					if (tep_unique_entry($sql_array)) {
						tep_db_perform(TABLE_CALENDAR, $sql_array);
						unset($_SESSION['scheduled']);
						$start_date = $_POST['selected_date'][0];
						$calendar_start_date = substr($start_date,0,7).'-01';
						header("Location: view_schedule.php?start_date=$calendar_start_date");
					}
			}
		}
		else
		{			// create multiple instances of the selected course
			$selected_dates = $_POST['selected_date'];
			if (count($_POST['selected_date']) == 0) {
				$no_dates_error = true;
			}
			else
			{
				$scheduled_date = array();
				foreach ($selected_dates as $a=>$b) {
					$scheduled_date[] = $b;

					$sql_array = array("course_id" => $scheduled->id,
							   "start_date" => $scheduled_date[0],
							   "start_time" => $scheduled->start_time,
							   "end_time" => $scheduled->end_time,
							   "dates" => serialize($scheduled_date),
							   "resources" => serialize($scheduled->resources),
							   "reg_online" => $scheduled->online_reg,
							   "user_id" => $_SESSION['admin_user']->id,
							   "cDate" => date("Y-m-d H:i:s"),
							   "mDate" => date("Y-m_d H:i:s"));
					if (tep_unique_entry($sql_array)) {
						tep_db_perform(TABLE_CALENDAR, $sql_array);
						unset($_SESSION['scheduled']);
						$start_date = $_POST['selected_date'][0];
						$calendar_start_date = substr($start_date,0,7).'-01';

					}
					$scheduled_date = array();
				}
				header("Location: view_schedule.php?start_date=$calendar_start_date");
			}
		}
	}


	echo $_POST['multiple'];
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');

	$stretch = 1; // amount of years to display calendar for

?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Scheduling Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Date Selection</td>
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
								<?php
								if ($no_dates_error) {
								?>
								<tr>
									<td colspan="2"><font color="red">You have not selected any dates!</font>
								</tr>
								<?php
								}
								?>
								<!-- CONTENT -->
								<tr>
									<td colspan="2">
										<span class="heading">Select Dates:</span>
									</td>
								</tr>
								<form name="dates" action="select_dates.php" method="post">
								<tr>
									<td colspan="2" align="center">
										<input name="dates" type="submit" value="Finish" class="submit3">
									</td>
								</tr>
								<?php
								$counter = 0;
								for ($year=date('Y'); $year <= (date('Y')+$stretch); $year++) {
									if ($counter == 0) {
										for ($month=date('n'); $month <= 24; $month++) {

											if ($counter % 2 == 0) { ?>
												<tr>
													<td align="center">
														<?php echo tep_generate_calendar($year, $month); ?>
													</td>
											<?php
											}
											else
											{ ?>
													<td align="center">
														<?php echo tep_generate_calendar($year, $month); ?>
													</td>
												</tr>
											<?php
											}
											$counter++;
										}
									}
									else if ($year== date('Y') + $stretch) {
										for ($month=1; $month <= date('m'); $month++) {
											if ($counter % 2 == 0) { ?>
												<tr>
													<td align="center">
														<?php echo tep_generate_calendar($year, $month); ?>
													</td>
											<?php
											}
											else
											{ ?>
													<td align="center">
														<?php echo tep_generate_calendar($year, $month); ?>
													</td>
												</tr>
											<?php
											}
											$counter++;
										}
									}
									else
									{
										for ($month=1; $month <= 12; $month++) {
											if ($counter % 2 == 0) { ?>
												<tr>
													<td align="center">
														<?php echo tep_generate_calendar($year, $month); ?>
													</td>
											<?php
											}
											else
											{ ?>
													<td align="center">
														<?php echo tep_generate_calendar($year, $month); ?>
													</td>
												</tr>
											<?php
											}
											$counter++;
										}
									}
								}
								?>
									<tr>
										<td colspan="2" align="center">
											<input name="dates" type="submit" value="Finish" class="submit3">
										</td>
									</tr>
								</form>



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