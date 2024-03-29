<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	// access level 1
	$access_level = '1';
	$access_error = false;
	
	$diet_id = $_GET['id'];
	
	include('includes/application_top.php');
	
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	
	// template for page build
	
	
	
	if (isset($_POST['edit_diet']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level)){
			$sql_array = array("name" => $_POST['name']);
			tep_db_perform(TABLE_DIET, $sql_array, 'update', "id = '$diet_id'");
			
			header("Location: add_diet.php");
			
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
			<td class="title" height="27" colspan=3>&nbsp;Manage Special Requirements</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Special Requirements</td>
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
										<h4>Edit Diet</h4>
										<form action="edit_diet.php?id=<?php echo $diet_id; ?>" name="add_diet" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Special Requirement:
												</td>
												<td class="right">
													<input name="name" type="text" value="<?php echo tep_get_name(TABLE_DIET, $diet_id); ?>">
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;
													
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="edit_diet" type="submit" value="Edit Requirement" class="submit3">
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
