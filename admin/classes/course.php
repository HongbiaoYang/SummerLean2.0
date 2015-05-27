<?php

/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

class course {

var $id;
var $type;
var $type_name;
var $category;
var $category_name;
var $center;
var $center_name;
var $name;
var $description;
var $min_instructors;
var $min_attendance;
var $max_attendance;

var $default_start_time;
var $default_end_time;

var $job = array();
var $specialty = array();
var $band = array();



function course($id) {
	$query = "select * from courses where id = '$id' limit 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	$this->id = $id;
	$this->type = $row['type'];
	$this->category = $row['category'];
	$this->center = $row['center'];
	$this->name = $row['name'];
	$this->description = $row['description'];
	$this->min_instructors = $row['min_instructors'];
	$this->min_attendance = $row['min_attendance'];
	$this->max_attendance = $row['max_attendance'];
	$this->default_start_time = $row['default_start_time'];
	$this->default_end_time = $row['default_end_time'];
	$this->set_job_requirements();
	$this->set_band_requirements();
	$this->set_specialty_requirements();

}


function set_job_requirements() {
	$query = "SELECT * FROM requirements WHERE
		course_id = '$this->id' AND
		requirement_type = 'job'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$this->job[] = $row['requirement_id'];
		}
	}

}

function set_specialty_requirements() {
	$query = "SELECT * FROM requirements WHERE
		course_id = '$this->id' AND
		requirement_type = 'specialty'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$this->specialty[] = $row['requirement_id'];
		}
	}

}

function set_band_requirements() {
	$query = "SELECT * FROM requirements WHERE
		course_id = '$this->id' AND
		requirement_type = 'band'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$this->band[] = $row['requirement_id'];
		}
	}

}

function set_scheduling($online_reg = '0', $dates, $resources, $start_time, $end_time) {
	$this->online_reg = $online_reg;
	$this->dates = $dates;
	$this->resources = $resources; //array to be serialized
	$this->start_time = $start_time;
	$this->end_time = $end_time;
}



function set_calendar_vars($calendar_id) {
	$query = "select * from calendar where id='$calendar_id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	$this->start_date = $row['start_date'];
	$this->calendar_id = $calendar_id;
	$this->registered = $row['registered'];
	$this->waiting_list = $row['waiting_list'];
	$this->cancelled = $row['cancelled'];
	$this->online_reg = $row['online_reg'];
	$this->dates = unserialize($row['dates']);
	$this->resources = unserialize($row['resources']);
	$this->start_time = substr($row['start_time'],0,5);
	$this->end_time = substr($row['end_time'],0,5);
}


}

?>