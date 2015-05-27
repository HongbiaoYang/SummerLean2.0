<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/


function tep_get_surveys() {
	$survey_array = array();
	$query = "select * from surveys";
	$result = tep_db_query($query);

	while ($row = tep_db_fetch_array($result)) {
		$survey_array[] = array("name"=>$row['name'],
					"phpesp_id"=>$row['phpesp_id']);
	}
	return $survey_array;


}

function tep_export_survey($id) {
	// need to close connection to currrent db and open one to PHP database
	tep_db_close();
	tep_db_connect(ESP_DB_HOST, ESP_DB_USER, ESP_DB_PASS, ESP_DB_NAME);
	// get questions
	$question_array = array(); //will hold info regarding questions of this survey
	$query = "select id, name, type_id from question where survey_id = '$id' and type_id != '100' and type_id != '99' order by position";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$question_array[] = array('id'		=> $row['id'],
									'name'		=> $row['name'],
									'type_id' 	=> $row['type_id']);
		}
	}
	$user_array = array(); //will hold info regarding questions of this survey
	$query = "select id from response where survey_id = '$id' and complete = 'Y'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			$user_array[] = $row['id'];
		}
	}
	$export_array = array();
	foreach ($user_array as $a => $b) {
		foreach ($question_array as $r=>$q) {

			$question_id = $q['id'];
			$response_id = $b;
			switch ($q['type_id']) {
				case 1:		// we need to get yes/no from response_bool table

							$query = "SELECT choice_id FROM " .
									"response_bool " .
									"WHERE response_id = '$response_id' " .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								$row = tep_db_fetch_array($result);
								$export_array[$b][$question_id] = $row['choice_id'];
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;

				// 2 is same as 3
				case 2:	// we need to get the text response from response_text table
							$query = "SELECT response FROM " .
									"response_text " .
									"WHERE response_id = '$response_id'" .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								$row = tep_db_fetch_array($result);
								// lets test if text start with -,=,+,/or* then replace with a space to avoid errors in excel
								if (substr($row['response'],0,1) == '-' || substr($row['response'],0,1) == '+' || substr($row['response'],0,1) == '=' || substr($row['response'],0,1) == '/' || substr($row['response'],0,1) == '*') {
									$response_text = substr($row['response'],1,strlen($row['response'])-1);
									$export_array[$b][$question_id] = $response_text;
								}
								else
								{
									$export_array[$b][$question_id] = $row['response'];
								}
								//echo $row['response'].'<br>';
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				case 3:	// we need to get the text response from response_text table
							$query = "SELECT response FROM " .
									"response_text " .
									"WHERE response_id = '$response_id'" .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								$row = tep_db_fetch_array($result);
								if (substr($row['response'],0,1) == '-' || substr($row['response'],0,1) == '+' || substr($row['response'],0,1) == '=' || substr($row['response'],0,1) == '/' || substr($row['response'],0,1) == '*') {
									$response_text = substr($row['response'],1,strlen($row['response'])-1);
									$export_array[$b][$question_id] = $response_text;
								}
								else
								{
									$export_array[$b][$question_id] = $row['response'];
								}

							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				// 4 is same as 6
				case 4: // we need to get the response from response_single table
							$query = "SELECT choice_id FROM " .
									"response_single " .
									"WHERE response_id = '$response_id' " .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								$row = tep_db_fetch_array($result);
								$export_array[$b][$question_id] = $row['choice_id'];
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				case 6: // we need to get the response from response_single table
							$query = "SELECT choice_id FROM " .
									"response_single " .
									"WHERE response_id = '$response_id' " .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								$row = tep_db_fetch_array($result);
								$export_array[$b][$question_id] = $row['choice_id'];
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				case 5:		// we need to get the response from response multiple table
							// anser value will be response_array of choice_id's
							$poss_array = array();		// this is an array with the possibilities
							// fill poss_array
							$query = "SELECT id FROM " .
									"question_choice " .
									"WHERE question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								while ($row = tep_db_fetch_array($result)) {
									$poss_array[] = $row['id'];
								}
							}
							$response_array = array();
							if (tep_db_num_rows($result) > 0) {
								foreach ($poss_array as $a=>$p) {
									$query = "SELECT choice_id FROM " .
											 "response_multiple " .
											 "WHERE response_id = '$response_id' " .
											 "AND question_id = '$question_id'";
									$result = tep_db_query($query);
									$found = false;
									$other = false;
									while ($row = tep_db_fetch_array($result)) {
										if ($row['choice_id'] == $p) {
											$found = true;
											// check for other
											$choice_id = $row['choice_id'];
											$other_query = "SELECT response FROM " .
													"response_other " .
													"WHERE response_id = '$response_id' " .
													"AND choice_id = '$choice_id' " .
													"AND question_id = '$question_id'";
											$other_result = tep_db_query($other_query);
											if (tep_db_num_rows($other_result) > 0) {
												$other_row = tep_db_fetch_array($other_result);
												$other_content = $other_row['response'];
												$other = true;
											}
										}
									}
									if ($found) {
										if ($other) {
											$response_array[] = $other_content;
										}
										else
										{
											$response_array[] = 1;
										}
									}
									else
									{
										$response_array[] = 2;
									}
								}
								$export_array[$b][$question_id] = $response_array;
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				case 8: 		// we need to get the response from response_rank table
							// the respons is in the format of array[choice_id] = rank
							$response_array = array();
							$query = "SELECT choice_id, rank FROM " .
									"response_rank " .
									"WHERE response_id = '$response_id' " .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								while ($row = tep_db_fetch_array($result)) {
									$choice_id = $row['choice_id'];
									$response_array[$choice_id] = $row['rank']+1;
								}
								$export_array[$b][$question_id] = $response_array;
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				case 9: 		// we need to get the response from response_date table
							$query = "SELECT response FROM " .
									"response_date " .
									"WHERE response_id = '$response_id' " .
									"AND question_id = '$question_id'";
							$result = tep_db_query($query);
							if (tep_db_num_rows($result) > 0) {
								$row = tep_db_fetch_array($result);
								$export_array[$b][$question_id] = $row['response'];
							}
							else
							{
								$export_array[$b][$question_id] = 99;
							}
							break;
				default:		// if none of the above we will give the question a value of 99
							$export_array[$b][$question_id] = 99;
							break;


			}
		}
	}

	$column_array = tep_create_columns($question_array);

	$file_name = tep_fill_export($column_array, $export_array, $id);
	tep_db_close;
	tep_db_connect();
	return $file_name;

}

