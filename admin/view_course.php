<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	$access_level = 3;

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	$action = $_GET['action'];
	$course = new course($_GET['id']);
	$error = false;


	/*if (isset($_GET['parent_folder'])) {
		$parent_folder_id = $_GET['parent_folder'];
	}
	else
	{
		$parent_folder_id = tep_get_folder_id($_GET['id']);
	}
	$current_folder = new folder($parent_folder_id);*/

	switch ($action) {
		case 'delete_file': if (tep_validate_user($_SESSION['admin_user'],$access_level)) {
								// get fullpath of file and check if can be deleted. then delete table entry
						   		$file = new file_instance($_GET['file_id']);
						   		if (unlink($current_folder->fullpath.'/'.$file->name)) {
						   			//remove the database entry
						   			$query = "delete from files where id = '$file->id'";
						   			$result = tep_db_query($query);
						   		}
						   		else
						   		{
						   			$error = '<font color="red">Could not delete file!</font>';
						   		}
						   }
						   break;
		case 'delete_folder': if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
								// check if we can delete a folder
								$folder_id = $_GET['folder_id'];
								$remove_folder = new folder($folder_id);
								if (rmdir($remove_folder->fullpath)) {
									$query = "delete from folders where id = '$folder_id'";
									$result = tep_db_query($query);
								}
								else
								{
									$error = '<font color="red">Could not delete folder!</font>';
								}
							 }
							 break;
	}
	if (isset($_POST['add_folder'])) {
		if (tep_validate_entry($_POST['folder_name']) && tep_unique_folder($_POST['folder_name'], $parent_folder_id)) {
			$error = false;
			// lets add the folder to the folder structure
			mkdir($current_folder->fullpath.'/'.$_POST['folder_name']);
			$sql_array = array('name' => $_POST['folder_name'],
							  'center' => $current_folder->center,
							  'type' => $current_folder->type,
							  'course' => $current_folder->course,
							  'parentfolder' => $parent_folder_id,
							  'visible' => $_POST['visible'],
							  'admin_id' => $_SESSION['admin_user']->id,
							  'cDate' => date("Y-m-d H:i:s"),
							  'deleted' => 0);
			tep_db_perform(TABLE_FOLDERS, $sql_array);
		}
		else
		{
			$error = '<font color="red">Add Folder Error!</font>';
		}

	}
	if (isset($_POST['file_upload']) && tep_validate_entry($_FILES['userfile']['name'])) {
		if (tep_upload_file( basename($_FILES['userfile']['name']), $_FILES['userfile']['tmp_name'], $current_folder->fullpath)) {
			$error = false;
			// lets make entry into files table
			// var_dump($_FILES);
			$sql_array = array('folder_id' => $current_folder->id,
							  'name' => basename($_FILES['userfile']['name']),
							  'file_type' => $_FILES['userfile']['type'],
							  'admin_id' => $_SESSION['admin_user']->id,
							  'visible' => $_POST['visible'],
							  'order_number' => mysql_insert_id(),
							  'cDate' => date("Y-m-d H:i:s"),
							  'deleted' => 0);
			tep_db_perform(TABLE_FILES, $sql_array);
			$order_number = mysql_insert_id();
			$sql_array = array('order_number' => $order_number);
			tep_db_perform(TABLE_FILES, $sql_array, 'update', "id = '$order_number'");
		}
		else
		{
			$error = '<font color="red">Upload Error!</font>';
		}
	}
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Course Requirements</td>
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
									<td class="right" colspan="2">
										<?php
										if (isset($_POST['added'])) {
											echo '<font color="green">Course successfully added.</font>';
										}
										?>
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
								<tr>
									<td class="right" colspan="2">
										Requirements
									</td>
								</tr>
								<tr>
									<td class="left" valign="top">
										Job Titles:
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
								<tr>
									<td class="left" valign="top">
										Specialties:
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
								<tr>
									<td class="left">
										Bands:
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
								<tr>
									<td class="right" colspan="2">
										Default Times:
									</td>
								</tr>
								<tr>
									<td class="left">Start Time:</td>
									<td class="right"><?php echo substr($course->default_start_time,0,5); ?></td>
								</tr>
								<tr>
									<td class="left">End Time:</td>
									<td class="right"><?php echo substr($course->default_end_time,0,5); ?></td>
								</tr>
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
								<form enctype="multipart/form-data" action="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->id; ?>" name="file_upload" method="post">
								<?php
								if ($current_folder->parent_folder) {
									?>
									<tr>
										<td class="right" colspan="3"><a href="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->parent_folder; ?>"><img src="images/parent.gif" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $current_folder->breadcrumb; ?></tr>
									</tr>
									<?php
								}
								if ($error) {
									?>
									<tr>
										<td class="right" colspan="3"><?php echo $error; ?></td>
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
								<tr>
									<td class="hright" colspan="3"><span class="head">Administrator Files</span></td>
								</tr>
								<?php
								// lets display folders first
								foreach ($current_folder->subfolders as $e => $f) {
									if (!$f['visible']) {
										?>
										<tr>
											<td width="5%" class="right"><img src="images/folder.gif" /></td>
											<td class="right" width="65%"><a href="view_course.php?id=<?php echo $_GET['id']  ?>&parent_folder=<?php echo $f['id']; ?>"><?php echo tep_get_folder_name($f['id']); ?></a></td>
											<td class="right" width="30%"><a href="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->id; ?>&action=delete_folder&folder_id=<?php echo $f['id']; ?>"><img src="images/delete.png" border="0"></a></td>
										</tr>
										<?php
									}
								}
								$admin_files = $current_folder->files;
								foreach ($admin_files as $a=>$b) {
									if (!$b['visible']) {
										$file = new file_instance($b['id']);
										$icon_path = tep_get_file_icon($file->file_type);
										?>
										<tr>
											<td width="5%" class="right"><img src="<?php echo $icon_path; ?>" /></td>
											<td class="right" width="65%"><a href="<?php echo $current_folder->relative_path.'/'.$file->name; ?>" target="_blank"><?php echo $file->name; ?></a></td>
											<td class="right" width="30%"><a href="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->id; ?>&action=delete_file&file_id=<?php echo $file->id; ?>"><img src="images/delete.png" border="0"></a></td>
										</tr>
										<?php
									}
								}
								?>
								<tr>
									<td class="hright" colspan="3"><span class="head">Upload File to this Course</span></td>
								</tr>
								<tr>
									<td class="right" colspan="3">
										<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
										<input name="userfile" type="file" />
										<input name="visible" type="checkbox">&nbsp;Make visible to users

									</td>
								</tr>
								<tr class="right">
									<td colspan="3"><input name = "file_upload" value="Upload" type="submit" class="submit3"></td>
								</tr>
								</form>
							</table>
						</td>
					</tr>
					<tr>
						<td width="100%">
							<table width="100%">
								<form name = "add_folder" action="view_course.php?id=<?php echo $_GET['id']; ?>&parent_folder=<?php echo $current_folder->id; ?>" method="post">
								<tr>
									<td class="hright"><span class="head">Add Folder</span></td>
								</tr>
								<tr>
									<td class="right"><input name="folder_name" type="text">&nbsp;<input name="visible" type="checkbox">&nbsp;Make visible to users</td>
								</tr>
								<tr>
									<td class="right"><input name="add_folder" type="submit" value="Add Folder" class="submit3"></td>
								</tr>
							</table>
						</td>
					</tr> -->


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
