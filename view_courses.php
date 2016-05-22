<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	if (!isset($_SESSION['learner'])) {
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');


	$where_clause = false;
	// page to display all courses with filter
?>

	<table width=<?php echo TABLE_WIDTH; ?>>
		<!-- CONTENT -->
		<tr>
			<td>
				<h2>Courses</h2>
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
								echo '<tr><td colspan="2"><br><span class="heading"><font color="blue">Centre: '.tep_get_name(TABLE_CENTERS, $temp_center).'</font></span></td></tr>';
							}
							if ($b['type'] != $temp_type) {
								$temp_type = $b['type'];
								$temp_cat = '';
								echo '<tr><td colspan="2"><span class="heading">Course Type: '.tep_get_name(TABLE_COURSE_TYPES, $temp_type).'</span></td></tr>';
							}
							if ($b['category'] != $temp_cat) {
								$temp_cat = $b['category'];
								echo '<tr><td colspan="2"><span class="heading2">Category: '.tep_get_name(TABLE_COURSE_CATEGORIES, $temp_cat).'</span></td></tr>';
							}
							echo '<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<a href="view_course.php?id='.$b['id'].'">'.$b['name'].'</a></td>';
						}
					}
				?>
				</table>
			</td>
		</tr>
	</table>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
