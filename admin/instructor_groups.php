<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	// access level 2

	$access_level = '3';
	$access_error = false;

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	$group_id = $_GET['group_id'];



	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');



	$action = $_GET['action'];
	switch ($action) {
		case 'delete': if (tep_validate_user($_SESSION['admin_user'])) {
			       		tep_delete_entry(TABLE_GROUP_USERS, $_GET['id']);
			       }
			       else
			       {
			       		$access_error = true;
			       		$error = PERMISSION_ERROR;
			       }
			       break;
	}
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Instructor Groups</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing Group</td>
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
										<table width="100%">
										<?php
											// TODO: create group class, get members and list it here
											$group_array = tep_get_groups();
											if (empty($group_array)) {
											?>
												<tr>
													<td class="right">
													<?php
														echo 'There are no instructor groups registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{
													$group = new group($group_id);
													?>
													<tr>
														<td width = "30%" class="left"><h4>
															<?php echo $group->name; ?></h4>
														</td>
														<td class="left">
															<a href="select_trainee.php?group_id=<?php echo $group->id; ?>">Add Instructors</a>
														</td>
													</tr>

												<?php
													// TODO: list the group's members here
													foreach ($group->members as $a => $b) {
														// get id of table group_users
														?>
														<tr>
															<td class="left"><a href="view_profile.php?id=<?php echo $b['user_id']; ?>"><?php echo tep_get_instructor_name($b['user_id']); ?></a></td>
															<td class="left"><a href="instructor_groups.php?group_id=<?php echo $group->id; ?>&action=delete&id=<?php echo $b['group_user_id']; ?>">Remove Instructor</a>
														</tr>
														<?php

													}
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