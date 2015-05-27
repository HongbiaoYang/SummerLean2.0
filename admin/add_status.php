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


	if (isset($_POST['add_status']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if ($_POST['default'] == 'on') {
			$default = '1';
		}
		else
		{
			$default = '0';
		}
		if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			$sql_array = array("name" => $_POST['name'],
					   "colour" => $_POST['colour'],
					   "def" => $default,
					   "cDate" => date("Y-m-d H:i:s"),
					   "mDate" => date("Y-m-d H:i:s"));
			tep_db_perform(TABLE_STATUS, $sql_array);
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
			       		tep_delete_entry(TABLE_STATUS, $_GET['id']);
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
			<td class="title" height="27" colspan=3>&nbsp;Manage User Status</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Status</td>
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
										<h4>Current Status</h4>
										<table width="100%">
										<?php
											//display current centers
											$status_array = tep_get_status();
											if (empty($status_array)) {
											?>
												<tr>
													<td class="right">
													<?php
														echo 'There are no statuses registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{
												foreach ($status_array as $s => $t) { ?>
													<tr>
														<td width = "30%" class="left">
															<?php echo $t['name']; ?>
														</td>
														<td class="left">
															<a href="edit_status.php?id=<?php echo $t['id']; ?>">Edit</a>&nbsp;|&nbsp;<a href="add_status.php?action=delete&id=<?php echo $t['id'] ?>">Delete</a>
														</td>
													</tr>
												<?php
												}
											}
										?>
										</table>
										<h4>Add a User Status</h4>
										<form action="add_status.php" name="add_status" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Status:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">Colour:</td>
												<td class="right">
													<input name="colour" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">Default:</td>
												<td class="right"><input name="default" type="checkbox"></td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="add_status" type="submit" value="Add Status" class="submit3">
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