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
	if (isset($_GET['action'])&&isset($_GET['valid'])) {
		if (!$_GET['valid'] || isset($_POST['cancel'])) {
			$user_id = $_GET['user_id'];
			header("Location: view_schedule.php");
		}
		else
		{
			$status = tep_get_default_status();
			$sql_array = array('calendar_id' => $_SESSION['course']->calendar_id,
					   'user_id' => $user->id,
					   'status' => $status,
					   'cDate' => date('Y-m-d H:i:s'),
					   'mDate' => date('Y-m-d H:i:s'));
			tep_db_perform(TABLE_REGISTRATIONS, $sql_array);
			$registration_id = mysql_insert_id();
			$note = 'Status changed to: '.tep_get_name(TABLE_STATUS, $status);
			$sql_array = array('admin_id' => $_SESSION['admin_user']->id,
							  'user_id' => $user->id,
							  'calendar_id' => $_SESSION['course']->calendar_id,
							  'description' => $note,
							  'cDate' => date("Y-m-d H:i:s"),
							  'deleted' => 0);
			tep_db_perform(TABLE_NOTES, $sql_array);




			header("Location: view_profile.php");
		}

	}



	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');
	$course_id = tep_get_course_id($_GET['id']);
	$scheduled = new scheduled($course_id);
	$scheduled->set_calendar_vars($_GET['id']);
	$_SESSION['course'] = $scheduled;
	//test if user is eligible to register
	if (tep_validate_course_registration($course_id, $user->job_title_id, $user->specialty_id, $user->band)) {
		$registration = true;
		$message = '<font color="green">You are allowed to register for this course. Click \'Continue\' to confirm your registration.</font>';
	}
	else
	{
		$registration = false;
		$message = '<font color="red">You do not have the correct qualifications to register for this course. Please view below to see which qualifications you need.</font>';
	}
	$query = "select * from registrations where user_id = '".$user->id."' and calendar_id = '".$_SESSION['course']->calendar_id."'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		$registration = false;
		$message = '<font color="red">You have already registered for this course. You cannot do so again.</font>';
	}
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Registrations</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Course Registration</td>
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
							<table width='100%' border="0">
								<tr>
									<td class="right" colspan="3">
										<?php echo $message; ?>
									</td>
								</tr>
								<tr>
									<td class="left">
										<span class="courseHeading">Date:</span>
									</td>
									<td class="right">
										<?php echo tep_swap_dates($scheduled->start_date); ?>&nbsp;&nbsp;<a href="edit_schedule_attributes.php?calendar_id=<?php echo $_GET['id']; ?>&id=<?php echo $course_id; ?>">Edit</a>
									</td>
									<td rowspan="16">
										<?php
										$center_id=$scheduled->center;
										$center_address=tep_db_query("select address_line1,address_line2,city,country,postcode,gmaplat,gmaplon from centers where id=$center_id");
										$address='';
										$gmaplat=mysql_result($center_address,0,'gmaplat');
										$gmaplon=mysql_result($center_address,0,'gmaplon');
									 	$address=mysql_result($center_address,0,address_line1).",".
										 mysql_result($center_address,0,address_line2).",".
										 mysql_result($center_address,0,city).",".
										 mysql_result($center_address,0,country).",".
										 mysql_result($center_address,0,postcode);
/*										If (GOOGLE_MAP_KEY!='') {
											If (empty($gmaplat))
											Echo "<iframe src='resolve.php?id=$center_id&height=400&width=400&add1=$address' width='400' height='500' frameborder='0' scrolling=no></iframe>";
											Else 
												Echo"<iframe src='gmap.php?height=400&width=400&lat=$gmaplat&lon=$gmaplon&add1=$address' width='400' height='400' frameborder='0' scrolling=no></iframe>";
										} 
*/
										?>
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
										Min:&nbsp;&nbsp;<?php echo $scheduled->min_attendance; ?><br>
										Max:&nbsp;&nbsp;<?php echo $scheduled->max_attendance; ?>
									</td>
								</tr>
								<?php 
								// test which requirements are active
								if (LEVEL1_REQUIRED=='true'||
								LEVEL2_REQUIRED=='true'||
								LEVEL3_REQUIRED=='true') {
										
								?>
									<tr>
										<td class="left">
											<span class="courseHeading">Requirements:</span>
										</td>
										<td>
											&nbsp;
										</td>
									</tr>
								<?php
								}
								if (LEVEL1_REQUIRED=='true') {	
								?>
									<tr>
										<td class="left">
											<span class="courseHeading"><?php echo LEVEL1_NAME; ?></span>
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
									</tr>
								<?php 
								}
								If (LEVEL2_REQUIRED=='true') {
								?>
									<tr>
										<td class="left">
											<span class="courseHeading"><?php  echo LEVEL2_NAME; ?></span>
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
								<?php 
								}
								If (LEVEL3_REQUIRED=='true') {
								?>
									<tr>
										<td class="left">
											<span class="courseHeading"><?php echo LEVEL3_NAME; ?></span>
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
								<?php 
								}
								?>
								<tr>
									<td class="left">
										<span class="courseHeading">Dates:</span>
									</td>
									<td class="right">
										<?php
											foreach ($scheduled->dates as $a=>$date) {
												echo $date.'<br>';
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
									<td class="left">
										<span class="courseHeading">Registered Learners:</span>
									</td>
									<td class="right">
										&nbsp&nbsp<font color="green"><?php echo $scheduled->registered; ?></font>
									</td>
								</tr>
								<tr>
									<td class="left">
										<span class="courseHeading">Cancelled:</span>
									</td>
									<td class="right">
										<?php $cancelled_text = ($scheduled->cancelled == 0) ? 'No' : '<font color="red">Yes</font>';
										echo $cancelled_text;
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										&nbsp;
									</td>
								</tr>
										
								<tr>
									<td align="center" colspan="2">
										<form name="register" action="course_register.php?action=register&valid=<?php echo $registration; ?>&user_id=<?php echo $_GET['user_id']; ?>" method="post">
											<?php
											if ($scheduled->max_attendance <= $scheduled->registered) { ?>
<!--												<input name = "register" type="submit" value="Join Waiting List" class="submit3">   --> 
											<?php
											}
											else
											{ ?>
												<input name = "register" type="submit" value="Continue" class="submit3">&nbsp;&nbsp;&nbsp;
											<?php
											}
											?>
											<input name = "cancel" type="submit" value="Cancel" class="submit3">
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
			</td>
		</tr>
	</TABLE>


<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
