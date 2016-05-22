<?php
/*
 * Created on Oct 12, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 // returns filename
 function tep_userexport($course_id, $users, $calendar_id) {
 	$schedule = new scheduled($course_id);
	$schedule->set_calendar_vars($calendar_id);
	$s_filename = tep_get_name(TABLE_COURSES, $course_id).$schedule->start_date.'.csv';
 	$filename = EXPORT_PATH.$s_filename;
 	$handle = fopen($filename, 'w');

	$headings = array("First name",
					"Last name",
					"E-Mail",
					"Hospital",
					"Home Tel",
					"Work Tel",
					"Mobile",
					"Bleep",
					"Address Line 1",
					"Address Line 2",
					"City",
					"Postcode",
					"Job Title",
					"Specialty",
					"Band",
					"GMC Reg",
					"Diet",
					"How Hear");
	$counter = 0;
	foreach ($headings as $a => $h) {
		if ($counter == 0) {
			fwrite($handle, '"'.$h.'"');
		}
		else
		{
			fwrite($handle, ',"'.$h.'"');
		}
		$counter++;
	}
	fwrite($handle, "\r");
	foreach ($users as $t => $u) {
		$user = new user(tep_get_username($u['user_id']));
		$user->set_profile();
		fwrite($handle,
		'"'.$user->firstname.'",' .
		'"'.$user->lastname.'",' .
		'"'.$user->username.'",' .
		'"'.$user->hospital_name.'",' .
		'"'.$user->home_telephone.'",' .
		'"'.$user->mobile.'",' .
		'"'.$user->mobile_telephone.'",' .
		'"'.$user->bleep.'",' .
		'"'.$user->address_line1.'",' .
		'"'.$user->address_line2.'",' .
		'"'.$user->city.'",' .
		'"'.$user->postcode.'",' .
		'"'.tep_get_name(TABLE_JOBS, $user->job_title_id).'",' .
		'"'.tep_get_name(TABLE_SPECIALTIES, $user->specialty_id).'",' .
		'"'.$user->band.'",' .
		'"'.$user->gmc_reg.'",' .
		'"'.$user->diet.'",' .
		'"'.$user->how_hear.'",');

		fwrite($handle, "\r");
	}





 	fclose($handle);
	return $s_filename;
 }




?>
