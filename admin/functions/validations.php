<?php

/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	function tep_validate_registration($type = '') {


		$error[0] = false;
		if ($type != 'profile') {
			if (!tep_validate_email($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* E-Mail address not valid';
			}
			if (!tep_username_unique($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* That E-Mail address has allready been registered';
			}
			if (strlen($_POST['password']) < 5) {
				$error[0] = true;
				$error[1] .= '<br>* Password must be at least 5 characters long';
			}
			if ($_POST['c_password'] != $_POST['password']) {
				$error[0] = true;
				$error[1] .= '<br>* Password confirmation does not match password';
			}
			if (strlen($_POST['firstname']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Forename is a required field';
			}
			if (strlen($_POST['lastname']) == 0) {
				$error[0] = true;
				$error[1] .= '<br>* Surname is a required field';
			}
		}
		if (!tep_validate_email($_POST['email'])) {
			$error[0] = true;
			$error[1] .= '<br>* E-Mail address not valid';
		}
		if (!isset($_POST['title'])) {
			$error[0] = true;
			$error[1] .= '<br>* Title not selected';
		}
		if (strlen($_POST['firstname']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Forename is a required field';
		}
		if (strlen($_POST['lastname']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Surname is a required field';
		}
		if (strlen($_POST['hosp_name']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Hospital Name is a required field';
		}
		if (strlen($_POST['addr1']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Address line 1 is a required field';
		}
		if (strlen($_POST['city']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* City is a required field';
		}
		if (strlen($_POST['postcode']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Postcode is a required field';
		}
		if (strlen($_POST['work_tel']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Work Telephone is a required field';
		}
		if (strlen($_POST['bleep']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Bleep is a required field';
		}
		if (strlen($_POST['job_title']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Job Title is a required field';
		}
		//if (strlen($_POST['specialty']) == 0) {
		//	$error[0] = true;
		//	$error[1] .= '<br>* Specialty is a required field';
		//}
		return $error;
	}
	function tep_validate_email($email){

		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
				return false;
		else
				return true;
	}
	//test if a course like this exists.
	function tep_unique_course($course, $center, $type, $category) {
		$query = "select * from courses where name='$course' and center='$center' and type = '$type' and category = '$category'";
		if (tep_db_num_rows(tep_db_query($query)) > 0) {
			return false;
		}
		else {
			return true;
		}
	}
	function tep_username_unique($username) {
		$query = "select * from users where username = '$username'";
		if (tep_db_num_rows(tep_db_query($query)) > 0)
			return false;
		else
			return true;
	}
	function tep_validate_entry($entry) {
		if (strlen($entry) > 0)
			return true;
		else
			return false;
	}
	// this is for adding and editing user information in the admin section
	function tep_validate_add_user($type = 'add') {
		$error[0] = false;


		if (strlen($_POST['email']) < 5) {
			$error[0] = true;
			$error[1] .= '<br>* Username must be at least 5 characters';
		}
		if ($type == 'add') {
			if (!tep_username_unique($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* That Username has allready been registered';
			}
			if (strlen($_POST['password']) < 5) {
				$error[0] = true;
				$error[1] .= '<br>* Password must be at least 5 characters long';
			}
			if ($_POST['c_password'] != $_POST['password']) {
				$error[0] = true;
				$error[1] .= '<br>* Password confirmation does not match password';
			}
		}
		if ($_POST['center'] > 0 || $_POST['type'] > 0 || $_POST['admin'] > 0) {

			$admin_user = $_SESSION['admin_user'];
			if ($admin_user->admin=='1' && $admin_user->center=='0' && $admin_user->type=='0') {
				if ($_POST['center'] > 0) {
					if ($_POST['admin'] != '1') {
						$error[0] = true;
						$error[1] .= '<br>* User needs to be of admin type to be made a centre administrator';
					}
				}
				if ($_POST['type'] > 0) {
					if ($_POST['center'] < 1) {
						$error[0] = true;
						$error[1] .= '<br>* User needs to be linked to a centre to be made administrator of an apartment';
					}
					if ($_POST['admin'] != '1') {
						$error[0] = true;
						$error[1] .= '<br>* User needs to be of admin type to be made apartment administrator';
					}
				}
			}
			else
			{
				$error[0] = true;
				$error[1] .= '<br>* You need to be a Super User to change or add administration permissions.';
			}
		}
		return $error;
	}

	function tep_validate_admin_login($username, $password) {
		$encrypted_password = md5($password);
		$query = "select * from users where username='$username' and password='$encrypted_password' and admin='1'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			//login success
			return true;
		}
		else
		{
			return false;
		}
	}

	function tep_validate_login($username, $password) {
		$encrypted_password = md5($password);
		$query = "select * from users where username='$username' and password='$encrypted_password'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			//login success
			return true;
		}
		else
		{
			return false;
		}
	}


	function tep_validate_user($user, $access_level='1', $center_id='0', $type_id='0') {
		//echo "ACCESS LEVEL:".$access_level;
		//echo "CENTER_ID:".$center_id;
		//echo "USER_CENTER:".$user->center;
		//echo "ADMIN_CLASS:".$user->admin_class;
		if ($user->admin_class == '1') {
			return true;
		}
		else if ($access_level == '2' && $user->admin_class == '2' && ($user->center == $center_id || $center_id == '0')) {
			return true;
		}
		else if ($access_level == '3' && ($user->admin_class == '3' || $user->admin_class == '2') && ($user->center == $center_id || $center_id == '0') && ($user->type == $type_id || $type_id == '0' || $user->admin_class = '2')) {
			return true;
		}
		else
		{
			return false;
		}

	}

	function tep_unique_entry($schedule_array) {
		$course_id = $schedule_array['course_id'];
		$start_date = $schedule_array['start_date'];
		$start_time = $schedule_array['start_time'];
		$end_time = $schedule_array['end_time'];
		$query = "select * from calendar where course_id = '$course_id' and start_date = '$start_date' and start_time < '$end_time' and end_time > '$start_time'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			return false;
		}
		else
		{
			return true;
		}

	}

	function tep_validate_course_registration($course_id, $job_title_id, $specialty_id, $band) {
		$query = "select * from requirements where course_id = '$course_id'";
		$result = tep_db_query($query);
		$job_array = array();
		$specialty_array = array();
		$band_array = array();
		while ($row = tep_db_fetch_array($result)) {
			if ($row['requirement_type'] == 'job') {
				$job_array[] = $row['requirement_id'];
			}
			else if ($row['requirement_type'] == 'specialty') {
				$specialty_array[] = $row['requirement_id'];
			}
			else if ($row['requirement_type'] == 'band') {
				$band_array[] = $row['requirement_id'];
			}
		}
		$registration = true;
		if (count($job_array) > 0) {
			$registration = false;
			foreach ($job_array as $a=>$b) {
				if ($b == $job_title_id) {
					$registration = true;
				}
			}
		}
		if ((count($specialty_array) > 0) && ($registration)) {
			$registration = false;
			foreach ($specialty_array as $a=>$b) {
				if ($b == $specialty_id) {
					$registration = true;
				}
			}
		}
		if ((count($band_array) > 0) && ($registration)) {
			$registration = false;
			foreach ($band_array as $a=>$b) {
				if ($b == $band) {
					$registration = true;
				}
			}
		}
		return $registration;
	}

	function tep_validate_unique_registration($user_id, $calendar_id) {

		$query = "select * from registrations where calendar_id = '$calendar_id' and user_id='$user_id'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			return false;
		}
		else
		{
			return true;
		}
	}
	// function to check if instructor is in a group
	function tep_instructor_in_group($group_id, $user_id) {
		$query = "SELECT * FROM group_users WHERE group_id = '$group_id' AND user_id = '$user_id'";
		$result = tep_db_query($query);
		if (tep_db_num_rows($result) > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
	//function to validate add survey form
	function tep_validate_survey() {
		if (strlen($_POST['name']) > 0 && strlen($_POST['phpesp_id'] > 0)) {
			return true;
		}
		else
		{
			return false;
		}
	}

	// returns false if correct, else returns error message
	function tep_validate_change_password($username, $old_password, $new_password, $confirm_password) {
		$password = tep_get_password($username);
		if ($password != md5($_POST['old_password'])) {
			$error = 'Old password field does not match current password.';
		}
		else if ($new_password != $confirm_password)
		{
			$error = 'Your confirmation password does not match your new password.';
		}
		else {
			if (strlen($new_password) < 5) {
				$error = 'Password must be at least 5 characters long.';
			}
			else
			{
				$error = false;
			}
		}
		return $error;
	}

	function prepare_input($input) {
		return addslashes($input);
	}
?>