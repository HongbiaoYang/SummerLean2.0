<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	$access_level = '3';
	include('includes/application_top.php');
	$course_id = $_GET['id'];
	$calendar_id = $_GET['calendar_id'];
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (!tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['id']), tep_get_course_type($_GET['id']))) {
		header("Location: select_course.php");
	}
	if (isset($_POST['attr'])) {
		$sql_array = array("start_time" => $_POST['start_hour'].':'.$_POST['start_minute'].':'.'00',
						   "end_time" => $_POST['end_hour'].':'.$_POST['end_minute'].':'.'00',
						   "resources" => serialize($_POST['resources']),
						   "reg_online" => $_POST['online_reg'],
						   "user_id" => $_SESSION['admin_user']->id,
						   "mDate" => date("Y-m_d H:i:s"));
		tep_db_perform(TABLE_CALENDAR, $sql_array, 'update', "id = '$calendar_id'");
		header("Location: edit_select_dates.php?id=$calendar_id");
	}
	// if instructor is added this function runs
	if (isset($_POST['add_instructor'])) {
		$sched = new scheduled($_GET['id']);
		$sched->set_calendar_vars($_GET['calendar_id']);
		$sched->instructors[] = $_POST['instructor'];
		$sql_array = array("instructors" => serialize($sched->instructors));
		tep_db_perform(TABLE_CALENDAR, $sql_array, 'update', "id = '$calendar_id'");
	}
	// if instructor is removed this function is run
	if (isset($_GET['remove_instructor_id'])) {
		$re_instr_id = $_GET['remove_instructor_id'];
		$sched = new scheduled($_GET['id']);
		$sched->set_calendar_vars($_GET['calendar_id']);
		foreach ($sched->instructors as $h=>$i) {
			if ($i != $re_instr_id) {
				$new_instructor_array[] = $i;
			}
		}
		$sql_array = array("instructors" => serialize($new_instructor_array));
		tep_db_perform(TABLE_CALENDAR, $sql_array, 'update', "id = '$calendar_id'");
	}
	$scheduled = new scheduled($_GET['id']);
	$scheduled->set_calendar_vars($_GET['calendar_id']);
	$_SESSION['scheduled'] = $scheduled;
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
			<td class="title" height="27" colspan=3>&nbsp;Scheduling Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Attributes</td>
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
									<td valign="top">
										<span class="heading">Please edit schedule</span>
									</td>
								</tr>
								<tr>
									<td valign="top">
										<form name="attr" action="edit_schedule_attributes.php?id=<?php echo $_GET['id']; ?>&calendar_id=<?php echo $_GET['calendar_id']; ?>" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Can learners register online?
												</td>
												<td class="right">
													<select name="online_reg" class="textbox1">
														<option value="0" <?php if (!$scheduled->online_reg) echo 'SELECTED'; ?>>No</option>
														<option value="1" <?php if ($scheduled->online_reg) echo 'SELECTED'; ?>>Yes</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left" valign="top">
													Select Resources:
												</td>
												<td class="right">
													<?php echo tep_build_dropdown(TABLE_RESOURCES, 'resources', true, '5', "center = '".$scheduled->center."'", true, $scheduled->resources); ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													<?php
														$scheduled_start_hour = substr($scheduled->start_time,0,2);
														$scheduled_start_minute = substr($scheduled->start_time,3,2);
														$hour = array();
														$minute = array();
														for ($i=0;$i < 24; $i++) {
															$hour[] = $i;
														}
														for ($j=0; $j < 60; $j+=5) {
															$minute[] = $j;
														}
													?>
													Start Time:
												</td>
												<td class="right">
													<select name='start_hour' class="textbox1">
													<?php
													foreach ($hour as $a=>$b) {
														if (strlen($b) == '1') {
															$b = '0'.$b;
														}
														if ($scheduled_start_hour == $b) {
															echo '<option SELECTED value="'.$b.'">'.$b.'</option>';
														}
														else
														{
															echo '<option value="'.$b.'">'.$b.'</option>';
														}
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
														if ($scheduled_start_minute == $y) {
															echo '<option SELECTED value="'.$y.'">'.$y.'</option>';
														}
														else
														{
															echo '<option value="'.$y.'">'.$y.'</option>';
														}
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left">
													End Time:
												</td>
												<td class="right">
													<select name='end_hour' class="textbox1">
													<?php
													$scheduled_end_hour = substr($scheduled->end_time,0,2);
													$scheduled_end_minute = substr($scheduled->end_time,3,2);
													foreach ($hour as $a=>$b) {
														if (strlen($b) == '1') {
															$b = '0'.$b;
														}
														if ($scheduled_end_hour == $b) {
															echo '<option SELECTED value="'.$b.'">'.$b.'</option>';
														}
														else
														{
															echo '<option value="'.$b.'">'.$b.'</option>';
														}
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
														if ($scheduled_end_minute == $y) {
															echo '<option SELECTED value="'.$y.'">'.$y.'</option>';
														}
														else
														{
															echo '<option value="'.$y.'">'.$y.'</option>';
														}
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td class="left">Instructors:</td>
												<td class="right">&nbsp;</td>
											</tr>
											<?php // here comes the list of current instructors
												if (is_array($scheduled->instructors)) {
													foreach ($scheduled->instructors as $h=>$i) {
													?>
														<tr>
															<td class="left">&nbsp;</td>
															<td class="right">
															<?php
																$instr = new user(tep_get_username($i));
																$instr->set_profile();
																echo $instr->firstname.' '.$instr->lastname;
														 	?>
														 	&nbsp;&nbsp;<a href="edit_schedule_attributes.php?id=<?php echo $_GET['id']; ?>&calendar_id=<?php echo $_GET['calendar_id']; ?>&remove_instructor_id=<?php echo $instr->id; ?>">remove</a></td>
														 	</td>
														</tr>
													<?php
													}
												}
												else
												{
													?>
													<tr>
														<td class="left">&nbsp;</td>
														<td class="right">No instructors assigned.</td>
													</tr>
													<?php
												}
												?>
											<tr>
												<td class="left">Select Instructor:</td>
												<td class="right"><?php echo tep_build_instructor_dropdown('instructor'); ?>
												<input name="add_instructor" type="submit" class="submit3" value="Add Instructor"></td>
											</tr>

											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td>
													&nbsp;
												</td>
												<td>
													<input name="attr" type="submit" value="Next" class="textbox1">
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
