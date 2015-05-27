<?php
/*
 * Created on 12 Mar 2007 by Jacques Malan
 *
 * Copyright Jacques Malan for Chelsea Westminster Simulation Centre
 */

 class scheduled extends course {

 	// scheduling information

	var $online_reg;
	var $dates;
	var $resources;
	var $start_time;
	var $end_time;
	var $users;

	var $calendar_id;
	var $start_date;
	var $status;			//array containing the number of users in different status.
	var $total_users;
	var $cancelled;

	var $attended;			//totals for reporting
	var $passed;
	var $failed;

	function scheduled($id) {
		$this->course($id);
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
		$this->cancelled = $row['cancelled'];
		$this->online_reg = $row['reg_online'];
		$this->dates = unserialize($row['dates']);
		$this->resources = unserialize($row['resources']);
		$this->instructors = unserialize($row['instructors']);
		$this->start_time = substr($row['start_time'],0,5);
		$this->end_time = substr($row['end_time'],0,5);
		// set status var
		$status_array = tep_get_status();
		foreach ($status_array as $r=>$s) {
			$this->status[] = array("id" => $s['id'],
								   "amount" => tep_get_status_amount($s['id'], $this->calendar_id));
		}
		$this->total_users = tep_get_total_users($this->calendar_id);

		$query = "SELECT * FROM registrations WHERE calendar_id = '$calendar_id' AND cancelled != '1'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			while ($row = tep_db_fetch_array($result)) {
				$this->users[] = array(	"id" => $row['user_id'],
										"status" => $row['status']);
			}
		}
	}

	function set_report_vars() {
		$this->attended = 0;
		$this->passed = 0;
		$this->failed = 0;
		$query = "select * from reporting where calendar_id = '$this->calendar_id'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			while ($row = tep_db_fetch_array($result)) {
				if ($row['attended'] == 1)
					$this->attended += $row['attended'];
				if ($row['pass'] == 1)
					$this->passed += $row['pass'];
				if ($row['fail'] == 1)
				$this->failed += $row['fail'];
			}
		}

	}

	function increment_registered($amount) {
		$this->registered += $amount;
	}

	function increment_waiting_list($amount) {
		$this->waiting_list += $amount;
	}
}
?>
