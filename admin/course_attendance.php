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
	//If the user has posted back the results, update the DB, then redirect to the report page
			If (!empty($_POST)){
				Foreach ($_POST as $key=>$value) 
					If (is_numeric($key)) {
//						Echo "$key -> $value<br>";
						switch ($value) {
							case "Attend":
								$pass = 1;
								$fail = 0;
								$attended = 1;
								break;
							case "Absent":
								$pass = 0;
								$fail = 1;
								$attended = 2;
								break;
							case "Ill":
								$pass = 0;
								$fail = 0;
								$attended = 3;
								break;
						}
						$calendar_id = $_GET['calendar_id'];
						$sql_array = array("calendar_id" => $calendar_id,
											"user_id" => $key,
											"attended" => $attended,
											"pass" => $pass,
											"fail" => $fail,
											"mDate" => date("Y-m-d H:i:s"));
						$query = "select * from reporting where calendar_id = '$calendar_id' and user_id = '$key' LIMIT 1";
						$result = tep_db_query($query);
						if (tep_db_num_rows($result) > 0) {
							//update
							tep_db_perform(TABLE_REPORTING, $sql_array, 'update',"calendar_id = '$calendar_id' and user_id = '$key'");
						}
						else
						{
							$sql_array['cDate'] = date('Y-m-d H:i:s');
							tep_db_perform(TABLE_REPORTING, $sql_array);
						}
					}						
			header("Location: course_attendance_report.php?calendar_id=".$_GET['calendar_id']);
			}
	//Now go and get all the information about the course

	if (isset($_GET['calendar_id'])) {
		if (is_numeric($_GET['calendar_id'])) { 
			$calendar_id = $_GET['calendar_id'];
			$scheduled = new scheduled(tep_get_course_id($calendar_id));
			$scheduled->set_calendar_vars($calendar_id);
			}
		Else header("Location: login.php");
		}
	Else header("Location: login.php");
		
	include(INCLUDES . 'header.php');

	include(INCLUDES . 'admin_header.php');
	
	?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Course Attendance Register</td>
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
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<table width='100%'>
								<!-- CONTENT -->
									<tr>
										<td class="hright"  width="20%"><span class="head"><?php echo $scheduled->name; ?></span></td>
										<td class="hright" width="15%"><span class="head"><?php echo tep_swap_dates($scheduled->start_date); ?></font></td>
										<td class="hleft" width="20%">Venue:</td>
										<td class="hright" width="15%"><span class="head"><?php echo tep_get_name(TABLE_CENTERS, $scheduled->center); ?></font></td>
										<td class="hleft" width="10%">Type:</td>
										<td class="hright" width="20%"><span class="head"><?php echo tep_get_name(TABLE_COURSE_TYPES, $scheduled->type); ?></span></td>
									</tr>
									</tr>
								<?php
								if ($access_error) {
								?>
									<tr>
										<td>
											<h2><?phpEcho $course_name;?></h2>
											<?php echo $error; ?>
										</td>
									</tr>
								<?php
								}
								$schedule_id = $_GET['calendar_id'];
								$course_id = tep_get_course_id($_GET['calendar_id']);
								$scheduled = new scheduled($course_id);
								$scheduled->set_calendar_vars($schedule_id);
									if (isset($_POST['search'])) {
										$search_term = $_POST['search_term'];
									}
									if (isset($_POST['add_trainee']) && (sizeof($_POST['selected_user']))) {
										foreach ($_POST['selected_user'] as $a=>$b) {
											// add users with id $b to scheduled course with calendar_id $schedule_id or add instructor with id $b to group with id $group_id
											$user = new user(tep_get_username($b));
											$user->set_profile();
										}
									}
									?>
										<form name="add_trainee" action="course_attendance.php?calendar_id=<?php echo $_GET['calendar_id'];?>" method="post">
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
											if (isset($_GET['calendar_id'])) {
												foreach ($scheduled->users as $a => $b) {
													if ($b['id'] == $userObj->id) {
														$in_group = true;
													}
												}
											}
											if ($in_group) {
												$course_id=$_GET['calendar_id'];
													?>
													<td class="right" colspan="2"><?php echo $userObj->firstname.' '.$userObj->lastname; ?></td>
													<td class="right">
														<INPUT TYPE=RADIO NAME="<?php echo $userObj->id; ?>" VALUE="Attend">Attended</td>
													<td class="right">
														<INPUT TYPE=RADIO NAME="<?php echo $userObj->id; ?>" VALUE="Ill">ILL</td>
													<td colspan="2" class="right">
														<INPUT TYPE=RADIO NAME="<?php echo $userObj->id; ?>" VALUE="Absent">Absent
													</td>
												</tr>
												<?php
												$counter++;
											}
										}
									}
									?>
									<tr>
										<td colspan="3"><input type="submit" name="register" value="Submit" class="button">&nbsp;|&nbsp;
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

