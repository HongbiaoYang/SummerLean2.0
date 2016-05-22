<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	// allows to add multiple course types i.e. Simulation Centre, Resus etc

	// access level 1

	$access_level = '1';
	$access_error = false;

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');


	if (isset($_POST['add_course_type']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'])) {
			$sql_array = array("name" => prepare_input($_POST['name']),
					   "description" => prepare_input($_POST['description']));
			tep_db_perform(TABLE_COURSE_TYPES, $sql_array);
			$type_id = mysql_insert_id();
			//tep_create_folder($_POST['name'], 0, $type_id);
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
					tep_delete_entry(TABLE_COURSE_TYPES, $_GET['id']);
					$query = "SELECT * FROM courses WHERE
						 type = '".$_GET['id']."'";
					$result = tep_db_query($query);
					while ($row = tep_db_fetch_array($result)) {
						tep_delete_entry(TABLE_COURSES, $row['id']);
						tep_delete_requirements($row['id']);
						//delete schedule and registrations
						$query1 = "select id from calendar where course_id = '".$row['id']."'";
						$result1 = tep_db_query($query1);
						while ($row1 = tep_db_fetch_array($result1)) {
							tep_delete_entry(TABLE_CALENDAR, $row1['id']);
							$query2 = "delete from registrations where calendar_id = '".$row1['id']."'";
							$result2 = tep_db_query($query2);
						}

					}
					$query = "DELETE FROM users WHERE type = '".$_GET['id']."'";
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
			<td class="title" height="27" colspan=3>&nbsp;Manage Course Types</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Course Type</td>
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
										<h4>Current Course Types</h4>
										<table width="100%">
										<?php
											//display current centers
											$ct_array = tep_get_course_types();
											if (empty($ct_array)) {
											?>
												<tr>
													<td class="right">
													<?php
														echo 'There are no course types registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{
												foreach ($ct_array as $s => $t) { ?>
													<tr>
														<td width = "30%" class="left">
															<?php echo $t['name']; ?>
														</td>
														<td class="left">
															<a href="edit_course_type.php?id=<?php echo $t['id'];?>">Edit</a>&nbsp;|&nbsp;<a href="add_course_type.php?action=delete&id=<?php echo $t['id'] ?>">Delete</a>
														</td>
													</tr>
												<?php
												}
											}
										?>
										</table>
										<h4>Add a Course Type</h4>
										<form action="add_course_type.php" name="add_course_type" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Course Type:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1">
												</td>
											</tr>
											<tr>
												<td class="left" valign="top">
													Description:
												</td>
												<td class="right">
													<textarea name="description" cols="60" rows="10" class="textbox1"></textarea>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;

												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input class="submit3" name="add_course_type" type="submit" value="Add Course Type">
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
