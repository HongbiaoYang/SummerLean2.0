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

	$calendar_id = $_GET['calendar_id'];
	if (isset($_GET['user_id']))
		$user_id = $_GET['user_id'];

	$scheduled = new scheduled(tep_get_course_id($calendar_id));
	$scheduled->set_calendar_vars($calendar_id);


	$users = tep_get_registered_users($calendar_id);
	if (isset($_POST['report_update'])) {
		if (tep_validate_user($_SESSION['admin_user'], $access_level, $_POST['center'], $_POST['type'])) {
			switch ($_POST['pass_fail']) {
				case 1:
					$pass = 1;
					$fail = 0;
					break;
				case 2:
					$pass = 0;
					$fail = 1;
					break;
				case 0:
					$pass = 0;
					$fail = 0;
					break;
			}
			$sql_array = array("calendar_id" => $scheduled->calendar_id,
								"user_id" => $_GET['user_id'],
								"attended" => $_POST['attended'],
								"pass" => $pass,
								"fail" => $fail,
								"mark" => $_POST['mark'],
								"comment" => $_POST['comment'],
								"mDate" => date("Y-m-d H:i:s"));
			$query = "select * from reporting where calendar_id = '$calendar_id' and user_id = '$user_id' LIMIT 1";
			$result = tep_db_query($query);
			if (tep_db_num_rows($result) > 0) {
				//update
				tep_db_perform(TABLE_REPORTING, $sql_array, 'update',"calendar_id = '$calendar_id' and user_id = '$user_id'");
			}
			else
			{
				$sql_array['cDate'] = date('Y-m-d H:i:s');
				tep_db_perform(TABLE_REPORTING, $sql_array);
			}
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
	}

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
			<td class="title" height="27" colspan=3>&nbsp;Reporting</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Course Report</td>
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
									<td align="left">
										<a name="Report"></a><h4>Report:</h4>
									</td>
								</tr>
								<?php
								if (count($users) == 0) { ?>
									<tr>
										<td class="hright"  width="20%"><span class="head"><?php echo $scheduled->name; ?></span></td>
										<td class="hright" width="15%"><span class="head"><?php echo tep_swap_dates($scheduled->start_date); ?></font></td>
										<td class="hleft" width="20%">Venue:</td>
										<td class="hright" width="15%"><span class="head"><?php echo tep_get_name(TABLE_CENTERS, $scheduled->center); ?></font></td>
										<td class="hleft" width="10%">Type:</td>
										<td class="hright" width="20%"><span class="head"><?php echo tep_get_name(TABLE_COURSE_TYPES, $scheduled->type); ?></span></td>
									</tr>
									<tr>
										<td class="right" colspan="6">
											There are no entries for this report.
										</td>
									</tr>
								<?php
								}
								else
								{
								?>
								<tr>
									<td>
										<table width="100%">
											<tr>
												<td class="hright"  width="20%"><span class="head"><?php echo $scheduled->name; ?></span></td>
												<td class="hright" width="15%"><span class="head"><?php echo tep_swap_dates($scheduled->start_date); ?></font></td>
												<td class="hleft" width="20%">Venue:</td>
												<td class="hright" width="15%"><span class="head"><?php echo tep_get_name(TABLE_CENTERS, $scheduled->center); ?></font></td>
												<td class="hleft" width="10%">Type:</td>
												<td class="hright" width="20%"><span class="head"><?php echo tep_get_name(TABLE_COURSE_TYPES, $scheduled->type); ?></span></td>
											</tr>
											<tr>
												<td colspan="6">
													<table width="100%">
														<tr>
															<td class="right">
																<span class="head">Name</span>
															</td>
															<td class="right">
																<span class="head">Attended</span>
															</td>
														</tr>
														<?php
														foreach ($users as $q => $r) {
															$report = new report($calendar_id, $r['user_id']);
															$user = new user(tep_get_username($r['user_id']));
															$user->set_profile();
															?>
																<tr>
																	<?php
																	if ($user->id == $_GET['user_id']) {
																		$class = 'highlight_right';
																	}
																	else
																	{
																		$class = 'right';
																	}
																	?>
<td class=<?php echo $class; ?>><?php echo $user->firstname.' '.$user->lastname; ?></td>
<td class=<?php echo $class; ?>><?php if ($report->attended == 1) echo 'Yes'; 
										else if ($report->attended == 2) echo 'No'; 
										else if ($report->attended == 3) echo 'ILL'; 
										else echo 'N/A'; ?></td>
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
								<?php
								}
								?>
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
	//var_dump($_SESSION);
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

