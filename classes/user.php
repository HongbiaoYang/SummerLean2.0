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
var $team;
var $facebook;
var $twitter;
var $whatsapp;
var $google;
var $bleep;
var $address_line1;
var $address_line2;
var $city;
var $county;
var $postcode;
var $country;
var $swb;
var $cDate;
var $mDate;
var $job_title_id;
var $specialty_id;
var $band;
var $gmc_reg;
var $diet;
var $picture;
var $background;
var $semester;


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
	$this->gender = $row['Gender'];
	$this->martial = $row['martial'];
    	$this->picture = $row['picture'];

	$this->netid = $row['netid'];
	$this->tnid = $row['TNID'];
	$this->email = $row['Email'];
	$this->country = $row['country'];
	$this->swb = $row['swb'];
	$this->team = $row['Team'];
	$this->insurance = $row['insurance'];
	$this->insurance_no = $row['insurance_no'];
	$this->background = $row['background'];
	$this->semester = $row['Semester'];

	$this->dep_date = $row['departure'];
	$this->dep_time = $row['dep_time'];
	$this->arr_date = $row['arrival'];
	$this->arr_time = $row['arr_time'];
	$this->flight = $row['flight'];
	$this->ticket = $row['ticket'];
	

	$this->hospital_name = $row['hospital_name'];
	$this->home_telephone = $row['home_telephone'];
	$this->mobile = $row['mobile'];
	$this->facebook = $row['facebook'];
	$this->twitter = $row['twitter'];
	$this->whatsapp = $row['whatsapp'];
	$this->google = $row['google'];
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

function set_choices() {
	$query = "select * from tbl_choices where stuindex = '$this->id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	$this->choice1 = $row['choice1'];
	$this->choice2 = $row['choice2'];
	$this->choice3 = $row['choice3'];
	$this->choice4 = $row['choice4'];
	$this->choice5 = $row['choice5'];
	$this->trip1 = $row['trip1'];
	$this->trip2 = $row['trip2'];
	$this->weekend1 = $row['weekend1'];
	$this->weekend2 = $row['weekend2'];

}

}
