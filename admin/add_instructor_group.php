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

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');


	if (isset($_POST['add_instructor_group']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			$sql_array = array("name" => prepare_input($_POST['name']),
					   "cDate" => date("Y-m-d H:i:s"),
					   "mDate" => date("Y-m-d H:i:s"));
			tep_db_perform(TABLE_GROUPS, $sql_array);
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
	}
	$action = $_GET['action'];
	switch ($action) {
		case 'delete': if (tep_validate_user($_SESSION['admin_user'])) {
			       		tep_delete_entry(TABLE_GROUPS, $_GET['id']);
			       		// also has to delete all entries in group users related to this group
			       		$group_id = $_GET['id'];
			       		$query = "DELETE FROM group_users WHERE group_id = '$group_id'";
			       		$result = tep_db_query($query);
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
			<td height="18" class="subtitle" valign="bottom" width="12%">Add, Remove or Edit Instructor Group</td>
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
										<h4>Current Instructor Groups</h4>
										<table width="100%">
										<?php
											//display current centers
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
												foreach ($group_array as $s => $t) { ?>
													<tr>
														<td width = "30%" class="left">
															<a href="instructor_groups.php?group_id=<?php echo $t['id']; ?>"><?php echo $t['name']; ?></a>
														</td>
														<td class="left">
															<a href="select_trainee.php?group_id=<?php echo $t['id']; ?>">Add Instructors</a>&nbsp;|&nbsp;<a href="edit_instructor_group.php?id=<?php echo $t['id']; ?>">Edit</a>&nbsp;|&nbsp;<a href="add_instructor_group.php?action=delete&id=<?php echo $t['id'] ?>">Delete</a>
														</td>
													</tr>
												<?php
												}
											}
										?>
										</table>
										<h4>Add a Instructor Group</h4>
										<form action="add_instructor_group.php" name="add_instructor_group" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Instructor Group:
												</td>
												<td class="right">
													<input name="name" type="text">
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="add_instructor_group" type="submit" value="Add Instructor Group" class="submit3">
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
