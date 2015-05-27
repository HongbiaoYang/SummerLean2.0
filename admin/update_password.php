<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	
	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (isset($_POST['change_password'])) {	
		$error = tep_validate_change_password($_SESSION['admin_user']->username, $_POST['old_password'], $_POST['new_password'], $_POST['confirm_password']);	
		if (!$error) {			
			$sql_array = array("password" => md5($_POST['new_password']));
			$username = $_SESSION['admin_user']->username;
			tep_db_perform(TABLE_USERS, $sql_array, 'update', "username = '$username'");
			header("Location: index.php");
		}
	}
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	
	
?>

	
	
	
	<!-- MAIN TABLE STARTS HERE -->
	
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Profile Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Update Password</td>
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
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<form name="change_password" action="update_password.php" method="post">
							<table width="100%">
								<?php
								if ($error) {
									?>
									<tr>
										<td colspan="2" class="right"><?php echo $error; ?></td>
									</tr>
									<?php
								}
								?>
								<tr>
									<td class="left" width="30%">
										Old password:
									</td>
									<td class="right">
										<input name="old_password" type="password" class="textbox1">
									</td>
								</tr>
								<tr>
									<td class="left">
										New Password:
									</td>
									<td class="right">
										<input name="new_password" type="password" class="textbox1">
									</td>
								</tr>
								<tr>
									<td class="left">
										Confirm Password:
									</td>
									<td class="right">
										<input name="confirm_password" type="password" class="textbox1">
									</td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input name="change_password" type="submit" value="Change Password" class="submit3"></td>
							</table>
						</form>
						</td>
					</tr>
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
	
	<!-- main content ends here -->
	
	<!--MAIN TABLE ENDS HERE---><!--BOTTOM TABLE STARTS HERE--->

	
<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
