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
 	var $groups = array();


 	function instructor($username) {
 		$this->user($username);
 		$this->set_profile();
 		$this->get_groups();
 	}

 	function get_groups() {
 		$query = "SELECT group_id FROM group_users WHERE user_id = '$this->id'";
 		$result = tep_db_query($query);
 		if (tep_db_num_rows($result) > 0) {
 			while ($row = tep_db_fetch_array($result)) {
 				$this->groups[] = $row['group_id'];
 			}
 		}
 	}

 	function instructor_attributes() {
 		$query = "select qualifications, photo from tbl_students where user_id='$this->id' LIMIT 1";
 		$result = tep_db_query($query);
 		$row = tep_db_fetch_array($result);
 		$this->photo = $row['photo'];
 		$this->qualifications = $row['qualifications'];

 	}

 	function get_instructor_courses() {
 		$this->courses = array();
 		$query = "select id, instructors, dates from calendar order by start_date desc";

 		$result = tep_db_query($query);
 		if (tep_db_num_rows($result) > 0) {
 			while($row = tep_db_fetch_array($result)) {
 				if (strlen($row['instructors']) > 0) {
 					if (in_array($this->id, unserialize($row['instructors']))) {
 						$this->courses[] = array('id' => $row['id'],
 											'instructors' => unserialize($row['instructors']),
 											'dates' => $row['dates']);
 					}
 				}
 			}
 		}

 	}
 }
?>
