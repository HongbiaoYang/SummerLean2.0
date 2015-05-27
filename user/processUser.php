<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	
	case 'add' :
		addUser();
		break;
		
	case 'edit' :
		modifyUser();
		break;
		
	case 'verify' :
	    verifyUser();
	    break;	    
		
	case 'delete' :
		deleteUser();
		break;
    
	case 'list' :
		listUsers();
		break;
		
	case 'pwd' :
		changePassword();
		break;
	case 'rename':
      refullname();
      break;

	default :
	    // if action is not defined or unknown
		// move to main user page
		header('Location: index.php');
}

/*
function used to create single user in table tbl_users
*/
function addUser()
{
	$email = $_POST['txtEmail'];
	$password = $_POST['txtPassword'];
	$fname = $_POST['txtFname'];
	$mname = $_POST['txtMname'];
	$lname = $_POST['txtLname'];
	$l2name = $_POST['txt2Lname'];
	$fullname = $_POST['txtFullname'];
	
	$cname = $_POST['cname'];
	$dob = $_POST['dob'];
	$sem = $_POST['sem'];
	$ewrite = $_POST['ewrite'];
	$elisten = $_POST['elisten'];
	$espeak = $_POST['espeak'];
	$gender = $_POST['gender'];
	$univ = $_POST['univ'];
	$maj = $_POST['maj'];
	$gpa = $_POST['gpa'];
	$choice1 = $_POST['choice1'];
	$choice2 = $_POST['choice2'];
	$choice3 = $_POST['choice3'];
	$choice4 = $_POST['choice4'];

	// check if the username is taken
	$sql = "SELECT Email
	        FROM tbl_students
			WHERE Email = '$email'";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 1) {
		header('Location: ../view.php?v=adduser&error=' . urlencode('Email already taken. Choose another one'));	
	} else {			
		$sql   = "INSERT INTO `tbl_students`
						  (`Email`, `Password`, `FirstName`, `MiddleName`, `LastName`, `LastName2`, 
						 `fullName`, `Nationality`, `Choice1`, `Choice2`, `Choice3`,
						 `Choice4`, `DoB`, `Semester`, `EnglishWrite`, `EnglishListen`, `EnglishSpeak`, `Gender`, `University`,
						 `Major`, `GPA`, `TimeStamp`) 
							VALUES ('$email', '$password', '$fname', '$mname', '$lname', '$l2name', '$fullname',
							$cname, $choice1, $choice2, $choice3, $choice4, '$dob', '$sem', $ewrite,
							$elisten, $espeak, '$gender','$univ', '$maj', $gpa, NOW())";
	

		dbQuery($sql);
	
		header('Location: ../index.php?success='.$email);
	}
}


function changePassword()
{
	$oldpass = $_POST["oldpass"];
	$newpass1 = $_POST["newpass1"];
	
	$sql = "Select email from tbl_students "
					. " where stuIndex = ". $_SESSION['asset_user_id']
					. " and password = \"". $oldpass."\"";
					
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 1) {
		
		 $usql = "UPDATE `tbl_students` SET `Password`= \"".$newpass1."\" "
    . "WHERE 1 and stuindex = " . $_SESSION['asset_user_id'];
    dbQuery($usql);
    
		header('Location: ../index.php?changed=true');
	}
	else 
	{
		header('Location: ../index.php?changed=false');
	}
	
}

function refullname()
{
	$oldpass = $_POST["oldpass"];
	$newname = $_POST["newname"];
	
	$sql = "Select email from tbl_students "
					. " where stuIndex = ". $_SESSION['asset_user_id']
					. " and password = \"". $oldpass."\"";
					
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 1) {
		
		 $usql = "UPDATE `tbl_students` SET  fullname = '$newname' "
    . "WHERE 1 and stuindex = " . $_SESSION['asset_user_id'];
    dbQuery($usql);
    header('Location: ../menu.php?v=USER');	
	}
	else
	{
	   header('Location: ../menu.php?v=USER&error=Failed! Wrong Password!');	
	}

	
}


/*
	Modify a user, it will mdify, edit user and able to update user details
*/

function listUsers()
{
	$cate = $_POST["cate"];
	$ckey = $_POST["ckey"];
	header('Location: ../menu.php?v=LIST&key='.urlencode($cate).'&value='.urlencode($ckey));	
}

function modifyUser()
{
 	$uid = $_POST["id"];
    $userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	$email = $_POST['txtEmail'];
	$fname = $_POST['txtFname'];
	$lname = $_POST['txtLname'];
	$utype = 'USER';
	$did = (int)$_POST['did'];
	
	/*
	// the password must be at least 6 characters long and is 
	// a mix of alphabet & numbers
	if(strlen($password) < 6 || !preg_match('/[a-z]/i', $password) ||
	!preg_match('/[0-9]/', $password)) {
	  //bad password
	}
	*/	
	// check if the username is taken
		$sql   = "UPDATE tbl_users  
			SET uname = '$userName', 
				pwd = '$password', 
				email = '$email', 
				fname = '$fname', 
				lname = '$lname', 
				did = $did
				WHERE uid = $uid";
	
		dbQuery($sql);
		header('Location: ../menu.php?v=USER');	
	
}

/*
	Remove a user
*/

function verifyUser()
{
    $vsql = "update tbl_students set verify = 1 where stuindex = ".$_SESSION['asset_user_id'];
    dbQuery($vsql);
    //echo "debug".$_SESSION['asset_user_id'];
    //header('Location: ../menu.php?v=USER');	
    header('Location: ../menu.php?v=USER');
}


function deleteUser()
{
	if (isset($_GET['userId']) && (int)$_GET['userId'] > 0) {
		$userId = (int)$_GET['userId'];
	} else {
		header('Location: index.php');
	}
	
	
	$sql = "DELETE FROM tbl_users 
	        WHERE uid = $userId";
	dbQuery($sql);
	
	header('Location: ../menu.php?v=USER');
}
?>