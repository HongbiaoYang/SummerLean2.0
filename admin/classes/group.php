<?php
/*
 * Created on Apr 21, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


 class group {

 	var $id;
 	var $name;
 	var $members = array();



	 function group($id) {
	 	$this->id = $id;
	 	$query = "SELECT * FROM groups WHERE id = '$id'";
	 	$result = tep_db_query($query);
	 	if (tep_db_num_rows($result) > 0) {
	 		while ($row = tep_db_fetch_array($result)) {
	 			$this->name = $row['name'];
	 		}
	 	}
	 	// get the members of this group
	 	$query = "SELECT gu.id, gu.user_id FROM group_users as gu left join profiles as p on (gu.user_id = p.user_id) WHERE gu.group_id = '$id' ORDER BY p.lastname";
	 	$result = tep_db_query($query);
	 	if (tep_db_num_rows($result) > 0) {
	 		while ($row = tep_db_fetch_array($result)) {
	 			$this->members[] = array('user_id' => $row['user_id'],
	 									 'group_user_id' => $row['id']);
	 		}
	 	}

	 }
 }
?>
