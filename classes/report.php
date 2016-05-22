<?php
/*
 * Created on 3 May 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 // This class is an instance of one users report for one course
 // needs calendar_id and user_id

 class report {
 	var $id;
 	var $calendar_id;
 	var $user_id;
 	var $attended;
 	var $pass;
 	var $fail;
 	var $mark;
 	var $comment;
 	var $cDate;
 	var $mDate;

 	function report($calendar_id, $user_id) {
 		$query = "select * from reporting where calendar_id = '$calendar_id' and user_id = '$user_id' LIMIT 1";
 		$result = tep_db_query($query);
 		$this->calendar_id = $calendar_id;
 		$this->user_id = $user_id;
 		if (tep_db_num_rows($result) > 0) {
 			$row = tep_db_fetch_array($result);
 			$this->id = $row['id'];
 			$this->attended = $row['attended'];
 			$this->pass = $row['pass'];
 			$this->fail = $row['fail'];
 			$this->mark = $row['mark'];
 			$this->comment = $row['comment'];
 			$this->cDate = $row['cDate'];
 			$this->mDate = $row['mDate'];
 		}
 	}

 	function set_attended($attended) {
 		$this->attended = $attended;
 	}
 	function set_pass($pass) {
 		$this->pass = $pass;
 	}
 	function set_fail($fail) {
 		$this->fail = $fail;
 	}
 	function set_mark($mark) {
 		$this->mark = $mark;
 	}
 	function set_comment($comment) {
 		$this->comment = $comment;
 	}

 	function update_reports() {
 		$date = date('Y-m-d H:i:s');
 		$query = "UPDATE ".TABLE_REPORTING." SET" .
 				"attended = $this->attended," .
 				"pass = $this->pass," .
 				"fail = $this->fail," .
 				"mark = $this->mark," .
 				"comment = $this->comment," .
 				"mDate = $date" .
 				"WHERE id = $this->id";
 		$result = tep_db_query($query);
 	}
 }
?>
