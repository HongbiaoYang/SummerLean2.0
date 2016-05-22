<?php
/*
 * Created on Jun 27, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 include('includes/application_top.php');


	$access_level = '3';
	$access_error = false;

	if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			$access_error = false;
	}
	else
	{
		$access_error = true;
		$error = PERMISSION_ERROR;
	}

	// template for page build
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
			header("Location: login.php");
	}
	include(INCLUDES . 'header.php');

	include(INCLUDES . 'admin_header.php');
	?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Users</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Select Users</td>
			<td width="83%"><IMG src="images/right.gif"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</TABLE>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="middle">
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
								$schedule_id = $_GET['calendar_id'];
								$course_id = tep_get_course_id($_GET['calendar_id']);
								$scheduled = new scheduled($course_id);
								$scheduled->set_calendar_vars($schedule_id);
								if (isset($_GET['group_id'])) {
									$group_id = $_GET['group_id'];
									?>
									<tr>
										<td align="left">
											<h4>Select Instructors to add to <?php echo tep_get_name(TABLE_GROUPS, $group_id); ?></h4>
										</td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td align="left">
											<h4>Select Users to add to <?php echo $scheduled->name.' starting on '.tep_swap_dates($scheduled->start_date); ?></h4>
										</td>
									</tr>
									<?php
								}
									if (isset($_POST['search'])) {
										$search_term = $_POST['search_term'];
									}
									if (isset($_POST['add_trainee']) && (sizeof($_POST['selected_user']))) {
										foreach ($_POST['selected_user'] as $a=>$b) {
											// add users with id $b to scheduled course with calendar_id $schedule_id or add instructor with id $b to group with id $group_id
											$user = new user(tep_get_username($b));
											$user->set_profile();
											if (isset($_GET['group_id'])) {
												if (!tep_instructor_in_group($_GET['group_id'], $user->id)) {
													$sql_array = array('group_id' => $_GET['group_id'],
																		'user_id' => $user->id);
													tep_db_perform(TABLE_GROUP_USERS, $sql_array);
													?>
													<tr>
														<td><font color="green"><?php echo $user->firstname.' '.$user->lastname.' has been added to the group.'; ?></font></td>
													</tr>
													<?php
												}
												else
												{
													?>
													<tr>
														<td><font color="red"><?php echo $user->firstname.' '.$user->lastname.' has allready been added to this group.'; ?></font></td>
													</tr>
													<?php
												}

											}
											else
											{
												if (tep_validate_course_registration($course_id, $user->job_title_id, $user->specialty_id, $user->band) && tep_validate_unique_registration($user->id, $scheduled->calendar_id)) {
													$status = tep_get_default_status();
													$note = 'Status changed to: '.tep_get_name(TABLE_STATUS, $status);
													$sql_array = array('calendar_id' => $scheduled->calendar_id,
																   		'user_id' => $user->id,
																   		'status' => $status,
														   				'cDate' => date('Y-m-d H:i:s'),
														   				'mDate' => date('Y-m-d H:i:s'));
																		tep_db_perform(TABLE_REGISTRATIONS, $sql_array);
													$registration_id = mysql_insert_id();
													$sql_array = array('admin_id' => $_SESSION['admin_user']->id,
																	 'user_id' => $user->id,
																	 'calendar_id' => $scheduled->calendar_id,
																	 'description' => $note,
																	 'cDate' => date("Y-m-d H:i:s"),
																	 'deleted' => 0);
													tep_db_perform(TABLE_NOTES, $sql_array);
													?>
													<tr>
														<td><?php echo $user->firstname.' '.$user->lastname.' has been registered.'; ?></td>
													</tr>
													<?php

													}
													else
													{
													?>
													<tr>
														<td><font color="red"><?php echo $user->firstname.' '.$user->lastname.' could not be registered.'; ?></font></td>
													</tr>
													<?php
												  }
											}
										}
									}
									if (isset($_GET['group_id'])) {
										$group = new group($_GET['group_id']);
										?>
										<form name="search" action="select_trainee.php?group_id=<?php echo $_GET['group_id'];?>" method="post">
									<?php
									}
									else
									{
									?>
										<form name="search" action="select_trainee.php?calendar_id=<?php echo $_GET['calendar_id'];?>" method="post">
									<?php
									}
									?>
										<tr>
										<td>
										<table>
											<tr>
												<td width="30%">
													Search:
												</td>
												<td>
													<input type="text" class="textbox1" name="search_term" value="<?php echo $_POST['search_term']; ?>">
												</td>
												<td>
													<input type="submit" class="button" name="search" value="Search">
												</td>
											</tr>
										</table>
										</td>
										</tr>
									</form>
									<?php
									if (isset($_GET['group_id'])) {
									?>
										<form name="add_trainee" action="select_trainee.php?group_id=<?php echo $_GET['group_id'];?>" method="post">
									<?php
									}
									else
									{
									?>
										<form name="add_trainee" action="select_trainee.php?calendar_id=<?php echo $_GET['calendar_id'];?>" method="post">
									<?php
									}
									?>
									<table>
									<?php
									$counter = 0;
									// We will include instructors to this list as technically they can also sign up for courses
									if (!isset($_GET['group_id'])) {
										$normal_users = tep_get_users_instructors($search_term);
									}
									else	// we will only include instructors in this one
									{
										$normal_users = tep_get_instructor_users($search_term);
									}
									if (count($normal_users)) {
										$counter = 0;
										foreach ($normal_users as $a => $user) {
											$userObj = new user($user['username']);
											$userObj->set_profile();
											if ($counter % 2 == 0) {
												?>
												<tr bgcolor="#E0E0E0">
												<?php
											}
											else
											{
												?>
												<tr>
												<?php
											}
											$in_group = false;
											if (isset($_GET['group_id'])) {
												foreach ($group->members as $a => $b) {
													if ($b['user_id'] == $userObj->id) {
														$in_group = true;
													}
												}
											}
											if (!$in_group) {
													?>
													<td class="left" width="5%"><input type="checkbox" name=selected_user[] value="<?php echo $userObj->id; ?>">
													<td class="right" width="35%"><?php echo '<a href="view_profile.php?id='.$user['id'].'">'.$userObj->firstname.' '.$userObj->lastname.'</a>'; ?></td>
													<td class="right" width="55%"><?php echo $userObj->username; ?></td>
												</tr>
												<?php
												$counter++;
											}
										}
									}
									?>
									<tr>
										<td colspan="3"><input type="submit" name="add_trainee" value="Add Checked" class="button">&nbsp;|&nbsp;
										<?php
										if (isset($_GET['group_id'])) {
										?>
											<a href="user_admin.php">Back</a></td><?php
										}
										else
										{
										?>
											<a href="course_registrations.php?id=<?php echo $scheduled->calendar_id; ?>">Back</a></td>
										<?php
										}
										?>
									</tr>
									</form>
									</table>
								</td>
							</tr>
						</TABLE>
					</TD>
				</TR>
			</TABLE>

			</td>
		</tr>
	</TABLE>
	<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

