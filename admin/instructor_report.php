<?php
/*
 * Created on Feb 28, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}


	// template for page build
	include(INCLUDES . 'print_header.php');

	$report_type = $_GET['report'];
	// heading
	if ($report_type=='1') {
	?>
		<TABLE width="800px" class="border">
	<?php
	}
	else
	{
		?>
		<TABLE width="1200px" class="border">
		<?php
	}
	?>
		<tr>
			<td align="center" class="border"><b>
				<?php
				switch ($report_type) {
					case 1:	echo 'Instructor Schedule';
							break;
					case 2:	echo 'Courses Instructed On Report';
							break;
					case 3:	echo 'Instructor Courses Attended Report';
							break;
					case 4:	echo 'Instructor Profile Report';
							break;
					case 5:	echo 'Report for: ';					// add individual instructor name
							break;
					default:	echo 'No Report Selected';
							break;
				}
				?>
			</b></td>
		</tr>
	</TABLE>
	<?php
	// default filter build
	if ($report_type != '1' && $report_type != '4') {
	?>
		<form name="filter" action='instructor_report.php?report=<?php echo $report_type; ?>' method='post'>
		<TABLE class="border" width="1200px">

			<tr>
				<td width="30%" class="left">Centre:</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_CENTERS, 'center', false, '1', '', true, $_POST['center'], 'name', 'All'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Course Type:</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_TYPES, 'course_type',  false, '1', '', true, $_POST['course_type'], 'name', 'All'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Category:</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_COURSE_CATEGORIES, 'category',  false, '1', '', true, $_POST['category'], 'name', 'All'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Course:</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_COURSES, 'courses',  false, '1', '', true, $_POST['courses'], 'name', 'All'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Instructor:</td>
				<td class="right"><?php echo tep_build_instructor_dropdown('instructor'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Group</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_GROUPS, 'group', false, '1', '', true, $_POST['group'], 'name', 'All'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Start Date:</td>
				<td class="right"><?php echo tep_build_date_dropdown('start_year','year', date('Y'), $month, $day, 8,5); ?>&nbsp;<?php echo tep_build_date_dropdown('start_month','month', $year, date('m'), $day); ?>&nbsp;<?php echo tep_build_date_dropdown('start_day','day', $year, $month, date('d')); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">End Date:</td>
				<td class="right"><?php echo tep_build_date_dropdown('end_year','year', date('Y', mktime(0,0,0,date('m')+8,0,date('Y'))), $month, $day, 8,5); ?>&nbsp;<?php echo tep_build_date_dropdown('end_month','month', $year, date('m', mktime(0,0,0,date('m')+8,0,date('Y'))), $day); ?>&nbsp;<?php echo tep_build_date_dropdown('end_day','day', $year, $month, date('d', mktime(0,0,0,date('m')+8,0,date('Y')))); ?></td>
			</tr>
			<tr>
				<td class="left">&nbsp;</td>
				<td class="right"><input type="submit" name="filter" class="button" value="Filter"></td>
			</tr>
	</TABLE>
	</form>
	<?php
	}
	else if (!isset($_POST['filter']) && $report_type != 4)
	{
	?>
		<TABLE width="800px">
			<form name="filter" action='instructor_report.php?report=<?php echo $report_type; ?>' method='post'>
			<tr>
				<td width="30%" class="left">Start Date:</td>
				<td class="left" width="10%">Year:</td><td class="right" width="10%"><?php echo tep_build_date_dropdown('start_year','year', date('Y'), $month, $day, 8,5); ?></td>
				<td class="left" width="10%">Month:</td><td class="right"><?php echo tep_build_date_dropdown('start_month','month', $year, date('m'), $day); ?>
				<td class="left" width="10%">Day:</td><td class="right"><?php echo tep_build_date_dropdown('start_day','day', $year, $month, date('d')); ?>
			</tr>
			<?php
				$default_end_date = date('Y-m-d', mktime(0,0,0,date('m')+8,0,date('Y')));			//set to 8 months ahead
			?>
			<tr>
				<td width="30%" class="left">End Date:</td>
				<td class="left" width="10%">Year:</td><td class="right" width="10%"><?php echo tep_build_date_dropdown('end_year','year', date('Y', mktime(0,0,0,date('m')+8,0,date('Y'))), $month, $day, 8,5); ?></td>
				<td class="left" width="10%">Month:</td><td class="right"><?php echo tep_build_date_dropdown('end_month','month', $year, date('m', mktime(0,0,0,date('m')+8,0,date('Y'))), $day); ?>
				<td class="left" width="10%">Day:</td><td class="right"><?php echo tep_build_date_dropdown('end_day','day', $year, $month, date('d', mktime(0,0,0,date('m')+8,0,date('Y')))); ?>
			</tr>
			<tr>
				<td colspan="7" class="left"><input name="filter" type="submit" value="Filter" class="submit3"></td>
			</tr>
			</form>
		</TABLE>
	<?php
	}
	else if ($report_type == 4) {
		?>
		<TABLE width="1200" class="border">
			<form name="filter" action='instructor_report.php?report=<?php echo $report_type; ?>' method='post'>
			<tr>
				<td width="30%" align="right" class="left">Job Title/Grade:	</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_JOBS, 'job_title', false, '1', '', true, $_POST['job_title']); ?></td>
			</tr>
			<tr>
				<td align="right" class="left">Specialty:</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty', false, '1', '', true, $_POST['specialty']); ?></td>
			</tr>
			<tr>
				<td align="right" class="left">Secondary Specialty:</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_SPECIALTIES, 'specialty2', false, '1', '', true, $_POST['specialty2']); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left" >Instructor:</td>
				<td class="right"><?php echo tep_build_instructor_dropdown('instructor'); ?></td>
			</tr>
			<tr>
				<td width="30%" class="left">Group</td>
				<td class="right"><?php echo tep_build_dropdown(TABLE_GROUPS, 'group', false, '1', '', true, $_POST['group'], 'name', 'All'); ?></td>
			</tr>
			<tr>
				<td class="left">&nbsp;</td>
				<td class="right"><input type="submit" name="filter" class="button" value="Filter"></td>
			</tr>

			</form>
		</TABLE>
		<?php
	}

	if (isset($_POST['filter'])) {
		if ($report_type != 4) {
			$date_from = $_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day'];
			$date_to = $_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day'];
			if ($report_type == 1) {
				?>
				<TABLE width="800px" class="border">
					<tr>
						<td class="border" align="center">Date Range: <?php echo tep_swap_dates($date_from).' - '.tep_swap_dates($date_to); ?></td>
					</tr>
				</TABLE>
				<?php
			}
			else
			{
				?>
				<TABLE width="1200px" class="border">
					<tr>
						<td class="border" align="center">Date Range: <?php echo tep_swap_dates($date_from).' - '.tep_swap_dates($date_to); ?></td>
					</tr>
				</TABLE>
				<?php
			}
		}
		if ($report_type == 1) {		// -------------------------START OF REPORT 1----------------------------
			// create query to select all courses that fall in date range
			$query = "SELECT " .
					"ca.id, " .
					"ca.course_id, " .
					"ca.start_date, " .
					"ca.dates, " .
					"ca.instructors, " .
					"c.name, " .
					"c.min_instructors " .
					"FROM calendar as ca left join courses as c on (ca.course_id = c.id) " .
					"WHERE ca.start_date > '$date_from' AND ca.start_date < '$date_to' " .
					"ORDER BY ca.start_date";
			$result = tep_db_query($query);
			if (tep_db_num_rows($result) > 0) {
				while ($row = tep_db_fetch_array($result)) {
					$ins_schedule_array[] = array("id" =>$row['id'],
												"course_id" => $row['course_id'],
												"start_date" => $row['start_date'],
												"dates" => unserialize($row['dates']),					// serialized date array
												"instructors" => unserialize($row['instructors']),
												"name" => $row['name'],
												"min_instructors" => $row['min_instructors']);
				}
			}
			else
			{
				echo 'There are no records to display';
			}
			?>
			<TABLE width="800px" class="border">
				<tr>
					<td align="center" width="5%" class="border"><b>Day</b></td>
					<td align="center" width="15%" class="border"><b>Date</b></td>
					<td align="center" width="20%" class="border"><b>Course</b></td>
					<td align="center" width="20%" class="border"><b>Instructor 1</b></td>
					<td align="center" width="20%" class="border"><b>Instructor 2</b></td>
					<td align="center" width="20%" class="border"><b>Instructor 3</b></td>
				</tr>
				<?php
				$temp_month = '';
				foreach ($ins_schedule_array as $r => $s) {
					foreach ($s['dates'] as $c=>$d) {
						$course_month = substr($d,5,2);
						if ($temp_month != $course_month) {
							?>
							<tr>
								<td colspan="6" align="center" class="border">
									<?php
										echo date('M', mktime(0,0,0,$course_month,1,0)).' '.substr($d,2,2);
										$temp_month = $course_month;
									?>
								</td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td align="center" class="border"><?php echo date('D', mktime(0,0,0,substr($d,5,2),substr($d,-2,2),substr($d,0,4))); ?></td>
							<td align="center" class="border"><?php echo tep_swap_dates($d); ?></td>
							<td align="center" class="border"><?php echo $s['name']; ?></td>
							<?php
							$min_instructors = $s['min_instructors'];
							for ($counter = 0; $counter < 3; $counter++) {
								if (sizeof($s['instructors']) > 0) {
									if ($counter < $min_instructors && strlen($s['instructors'][$counter]) == 0) {
										?>
										<td align="center" bgcolor="red" class="border"><?php echo tep_get_instructor_name($s['instructors'][$counter]); ?></td>
										<?php
									}
									else
									{
									?>
										<td align="center" class="border"><?php echo tep_get_instructor_name($s['instructors'][$counter]); ?></td>
									<?php
									}
								}
							}
							?>
						</tr>
						<?php
					}
				}
				?>
			</TABLE>
			<?php
		}
		//  -----------------------------------------END OF REPORT 1------------------------------
		//  --------------------------------------BEGINNING OF REPORT 2---------------------------
		else if ($report_type == 2)
		{
			$center = $_POST['center'];
			$course_type = $_POST['course_type'];
			$category = $_POST['category'];
			$courses = $_POST['courses'];
			$start_date = $_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day'];
			$end_date = $_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day'];
			$instructor = $_POST['instructor'];
			$group = $_POST['group'];

			// get list of headings
			$where_clause = '';
			if ($center > 0) {
				$where_clause = "center = ".$center;
			}
			if ($course_type > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and type = ".$course_type;
				}
				else
				{
					$where_clause = "type = ".$course_type;
				}
			}
			if ($category > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and category = ".$category;
				}
				else
				{
					$where_clause = "category = ".$category;
				}
			}
			if ($courses > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and id = ".$courses;
				}
				else
				{
					$where_clause = "id = ".$courses;
				}
			}
			// end of where clause build
			if (strlen($where_clause) > 0) {
				$query = "SELECT id, name FROM courses WHERE ".$where_clause." ORDER BY name";
			}
			else
			{
				$query = "SELECT id, name FROM courses ORDER BY name";
			}
			$result = tep_db_query($query);
			if (tep_db_num_rows($result) > 0) {
				while ($row = tep_db_fetch_array($result)) {
					$heading_array[] = array("id" => $row['id'],
											"name" => $row['name']);
				}
			}
			?>
			<TABLE class="border" width="1200px">
				<tr>
					<td class="border" align="center">
						Name
					</td>
					<?php
					foreach ($heading_array as $a=>$b) {
					?>
					<td class="border" align="center">
						<?php echo $b['name']; ?>
					</td>
					<?php
					}
				?>
					<td class="border" align="center">Total</td>
				</tr>
				<?php
				$instructor_id = $_POST['instructor'];
				if ($_POST['instructor'] > 0) {
					$instructor = new instructor(tep_get_username($instructor_id));
					$instructor->get_instructor_courses();
					?>
					<tr>
						<td class="border" align="center">
							<?php echo $instructor->firstname.' '.$instructor->lastname; ?>
						</td>
						<?php
						$total_counter_past = 0;
						$total_counter_future = 0;
						foreach ($heading_array as $a=>$b) {
							// calculate the amount of courses that he has been on and will be on
							$heading_counter_past = 0;
							$heading_counter_future = 0;
							foreach ($instructor->courses as $i=>$j) {
								if (tep_get_course_id($j['id']) == $b['id']) {
									$dates_array = unserialize($j['dates']);
									if ($dates_array[0] > date("Y-m-d")) {
										if ($dates_array[0] >= $date_from && $dates_array[0] <= $date_to) {
											$heading_counter_future++;
											$total_counter_future++;
										}
									}
									else
									{
										if ($dates_array[0] >= $date_from && $dates_array[0] <= $date_to) {
											$total_counter_past++;
											$heading_counter_past++;
										}
									}
								}
							}
							$total_heading = $heading_counter_past + $heading_counter_future;
							?>
							<!-- <td align="center" class="border">
								<font color="red"><?php echo $heading_counter_past; ?></font>
							</td> -->
							<td align="center" class="border">
								<font color="green"><?php echo $total_heading; ?></font>
							</td>
							<?php
						}
						$total_counter = $total_counter_future + $total_counter_past;
						?>
						<!-- <td align="center" class="border">
								<font color="red"><?php echo $total_counter_past; ?></font>
						</td> -->
						<td align="center" class="border">
							<font color="green"><?php echo $total_counter; ?></font>
						</td>
					</tr>
					<?php
				}
				else
				{
					if ($group == 0) {
						$instructor_array = tep_get_instructors();
					}
					else
					{
						$instructor_array = tep_get_group_instructors($group);
					}
					foreach ($instructor_array as $d=>$e) {
						$instructor = new instructor(tep_get_username($e['id']));
						$instructor->get_instructor_courses();
						?>
						<tr>
							<td class="border" align="center">
								<?php echo $instructor->firstname.' '.$instructor->lastname; ?>
							</td>
							<?php
							$total_counter_past = 0;
							$total_counter_future = 0;
							foreach ($heading_array as $a=>$b) {
								// calculate the amount of courses that he has been on and will be on
								$heading_counter_past = 0;
								$heading_counter_future = 0;
								foreach ($instructor->courses as $i=>$j) {
									if (tep_get_course_id($j['id']) == $b['id']) {
										$dates_array = unserialize($j['dates']);
										if ($dates_array[0] > date("Y-m-d")) {
											if ($dates_array[0] >= $date_from && $dates_array[0] <= $date_to) {
												$heading_counter_future++;
												$total_counter_future++;
											}
										}
										else
										{
											if ($dates_array[0] >= $date_from && $dates_array[0] <= $date_to) {
												$total_counter_past++;
												$heading_counter_past++;
											}
										}
									}
								}
								$heading_counter = $heading_counter_past + $heading_counter_future;
								?>
								<!-- <td align="center" class="border">
									<font color="red"><?php echo $heading_counter_past; ?></font>
								</td> -->
								<td align="center" class="border">
									<font color="green"><?php echo $heading_counter; ?></font>
								</td>
								<?php
							}
							$total_counter = $total_counter_past + $total_counter_future;
							?>
							<!-- <td align="center" class="border">
									<font color="red"><?php echo $total_counter_past; ?></font>
							</td> -->
							<td align="center" class="border">
								<font color="green"><?php echo $total_counter; ?></font>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</TABLE>
			<?php
		}
		// --------------------------------------------END OF REPORT 2----------------------------------
		// -------------------------------------------START OF REPORT 3---------------------------------
		else if ($report_type == 3)
		{
			$center = $_POST['center'];
			$course_type = $_POST['course_type'];
			$category = $_POST['category'];
			$courses = $_POST['courses'];
			$start_date = $_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day'];
			$end_date = $_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day'];
			$instructor = $_POST['instructor'];
			$group = $_POST['group'];

			// get list of headings
			$where_clause = '';
			if ($center > 0) {
				$where_clause = "c.center = ".$center;
			}
			if ($course_type > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and c.type = ".$course_type;
				}
				else
				{
					$where_clause = "c.type = ".$course_type;
				}
			}
			if ($category > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and c.category = ".$category;
				}
				else
				{
					$where_clause = "c.category = ".$category;
				}
			}
			if ($courses > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and c.id = ".$courses;
				}
				else
				{
					$where_clause = "c.id = ".$courses;
				}
			}


			?>
			<TABLE width = "1200px" class="border">
			<?php
				// loop through courses
					// loop through schedule (only for specified time)
						// loop through candidates
							// test for instructor
								// add to heading_array
				$heading_array = array();
				$calendar_array = tep_get_scheduled_courses($start_date, $end_date, $where_clause);
				$counter = 0;
				foreach ($calendar_array as $b=>$c) {
					$counter++;
					$user_array = tep_get_registered_users($c['cal_id']);
					if (sizeof($user_array) > 0) {
						foreach ($user_array as $d=>$e) {
							$user = new user(tep_get_username($e['user_id']));
							if ($user->instructor == 1) {
								if (!in_array($c['course_id'], $heading_array)) {
									$heading_array[] = $c['course_id'];
								}
							}
						}
					}

				}

				?>
				<tr>
					<td class="border" align="center">
						Name
					</td>
					<?php
					foreach ($heading_array as $a=>$b) {
					?>
					<td class="border" align="center">
						<?php echo tep_get_course_name($b); ?>
					</td>
					<?php
					}
				?>
					<td class="border" align="center">Total</td>
				</tr>
				<?php
				if ($_POST['instructor'] > 0) {
					// we only need to do one line
					$instructor_array[] = array('id' => $_POST['instructor']);
				}
				else
				{
					// do full instructor list
					if ($group == 0) {
						$instructor_array = tep_get_instructors();
					}
					else
					{
						$instructor_array = tep_get_group_instructors($group);
					}
				}
				foreach($instructor_array as $i=>$j) {
					$past_attended_total = 0;
					$future_attended_total = 0;

					?>
					<tr>
						<td class="border"><?php echo tep_get_instructor_name($j['id']); ?></td>
					<?php
					foreach($heading_array as $a=>$b) {
						$past_heading = 0;
						$future_heading = 0;
						foreach($calendar_array as $c=>$d) {
							$scheduled = new scheduled($d['course_id']);
							$scheduled->set_calendar_vars($d['cal_id']);
							$counter++;
							if ($d['course_id'] == $b) {
								$registered_users = tep_get_registered_users($d['cal_id']);
								if (count($registered_users) > 0) {
									foreach ($registered_users as $x => $z) {
										if ($j['id'] == $z['user_id']) {
											if ($scheduled->start_date < date("Y-m-d")) {
												$past_heading++;
												$past_attended_total++;
											}
											else
											{
												$future_heading++;
												$future_attended_total++;
											}
										}
									}
								}
							}
						}
						$total_heading = $future_heading + $past_heading;
						?>
						<!-- <td class="border"><font color="red"><?php echo $past_heading; ?></font></td> -->
						<td class="border"><font color="green"><?php echo $total_heading; ?></td>
						<?php

					}
					$total_attended = $future_attended_total + $past_attended_total;
					?>
					<!-- <td class="border"><font color="red"><?php echo $past_attended_total; ?></font></td> -->
					<td class="border"><font color="green"><?php echo $total_attended; ?></font></td>
					<?php

				}
				?>
				</tr>
			</TABLE>
			<?php
		}
		// ----------------------------------------END OF REPORT 3----------------------------------
		// ---------------------------------------START OF REPORT 4---------------------------------
		else if ($report_type == 4) {

			$instructor_id = $_POST['instructor'];
			$job_title_id = $_POST['job_title'];
			$specialty_id = $_POST['specialty'];
			$specialty2_id = $_POST['specialty2'];
			$group = $_POST['group'];

			// start of where clause build
			$where_clause = '';
			if ($job_title_id > 0) {
				$where_clause = "p.job_title_id = ".$job_title_id;
			}
			if ($specialty_id > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and p.specialty_id = ".$specialty_id;
				}
				else
				{
					$where_clause = "p.specialty_id = ".$specialty_id;
				}
			}
			if ($specialty2_id > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and p.specialty2_id = ".$specialty2_id;
				}
				else
				{
					$where_clause = "p.specialty2_id = ".$specialty2_id;
				}
			}
			if ($instructor_id > 0) {
				if (strlen($where_clause) > 0) {
					$where_clause .= " and u.id = ".$instructor_id;
				}
				else
				{
					$where_clause = "u.id = ".$instructor_id;
				}
			}

			// end of where clause build

			// query users/tbl_students for instructors with filtered criteria
			if ($where_clause != '') {
				$query = "SELECT " .
						"u.username " .
						"FROM users as u LEFT JOIN tbl_students as p on (u.id = p.user_id) " .
						"WHERE ".$where_clause." and u.instructor = 1 ORDER BY p.lastname";
			}
			else
			{
				$query = "SELECT u.username FROM users as u LEFT JOIN tbl_students as p on (u.id = p.user_id) WHERE u.instructor = 1 ORDER BY p.lastname";
			}
			$result = tep_db_query($query);
			$instructor_array = array();
			if (tep_db_num_rows($result) > 0) {
				while ($row = tep_db_fetch_array($result)) {
					$instructor_array[] = $row['username'];
				}
			}

			?>
			<TABLE width="1200px" class="border">
				<tr>
					<td class="border" align="center"><b>Name</b></td>
					<td class="border" align="center"><b>E-Mail</b></td>
					<td class="border" align="center"><b>Job Title</b></td>
					<td class="border" align="center"><b>Specialty</b></td>
					<td class="border" align="center"><b>Secondary Specialty</b></td>
					<td class="border" align="center"><b>Group</b></td>
				</tr>

			<?php
			$groupObj = new group($group);
			if (count($instructor_array) > 0) {
				foreach ($instructor_array as $a=>$b) {
					// test if $b is in the current group if group has been selected - showrecord = true or showrecord=false
					$showrecord = true;
					if ($group > 0) {
						$showrecord = false;
						foreach ($groupObj->members as $m => $n) {
							$username = tep_get_username($n['user_id']);
							if ($username == $b) {
								$showrecord = true;
							}
						}
					}
					if ($showrecord) {
						$instructor = new instructor($b);
						?>
						<tr>
							<td class="border" align="center"><a href="view_profile.php?id=<?php echo $instructor->id; ?>"><?php echo $instructor->firstname.' '.$instructor->lastname; ?></a></td>
							<td class="border" align="center"><?php echo $instructor->username; ?></td>
							<td class="border" align="center"><?php echo tep_get_name('jobs', $instructor->job_title_id); ?></td>
							<td class="border" align="center"><?php echo tep_get_name('specialties', $instructor->specialty_id); ?></td>
							<td class="border" align="center"><?php echo tep_get_name('specialties', $instructor->specialty2_id); ?></td>
							<td class="border" align="center"><?php
								if (count($instructor->groups) > 0) {
									foreach ($instructor->groups as $a=>$b) {
										echo tep_get_name(TABLE_GROUPS, $b).'<br>';
									}
								}
								else
								{
									'None';
								}

							?></td>
						</tr>
						<?php
					}
				}
			}
			else
			{
				?>
				<tr>
					<td class="border" align="center" colspan="6">There are no records to display. Please redesign your filter and try again.</td>
				</tr>
				<?php
			}

			?>
			</TABLE>
			<?php
		}
	}
?>
<TABLE>
	<tr>
		<td><a href="../admin">back</a></td>
	</tr>
</TABLE>

