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
	
	$job_id = $_GET['id'];
	
	include('includes/application_top.php');
	
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build

	
	
	if (isset($_POST['edit_jobs']) && tep_validate_entry($_POST['name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			
			$sql_array = array("name" => $_POST['name'],
					   "mDate" => date("Y-m-d H:i:s"));
			tep_db_perform(TABLE_JOBS, $sql_array, 'update', "id = '$job_id'");
			
			header("Location: add_jobs.php");
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
			<td class="title" height="27" colspan=3>&nbsp;Manage Job Titles</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add or Remove Job Title</td>
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
										<h4>Edit Job Title</h4>
										<form action="edit_jobs.php?id=<?php echo $job_id; ?>" name="add_jobs" method="POST">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Job Title:
												</td>
												<td class="right">
													<input name="name" type="text" value="<?php echo tep_get_name(TABLE_JOBS, $job_id); ?>">
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;
													
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="edit_jobs" type="submit" value="Edit Job Title" class="submit3">
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

