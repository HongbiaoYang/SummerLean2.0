<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	$access_level = 3;

	if (!isset($_SESSION['learner'])) {
		header("Location: login.php");
	}
	$user = $_SESSION['learner'];
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');
	$action = $_GET['action'];
	$course = new course($_GET['id']);
	$error = false;


	if (isset($_GET['parent_folder'])) {
		$parent_folder_id = $_GET['parent_folder'];
	}
	else
	{
		$parent_folder_id = tep_get_folder_id($_GET['id']);
	}
	$current_folder = new folder($parent_folder_id);

?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>View Course</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%"><?php echo $course->name; ?></td>
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
									<td class="left" width="30%">
										<h4>Course:</h4>
									</td>
									<td class="right">
										 <?php echo $course->name; ?></h4>
									</td>
								</tr>
								<tr>
									<td class="left">
										Course Type:
									</td>
									<td class="right">
										<?php echo tep_get_name(TABLE_COURSE_TYPES, $course->type); ?>
									</td>
								</tr>
								<tr>
									<td class="left">
										Center:
									</td>
									<td class="right">
										<?php echo tep_get_name(TABLE_CENTERS, $course->center); ?>
									</td>
								</tr>
								<tr>
									<td class="left">
										Category:
									</td>
									<td class="right">
										<?php echo tep_get_name(TABLE_COURSE_CATEGORIES, $course->category); ?>
									</td>
								</tr>
								<tr>
									<td class="left">
										Description:
									</td>
									<td class="right">
										<?php echo $course->description; ?>
									</td>
								</tr>
								<tr>
									<td class="right" colspan="2">
										Attendance Restrictions:
									</td>
								</tr>
								<tr>
									<td class="left">
										Minimum Attendance:
									</td>
									<td class="right">
										<?php echo $course->min_attendance; ?>
									</td>
								</tr>
								<tr>
									<td class="left">
										Maximum Attendance:
									</td>
									<td class="right">
										<?php echo $course->max_attendance; ?>
									</td>
								</tr>
								<?php 
								// test which requirements are active
								if (LEVEL1_REQUIRED=='true'||
									LEVEL2_REQUIRED=='true'||
									LEVEL3_REQUIRED=='true') {
								
								?>
									<tr>
										<td class="right" colspan="2">
											Requirements
										</td>
									</tr>
								<?php
								}
								if (LEVEL1_REQUIRED=='true') {	
								?>
									<tr>
										<td class="left" valign="top">
											<?php echo LEVEL1_NAME; ?>
										</td>
										<td class="right">
											<?php
											if (count($course->job) > 0) {
												$counter = 0;
												foreach ($course->job as $job_id) {
													if ($counter != 0) {
														echo '<br>';
													}
													$counter++;
													echo tep_get_name(TABLE_JOBS, $job_id);
												}
											}
											else
											{
												echo 'None';
											}
											?>
										</td>
									</tr>
								<?php 
								}
								If (LEVEL2_REQUIRED=='true') {
								?>
									<tr>
										<td class="left" valign="top">
											<?php echo LEVEL2_NAME; ?>
										</td>
										<td class="right">
											<?php
											if (count($course->specialty) > 0) {
												$counter = 0;
												foreach ($course->specialty as $specialty_id) {
													if ($counter != 0) {
														echo '<br>';
													}
													$counter++;
													echo tep_get_name(TABLE_SPECIALTIES, $specialty_id);
												}
											}
											else
											{
												echo 'None';
											}
											?>
										</td>
									</tr>
								<?php 
								}
								If (LEVEL3_REQUIRED=='true') {
								?>
									<tr>
										<td class="left">
											<?php echo LEVEL3_NAME; ?>
										</td>
										<td class="right">
											<?php
											if (count($course->band) > 0) {
												$counter = 0;
	
												foreach ($course->band as $band_id) {
													if ($counter != 0) {
														echo '<br>';
													}
													$counter++;
													echo tep_get_name(TABLE_BANDS, $band_id);
												}
											}
											else
											{
												echo 'None<br>';
											}
											?>
										</td>
									</tr>
								<?php 
								}
								?>
							</table>
						</td>
					</tr>
					<!-- <tr>
						<td>
							<?php
							if (isset($_GET['parent_folder'])) {
								$parent_folder_id = $_GET['parent_folder'];
							}
							else
							{
								$parent_folder_id = tep_get_folder_id($_GET['id']);
							}
							$current_folder = new folder($parent_folder_id);
							?>
							<table width="100%">
								<?php
								if ($current_folder->parent_folder) {
									?>
									<tr>
										<td class="right" colspan="3"><a href="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->parent_folder; ?>"><img src="images/parent.gif" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $current_folder->breadcrumb; ?></tr>
									</tr>
									<?php
								}
								?>
								<tr>
									<td class="hright" colspan="3"><span class="head">User Files</span></td>
								</tr>
								<?php
								//lets display user folders

								foreach ($current_folder->subfolders as $e => $f) {
									if ($f['visible']) {
										?>
										<tr>
											<td width="5%" class="right"><img src="images/folder.gif" /></td>
											<td class="right" width="65%"><a href="view_course.php?id=<?php echo $_GET['id']  ?>&parent_folder=<?php echo $f['id']; ?>"><?php echo tep_get_folder_name($f['id']); ?></a></td>
											<td class="right" width="30%"><a href="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->id; ?>&action=delete_folder&folder_id=<?php echo $f['id']; ?>"><img src="images/delete.png" border="0"></a></td>
										</tr>
										<?php
									}
								}
								$user_files = $current_folder->files;
								foreach ($user_files as $a=>$b) {
									if ($b['visible']) {
										$file = new file_instance($b['id']);
										// select image to use for file
										$icon_path = tep_get_file_icon($file->file_type);
										?>
										<tr>
											<td width="5%" class="right"><img src="<?php echo $icon_path; ?>" /></td>
											<td class="right" width="65%"><a href="download_file.php?path=<?php echo $current_folder->fullpath; ?>&filename=<?php echo $file->name; ?>"><?php echo $file->name; ?></a></td>
											<td class="right" width="30%"><a href="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->id; ?>&action=delete_file&file_id=<?php echo $file->id; ?>"><img src="images/delete.png" border="0"></a></td>
										</tr>
										<?php
									}
								}
								?>
							</table>
						</td>
					</tr> -->
					<tr>
						<td>
							<a href="view_schedule.php?action=register&id=<?php echo $user->id; ?>&course_id=<?php echo $course->id; ?>">Register</a>
						</td>
					</tr>


				</table>


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
