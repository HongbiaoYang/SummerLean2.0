<?php
/*
 * Created on Jul 11, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class bus_report {
	var $center;
	var $course_type;
	var $category;
	var $course;			//array of courses that are eligible for report
	var $start_date;
	var $end_date;

	var $scheduled_courses;			//courses included in $course that was scheduled within the given time

	var $total_courses;
	var $total_status; 				// array containing the status id as key and totals as values.
	var $total_cancelled;
	var $total_attended;
	var $total_passed;
	var $total_failed;

	function bus_report($center, $course_type, $category, $course, $start_date, $end_date) {
		$this->total_courses = array();
		$this->total_registered = array();
		$this->total_waiting_list = array();
		$this->total_cancelled = array();
		$this->total_attended = array();
		$this->total_passed = array();
		$this->total_failed = array();
		$this->center = $this->get_center($center);
		$this->course_type = $this->get_course_type($course_type);
		$this->category = $this->get_category($category);
		$this->course = $this->get_course($course);
		$this->start_date = tep_date_turn($start_date);
		$this->end_date = tep_date_turn($end_date);

		$this->scheduled_courses = $this->get_scheduled_courses();
	}

	function get_center($center) {
		$center_array = array();
		if ($center == 0) {
			$query = "select id from centers";
			$result = tep_db_query($query);
			while ($row = tep_db_fetch_array($result)) {
				$center_array[] = $row['id'];
			}
		}
		else
		{
			$center_array[] = $center;
		}
		return $center_array;
	}
	function get_course_type($course_type) {
		$course_type_array = array();
		if ($course_type == 0) {
			$query = "select id from course_types";
			$result = tep_db_query($query);
			while ($row = tep_db_fetch_array($result)) {
				$course_type_array[] = $row['id'];
			}
		}
		else
		{
			$course_type_array[] = $course_type;
		}
		return $course_type_array;
	}
	function get_category($category) {
		$category_array = array();
		if ($category == 0) {
			$query = "select id from course_categories";
			$result = tep_db_query($query);
			while ($row = tep_db_fetch_array($result)) {
				$category_array[] = $row['id'];
			}
		}
		else
		{
			$category_array[] = $category;
		}
		return $category_array;
	}
	function get_course($course) {
		$course_array = array();
		// build where clause to exclude courses by previous choices.
		$where_clause = 'where ';
		$counter = 0;
		// for centers
		foreach ($this->center as $a=>$b) {
			if ($counter > 0) {
				$where_clause .= ' or ';
			}
			else
			{
				$where_clause .= '(';
			}
			$where_clause .= 'center = '.$b;
			$counter++;

		}
		$where_clause .= ')';
		// for course types
		$where_clause .= ' and ';
		$counter = 0;
		foreach ($this->course_type as $a=>$b) {
			if ($counter > 0) {
				$where_clause .= ' or ';
			}
			else
			{
				$where_clause .= '(';
			}
			$where_clause .= 'type = '.$b;
			$counter++;
		}
		$where_clause .= ')';
		// for categories
		$where_clause .= ' and ';
		$counter = 0;
		foreach ($this->category as $a=>$b) {
			if ($counter > 0) {
				$where_clause .= ' or ';
			}
			else
			{
				$where_clause .= '(';
			}
			$where_clause .= 'category = '.$b;
			$counter++;
		}
		$where_clause .= ')';
		if ($course != 0) {
			$where_clause .= ' and (id = '.$course.')';
		}
		$query = "select id from courses ".$where_clause;
		//echo $query;
		$result = tep_db_query($query);
		while ($row = tep_db_fetch_array($result)) {
			$course_array[] = $row['id'];
		}
		return $course_array;
	}


	function get_scheduled_courses() {
		// find $this->course in the timeframe given. All start dates are applicable

		//build where clause from $course
//		$where_clause = ' and ';
		$counter = 0;
		foreach ($this->course as $a=>$b) {
			if ($counter > 0) {
				$where_clause .= ' or ';
			}
			else
			{
				$where_clause .= '(';
			}
			$where_clause .= 'course_id = '.$b;
			$counter++;
		}
		If ($counter>0) {
			$where_clause = ' and '.$where_clause. ')';
		}

		$scheduled_courses_array = array();
		$query = "select id, course_id from calendar where start_date > '$this->start_date' and start_date < '$this->end_date' ".$where_clause;
		//echo $query;
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			while ($row = tep_db_fetch_array($result)) {
				// add attended, passed and failed to the array using $row['id'] from previous result. Could join?

				$scheduled_courses_array[] = array('id' => $row['id'],
												'course_id' => $row['course_id']);
			}
			return $scheduled_courses_array;
		}
		else
		{
			//there was not any courses in this time and we return an empty array
			return $scheduled_courses_array;
		}
	}

	function update_totals($course, $status, $cancelled, $attended, $passed, $failed) {
		$this->total_courses[$course]++;
		$this->total_cancelled[$course] += $cancelled;
		$this->total_attended[$course] += $attended;
		$this->total_passed[$course] += $passed;
		$this->total_failed[$course] += $failed;
		// total status amounts needs to be updated

		foreach ($status as $a => $b) {
			$this->status[$course][$b['id']] = $this->status[$course][$b['id']]+$b['amount'];
		}


	}

 }
?>
