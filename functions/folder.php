<?php
/*
 * Created on Aug 6, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


 function tep_create_folder($name, $center=0, $type=0, $course=0, $user_added=false, $visible = 0) {
 	if (!$user_added) {
	 	if ($center != 0 && $type == 0) {
	 		//center folder -- create in Uploads directory with centre name
	 		mkdir(FILE_DIR.'/'.$name);
	 		// create database entry
	 	}
	 	else if ($type != 0 && $course == 0) {
	 		//type folder so get the centre and create in this file
	 		$center_name = tep_get_name(TABLE_CENTERS, $center);
	 		mkdir(FILE_DIR.'/'.$name);

	 	}
	 	else if ($center != 0 && $type != 0 && $course != 0) {
	 		$center_name = tep_get_name(TABLE_CENTERS, $center);
	 		$type_name = tep_get_name(TABLE_COURSE_TYPES, $type);
	 		if (!is_dir(FILE_DIR.'/'.$center_name.'/'.$type_name)) {


	 			mkdir(FILE_DIR.'/'.$center_name.'/'.$type_name);
	 		}
	 		mkdir(FILE_DIR.'/'.$center_name.'/'.$type_name.'/'.$name);
	 	}

 	}
 	else   // user has added the folder
 	{

 		if ($center == 0) {
 			// application wide folder
 			mkdir(FILE_DIR.'/'.$name);
 		}
 		if ($center != 0 && $type == 0) {
	 		//center folder -- create in Uploads directory with centre name
	 		$center_name = tep_get_name(TABLE_CENTERS, $center);

	 		mkdir(FILE_DIR.'/'.$center_name.'/'.$name);
	 		// create database entry
	 	}
	 	else if ($center == 0 && $type != 0 && $course == 0) {
	 		//type folder so get the centre and create in this file

	 		$type_name = tep_get_name(TABLE_COURSE_TYPES, $type);
	 		mkdir(FILE_DIR.'/'.$type_name.'/'.$name);

	 	}
	 	else if ($center != 0 && $type != 0 && $course == 0) {
	 		$center_name = tep_get_name(TABLE_CENTERS, $center);
	 		$type_name = tep_get_name(TABLE_COURSE_TYPES, $type);

	 		mkdir(FILE_DIR.'/'.$center_name.'/'.$type_name.'/'.$name);
	 	}
	 	else if ($center != 0 && $type != 0 && $course != 0) {
	 		$center_name = tep_get_name(TABLE_CENTERS, $center);
	 		$type_name = tep_get_name(TABLE_COURSE_TYPES, $type);
	 		$course_name = tep_get_name(TABLE_COURSES, $course);
	 		mkdir(FILE_DIR.'/'.$center_name.'/'.$type_name.'/'.$course_name.'/'.$name);
	 	}
 	}
  	$sql_array = array('name' => $name,
 					  'center' => $center,
 					  'type' => $type,
 					  'course' => $course,
 					  'visible' => $visible,
 					  'admin_id' => $_SESSION['admin_user']->id,
 					  'cDate' => date("Y-m-d H:i:s"),
 					  'mDate' => date("Y-m-d H:i:s"),
 					  'deleted' => 0);
	 tep_db_perform(TABLE_FOLDERS, $sql_array);
 }


 function tep_get_folder_id($course_id) {
 	$query = "select id from folders where course = '$course_id' LIMIT 1";
 	$result = tep_db_query($query);
 	if (tep_db_num_rows($result) > 0) {
 		$row = tep_db_fetch_array($result);
 		return $row['id'];
 	}
 	else
 	{
 		return false;
 	}
 }

 function tep_get_folder_name($folder_id) {
 	$query = "select name from folders where id = '$folder_id' LIMIT 1";
 	$result = tep_db_query($query);
 	$row = tep_db_fetch_array($result);
 	return $row['name'];
 }

 function tep_get_folder_path($id) {

	// need to build in a recursive loop to look at all the possible parent folders to create the complete path

	$fullpath_array = array();
	$parent_folder_exist = true;

	while ($parent_folder_exist) {
		$query = "select * from folders where id = '$id' and parentfolder > '0' LIMIT 1";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			$row = tep_db_fetch_array($result);
			$parent_folder_exist = true;
			$id = $row['parentfolder'];
			$fullpath_array[] = $row['name'];

		}
		else
		{
			$parent_folder_exist = false;
		}
		// keep adding parent folders until the parent folder does not have a parent folder
	}
		$query = "select * from folders where id = '$id' LIMIT 1";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0 && !$parent_folder_exist) {
			$row = tep_db_fetch_array($result);
			if ($row['center'] > 0 && $row['type'] == 0) {
				$fullpath_array[] = FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']);
			}
			else if ($row['center'] == 0 && $row['type'] > 0) {
				$fullpath_array[] = FILE_DIR.'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']);
			}
			else if ($row['center'] > 0 && $row['type'] > 0 && $row['course']) {
				$fullpath_array[] = FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']).'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']).'/'.tep_get_name(TABLE_COURSES, $row['course']);
			}
		}
	$counter = 0;
	foreach ($fullpath_array as $a => $b) {
		if ($counter > 0) {
			$fullpath = $b.'/'.$fullpath;
		}
		else
		{
			$fullpath = $b;
		}
		$counter++;
	}
	return $fullpath;
 }

 function tep_unique_folder($folder_name, $parent_folder) {
	$query = "select * from folders where name='$folder_name' and parentfolder = '$parent_folder'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		return false;
	}
	else
	{
		return true;
	}
 }



?>
