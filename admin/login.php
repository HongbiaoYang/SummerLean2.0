<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	// template for page build
	$error = false;
	if (isset($_POST['login'])) {
		//login procedure
		// 1. validate
		// 2. create user object
		if (tep_validate_admin_login($_POST['username'], $_POST['password'])) {
			//create session object of user
			$error = false;
			$_SESSION['admin_user'] = new user($_POST['username']);
			header("Location: index.php");
		}
		else
		{
			$error = true;
		}
	}



	include(INCLUDES . 'header.php');
//	include(INCLUDES . 'leftmenu.php');


?>



	<TABLE width="780" cellspacing="0" cellpadding="0" border="0" align="center" height="100%">
		<tr><td valign="middle">
			<TABLE width="600" cellspacing="0" cellpadding="0" border="0" align="center">

				<tr>
					<td valign="top"><img src="../images/logo.png"></td>
					<td valign="MIDDLE" rowspan="3" align='left'>
					<form action="login.php<?php
					If ($_GET['access']=='true') Echo "?access=true";
					?>
					" name="login" method="post">

					<TABLE width="248" cellspacing="2" cellpadding="2" border="0" align="center">
					<?php
					if ($error) {	?>
						<tr>
							<td colspan="2" class="error"><?php echo $error; ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					<?php
					}
					?>
					<tr>

						<td class="left">Username</td>
						<?php
						if (isset($_POST['username'])) {
						?>
							<td colspan=2><INPUT TYPE="text" NAME="username" class="textbox1" SIZE=16 value="<?php echo $_POST['username']; ?>"></td>
						<?php
						}
						else
						{
						?>
							<td colspan=2><INPUT TYPE="text" NAME="username" class="textbox1" SIZE=16></td>
						<?php
						}
						?>
					</tr>
					<tr>
						<td class="left">Password</td>
						<td><INPUT TYPE="password" NAME="password" class="textbox1" SIZE=16></td>
					</tr>
					<tr>
						<td colspan=2><center>
							<input type="submit" name="login" value="Login" class="login"><br /></center>
						</td>
					</tr>
					<tr>
						<td colspan="2"><center>
							<a href="add_user.php" class="frontlink">Register</a>&nbsp;
							<a href="forgotten_password.php" class="frontlink">Forgotten Password</a>&nbsp;
			</td>
						</tr>
					</TABLE>

					</form>
					</td>
				</tr>



			</TABLE>
		</td></tr>
			<br><br><br><br>
	</body>

</html>
<?php
	//include(INCLUDES . 'rightmenu.php');
	include('includes/footer.php');
?>
