<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	// access level: 1 (superuser)


	include('includes/application_top.php');

	$access_level = '1'; //superusers are allowed to add, edit and delete values on this page
	$access_error = false;


	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');

	include(INCLUDES . 'admin_header.php');

	if (isset($_POST['add_center']) && tep_validate_entry($_POST['name'])) {
		// make entry into centers
		if (tep_validate_user($_SESSION['admin_user'])) {
			$sql_array = array("name" => prepare_input($_POST['name']),
								"address_line1" => prepare_input($_POST['address_line1']),
								"address_line2" => prepare_input($_POST['address_line2']),
								"city" => prepare_input($_POST['city']),
								"country" => prepare_input($_POST['country']),
								"postcode" => prepare_input($_POST['postcode']),
								"contact_name" => prepare_input($_POST['contact_name']),
								"contact_phone" => prepare_input($_POST['contact_phone']),
								"contact_fax" => prepare_input($_POST['contact_fax']),
								"contact_email" => prepare_input($_POST['contact_email']));
			tep_db_perform(TABLE_CENTERS, $sql_array);
			$center_id = mysql_insert_id();
			// create folder
			//tep_create_folder($_POST['name'], $center_id);
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
			       		tep_delete_entry(TABLE_CENTERS, $_GET['id']);
					$query = "SELECT * FROM courses WHERE
						 center = '".$_GET['id']."'";
					$result = tep_db_query($query);
					while ($row = tep_db_fetch_array($result)) {
						tep_delete_entry(TABLE_COURSES, $row['id']);
						tep_delete_requirements($row['id']);
						$query1 = "select id from calendar where course_id = '".$row['id']."'";
						$result1 = tep_db_query($query1);
						while ($row1 = tep_db_fetch_array($result1)) {
							tep_delete_entry(TABLE_CALENDAR, $row1['id']);
							$query2 = "delete from registrations where calendar_id = '".$row1['id']."'";
							$result2 = tep_db_query($query2);
						}
					}
					$query = "DELETE FROM resources WHERE center = '".$_GET['id']."'";
					$result = tep_db_query($query);
					$query = "DELETE FROM users WHERE center = '".$_GET['id']."'";
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
			<td class="title" height="27" colspan=3>&nbsp;Manage Locations</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Course Locations</td>
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
										<h4>Current Locations</h4>
										<table width="100%">
										<?php
											//display current centers
											$center_array = tep_get_centers();
											if (empty($center_array)) {
											?>
												<tr>
													<td colspan="2" class="right">
													<?php
														echo 'There are no locations registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{
												foreach ($center_array as $s => $t) {
													$center = new center($t['id']);
												?>
													<tr>
														<td width = "30%" class="left">
															<?php echo $center->name; ?>
														</td>
														<td class="left">
															<a href="edit_center.php?id=<?php echo $t['id']; ?>">Edit</a>&nbsp;|&nbsp;<a href="add_center.php?action=delete&id=<?php echo $t['id'] ?>">Delete</a>
														</td>
													</tr>
													<tr>
														<td class="left">&nbsp;</td>
														<td class="right">
															<?php
															echo $center->address_line1.'<br>';
															echo $center->address_line2.'<br>';
															echo $center->city.'<br>';
															echo $center->country.'<br>';
															echo $center->postcode.'<br>';
															echo '<b>Contact:</b><br>';
															echo 'Name: '.$center->contact_name.'<br>';
															echo 'Phone: '.$center->contact_phone.'<br>';
															echo 'Fax: '.$center->contact_fax.'<br>';
															echo 'E-Mail: '.$center->contact_email.'<br>';
															?>
														</td>
													</tr>
												<?php
												}
											}
										?>
										</table>
										<h4>Add a center</h4>
										<form action="add_center.php" name="add_center" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Center Name:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Address Line 1:
												</td>
												<td class = "right">
													<input name="address_line1" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Address Line 2:
												</td>
												<td class="right">
													<input name="address_line2" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													City:
												</td>
												<td class="right">
													<input name="city" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Country:
												</td>
												<td class="right">
													<input name="country" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Postcode:
												</td>
												<td class="right">
													<input name="postcode" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact Name:
												</td>
												<td class="right">
													<input name="contact_name" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact Phone:
												</td>
												<td class="right">
													<input name="contact_phone" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact Fax:
												</td>
												<td class="right">
													<input name="contact_fax" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact E-Mail:
												</td>
												<td class="right">
													<input name="contact_email" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="add_center" type="submit" value="Add Centre" class="submit3">
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
