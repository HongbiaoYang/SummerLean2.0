<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

function tep_customize_dropdown($tablename, $menu_name, $multiple = false, $size = '1', $where_clause = '', $selected = false, $selected_id = '', $fieldkey = 'id', $fieldname='name', $default_option_name = '--Select--') {
    // table needs to be in format id - name
	if (strlen($where_clause) > 0) {
		$query = "select * from $tablename where ".$where_clause." order by ".$fieldname;
	}
	else
	{
		$query = "select * from $tablename";
	}
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		if ($multiple) {
			$menu = '<select name="'.$menu_name.'[]" class="textbox1" multiple="multiple" size="'.$size.'">';
		}
		else
		{
			$menu = '<select name="'.$menu_name.'" class="textbox1"><option value="0">'.$default_option_name.'</option>';
		}
		while ($row = tep_db_fetch_array($result)) {
			$choice= false;
			if (is_array($selected_id)) {
				foreach ($selected_id as $a => $b) {
					if ($b == $row[$fieldkey]) {
						$choice = true;
					}
				}
				if ($choice) {
					$menu .= '<option SELECTED value="'.$row[$fieldkey].'">'.$row[$fieldname].'</option>';
				}
				else
				{
					$menu .= '<option1 value="'.$row[$fieldkey].'">'.$row[$fieldname].'</option>';
				}
			}
			else if ($selected && $selected_id == $row[$fieldkey]) {
				$menu .= '<option SELECTED value="'.$row[$fieldkey].'">'.$row[$fieldname].'</option>';
			}
			else
			{
				$menu .= '<option value="'.$row[$fieldkey].'">'.$row[$fieldname].'</option>';
			}
		}
		$menu .= '</select>';
		return $menu;
	}
	else
	{
		$menu = '<input name="'.$menu_name.'" type="text">';
		return $menu;
	}

}

function tep_dropdown_eval($id) {
    $menu = '<select name="'.$id.'" class="textbox1"><option value=0>-----</option>';
    
    for ($i = 1; $i <= 4; $i++) {
        if ($_POST[$id] == $i) {
           $menu .= "<option selected value = ".$i ." >".$i."</option>";
        } else {
           $menu .= "<option value = ".$i ." >".$i."</option>";
        }
    } 
    /*
    $menu .= '<option value=1>1</option>';
    $menu .= '<option value=2>2</option>';
    $menu .= '<option value=3>3</option>';
    $menu .= '<option value=4>4</option>';
    */
    
    $menu .= '</select>';

    return $menu;
}

function tep_check_evaluated($id) {
	$query = "SELECT * FROM tbl_evaluate where 1 and evaluator = ".$id . " and evaluatee = ".$id;

	 $result = tep_db_query($query);
   $row = tep_db_fetch_array($result);

    if ($row["done"] == 0) {
      return "<span class = \"fronttitle\">Pending</span>";
    } else {
      return "<span class = \"frontsubtitle\">Completed</span>";
    }
        
}

function tep_build_dropdown($tablename, $menu_name, $multiple = false, $size = '1', $where_clause = '', $selected = false, $selected_id = '', 
														$fieldname='name', $default_option_name = '--Select--') {
	return tep_customize_dropdown($tablename, $menu_name, $multiple, $size, $where_clause, $selected, $selected_id
	                    , 'id', $fieldname, $default_option_name);
	
}

function tep_build_roommate_dropdown($tablename, $menu_name, $multiple = false, $size = '1', $where_clause = '', $selected = false, $selected_id = '', 
														$fieldkey, $fieldname='name', $default_option_name = '--Select--') {
	return tep_customize_dropdown($tablename, $menu_name, $multiple, $size, $where_clause, $selected, $selected_id
	                    , $fieldkey, $fieldname, $default_option_name);
	
}


function tep_build_project_dropdown($menu_name, $selected = false, $selected_id = '', $default_option_name = '--Select--') {
    
	$query = "SELECT p.projindex, c.companyname, p.title FROM `tbl_projects` p 
	          Left join tbl_companies c on p.comindex = c.comindex WHERE 1";

	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
	$menu = '<select name="'.$menu_name.'" class="textbox1"><option value="0">'.$default_option_name.'</option>';
		
		while ($row = tep_db_fetch_array($result)) {
		  if ($selected && $selected_id == $row["projindex"]) {
				$menu .= '<option SELECTED value="'.$row["projindex"].'">'.$row["projindex"]." <strong>".$row["companyname"]."11</strong> - ".$row["title"].'</option>';
			}
			else
			{
				$menu .= '<option value="'.$row["projindex"].'">'.$row["projindex"]." ".$row["companyname"]." - ".$row["title"].'</option>';
			}
		}
		$menu .= '</select>';
		return $menu;
	}
	else
	{
		$menu = '<input name="'.$menu_name.'" type="text">';
		return $menu;
	}

}



