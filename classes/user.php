<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
class user {

var $id;
var $username;
var $admin;
var $center;
var $type;
var $instructor;
var $admin_class;

//profile
var $title;
var $firstname;
var $lastname;
var $gender;
var $martial;
var $insurance;
var $insurance_no;
var $hospital_name;
var $home_telephone;
var $mobile;
var $mobile_telephone;
var $bleep;
var $address_line1;
var $address_line2;
var $city;
var $county;
var $postcode;
var $country;
var $cDate;
var $mDate;
var $job_title_id;
var $specialty_id;
var $band;
var $gmc_reg;
var $diet;



function user($username) {
	$query = "select * from users where username = '$username'";
	$result = tep_db_query($query);

	while ($row = tep_db_fetch_array($result)) {
		$this->id = $row['id'];
		$this->admin = $row['admin'];
		$this->center = $row['center'];
		$this->type = $row['type'];
		$this->instructor = $row['instructor'];
		if ($this->admin == '0' && $this->center == '0' && $this->type == '0') {
			$this->admin_class = '0';	//no administrative rights
		}
		if ($this->admin == '1' && $this->center == '0' && $this->type == '0') {
			$this->admin_class = '1';	//superuser
		}
		if ($this->admin == '1' && $this->center != '0' && $this->type =='0') {
			$this->admin_class = '2';	//center adminstrator
		}
		if ($this->admin == '1' && $this->center != '0' && $this->type != '0') {
			$this->admin_class = '3';	//department administrator
		}
	}

	$this->username = $username;


}

function set_profile() {
	$query = "select * from tbl_students where stuindex = '$this->id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	$this->firstname = $row['FirstName'];
	$this->middlename = $row['MiddleName'];
	$this->lastname = $row['LastName'];
	$this->lastname2 = $row['LastName2'];
	$this->fullname = $row['fullName'];
	$this->gender = $row['gender'];
	$this->martial = $row['martial'];
    

	$this->netid = $row['netid'];
	$this->tnid = $row['TNID'];
	$this->email = $row['Email'];
	$this->country = $row['Nationality'];
	$this->team = $row['Team'];
	$this->choice1 = $row['Choice1'];
	$this->choice2 = $row['Choice2'];
	$this->choice3 = $row['Choice3'];
	$this->choice4 = $row['Choice4'];
	$this->insurance = $row['insurance'];
	$this->insurance_no = $row['insurance_no'];

	$this->hospital_name = $row['hospital_name'];
	$this->home_telephone = $row['home_telephone'];
	$this->mobile = $row['mobile'];
	$this->mobile_telephone = $row['mobile_telephone'];
	$this->bleep = $row['bleep'];
	$this->address_line1 = $row['address_line1'];
	$this->address_line2 = $row['address_line2'];
	$this->city = $row['city'];
	$this->postcode = $row['postcode'];
	$this->country = $row['country'];
	$this->cDate = $row['cDate'];
	$this->mDate = $row['mDate'];
	$this->job_title_id = $row['job_title_id'];
	$this->specialty_id = $row['specialty_id'];
	$this->band = $row['band'];
	$this->gmc_reg = $row['gmc_reg'];
	$this->diet = $row['diet'];
	$this->how_hear = $row['how_hear'];
	$this->accessibility = $row['accessibility'];
}


}
