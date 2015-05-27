<?php
/*
 * Created on Apr 24, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include('includes/application_top.php');


 if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
 }

 $counter = 0;
 $user_detail_array = array();
 $error_array = array();
 $query = "SELECT * FROM details";
 $result = tep_db_query($query);

if (isset($_POST['import'])) {

 while ($row = tep_db_fetch_array($result)) {
 	$user_detail_array[] = array("surname" => $row['surname'],
 								"firstname" => $row['firstname'],
 								"title" => $row['title'],
 								"email" => $row['email']);

 }

 foreach ($user_detail_array as $a => $b) {
 	$unique = true;
 	$counter++;
 	$firstname = $b['firstname'];
 	$surname = $b['surname'];
 	$title = $b['title'];
 	$username = $b['email'];
 	// need to check if this e-mail allready exist as username
 	$unique_query = "SELECT * FROM users WHERE username = '$username'";
 	$unique_result = tep_db_query($unique_query);
 	if (tep_db_num_rows($unique_result)) {
 		$unique = false;
 	}
 	$password = md5('password');
	if ($unique) {
	 	$sql_array = array("username" => $username,
	 						"password" => $password);
	 	tep_db_perform(TABLE_USERS, $sql_array);

	 	$user_id = mysql_insert_id();

	 	$sql_array = array("user_id" => $user_id,
	 					   "title" => $title,
	 					   "firstname" => $firstname,
	 					   "lastname" => $surname,
	 					   "job_title_id" => 16);	// JOB TITLE FOR MEDICAL STUDENTS

	 	tep_db_perform(TABLE_PROFILES, $sql_array);
 	}
 	else
 	{
		$error_array[] = $username;
 		// TODO: build error message for non-unique entries
 	}
 }

 echo $counter;
}

foreach ($error_array as $a=>$b) {
	echo '<font color="red">'.$b.' could not be registered. Reason: duplicate username. <br></font>';
}

?>
<form name="import" action="import_users.php" method="post">
	<input name="import" type="submit" value="Import Users">
</form>