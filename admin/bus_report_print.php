<?php
/*
 * Created on Oct 24, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 	$access_level = '3';
	$access_error = false;

	include('includes/application_top.php');


	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	include(INCLUDES . 'header.php');
	Echo "<h2>Course Report</h2>";
	Foreach ($_POST as $a=>$b) {
		If ($b <> 0){
			If ($a == 'center') {$b=tep_get_name('centers',$b);}
			If ($a == 'course_type') {$b=tep_get_name('course_types',$b);}
			If ($a == 'category') {$b=tep_get_name('course_categories',$b);}
			If ($a == 'courses') {$b=tep_get_name('courses',$b);}
			Echo "<h3>$b</h3><br>";
			
			}
		}
	if (isset($_POST['filter'])) {
		If (empty($_POST['start_date'])) $_POST['start_date']='01/01/2000';
		If (empty($_POST['end_date'])) $_POST['end_date']='01/01/2220';

		$bus_report = new bus_report($_POST['center'], $_POST['course_type'], $_POST['category'], $_POST['courses'], $_POST['start_date'], $_POST['end_date']);
		?>
		<table bgcolor="white" width="100%">
		<tr>
		<td>
		<table width="100%">
			<tr>
				<td class="hright">Date</td>
				<td class="hright">Cancelled</td>
				<td class="hright">Course</td>
				<?php
				$status_array = tep_get_status();
				foreach ($status_array as $r => $s) {
					echo "<td class='hright'>".$s['name']."</td>";
				}
				?>
				<td class="hright">Attended</td>
				<td class="hright">Passed</td>
				<td class="hright">Failed</td>
			</tr>

			<?php
			foreach ($bus_report->scheduled_courses as $a => $b) {
				$scheduled = new scheduled($b['course_id']);
				$scheduled->set_calendar_vars($b['id']);
				$scheduled->set_report_vars();
				$bus_report->update_totals($scheduled->id, $scheduled->status, $scheduled->cancelled, $scheduled->attended, $scheduled->passed, $scheduled->failed);
				if ($scheduled->cancelled) {
					$class='h2right';
				}
				else
				{
					$class='right';
				}
				?>
				<tr>
					<td class="<?php echo $class;?>"><?php echo tep_swap_dates($scheduled->start_date); ?></td>
					<td class="<?php echo $class;?>"><?php echo $scheduled->cancelled; ?></td>
					<td class="<?php echo $class;?>"><a href="course_registrations.php?id=<?php echo $scheduled->calendar_id; ?>"><?php echo $scheduled->name; ?></a></td>
					<?php
						foreach ($scheduled->status as $y=>$z) {
							?>
							<td class="<?php echo $class;?>"><?php echo $z['amount']; ?></td>
						<?php
						}
					?>
					<td class="<?php echo $class;?>"><?php echo $scheduled->attended; ?></td>
					<td class="<?php echo $class;?>"><?php echo $scheduled->passed; ?></td>
					<td class="<?php echo $class;?>"><?php echo $scheduled->failed; ?></td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
	}
	?>
	<!-- totals of the report run -->
	<table width="100%">
		<tr>
			<td class="hright"><span class="courseHeading">Totals</span></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td class="hright">Amount</td>
			<td class="hright">Cancelled</td>
			<td class="hright">Course</td>
			<?php
			$status_array = tep_get_status();
			foreach ($status_array as $r => $s) {
				echo "<td class='hright'>".$s['name']."</td>";
			}
			?>
			<td class="hright">Attended</td>
			<td class="hright">Passed</td>
			<td class="hright">Failed</td>
		</tr>
		<?php
		if (isset($_POST['filter'])) {
			foreach ($bus_report->total_courses as $a=>$b) {
				?>
				<tr>
					<td class="right"><?php echo $bus_report->total_courses[$a]; ?></td>
					<td class="right"><?php echo $bus_report->total_cancelled[$a]; ?></td>
					<td class="right"><?php echo tep_get_course_name($a); ?></td>
					<?php // here comes the stats regarding all the possible states
					$status_array = tep_get_status();
					foreach ($status_array as $y => $z) {
						?><td class="right"><?php echo $bus_report->status[$a][$z['id']]; ?></td><?php
					}
					?>
					<td class="right"><?php echo $bus_report->total_attended[$a]; ?></td>
					<td class="right"><?php echo $bus_report->total_passed[$a]; ?></td>
					<td class="right"><?php echo $bus_report->total_failed[$a]; ?></td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		</td>
		</tr>
		</table>