function tep_build_trip_dropdown($tablename, $menu_name, $multiple = false, $size = '1', $where_clause = '', $selected = false, $selected_id = '', $fieldkey = 'id', $fieldname='name', $default_option_name = '--Select--') {
    // table needs to be in format id - name
	if (strlen($where_clause) > 0) {
		$query = "select * from $tablename where ".$where_clause." order by ".$fieldkey;
	}
	else
	{
		$query = "select * from $tablename";
	}
	

	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		if ($multiple) {
			$menu = '<select name="'.$menu_name.'[]" class="textbox1" multiple="multiple" size="'.$size.'">';
		}
		else
		{
			$menu = '<select name="'.$menu_name.'" class="textbox1"><option value="0">'.$default_option_name.'</option>';
		}
		while ($row = tep_db_fetch_array($result)) {
		    
		  $remaining = $row["capacity"] - tep_get_taken(TABLE_CHOICES, $row[$fieldkey]);
		    
			$choice= false;
			if (is_array($selected_id)) {
				foreach ($selected_id as $a => $b) {
					if ($b == $row[$fieldkey]) {
						$choice = true;
					}
				}
				if ($choice) {
					$menu .= '<option SELECTED value="'.$row[$fieldkey].'">'.$row[$fieldname]." (remain:".$remaining."/".$row["capacity"].')</option>';
				}
				else
				{
					$menu .= '<option1 value="'.$row[$fieldkey].'">'.$row[$fieldname]." (remain:".$remaining."/".$row["capacity"].')</option>';
				}
			}
			else if ($selected && $selected_id == $row[$fieldkey]) {
				$menu .= '<option SELECTED value="'.$row[$fieldkey].'">'.$row[$fieldname]." (remain:".$remaining."/".$row["capacity"].')</option>';
			}
			else
			{
				$menu .= '<option value="'.$row[$fieldkey].'">'.$row[$fieldname]." (remain:".$remaining."/".$row["capacity"].')</option>';
			}
		}
		$menu .= '</select>';
		return $menu;
	}
	else
	{
		$menu = '<input name="'.$menu_name.'" type="text">';
		return $menu;
	}

}

function tep_get_taken($table, $id) {

    $query = " SELECT count(*) FROM `tbl_choices` WHERE 1 and trip1 = ".$id." or trip2 = ".$id;
    $result = tep_db_query($query);
    $row = tep_db_fetch_array($result);
    return $row['count(*)'];
}


