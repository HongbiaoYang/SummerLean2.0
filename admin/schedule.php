<?php
/*
 * Created on Oct 29, 2007
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

	$schedule_array = array();
	/*
	if (strlen($where_clause)>0) {
		$query = "select ca.id, " .
				"ca.course_id, " .
				"ca.start_date, " .
				"ca.start_time, " .
				"ca.end_time, " .
				"ca.dates, " .
				"ca.resources, " .
				"ca.cancelled, " .
				"c.center, " .
				"c.type, " .
				"c.name " .
				"from calendar as ca " .
				"left join " .
				"courses as c " .
				"on (ca.course_id = c.id) " .
				"where ".$where_clause." " .
				"order by " .
				"ca.start_date, " .
				"c.center, " .
				"c.type, " .
				"ca.start_time, " .
				"c.name";
	}
	else
	{ */
		$query = "select ca.id, " .
				"ca.course_id, " .
				"ca.start_date, " .
				"ca.start_time, " .
				"ca.end_time, " .
				"ca.dates, " .
				"ca.resources, " .
				"ca.cancelled, " .
				"c.center, " .
				"c.type, " .
				"c.name " .
				"from calendar as ca " .
				"left join " .
				"courses as c on (ca.course_id = c.id) " .
				"order by " .
				"ca.start_date, " .
				"c.center, " .
				"c.type, " .
				"ca.start_time, " .
				"c.name";
	//}
	$result = tep_db_query($query);
	while ($row = tep_db_fetch_array($result)) {
		foreach (unserialize($row['dates']) as $a=>$date) {
			//if ($date >= $start_date && $date <= $end_date) {
				$schedule_array[] = array(	'date' => $date,
											'course_id' => $row['course_id'],
											'id' => $row['id']);
			//}
		}
	}

	function cmp($a, $b) {
		return strnatcasecmp( $a['date'], $b['date'] );
	}
	usort($schedule_array, "cmp");






 include(INCLUDES . 'header.php');
 include(INCLUDES . 'admin_header.php');
 ?>
<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
	<tr>
		<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
	</tr>
	<tr>
		<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
		<td class="title" height="27" colspan=3>&nbsp;Schedule</td>
	</tr>
	<tr>
		<td width="2%"><IMG src="images/left.gif"></td>
		<td height="18" class="subtitle" valign="bottom" width="12%">Viewing Schedule</td>
		<td width="83%"><IMG src="images/right.gif"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
</TABLE>
<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
	<tr>
		<td align="middle">
		<br><br>
		<table width="95%" align="center" cellspacing="1" cellpadding="3">
			<tr>
				<td>
					<table width='100%'>
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
						else
						{
						?>
							<tr>
								<td width="100%">
									<?php echo tep_schedule_calendar(date('Y'), date('m'), $schedule_array); ?>

								</td>
							</tr>
						<?php
						}
						?>
					</table>
				</td>
			</tr>
		</table>
		<table width="96%" align="center" cellspacing="0" cellpadding="2" border="0">
			<tr>
				<td colspan=3 align=right></td>
			</tr>
		</table>
	</td>
	</tr>
</table>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

