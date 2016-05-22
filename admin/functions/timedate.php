<?php
/*
 * Created on Oct 10, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 *
 * This function will contain all date and time functions necessary to display the appropriate information
 * in scheduling when looking for a certain month, week or day
 *
 */

 function tep_get_month_range($month, $year) {
 	$last_day = date("d", mktime(0,0,0,$month+1,0,$year)); // this will return the last day of the specified month in the specified year.
 	return $last_day;
 }


function tep_date_turn($date) { //changes d-m-Y to Y-m-d
	$year = substr($date,-4,4);
	$month = substr($date,-7,2);
	if (strlen($date) == '10') {
		$day = substr($date,0,2);
	}
	else
	{
		$day = '0'.substr($date,0,1);
	}
	return $year.'-'.$month.'-'.$day;
}

function tep_swap_dates($date) { //changes Y-m-d to d-m-Y
	$day = substr($date,8,2);
	$month = substr($date,5,2);
	$year = substr($date,0,4);
	return $day.'-'.$month.'-'.$year;
}
?>