function tep_create_columns($question_array) {
	$column_array = array();
	foreach ($question_array as $r=>$q) {

		$question_id = $q['id'];
		if ($q['type_id'] == 5 or $q['type_id'] == 8) {	//we need to create multiple columns
			$query = "select qc.content from question as q left join question_choice as qc on q.id = qc.question_id where q.id = '$question_id' order by qc.id";
			$result = tep_db_query($query);
			while ($row = tep_db_fetch_array($result)) {
				$column_array[] = $row['content'];
			}
		}
		else												// we need to get the question name
		{

			$query = "select name from question where id = '$question_id' LIMIT 1";
			$result = tep_db_query($query);
			$row = tep_db_fetch_array($result);
			$column_array[] = $row['name'];
		}
	}
	return $column_array;
}


function tep_fill_export($column_array, $export_array, $survey_id) {
	$file_name = tep_get_survey_name($survey_id).'.csv';
	$handle = fopen(EXPORT_PATH.tep_get_survey_name($survey_id).'.csv', 'w');
	$final_array = array();

	$counter = 0;
	foreach ($column_array as $a => $b) {
		if ($counter == 0) {
			fwrite($handle, '"'.$b.'"');
		}
		else
		{
			$content = ',"'.$b.'"';
			fwrite($handle, $content);
		}
		$counter++;
	}
	fwrite($handle, "\r");

	foreach ($export_array as $a=>$b) {		// $b constitutes a row of the export
		$counter = 0;
		foreach ($b as $c => $d) {			// if $d is not an array it constitutes an entry into the export
			if (is_array($d)) {				// if it is an array it is broken down further to $f which constitutes an entry into the record.
				foreach($d as $e=>$f) {

					if ($counter == 0) {
						fwrite($handle, '"'.$f.'"');
					}
					else
					{
						$content = ',"'.$f.'"';
						fwrite($handle, $content);
						//echo $content;
					}


				}
			}
			else
			{
				$question_type = tep_get_question_type($c);
				if ($question_type == 4 || $question_type == 6) {
					$d = tep_get_single_export_value($c, $d);
				}
				else if ($question_type == 1) {
					$d = tep_get_yesno_export_value($d);
				}
				if ($counter == 0) {
					fwrite($handle, '"'.$d.'"');
				}
				else
				{
					$content = ',"'.$d.'"';
					$trans = array("\n\r"=>" " , "\r"=>" ", "\n"=>" ");
					$content = strtr($content, $trans);
					fwrite($handle, $content);

				}
			}
			$counter++;
		}
		fwrite($handle,"\r");
	}
	fclose($handle);
	return $file_name;
}

function tep_get_single_export_value($question_id, $real_value) {
	$query = "select id from question_choice where question_id = '$question_id' order by id LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $real_value - $row['id'] + 1;
}

function tep_get_yesno_export_value($real_value) {
	if ($real_value == 'Y') {
		return 1;
	}
	else if ($real_value == 'N') {
		return 2;
	}
	else
	{
		return 99;
	}
}

function tep_get_question_type($question_id) {
	$query = "select type_id from question where id = '$question_id' LIMIT 1";
	$result = tep_db_query($query);
	$row = tep_db_fetch_array($result);
	return $row['type_id'];
}

function tep_get_survey_name($survey_id) {
	$query = "SELECT name from survey WHERE id = '$survey_id'";
	$result = tep_db_query($query);
	if (tep_db_num_rows($result) > 0) {
		$row = tep_db_fetch_array($result);
		return $row['name'];
	}
}

?>