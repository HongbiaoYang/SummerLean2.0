<?php
/*
 * Created on Aug 6, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 *
 *
 * folder exists for every centre, type and course and cannot be removed. These folders are created at the time of course creation. If a type, course or center is removed all folders related will be removed.
 * Base folder is Uploads
 */

 class folder {

 	var $id;
 	var $name;
 	var $center;
 	var $type;
 	var $course;
 	var $permission;
 	var $admin_id;
 	var $cDate;
 	var $mDate;

	var $files;		//array of file id's located in this folder. Needs to be empty to be able to delete a folder.

	var $fullpath;
	var $relative_path;

	var $subfolders;		//array of all folders inside this folder

	var $parent_folder;  // id of this folders parent id. set to false if none exist.

 	var $breadcrumb;		// array of folders in breadcrumb


 	function folder($id) {
 		$query = "select * from folders where id = '$id' LIMIT 1";
 		$result = tep_db_query($query);
 		if (tep_db_num_rows($result) > 0) {
 			$row = tep_db_fetch_array($result);
 			$this->id = $id;
 			$this->name = $row['name'];
 			$this->center = $row['center'];
 			$this->type = $row['type'];
 			$this->course = $row['course'];
 			$this->permission = $row['permission'];
 			$this->admin_id = $row['admin_id'];
 			$this->cDate = $row['cDate'];
 			$this->mDate = $row['mDate'];

 			$this->files = $this->get_files($this->id);
 			$this->fullpath = $this->get_folder_path($this->id);
 			$this->relative_path = $this->get_folder_path($this->id, true);
 			$this->subfolders = $this->get_subfolders($this->id);
 			$this->parent_folder = $this->get_parent_folder($this->id);
 			$this->breadcrumb = $this->get_breadcrumb($this->id);
 		}
 	}


	function get_folder_path($id, $relative = false) {

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
			if (tep_db_num_rows($result) > 0 && !$parent_folder_exist && !$relative) {
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
			else if (tep_db_num_rows($result) > 0 && !$parent_folder_exist && $relative) {
				$row = tep_db_fetch_array($result);
				if ($row['center'] > 0 && $row['type'] == 0) {
					$fullpath_array[] = RELATIVE_FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']);
				}
				else if ($row['center'] == 0 && $row['type'] > 0) {
					$fullpath_array[] = RELATIVE_FILE_DIR.'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']);
				}
				else if ($row['center'] > 0 && $row['type'] > 0 && $row['course']) {
					$fullpath_array[] = RELATIVE_FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']).'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']).'/'.tep_get_name(TABLE_COURSES, $row['course']);
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

	 function get_subfolders($id) {
	 	$subfolders = array();
	 	$query = "select * from folders where parentfolder = '$id' order by name";
	 	$result = tep_db_query($query);
	 	if (tep_db_num_rows($result) > 0) {
	 		//lets make an array with all the folders and their permissions
	 		while ($row = tep_db_fetch_array($result)) {
	 			$subfolders[] = array('id' => $row['id'],
	 									   'visible' => $row['visible']);
	 		}
	 	}
		return $subfolders;
	 }


	 // return array with id and visibility of files
	 // @param id (folder id)
	 function get_files($id) {

	 	$file_array = array();
		$query = "select id, visible from files where folder_id = '$id' order by name";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			while ($row = tep_db_fetch_array($result)) {
				$file_array[] = array("id" => $row['id'],
									 "visible" => $row['visible']);
			}
		}
		return $file_array;
	 }

	 function get_parent_folder($id) {
	 	$parent_folder = false;
	 	$query = "select parentfolder from folders where id = '$id'";
	 	$result = tep_db_query($query);
	 	if (tep_db_num_rows($result) > 0) {
	 		$row = tep_db_fetch_array($result);
	 		if ($row['parentfolder'] != 0)
	 			return $row['parentfolder'];
	 		else
	 			return false;
	 	}
	 	else
	 	{
	 		return false;
	 	}

	 }

	 function get_breadcrumb($id) {
	 	$breadcrumb_array = array();
		$parent_folder_exist = true;
		$breadcrumb_string = '';
		while ($parent_folder_exist) {
			$query = "select * from folders where id = '$id' and parentfolder > '0' LIMIT 1";
			$result = tep_db_query($query);
			if (tep_db_num_rows($result) > 0) {
				$row = tep_db_fetch_array($result);
				$parent_folder_exist = true;
				$id = $row['parentfolder'];
				$breadcrumb_array[] = $row['name'];

			}
			else
			{
				$parent_folder_exist = false;
			}
			// keep adding parent folders until the parent folder does not have a parent folder
			// that should now contain all the breadcrumbs
		}
		foreach ($breadcrumb_array as $k => $l) {
			$breadcrumb_string = $l.' > '.$breadcrumb_string;
		}
		return $breadcrumb_string;
	}

 }
?>
