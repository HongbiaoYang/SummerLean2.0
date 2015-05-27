<?php
/*
 * Created on Jul 30, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


 class note {

 	var $id;
 	var $admin_id;
 	var $user_id;
 	var $calendar_id;
 	var $description;
 	var $deleted;
 	var $cDate;

 	function note($id) {
 		$query = "select * from notes where id = '$id' LIMIT 1";
 		$result = tep_db_query($query);
 		$row = tep_db_fetch_array($result);
 		$this->admin_id = $row['admin_id'];
 		$this->user_id = $row['user_id'];
 		$this->calendar_id = $row['calendar_id'];
 		$this->description = $row['description'];
 		$this->cDate = $row['cDate'];
 		$this->deleted = $row['deleted'];
 	}


 }
?>
