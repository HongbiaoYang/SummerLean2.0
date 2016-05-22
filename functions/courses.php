<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

function tep_get_centers() {
	$query = "select * from centers order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$center_array[] = array("id" => $row['id'],
					"name" => $row['name']);
	}
	return $center_array;
}

function tep_get_categories() {
	$query = "select * from course_categories order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$category_array[] = array("id" => $row['id'],
					"name" => $row['name']);
	}
	return $category_array;
}

function tep_get_course_types() {
	$query = "select * from course_types order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$ct_array[] = array("id" => $row['id'],
				    "name" => $row['name']);
	}
	return $ct_array;
}

function tep_get_jobs() {
	$query = "select * from jobs order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$job_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $job_array;
}
function tep_get_groups() {
	$query = "select * from groups order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$group_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $group_array;
}


function tep_get_status() {
	$query = "select * from status order by id";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$status_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $status_array;
}

function tep_get_default_status() {
	$query = "select id from status where def = '1' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['id'];
}

function tep_get_status_amount($status_id, $calendar_id) {
	$query = "select count(*)'amount' from registrations where status='$status_id' and calendar_id='$calendar_id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['amount'];
}

function tep_get_total_users($calendar_id) {
	$query = "select count(*)'users' from registrations where calendar_id = '$calendar_id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['users'];
}

function tep_get_specialties() {
	$query = "select * from specialties order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$specialty_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $specialty_array;
}

function tep_get_bands() {
	$query = "select * from bands order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$band_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $band_array;
}

function tep_get_resource_types() {
	$query = "select * from resource_type order by order_value";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$rt_array[] = array("id" => $row['id'],
				     "name" => $row['name'],
				     "order" => $row['order_value']);
	}
	return $rt_array;
}

function tep_get_courses($where_clause = '') {
	if ($where_clause == '') {
		$query = "select c.id as course_id, c.name, c.category, c.center, c.type
				 from courses as c order by c.center, c.type, c.category, c.name";
	}
	else
	{
		$query = "select c.id as course_id, c.name, c.category, c.center, c.type from courses as c
				left join requirements as r on c.id=r.course_id
				where ".$where_clause." order by c.center, c.type, c.category, c.name";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$course_array[] = array("id" => $row['course_id'],
				        "name" => $row['name'],
				        "category" => $row['category'],
				        "center" => $row['center'],
				        "type" => $row['type']);
	}
	return $course_array;
}

function tep_get_scheduled_courses($start_date, $end_date, $where_clause ='') {
	if ($where_clause == '') {
		$query = "SELECT ca.id, ca.course_id FROM calendar as ca left join courses as c on (c.id = ca.course_id) WHERE ca.start_date >= '$start_date' AND ca.start_date <= '$end_date'";
	}
	else
	{
		$query = "SELECT ca.id, ca.course_id FROM calendar as ca left join courses as c on (c.id = ca.course_id) WHERE ".$where_clause."  AND start_date >= '$start_date' AND start_date <= '$end_date'";
	}


	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$calendar_array[] = array('cal_id' => $row['id'],
									 'course_id' => $row['course_id']);
		}
	}
	return ($calendar_array);
}

function tep_get_course_id($id) {
	$query = "select course_id from calendar where id = '$id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['course_id'];
}

function tep_get_course_name($course_id) {
	$query = "select name from courses where id = '$course_id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['name'];
}

function tep_get_resources() {
	$query = "select r.id, r.name'resource', rt.name'resource_type', c.name'center' from resources as r left join resource_type as rt on (r.type= rt.id) left join centers as c on (r.center = c.id) order by c.name,rt.order_value,r.name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$resource_array[] = array("id" => $row['id'],
				     	  "name" => $row['resource'],
				     	  "resource_type" => $row['resource_type'],
				     	  "center" => $row['center']);
	}
	return $resource_array;
}


function tep_delete_entry($table, $id) {
	$query = "delete from $table where id = '$id'";
	$result = tep_db_query($query);
}

function tep_delete_requirements($course_id) {
	$query = "delete from requirements where course_id = '$course_id'";
	$result = tep_db_query($query);
}

function tep_get_course_center($id) {
	$query = "select center from courses where id = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['center'];
}

function tep_get_course_type($id) {
	$query = "select type from courses where id = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['type'];
}

function tep_get_course_category($id) {
	$query = "select category from courses where id = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['category'];
}

function tep_get_registered_users($calendar_id) {
	$query = "select user_id, status from registrations where calendar_id = '$calendar_id'";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$users[] = array('user_id' => $row['user_id'],
				 'status' => $row['status']);
	}
	return $users;
}

function tep_cancel_course($id) {
	$query  = "update calendar set cancelled = '1', registered = '0', waiting_list='0' where id = '$id'";
	$result =  tep_db_query($query);
}

function tep_reschedule_course($id) {
	$query = "update calendar set cancelled = '0' where id ='$id'";
	$result = tep_db_query($query);
}


function tep_get_registration_id($user_id, $calendar_id) {
	$query = "select id from registrations where calendar_id = '$calendar_id' and user_id = '$user_id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['id'];
}

?>