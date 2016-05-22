<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	// template for page build
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
			header("Location: login.php");
	}


	include(INCLUDES . 'header.php');
	//include(INCLUDES . 'leftmenu.php');
	include(INCLUDES . 'admin_header.php');

	$search_term = '';
	if (isset($_REQUEST['search'])) {
		$search_term = $_REQUEST['search_term'];
	}

	$admin_users = tep_get_admin_users($search_term);

	$instructor_users = tep_get_instructor_users($search_term);

?>

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=2 width="300">&nbsp;View Users</td>

		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>

	</TABLE>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="center">
				<br><br>
				<!-- main content starts here -->
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td colspan="3">
							<table width="100%">
								<tr>
									<td class="hright" colspan="3" height="20px">
									<?php
										if ($_GET['type'] == 'admin') {
											?>&nbsp;&nbsp;<a href="view_users.php">View Trainees</a> | <a href="view_users.php?type=instructors">View Instructors</a><?php
										}
										else if ($_GET['type'] == 'instructors')
										{
											?>&nbsp;&nbsp;<a href="view_users.php">View Trainees</a> | <a href="view_users.php?type=admin">View Administrators</a><?php
										}
										else
										{
											?>&nbsp;&nbsp;<a href="view_users.php?type=admin">View Administrators</a> | <a href="view_users.php?type=instructors">View Instructors</a><?php
										}
										?>
									</td>
								</tr>
								<tr>
									<form name="search" action="view_users.php?type=<?php echo $_GET['type'];?>" method="post">
									<td width="30%" class="left">
										Search:
									</td>
									<td width="30%" class="right">
										<input name="search_term" type="text" value="<?php echo $_REQUEST['search_term']; ?>" class="textbox1">
									</td>
									<td class="right">
										<input name="search" type="submit" value="Search" class="submit3">
									</td>
									</form>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
					<?php
					if ($_GET['type'] == 'admin') {
					?>
						<td colspan="2" class="hright">
							<h4>Super Users:</h4>
						</td>
						</tr>
						<?php
						if (count($admin_users) > 0) {
							foreach ($admin_users as $c=>$u) {
								if ($u['center'] == 0 && $u['type'] == 0) {
										$user = new user($u['username']);
										$user->set_profile();
								?>
								<tr>
									<td class="right" width="40%">
										<?php echo '<a href="view_profile.php?id='.$u['id'].'">'.$u['username'].'</a>'; ?>
									</td>
									<td class="right"><?php echo $user->fullname; ?></td>
								</tr>
								<?php
								}
							}
						}
						?>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" class="hright">
								<h4>Centre Administrators</h4>
							</td>
						</tr>
						<?php
							$center_temp = '';
							$type_temp = '';
							if (count($admin_users) > 0) {
								foreach ($admin_users as $c=>$u) {
									if ($u['center'] != '0') {
										if ($center_temp != $u['center']) {
											$center_temp = $u['center'];
											?>
											<tr>
												<td colspan="2" class="right">
													<h4><?php echo tep_get_name(TABLE_CENTERS, $u['center']); ?></h4>
												</td>
											</tr>
										<?php
										}
										if ($type_temp != $u['type'] && $u['type'] != '0') {
											$type_temp = $u['type'];
											?>
											<tr>
												<td colspan="2" class="right">
													<span class="subtitle2"><?php echo '&nbsp;&nbsp;'.tep_get_name(TABLE_COURSE_TYPES, $u['type']); ?></span>
												</td>
											</tr>
											<?php
										}
										$user = new user($u['username']);
										$user->set_profile();
										?>
										<tr>

											<td class="right" width="40%"><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="view_profile.php?id='.$u['id'].'">'.$u['username'].'</a>'; ?></td>
											<td class="right"><?php echo $user->lastname.', '.$user->firstname; ?></td>
										</tr>
									<?php
									}
								}
							}
						?>
						<tr>
							<td>&nbsp;</td>
						</tr>
					<?php
					}
					else if ($_GET['type'] == 'instructors') {
					?>
						<tr>
						<td colspan="3" class="hright">
							<h4>Instructors:</h4>
						</td>
						</tr>
						<?php
						if (count($instructor_users) > 0) {
							foreach ($instructor_users as $c=>$u) {
								$instructor = new instructor(tep_get_username($u['id']));
								$instructor->instructor_attributes();
								?>
								<tr>
									<td class="right">
										<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="view_profile.php?id='.$u['id'].'">'.$instructor->username.'</a>'; ?>
									</td>
									<td class="right">
										<?php echo $instructor->lastname.', '.$instructor->firstname; ?>
									</td>
									<td class="left">
										<img src="<?php echo RELATIVE_UPLOAD_DIR."/".$instructor->photo;?>" height="90" width="70">
									</td>
								</tr>
								<?php
							}
						}
						?>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<?php
						}
						else
						{
						?>
						<tr>
							<td colspan="3" class="hright">
								<h4>Trainees</h4>
							</td>
						</tr>
						<?php
						$counter = 0;
						$normal_users = tep_get_users($search_term);
						if (count($normal_users)) {
							$counter = 0;
							foreach ($normal_users as $a => $u) {
								$user = new user($u['username']);
								$user->set_profile();
								if ($counter % 2 == 0) {
								?>
									<tr bgcolor="#E0E0E0">
								<?php
								}
								else
								{
								?>
									<tr>
								<?php
								}
								?>

									<td class="right"><?php echo '<a href="view_profile.php?id='.$user->id.'">'.$user->username.'</a>'; ?></td>
									<td class="right"><?php echo $user->lastname.', '.$user->firstname; ?></td>
								  <td class="right"><?php echo $user->fullname; ?></td>
								  <td class="right"><?php echo tep_get_name(TABLE_COUNTRIES, $user->country); ?></td>
								</tr>
								<?php
								$counter++;
							}
						}
						}
						?>
				</table>
				<br><br>
				<table width="96%" align="center" cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td colspan=3 align=right></td>
					</tr>
				</table>
				<br><br>
			</td>
		</tr>
	</TABLE>

<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>