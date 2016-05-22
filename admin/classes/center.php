<?php
/*
 * Created on 13 Apr 2007 by Jacques Malan
 *
 * Copyright Jacques Malan for Chelsea Westminster Simulation Centre
 */
 
 class center {
 	
 	var $id;
 	var $name;
 	var $address_line1;
 	var $address_line2;
 	var $city;
 	var $country;
 	var $postcode;
 	var $contact_name;
 	var $contact_phone;
 	var $contact_fax;
 	var $contact_email;
 	
 	
 	function center($id) {
 		$query = "select * from centers where id ='$id' LIMIT 1";
 		$result = tep_db_query($query);
 		$row = tep_db_fetch_array($result);
 		
 		$this->id = $id;
 		$this->name = $row['name'];
 		$this->address_line1 = $row['address_line1'];
 		$this->address_line2 = $row['address_line2'];
 		$this->city = $row['city'];
 		$this->country = $row['country'];
 		$this->postcode = $row['postcode'];
 		$this->contact_name = $row['contact_name'];
 		$this->contact_phone = $row['contact_phone'];
 		$this->contact_fax = $row['contact_fax'];
 		$this->contact_email = $row['contact_email'];
 	}
 	
 	
 }
?>
