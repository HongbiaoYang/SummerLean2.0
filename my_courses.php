<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user'])) {
		header("Location: login.php");
	}
	$action = $_GET['action'];
	switch ($action) {
		case 'cancel':
				//tep_delete_entry(TABLE_REGISTRATIONS, $_GET['r_id']);
				// reduce registered in calendar and waiting list
				// move person from waiting list to registered
				//
				$sql_array = array('status' => '4',
								   'mDate' => date("Y-m-d H:i:s"));
				tep_db_perform(TABLE_REGISTRATIONS, $sql_array, 'update', "id = '".$_GET['r_id']."'");
				$query = "select registered, waiting_list from calendar where id= '".$_GET['id']."' LIMIT 1";
				$result = tep_db_query($query);
				$row = tep_db_fetch_array($result);
				if ($row['waiting_list'] > 0) {
					// reduce with one
					// move person with lowest date to registered
					// registered amount stays the same
					$new_waiting_list = $row['waiting_list'] - 1;
					$sql_array = array('waiting_list' => $new_waiting_list,
							   		   'mDate' => date("Y-m-d H:i:s"));
					tep_db_perform(TABLE_CALENDAR, $sql_array, 'update', "id = '".$_GET['id']."'");
					$query = "select id, min(cDate)'cDate' from registrations where calendar_id = '".$_GET['id']."' and status='2' group by cDate LIMIT 1";
					$result = tep_db_query($query);

					if (tep_db_num_rows($result) > 0) {
						$row = tep_db_fetch_array($result);
						$sql_array = array('status' => 1,
								   'mDate' => date('Y-m-d H:i:s'));
						tep_db_perform(TABLE_REGISTRATIONS, $sql_array, 'update', "id = '".$row['id']."'");
					}
				}
				else
				{
					// reduce registered value by 1
					$new_registered = $row['registered'] - 1;
					$sql_array = array('registered' => $new_registered,
							   		   'mDate' => date("Y-m-d H:i:s"));
					tep_db_perform(TABLE_CALENDAR, $sql_array, 'update', "id = '".$_GET['id']."'");

				}
				break;
	}

	$user = $_SESSION['admin_user'];
	$schedule_array = array();
	$query = "select ca.id, ca.course_id, ca.start_date, ca.duration, ca.start_time, ca.end_time, ca.resources, ca.reg_online, c.center, c.type, c.name, r.id'registration_id', r.status from calendar as ca left join registrations as r on (r.calendar_id = ca.id) left join courses as c on (ca.course_id = c.id) where r.user_id = '$user->id' order by ca.start_date, c.center, c.type, ca.start_time, c.name";
	$result = tep_db_query($query);
	$courses_error = false;
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			if (date("Y-m-d", mktime(0, 0, 0, substr($row['start_date'],5,2), substr($row['start_date'],-2,2)+$row['duration']-1, substr($row['start_date'],0,4))) >= date("Y-m-d"))
				$past = false;
			else
				$past = true;

			//if ((substr($row['start_date'],5,2) == date("m") && (substr($row['start_date'],-2,2)+$row['duration']-1) >= date("d")) || (substr($row['start_date'],5,2) > date("m") && substr($row['start_date'],0,4) >= date("Y"))) {
				$schedule_array[] = array('id' => $row['id'],
							  'date' => $row['start_date'],
							  'course_id' => $row['course_id'],
							  'center' => $row['center'],
							  'type' => $row['type'],
							  'name' => $row['name'],
							  'duration' => $row['duration'],
							  'start_time' => $row['start_time'],
							  'end_time' => $row['end_time'],
							  'resources' => unserialize($row['resources']),
							  'reg_online' => $row['reg_online'],
							  'status' => $row['status'],
							  'registration_id' => $row['registration_id'],
							  'past' => $past);
		}
	}
	else
	{
		$courses_error = true; //no courses has been registered for.
	}



	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'leftmenu.php');


?>

	<table width=<?php echo TABLE_WIDTH; ?>>
		<!-- CONTENT -->
		<?php
		if ($access_error) {
		?>
			<tr>
				<td>
					<?php echo $error; ?>
				</td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td>
				<h2>Schedule:</h2>
			</td>
			<td align="right">
				<?php
				if ($_GET['show'] == 'all') {
				?>
					<a href="my_courses.php">Show Upcoming</a>
				<?php
				}
				else
				{
				?>
					<a href="my_courses.php?show=all">Show All</a>
				<?php
				}
				?>
			</td>
			<td width="10%">&nbsp;

			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%">
					<tr>
						<td>&nbsp;

						</td>
						<td>
							<span class="heading2">Duration</span>
						</td>
						<td>
							<span class="heading2">Start Time</span>
						</td>
						<td>
							<span class="heading2">End Time</span>
						</td>
						<td>
							<span class="heading2">Status</span>
						</td>
						<td>
							<span class="heading2">Action</span>
						</td>
					</tr>
					<?php
					$date_temp = '';
					$center_temp = '';
					$type_temp = '';
					foreach ($schedule_array as $x=>$y) {
						if ((!$y['past'])||($_GET['show']=='all')) {
							if ($date_temp != $y['date']) {
								$date_temp = $y['date'];
								?>
								<tr>
									<td colspan="5"><span class="heading"><?php echo $y['date'] ?></span></td>
								</tr>
								<?php
								$center_temp = '';
								$type_temp = '';
							}
							if ($center_temp != $y['center']) {
								$center_temp = $y['center'];
								?>
								<tr>
									<td colspan="5"><span class="heading1">&nbsp;&nbsp;<?php echo tep_get_name(TABLE_CENTERS, $y['center']); ?></span></td>
								</tr>
								<?php
								$type_temp = '';
							}
							if ($type_temp != $y['type']) {
								$type_temp = $y['type'];
								?>
								<tr>
									<td colspan="5"><span class="heading2">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_get_name(TABLE_COURSE_TYPES, $y['type']); ?></span></td>
								</tr>
								<?php
							}
							?>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<a href="view_course.php?id='.$y['course_id'].'">'.$y['name']; ?></a></td>
								<td><?php echo $y['duration'] ?>&nbsp;<?php $day_string = ($y['duration'] == '1') ? 'day' : 'days'; echo $day_string;?></td>
								<td><?php echo substr($y['start_time'],0,5) ?></td>
								<td><?php echo substr($y['end_time'],0,5) ?></td>
								<td><?php
									if ($y['past'])
										echo '<font color="red">History</font>';
									else if ($y['status'] == '1')
										echo STATUS1;
									else if ($y['status'] == '2')
										echo STATUS2;
									else if ($y['status'] == '3')
										echo STATUS3;
									else if ($y['status'] == '4')
										echo STATUS4;
									?>
								</td>
								<td>
									<?php
									if ($y['status'] != '4') {
									?>
										<a href="my_courses.php?action=cancel&id=<?php echo $y['id']; ?>&r_id=<?php echo $y['registration_id'] ?>">Cancel</a>
									<?php
									}
									?>
								</td>
							</tr>
							<?php
						}
					}
					if ($courses_error) { ?>
						<tr>
							<td colspan="5">
								<font color="red">You do not yet have any courses. Use the menu to view the schedule and select courses to register for.</font>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</td>
		</tr>
	</table>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
