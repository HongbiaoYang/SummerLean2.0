<?php
/*
 * Created on Jul 30, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 	$access_level = '3';
	$access_error = false;
	$user_id = 0;
	$calendar_id = 0;
	include('includes/application_top.php');

	if (isset($_REQUEST['cal_id'])) {
		$calendar_id = $_REQUEST['cal_id'];
		$scheduled = new scheduled(tep_get_course_id($calendar_id));
		$scheduled->set_calendar_vars($calendar_id);
	}
	if (isset($_REQUEST['user_id'])) {
		$user_id = $_REQUEST['user_id'];
		$user = new user(tep_get_username($user_id));
		$user->set_profile();
	}
	if (isset($_POST['addnote'])) {
		$sql_array = array(admin_id => $_SESSION['admin_user']->id,
						  user_id => $user_id,
						  calendar_id => $calendar_id,
						  description => $_POST['description'],
						  cDate => date('Y-m-d H:i:s'),
						  deleted => '0');
		if (tep_db_perform(TABLE_NOTES, $sql_array)) {
			$added_note = true;
		}
		else
		{
			$added_note = false;
		}
	}


	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	include(INCLUDES . 'header.php');

?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<?php include('includes/window_header.php');  ?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">

					<?php
					if (isset($_REQUEST['cal_id'])) {
					?>
						<tr>
							<td class="right">
								Date: <?php echo tep_swap_dates($scheduled->start_date); ?>
							</td>
						</tr>
						<tr>
							<td class="right">
								Course: <?php echo $scheduled->name; ?>
							</td>
						</tr>
					<?php
					}
					if (isset($_REQUEST['user_id'])) {
					?>
						<tr>
							<td class="right">
								User: <?php echo $user->firstname.' '.$user->lastname; ?>
							</td>
						</tr>
					<?php
					}
					if (isset($_REQUEST['addnote'])) {
						if ($added_note) {
						?>
							<tr>
								<td class="hright">You have successfully added the note. <input type=button value="Close This Window" onClick="javascript:window.close();">
							</tr>
						<?php
						}
						else
						{
							?>
							<tr>
								<td class="hright">An error occurred when trying to add the note. <input type=button value="Close This Window" onClick="javascript:window.close();">
							</tr>
							<?php
						}
					}
					else
					{
					?>
					<form name="addnote" action="add_note.php" method="post">
					<tr>
						<td><?php
							if (isset($_REQUEST['cal_id'])) {
								?>
								<input type='hidden' name='cal_id' value='<?php echo $_REQUEST['cal_id']; ?>'>
								<?php
							}
							if (isset($_REQUEST['user_id'])) {
								?>
								<input type='hidden' name='user_id' value='<?php echo $_REQUEST['user_id']; ?>'>
								<?php
							}
						?>
							<textarea name="description" rows="15" cols="70"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input name="addnote" type="submit" class="submit3" value="Add Note">&nbsp;&nbsp;
							<input type=button value="Close This Window" onClick="javascript:window.close();">
						</td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td></td>
					</tr>
					</form>
				</table>
			</td>
		<tr>
	</table>
