<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	
	$access_level = '3';
	$access_error = false;
	
	include('includes/application_top.php');
	
	
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		if (tep_validate_user($_SESSION['admin_user'], $access_level, tep_get_course_center($_GET['id']), tep_get_course_type($_GET['id']))) {
			header("Location: schedule_attributes.php?id=$id");
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
			<td class="title" height="27" colspan=3>&nbsp;Scheduling Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Select Course</td>
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
										<h4>Courses</h4> <span class="right">Course not here? <a href="add_course.php">Create</a> course first.
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%">
										<?php
											//display current courses
											$course_array = tep_get_courses();
											if (empty($course_array)) {
											?>
												<tr>
													<td>
													<?php
														echo 'There are no courses registered';
													?>
													</td>
												</tr>
												<?php
											}
											else
											{	
												
												foreach ($course_array as $a => $b) {
													if ($b['center'] != $temp_center) {
														$temp_center = $b['center'];
														$temp_type = '';
														$temp_cat = '';
														echo '<tr><td colspan="2" class="hright"><span class="head">Centre: '.tep_get_name(TABLE_CENTERS, $temp_center).'</span></td></tr>';
													}
													if ($b['type'] != $temp_type) {
														$temp_type = $b['type'];
														$temp_cat = '';
														echo '<tr><td colspan="2" class="h2right"><span class="head">Course Type: '.tep_get_name(TABLE_COURSE_TYPES, $temp_type).'</span></td></tr>';
													}
													if ($b['category'] != $temp_cat) {
														$temp_cat = $b['category'];
														echo '<tr><td colspan="2" class="h3right"><span class="head">Category: '.tep_get_name(TABLE_COURSE_CATEGORIES, $temp_cat).'</span></td></tr>';
													}
													echo '<tr><td colspan="2" class="right">&nbsp;&nbsp;&nbsp;&nbsp;<a href="select_course.php?id='.$b['id'].'">'.$b['name'].'</a></td>';			
												}
											}
										?>
										</table>
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
