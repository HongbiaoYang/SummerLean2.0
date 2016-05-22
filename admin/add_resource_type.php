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
	
	
	if (isset($_POST['add_rt']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			$sql_array = array("name" => prepare_input($_POST['name']));
			tep_db_perform(TABLE_RESOURCE_TYPE, $sql_array);
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
	}
	if (isset($_POST['order'])) {
		if (tep_validate_user($_SESSION['admin_user'])) {
			$id = $_GET['id'];
			$sql_array = array('order_value' => $_POST['order_value']);
			tep_db_perform(TABLE_RESOURCE_TYPE, $sql_array, 'update', "id = '".$id."'");
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
			       		tep_delete_entry(TABLE_RESOURCE_TYPE, $_GET['id']);
			       		$query = "delete from ".TABLE_RESOURCES."
			       			WHERE type = '".$_GET['id']."'";
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
									<td class="right">
										<?php echo $error; ?>
									</td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td align="left">
									<h4>Current Resource Types</h4>
									<table width="100%">
									
									<?php
										//display current centers
										$rt_array = tep_get_resource_types();
										if (empty($rt_array)) {
										?>
											<tr>
												<td class="right">
												<?php
													echo 'There are no resource types registered';
												?>
												</td>
											</tr>
											<?php
										}
										else
										{
											foreach ($rt_array as $s => $t) { ?>
												<tr>
													<td width = "30%" class="left">
														<?php echo $t['name']; ?>
													</td>
													<td class="right">
														<form action="add_resource_type.php?id=<?php echo $t['id']; ?>" name="order" method="post">
														<input class="textbox1" type="text" name = "order_value" size="2" value="<?php echo $t['order'] ?>"> 
														<input name="order" type="submit" value="Change Order" class="submit3">
														</form>
													</td>
													<td class="left">
														<a href="edit_resource_type.php?id=<?php echo $t['id']; ?>">Edit</a>&nbsp;|&nbsp;<a href="add_resource_type.php?action=delete&id=<?php echo $t['id'] ?>">Delete</a>
													</td>
													
												</tr>
											<?php
											}
										}
									?>
									</table>
									<h4>Add a Specialty</h4>
									<form action="add_resource_type.php" name="add_rt" method="POST">
									<table width="100%">
										<tr>
											<td width="30%" class="left">
												Resource Type:
											</td>
											<td class="right">
												<input name="name" type="text" class="textbox1">
											</td>
										</tr>
										<tr>
											<td colspan="2">&nbsp;
												
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<input name="add_rt" type="submit" value="Add Resource Type" class="submit3">
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
