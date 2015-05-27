<?php
/*
 * Created on Aug 8, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class file_instance {

 	var $id;
 	var $folder_id;
 	var $name;
 	var $filetype;
 	var $admin_id;
 	var $visible;
 	var $order_number;
 	var $cDate;
 	var $deleted;

 	var $fullpath;
 	var $relative_path;


 	function file_instance($id) {

 		$this->id = $id;
 		$query = "select * from files where id = '$id' LIMIT 1";
 		$result = tep_db_query($query);
 		if (tep_db_num_rows($result)>0) {
 			$row = tep_db_fetch_array($result);
 			$this->folder_id = $row['folder_id'];
 			$this->name = $row['name'];
 			$this->file_type = $row['file_type'];
 			$this->admin_id = $row['admin_id'];
 			$this->visible = $row['visible'];
 			$this->order_number = $row['order_number'];
 			$this->cDate = $row['cDate'];
 			$this->deleted = $row['deleted'];
 			$this->fullpath = $this->get_fullpath();
 			$this->relative_path = $this->get_relative_path();
 		}
 	}
// this needs changing... this fullpath is not necessarily true
 	function get_fullpath() {
		$query = "select * from folders where id = '$this->folder_id' LIMIT 1";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			// TODO: This where I stopped 8 Aug.
			$row = tep_db_fetch_array($result);
			if ($row['center'] > 0 && $row['type'] == 0) {
				$fullpath = FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']).'/'.$this->name;
			}
			else if ($row['center'] == 0 && $row['type'] > 0) {
				$fullpath = FILE_DIR.'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']).'/'.$this->name;
			}
			else if ($row['center'] > 0 && $row['type'] > 0 && $row['course']) {
				$fullpath = FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']).'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']).'/'.tep_get_name(TABLE_COURSES, $row['course']).'/'.$this->name;
			}
			return $fullpath;
		}

 	}

 	function get_relative_path() {
		$query = "select * from folders where id = '$this->folder_id' LIMIT 1";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			// TODO: This where I stopped 8 Aug.
			$row = tep_db_fetch_array($result);
			if ($row['center'] > 0 && $row['type'] == 0) {
				$relative_path = RELATIVE_FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']).'/'.$this->name;
			}
			else if ($row['center'] == 0 && $row['type'] > 0) {
				$relative_path = RELATIVE_FILE_DIR.'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']).'/'.$this->name;
			}
			else if ($row['center'] > 0 && $row['type'] > 0 && $row['course']) {
				$relative_path = RELATIVE_FILE_DIR.'/'.tep_get_name(TABLE_CENTERS, $row['center']).'/'.tep_get_name(TABLE_COURSE_TYPES, $row['type']).'/'.tep_get_name(TABLE_COURSES, $row['course']).'/'.$this->name;
			}
			return $relative_path;
		}

 	}

 }
?>
