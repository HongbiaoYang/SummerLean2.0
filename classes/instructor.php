<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

 class instructor extends user {

 	var $photo;
 	var $qualifications;
 	var $courses;


 	function instructor($username) {
 		$this->user($username);
 		$this->set_profile();
 	}

 	function instructor_attributes() {
 		$query = "select qualifications, photo from profiles where user_id='$this->id' LIMIT 1";
 		$result = tep_db_query($query);
 		$row = tep_db_fetch_array($result);
 		$this->photo = $row['photo'];
 		$this->qualifications = $row['qualifications'];

 	}

 	/* function get_instructor_courses() {
 		$this->courses = array();
 		$query = "select id, instructor1, instructor2, instructor3, dates from calendar where instructor1 = '$this->id' or instructor2='$this->id' or instructor3='$this->id'";
 		$result = tep_db_query($query);
 		if (tep_db_num_rows($result) > 0) {
 			while($row = tep_db_fetch_array($result)) {
 				$this->courses[] = array('id' => $row['id'],
 										'instructor1' => $row['instructor1'],
 										'instructor2' => $row['instructor2'],
 										'instructor3' => $row['instructor3'],
 										'dates' => $row['dates']);
 			}
 		}

 	} */
 }
?>
