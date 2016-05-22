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
	
	$center_id = $_GET['id'];
	$center = new center($center_id);
	
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build

	
	if (isset($_POST['edit_center']) && tep_validate_entry($_POST['name'])) {
		// make entry into centers
		if (tep_validate_user($_SESSION['admin_user'])) {
			$sql_array = array("name" => $_POST['name'],
								"address_line1" => $_POST['address_line1'],
								"address_line2" => $_POST['address_line2'],
								"city" => $_POST['city'],
								"country" => $_POST['country'],
								"postcode" => $_POST['postcode'],
								"contact_name" => $_POST['contact_name'],
								"contact_phone" => $_POST['contact_phone'],
								"contact_fax" => $_POST['contact_fax'],
								"contact_email" => $_POST['contact_email'],
								"gmaplat" => NULL,
								"gmaplon" => NULL);
			tep_db_perform(TABLE_CENTERS, $sql_array, 'update', "id = '$center_id'");
			
			header("Location: add_center.php");
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
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
										<h4>Edit a center</h4>
										<form action="edit_center.php?id=<?php echo $center_id; ?>" name="add_center" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Center Name:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1" value="<?php echo $center->name; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Address Line 1:
												</td>
												<td class = "right">
													<input name="address_line1" type="text" class="textbox1" value="<?php echo $center->address_line1; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Address Line 2:
												</td>
												<td class="right">
													<input name="address_line2" type="text" class="textbox1" value = "<?php echo $center->address_line2; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													City:
												</td>
												<td class="right">
													<input name="city" type="text" class="textbox1" value = "<?php echo $center->city; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Country:
												</td>
												<td class="right">
													<input name="country" type="text" class="textbox1" value="<?php echo $center->country; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Postcode:
												</td>
												<td class="right">
													<input name="postcode" type="text" class="textbox1" value="<?php echo $center->postcode; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact Name:
												</td>
												<td class="right">
													<input name="contact_name" type="text" class="textbox1" value="<?php echo $center->contact_name; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact Phone:
												</td>
												<td class="right">
													<input name="contact_phone" type="text" class="textbox1" value="<?php echo $center->contact_phone; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact Fax:
												</td>
												<td class="right">
													<input name="contact_fax" type="text" class="textbox1" value="<?php echo $center->contact_fax; ?>">
												</td>
											</tr>
											<tr>
												<td class="left">
													Contact E-Mail:
												</td>
												<td class="right">
													<input name="contact_email" type="text" class="textbox1" value="<?php echo $center->contact_email; ?>">
												</td>
											</tr>											
											<tr>
												<td colspan="2">&nbsp;
													
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="edit_center" type="submit" value="Edit Centre" class="submit3">
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

