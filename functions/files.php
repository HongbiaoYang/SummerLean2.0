<?php
/*
 * Created on Aug 6, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 function tep_upload_file($filename, $temp_filename, $folder_path) {
	$uploadfile = $folder_path .'/'.$filename;
	if (!is_file($uploadfile)) {
		if (move_uploaded_file($temp_filename, $uploadfile)) {
			chmod($uploadfile, 0777);
   	 		return true;		// upload successful
		}
		else
		{
    			return false;	// upload failed
		}
	}
 }


 function tep_get_files($course, $administrator = false) {
 	$file_array = array();
 	$folder_id = tep_get_folder_id($course);
 	if (!$administrator) {
 		$query = "select id from files where visible = 'on' and folder_id = '$folder_id'";
 	}
 	else
 	{
 		$query = "select id from files where visible != 'on' and folder_id = '$folder_id'";
 	}
 	$result = tep_db_query($query);
 	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$file_array[] = $row['id'];
		}
		return $file_array;
 	}
 	else
 	{
 		return false;
 	}

 }

function tep_get_file_icon($haystack) {
		if (strpos($haystack, 'excel')) {
			//use excel icon
			$icon_path = 'images/xls_file_icon.gif';
		}
		else if (strpos($haystack, 'pdf')) {
			$icon_path = 'images/pdf_file_icon.gif';
		}
		else if (strpos($haystack, 'word')) {
			$icon_path = 'images/doc_file_icon.gif';
		}
		else if (strpos($haystack, 'powerpoint')) {
			$icon_path = 'images/ppt_file_icon.gif';
		}
		else
		{
			$icon_path = 'images/file_icon.gif';
		}
		return $icon_path;
}
?>
