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
	include(INCLUDES . 'leftmenu.php');
	
	$course = new course($_GET['id']);
?>

	<table width='100%'>
		<!-- CONTENT -->
		<tr>
			<td>
				<p class="heading">Course: <?php echo $course->name; ?></p>
				Course successfully added.
				<p class="heading">Course Type:</p>
				<?php echo tep_get_name(TABLE_COURSE_TYPES, $course->type); ?>
				<p class="heading">Center</p>
				<?php echo tep_get_name(TABLE_CENTERS, $course->center); ?>
				<p class="heading">Category</p>
				<?php echo tep_get_name(TABLE_COURSE_CATEGORIES, $course->category); ?>
				<p class="heading">Description</p>
				<?php echo $course->description; ?>
				<p class="heading">Attendance Restrictions</p>
				Minimum Attendance: <?php echo $course->min_attendance; ?><br>
				Maximum Attendance: <?php echo $course->max_attendance; ?>
				<p class="heading">Requirements</p>
				<span class="heading2">Job Titles:</span><br>
				<?php
				foreach ($course->job as $job_id) {
					echo tep_get_name(TABLE_JOBS, $job_id).'<br>';
				}
				?>
				<span class="heading2">Specialties:</span><br>
				<?php
				foreach ($course->specialty as $specialty_id) {
					echo tep_get_name(TABLE_SPECIALTIES, $specialty_id).'<br>';
				}
				?>
				<span class="heading2">Bands</span>
				<?php
				foreach ($course->band as $band_id) {
					echo tep_get_name(TABLE_BANDS, $band_id).'<br>';
				}
				?>
			</td>
		</tr>
	</table>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