function tep_build_date_dropdown($menu_name, $type, $year = 0, $month = 0, $day = 0, $lead_in = 0, $lead_out = 0) {
	$menu = '<select name="'.$menu_name.'" class="textbox1">';
	$current_year = date('Y');
	if ($type == 'year') {
		$selected_year = $year;
		$first_year = $current_year - $lead_in;
		$last_year = $current_year + $lead_out;
		for ($i = $first_year; $i <= $last_year; $i++) {
			if ($i == $selected_year) {
				$menu .= '<option SELECTED value="'.$i.'">'.$i.'</option>';
			}
			else
			{
				$menu .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$menu .= '</select>';
	}
	else if ($type == 'month') {
		$current_month = $month;
		for ($i = 1; $i <= 12; $i++) {
			switch ($i) {
				case 1 : $d = 'January';
						break;
				case 2 : $d = 'February';
						break;
				case 3 : $d = 'March';
						break;
				case 4 : $d = 'April';
						break;
				case 5 : $d = 'May';
						break;
				case 6 : $d = 'June';
						break;
				case 7 : $d = 'July';
						break;
				case 8 : $d = 'Augustus';
						break;
				case 9 : $d = 'September';
						break;
				case 10: $d = 'October';
						break;
				case 11: $d = 'November';
						break;
				case 12: $d = 'December';
						break;
			}
			if ($i == $current_month) {
				$menu .= '<option SELECTED value="'.$i.'">'.$d.'</option>';
			}
			else
			{
				$menu .= '<option value="'.$i.'">'.$d.'</option>';
			}
		}
		$menu .= '</select>';
	}
	else if ($type == 'day') {
		if ($year == 0) {
			$year = date('Y');
		}
		if ($month == 0) {
			$month = date('m');
		}
		$top_day = tep_get_month_range($month, $year);
		if ($day > 0) {
			$current_day = $day;
		}
		else
		{
			$current_day = date("d");
		}
		for ($i = 1; $i <= 31; $i++) {
			if ($i == $current_day) {
				$menu .= '<option SELECTED value="'.$i.'">'.$i.'</option>';
			}
			else
			{
				$menu .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$menu .= '</select>';
	}
	return $menu;
}

function tep_build_instructor_dropdown($menu_name, $id = '') {
	$query =  "select users.id, tbl_students.firstname, tbl_students.lastname from users left join tbl_students on (users.id = tbl_students.user_id) where users.instructor = '1'";
	$result = tep_db_query($query);
	$menu = '<select name="'.$menu_name.'" class="textbox1"><option value="0">--Select--</option>"';
	while ($row = tep_db_fetch_array($result)) {
		if ($id == $row['id']) {
			$menu .= '<option SELECTED value="'.$row['id'].'">'.$row['firstname'].' '.$row['lastname'].'</option>';
		}
		else
		{
			$menu .= '<option value="'.$row['id'].'">'.$row['firstname'].' '.$row['lastname'].'</option>';
		}
	}
	$menu .= '</select>';
	return $menu;


}


function tep_build_radios($tablename, $menuname, $checked = false, $checked_id = 0) {
	$query = "select * from $tablename";
	$result = tep_db_query($query);
	$radios = '';
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			if ($checked && $checked_id == $row['id']) {
				$radios .= '<input type="radio" checked name="'.$menuname.'" value="'.$row['id'].'">'.$row['name'].'&nbsp;&nbsp;&nbsp;';
			}
			else
			{
				$radios .= '<input type="radio" name="'.$menuname.'" value="'.$row['id'].'">'.$row['name'].'&nbsp;&nbsp;&nbsp;';
			}
		}
		return $radios;
	}
	else
	{
		return 'There are no menu options selected, please add menu items before continueing.';
	}

}

function tep_build_checkbox($tablename, $menuname, $checklist) {
	$query = "select * from $tablename";
	$result = tep_db_query($query);
	$radios = '';
	
	$cnt=0;
	if (tep_db_num_rows($result) > 0) {
	    
	    //$radio .= "<dl><dd>";
	    
	    $check_array  = explode(".", $checklist);
	    
		while ($row = tep_db_fetch_array($result)) {
        
        
      $radios .= "<br/>";
		    
		   
	
			if (in_array($row['id'], $check_array)) {
				$radios .= '<input type="checkbox" checked name="'.$menuname.'" value="'.$row['id'].'">'.$row['name'].'&nbsp;&nbsp;&nbsp;';
			}
			else
			{
				$radios .= '<input type="checkbox" name="'.$menuname.'" value="'.$row['id'].'">'.$row['name'].'&nbsp;&nbsp;&nbsp;';
			}
		}
		
		// $radios.=$check_array[0]."==".$check_array[1]."--";
		
		return $radios;
	}
	else
	{
		return 'There are no menu options selected, please add menu items before continueing.';
	}

}

function tep_evaluatee_name($id) {
  $query = "select firstname, lastname from tbl_students where stuindex = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['firstname'].' '.$row['lastname'];

}

function tep_get_name($tablename, $id) {
	$query = "select name from $tablename where id = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['name'];
}

function tep_get_name_pro($tablename, $key, $name, $id) {
	$query = "select $name from $tablename where $key = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row[$name];
}

function tep_get_description($tablename, $id) {
	$query = "select description from $tablename where id = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['description'];

}

function tep_get_leader($id) {
	$query = "select t.* from tbl_teamleaders t, tbl_students s, tbl_projects p 
	          where 1 and 
	          s.team = p.projindex and p.TeamLeader = t.leaderindex and s.team = '$id'";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row;

}

function tep_get_num_instructors($scheduled) {
	if (is_array($scheduled->instructors)) {
		return count($scheduled->instructors);
	}
	else
	{
		return 0;
	}
}

function tep_get_user_notes($user_id) {
	$note_array = array();
	$query = "select id from notes where user_id = '$user_id' and deleted = '0'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$note_array[] = $row['id'];
		}
	}
	return $note_array;
}

function tep_get_calendar_notes($calendar_id) {
	$note_array = array();
	$query = "select id from notes where calendar_id = '$calendar_id' and deleted = '0'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$note_array[] = $row['id'];
		}
	}
	return $note_array;
	
}

function tep_get_project_name($id) {
	$query = "SELECT * 
        FROM  `tbl_projects` p,  `tbl_students` s
        WHERE 1 
        AND s.team = p.projindex
        AND s.stuindex =".$id;
        
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['Title'];
}

function tep_get_team_leader($id) {
	$query = "
	SELECT t.firstname, t.lastname, t.email, t.bio, 
	t.picture, t.mobile, p.title, c.CompanyName, p.comments, p.ProjDesc
	FROM  `tbl_teamleaders` t
	LEFT JOIN tbl_projects p ON t.leaderIndex = p.teamleader
	LEFT JOIN tbl_students s ON s.team = p.projindex
	LEFT JOIN tbl_companies c ON c.comindex = p.comindex
	WHERE 1 
        AND s.stuindex =".$id;
        
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row;
}


function tep_get_teammates($id, $team) {
	$query = "
	SELECT firstname, lastname, email, mobile
	FROM  `tbl_students` 
	WHERE 1 
	AND team = ". $team .
      " AND stuindex != ".$id;
        
	$team_array = array();
	$result = tep_db_query($query);
	while (	$row = tep_db_fetch_array($result)) {
		 array_push($team_array, $row);
	}

	return $team_array;
}



?>
