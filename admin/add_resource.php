<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	$access_level = '2';
	$access_error = false;

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');


	if (isset($_POST['add_resource']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		$access_level = '2';
		if (tep_validate_user($_SESSION['admin_user'], $access_level, $_POST['center'])) {
			$sql_array = array("name" => prepare_input($_POST['name']),
					   "type" => prepare_input($_POST['type']),
					   "center" => prepare_input($_POST['center']));
			tep_db_perform(TABLE_RESOURCES, $sql_array);
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
	}
	$action = $_GET['action'];
	switch ($action) {
		case 'delete': $access_level = '1';
				  if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			       		tep_delete_entry(TABLE_RESOURCES, $_GET['id']);
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
			<td class="title" height="27" colspan=3>&nbsp;Manage Resources</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Resources</td>
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
										<h4>Current Resources</h4>
										<table width="100%">
										<?php
											//display current centers
											$resource_array = tep_get_resources();
											if (empty($resource_array)) {
											?>
												<tr>
													<td class="right">
													<?php
														echo 'There are no resources registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{
												$temp = '';
												$count = 0;
												foreach ($resource_array as $s => $t) {
													if ($temp != $t['center']) {
														$temp = $t['center'];
														if ($count == 0) {
															$count++;
															?>
															<tr>
																<td colspan="3">
																	&nbsp;
																</td>
															</tr>
														<?php
														}
														?>
														<tr>
															<td colspan = "3" class="right">
																<?php echo '<b>'.$temp.'</b>'; ?>
															</td>
														</tr>
													<?php
													}
													?>
													<tr>
														<td width = "30%" class="left">
															<?php echo $t['name']; ?>
														</td>
														<td width="40%" class="right">
															<?php echo $t['resource_type']; ?>
														</td>
														<td class="left">
															<a href="edit_resource.php?id=<?php echo $t['id']; ?>">Edit</a>&nbsp;|&nbsp;<a href="add_resource.php?action=delete&id=<?php echo $t['id'] ?>">Delete</a>
														</td>
													</tr>
												<?php
												}
											}
										?>
										</table>
										<h4>Add a Resource</h4>
										<form action="add_resource.php" name="add_resource" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Resource:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Select Type:
												</td>
												<td class="right">
													<?php echo tep_build_dropdown(TABLE_RESOURCE_TYPE, 'type'); ?>
												</td>
											</tr>
											<tr>
												<td class="left">
													Select Center:
												</td>
												<td class="right">
													<?php echo tep_build_dropdown(TABLE_CENTERS, 'center'); ?>
												</td>
											</tr>

											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="add_resource" type="submit" value="Add Resource Type" class="submit3">
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
