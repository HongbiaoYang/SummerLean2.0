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


function tep_build_dropdown($tablename, $menu_name, $multiple = false, $size = '1', $where_clause = '', $selected = false, $selected_id = '', $fieldname='name', $default_option_name = '--Select--') {
	return tep_customize_dropdown($tablename, $menu_name, $multiple, $size, $where_clause, $selected, $selected_id
	                    , 'id', $fieldname, $default_option_name);
	
}


function tep_build_project_dropdown($tablename, $menu_name, $multiple = false, $size = '1', $where_clause = '', $selected = false, $selected_id = '', $fieldkey = 'id', $fieldname='name', $default_option_name = '--Select--') {
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
					$menu .= '<option SELECTED value="'.$row[$fieldkey].'">'.$row[$fieldkey]." - ".$row[$fieldname].'</option>';
				}
				else
				{
					$menu .= '<option1 value="'.$row[$fieldkey].'">'.$row[$fieldkey]." - ".$row[$fieldname].'</option>';
				}
			}
			else if ($selected && $selected_id == $row[$fieldkey]) {
				$menu .= '<option SELECTED value="'.$row[$fieldkey].'">'.$row[$fieldkey]." - ".$row[$fieldname].'</option>';
			}
			else
			{
				$menu .= '<option value="'.$row[$fieldkey].'">'.$row[$fieldkey]." - ".$row[$fieldname].'</option>';
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
	$query =  "select users.id, profiles.firstname, profiles.lastname from users left join profiles on (users.id = profiles.user_id) where users.instructor = '1'";
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

function tep_build_checkbox($tablename, $menuname, $checked = false, $checked_id = 0) {
	$query = "select * from $tablename";
	$result = tep_db_query($query);
	$radios = '';
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			if ($checked && $checked_id == $row['id']) {
				$radios .= '<input type="checkbox"  name="'.$menuname.'" value="'.$row['id'].'">'.$row['name'].'&nbsp;&nbsp;&nbsp;';
			}
			else
			{
				$radios .= '<input type="checkbox" name="'.$menuname.'" value="'.$row['id'].'">'.$row['name'].'&nbsp;&nbsp;&nbsp;';
			}
		}
		return $radios;
	}
	else
	{
		return 'There are no menu options selected, please add menu items before continueing.';
	}

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
	          s.team = p.projindex and p.comindex = t.leaderindex and s.team = '$id'";
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



?>
