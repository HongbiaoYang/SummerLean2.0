<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	
	if (isset($_POST['add_survey'])) {
		if (tep_validate_survey()) {
			// add the survey to the database
			$sql_array = array('name'=> prepare_input($_POST['name']),
					   'phpesp_id'=> prepare_input($_POST['phpesp_id']));
			tep_db_perform(TABLE_SURVEYS, $sql_array);
			header("Location: surveys.php");
		}
		else
		{
			//set error message and display form again
			$error = true;
		}
	}


	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	//include(INCLUDES . 'leftmenu.php');
	

?>

	
	
	
	<!--MAIN TABLE STARTS HERE--->
	
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Survey Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Add Survey</td>
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
					<form action="add_survey.php" name="add_survey" method="post">
					<?php
					if ($error) {
					?>
						<tr>
							<td class="required" colspan="2">You need to fill in both fields</td>
						</tr>
					<?php
					}
					?>
					
					<tr>
						<td align="right" class="left" width="50%" valign="middle">Survey Name:</td>
						<td class="right" width="50%"><input name="name" type="text" value="<?php $_POST['name'];?>" class="textbox1"></td>
					</tr>
					<tr>
						<td align="right" class="left" width="50%" valign="middle">phpESP SID</td>
						<td class="right" width="50%"><input name="phpesp_id" type="text" value="<?php $_POST['phpesp_id']; ?>" class="textbox1"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input name="add_survey" type="submit" value="Add Survey" class="submit3"></td>
					</tr>
					</form>

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
	
	<!-- main content ends here -->
	
	<!--MAIN TABLE ENDS HERE---><!--BOTTOM TABLE STARTS HERE--->
	
<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

