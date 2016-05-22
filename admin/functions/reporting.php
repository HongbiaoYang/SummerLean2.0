<?php
/*
 * Created on 4 May 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 function tep_get_report_array($calendar_id) {
 	$query = "select * from reporting where id = $calendar_id";
 	$result = tep_db_query($query);
 	if (tep_db_num_rows($result) > 0) {
 		while ($row = tep_db_fetch_array($result)) {
 			$report_array = array("id" => $row['id'],
 								"calendar_id" => $row['calendar_id'],
 								"user_id" => $row['user_id']);
 		}
 	}
 	return $report_array;
 }
?>
