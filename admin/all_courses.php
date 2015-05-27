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

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');

	if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
		$user = new user(tep_get_username($user_id));
	}

	$where_array = array();
	if (isset($_POST['filter'])) {
		$center = $_POST['center'];
		$type = $_POST['type'];
		$category = $_POST['category'];
		$course = $_POST['course'];
		if ($center >= 1) {
			$where_array['center'] = $center;
		}
		if ($type >= 1) {
			$where_array['type'] = $type;
		}
		if ($category >= 1) {
			$where_array['category'] = $category;
		}
		$counter = 0;
		foreach ($where_array as $a=>$b) {
			if ($counter == 0) {
				$where_clause = $a.' = '.$b;
			}
			else
			{
				$where_clause .= ' and '.$a.' = '.$b;
			}
			$counter++;
		}
	}
	// page to display all courses with filter
	?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;All Courses</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing all courses</td>
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
								<tr>
									<table width="100%">
										<tr>
											<form name="filter" action="all_courses.php" method="post">
											<td class="left">Venue:</td><td class="right"><?php echo tep_build_dropdown(TABLE_CENTERS, center, false, 1, '', true, $_POST['center']); ?></td>
											<td class="left">Type:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_TYPES, type, false, 1, '', true, $_POST['type']); ?></td>
											<td class="left">Category:</td><td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_CATEGORIES, category, false, 1, '', true, $_POST['category']); ?></td>
											<td class="left"><input type="submit" name="filter" class="submit3" value="Filter"></td>
											</form>
										</tr>
									</table>
								</tr>
								<tr>
									<td align="left">
										<h4>Courses</h4>
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%">
										<?php
											//display current courses
											$course_array = tep_get_courses($where_clause);
											if (empty($course_array)) {
											?>
												<tr>
													<td class="right">
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
													echo '<tr><td class="left" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<a href="view_course.php?id='.$b['id'].'">'.$b['name'].'</a></td>
															<td class="left"><a href ="edit_course.php?id='.$b['id'].'">Edit</a>';
															if (isset($_GET['user_id'])) {
																echo '&nbsp;|&nbsp;<a href="view_schedule.php?action=register&id='.$user_id.'&course_id='.$b['id'].'">Register</a>';
															}

															echo '</td></tr>';
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
			</td>
		</tr>
	</TABLE>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
