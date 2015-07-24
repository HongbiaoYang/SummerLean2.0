<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

function tep_get_admin_users($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.admin='1' and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term%' OR p.lastname LIKE '%$search_term%' OR p.gmc_reg LIKE '%$search_term%') order by u.center, u.type, u.username";
	}
	else
	{
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.admin='1' order by u.center, u.type, p.lastname";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$admin_array[] = array('id' => $row['id'],
				       'username' => $row['username'],
				       'admin' => $row['admin'],
				       'center' => $row['center'],
				       'type' => $row['type']);
	}
	return $admin_array;
}

function tep_get_instructor_users($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join tbl_students p on (u.id = p.stuindex) where u.instructor='1' and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term' OR p.lastname LIKE '%$search_term') ORDER by u.username";
	}
	else
	{
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.instructor='1' order by p.lastname";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$instructor_id_array[] = array('id' => $row['id'],
										'username' => $row['username']);
	}
	return $instructor_id_array;
}




function tep_get_users($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.admin='0' and u.instructor='0' and p.rank = 0 and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term%' OR p.lastname LIKE '%$search_term%') order by p.lastname";
	}
	else
	{
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.admin='0' and u.instructor='0' order by p.lastname";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$user_array[] = array('id' => $row['id'],
				      'username' => $row['username']);
	}
	return $user_array;
}
function tep_get_users_instructors($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.admin='0' and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term%' OR p.lastname LIKE '%$search_term%') order by p.lastname";
	}
	else
	{
		$query = "select * from users as u left join tbl_students as p on (u.id = p.stuindex) where u.admin='0' order by p.lastname";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$user_array[] = array('id' => $row['id'],
				      'username' => $row['username']);
	}
	return $user_array;
}

function tep_get_diets() {
	$query = "select * from diet order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$diet_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $diet_array;
}

function tep_get_how_hear() {
	$query = "select * from how_hear order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$how_hear_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $how_hear_array;
}

function tep_get_username($stuindex) {
	$query = "select username from users where id = '$stuindex'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['username'];
}

// returns array of stuindex's for instructors

function tep_get_instructors() {
	$query = "select u.id, p.firstname from users as u left join tbl_students as p on (u.id = p.stuindex) where u.instructor = '1' ORDER BY p.lastname";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$instructor_id_array[] = array("id" => $row['id']);
	}
	return $instructor_id_array;
}

function tep_get_group_instructors($group_id) {
	$query = "SELECT stuindex FROM group_users WHERE group_id = '$group_id'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$instructor_id_array[] = array("id" => $row['stuindex']);
		}
	}
	else{
		$instructor_id_array = array();
	}
	return $instructor_id_array;
}

function tep_get_instructor_name($id) {
	$query = "select firstname, lastname from tbl_students where stuindex ='$id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['firstname'].' '.$row['lastname'];		//returns id and full name of instructor
}

function tep_get_password($username) {
	$query ="select password from users where username='$username' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['password'];
}
function tep_get_activation($username) {
	$query ="select active from users where username='$username' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['active'];
}
function tep_activate_user($id) {
	$sql_array = array("active" => 0);
	// enter user into users database
	tep_db_perform(TABLE_USERS, $sql_array, 'update', "id='$id'");
}
?>
