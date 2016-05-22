<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
		
	$access_level = '1';
	$access_error = false;
	
	$course_type_id = $_GET['id'];
	
	include('includes/application_top.php');
	
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	
	if (isset($_POST['edit_course_type']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'])) {
			$sql_array = array("name" => $_POST['name'],
					   "description" => $_POST['description']);
			tep_db_perform(TABLE_COURSE_TYPES, $sql_array, 'update', "id = '$course_type_id'");
			
			header("Location: add_course_type.php");
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
										
										<h4>Edit Course Type</h4>
										<form action="edit_course_type.php?id=<?php echo $course_type_id; ?>" name="add_course_type" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Course Type:
												</td>
												<td class="right">
													<input name="name" type="text" class="textbox1" value="<?php echo tep_get_name(TABLE_COURSE_TYPES, $course_type_id); ?>">
												</td>
											</tr>
											<tr>
												<td class="left" valign="top">
													Description:
												</td>
												<td class="right">
													<textarea name="description" cols="60" rows="10" class="textbox1"><?php echo tep_get_description(TABLE_COURSE_TYPES, $course_type_id); ?></textarea>
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;
													
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input class="submit3" name="edit_course_type" type="submit" value="Edit Course Type">
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
