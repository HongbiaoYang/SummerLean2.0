<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

function tep_get_admin_users($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join profiles as p on (u.id = p.user_id) where u.admin='1' and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term%' OR p.lastname LIKE '%$search_term%' OR p.gmc_reg LIKE '%$search_term%') order by u.center, u.type, u.username";
	}
	else
	{
		$query = "select * from users where admin='1' order by center, type, username";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$admin_array[] = array('id' => $row['id'],
				       'username' => $row['username'],
				       'admin' => $row['admin'],
				       'center' => $row['center'],
				       'type' => $row['type']);
	}
	return $admin_array;
}

function tep_get_instructor_users($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join profiles p on (u.id = p.user_id) where u.instructor='1' and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term' OR p.lastname LIKE '%$search_term') ORDER by u.center, u.type, u.username";
	}
	else
	{
		$query = "select * from users where instructor='1' order by center, type, username";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$instructor_id_array[] = array('id' => $row['id']);
	}
	return $instructor_id_array;
}

function tep_get_users($search_term = '') {
	if (strlen($search_term) > 0) {
		$query = "select * from users as u left join profiles as p on (u.id = p.user_id) where u.admin='0' and u.instructor='0' and (u.username LIKE '%$search_term%' OR p.firstname LIKE '%$search_term%' OR p.lastname LIKE '%$search_term%') order by username";
	}
	else
	{
		$query = "select * from users where admin='0' and instructor='0' order by username";
	}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$user_array[] = array('id' => $row['id'],
				      'username' => $row['username']);
	}
	return $user_array;
}


function tep_get_diets() {
	$query = "select * from diet order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$diet_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $diet_array;
}

function tep_get_how_hear() {
	$query = "select * from how_hear order by name";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$how_hear_array[] = array("id" => $row['id'],
				     "name" => $row['name']);
	}
	return $how_hear_array;
}

function tep_get_username($user_id) {
	$query = "select username from users where id = '$user_id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['username'];
}

// returns array of user_id's for instructors

function tep_get_instructors() {
	$query = "select * from users where instructor = '1'";
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		$instructor_id_array[] = array("id" => $row['id']);
	}
	return $instructor_id_array;
}

function tep_get_instructor_name($id) {
	$query = "select firstname, lastname from profiles where user_id ='$id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['firstname'].' '.$row['lastname'];		//returns id and full name of instructor
}

function tep_get_password($username) {
	$query ="select password from users where username='$username' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['password'];
}

function tep_set_accessibility($userid,$accessibility) {
	If ($accessibility=='true') $accessibility=1;
	Else $accessibility=0;
	$query ="update profiles set accessibility=$accessibility where user_id=$userid LIMIT 1";
	$result = tep_db_query($query);
}

function tep_activate_account($email) {
	$query ="update users set active=0 where username='$email' LIMIT 1";
	$result = tep_db_query($query);
}

function createRandomPassword($length) {
    $chars = "abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= $length) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

Function tep_email($to,$subject,$message) {
	
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers  .= "From: ".FROM."\r\n";
    If (mail($to, $subject, $message, $headers)) return true;
    Else return False;
}

function check_upload($file_upload)
{
   
    $target_dir = "uploads/";
    $target_file = basename($file_upload["name"]);
    $target_path = $target_dir . $target_file;
    $ulerror[0] = 1;
    $ulerror[1] = "";
    
    $imageFileType = pathinfo($target_path, PATHINFO_EXTENSION);
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["register"])) {
        
        $tmp_file = $file_upload["tmp_name"];
        if (strlen($tmp_file) == 0 || $tmp_file == '') {
            $ulerror[1]  = "File is empty";
            $ulerror[0] = 0;
            return $ulerror;
        }
        
        $check = getimagesize($file_upload["tmp_name"]);
        
        if($check !== false) {
            $ulerror[1]  = "File is an image - " . $check["mime"] . ".";
            $ulerror[0] = 1;
        } else {
            $ulerror[1]  = "File is not an image.";
            $ulerror[0] = 0;
            return $ulerror;
        }
    }
    
    // Check if file already exists
    if (file_exists($target_path)) {
        $ulerror[1] = "Sorry, file already exists.";
        $ulerror[0] = 0;
        return $ulerror;
    }
    // Check file size
    if ($file_upload["size"] > 2000000) {
        $ulerror[1] =  "Sorry, your file is too large.";
        $ulerror[0] = 0;
        return $ulerror;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        $ulerror[1] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $ulerror[0] = 0;
        return $ulerror;
    }
    
    return $ulerror;
}

function do_upload($file_upload, $user_id)
{
    $target_dir = "uploads/";
    $target_file =  $user_id.'-'. basename($file_upload["name"]);
    $target_path = $target_dir . $target_file;
    
    if (move_uploaded_file($file_upload["tmp_name"], $target_path)) {
        // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        return $target_file;
    } 
    
    
    
}

function gen_background_value($back_array) {
    
    $backs = $back_array;
    $backstr = '';
    if(empty($backs))
    {
    echo("You didn't select any buildings.");
    }
    else
    {
    $N = count($backs);
    for($i=0; $i < $N; $i++)
    {
        
      $backstr .= htmlspecialchars($backs[$i] ). ".";
    }
    } 
    
    return  $backstr;
}

?>