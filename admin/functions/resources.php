<?php
/*
 * Created on 13 Apr 2007 by Jacques Malan
 *
 * Copyright Jacques Malan for Chelsea Westminster Simulation Centre
 */
 function tep_get_resource_type($resource_id) {
 	$query = "select type from resources where id = '$resource_id' LIMIT 1";
 	$result = tep_db_query($query);
 	$row = tep_db_fetch_array($result);
 	return $row['type'];
 }

function tep_get_resource_center($resource_id) {
	$query = "select center from resources where id = '$resource_id' LIMIT 1";
 	$result = tep_db_query($query);
 	$row = tep_db_fetch_array($result);
 	return $row['center'];
}
?>
