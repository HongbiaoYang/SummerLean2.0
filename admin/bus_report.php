<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems


  Copyright (c) 2007 Jacques Malan

  This page will give some basic reporting on courses for a specified time period.

  This version of the code is released under the GNU General Public License
*/
	// page to display schedule
	$access_level = '3';
	$access_error = false;

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (isset($_POST['filter'])) {
		$bus_report = new bus_report($_POST['center'], $_POST['course_type'], $_POST['category'], $_POST['courses'], $_POST['start_date'], $_POST['end_date']);
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
			<td class="title" height="27" colspan=3>&nbsp;Business Report</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Reporting</td>
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
								<form name="filter" action='bus_report_print.php' method='post'>
								<tr>
									<td align="left" colspan="2">
										<h4>Filter</h4>
									</td>
								</tr>
								<tr>
									<td width="30%" class="left">Centre:</td>
									<td class="right"><?php echo tep_build_dropdown(TABLE_CENTERS, 'center', false, '1', '', true, $_POST['center'], 'name', 'All'); ?></td>
								</tr>
								<tr>
									<td width="30%" class="left">Course Type:</td>
									<td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_TYPES, 'course_type',  false, '1', '', true, $_POST['course_type'], 'name', 'All'); ?></td>
								</tr>
								<tr>
									<td width="30%" class="left">Category:</td>
									<td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_CATEGORIES, 'category',  false, '1', '', true, $_POST['category'], 'name', 'All'); ?></td>
								</tr>
								<tr>
									<td width="30%" class="left">Course:</td>
									<td class="right"><?php echo tep_build_dropdown(TABLE_COURSES, 'courses',  false, '1', '', true, $_POST['courses'], 'name', 'All'); ?></td>
								</tr>
								<tr>
									<td width="30%" class="left">Start Date:</td>
									<td class="right"><input name = "start_date" id="start_date" class="textbox1" type="text" size="25" value="<?php echo $_POST['start_date'];?>"> <a href="javascript:NewCal('start_date','DDMMYYYY')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>&nbsp;Format: dd-mm-yyyy</td>
								</tr>
								<tr>
									<td width="30%" class="left">End Date:</td>
									<td class="right"><input name="end_date" id="end_date" class="textbox1" type="text" size="25" value="<?php echo $_POST['end_date'];?>"> <a href="javascript:NewCal('end_date','DDMMYYYY')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>&nbsp;Format: dd-mm-yyyy</td>
								</tr>
								<tr>
									<td class="left">
									<td class="right"><input type="submit" name="filter" class="button" value="Filter"></td>
								</tr>
								</form>
							</table>

						<br><br>
						</td>
					</tr>
				</table>
				<table width="96%" align="center" cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td colspan=3 align=right></td>
					</tr>
				</table>
			</td>
		</tr>
	</TABLE>


<?php
	//var_dump($_SESSION);
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>