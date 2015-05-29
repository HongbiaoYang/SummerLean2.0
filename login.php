

<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	if (isset($_SESSION['learner'])) {
		header("Location: index.php");
	}
	


	// template for page build
	$error = false;
	if (isset($_POST['login'])) {
		//login procedure
		// 1. validate
		// 2. create user object
		if (tep_validate_login($_POST['username'], $_POST['password'])) {
			//create session object of user
			If (tep_active_account($_POST['username'])) {
				$error = false;
				$_SESSION['learner'] = new user($_POST['username']);
				$user = $_SESSION['learner'];
				$user->set_profile();
	
				header("Location: index.php");
			}
			else
			{
				$error = "Your account has not been activated yet. Please check your emails to activate your account.";
			}
		}
		else
		{
			$error = "Invalid username or password.";
		}
	}
	include('includes/header.php');


?>

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" height="100%">
		<tr><td valign="middle">
			<TABLE width="600" cellspacing="0" cellpadding="0" border="0" align="center">
				<tr><td colspan='5' ><img src="images/SmartKitchen.png"></td></tr>
				<tr>
					<td valign="top"><img src="images/Vista_icons_09.png"></td>
					<td valign="MIDDLE" rowspan="3" align='left'>
					<form action="login.php<?php
					If ($_GET['access']=='true') Echo "?access=true";
					?>
					" name="login" method="post">

					<TABLE width="248" cellspacing="2" cellpadding="2" border="0" align="center">
					<?php
					if ($error) {	?>
						<tr>
							<td colspan="2" class="error"><?phpEcho $error; ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					<?php
					}
					?>
					<tr>

						<td class="left">Username</td>
						<td colspan=2><INPUT TYPE="text" NAME="username" class="textbox1" SIZE=16 value="<?php $_POST['username']; 
						    ?>"></td>
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
							<a class="frontlink" href="choose_type.php">Register</a>&nbsp;
							<a href="forgotten_password.php" class="frontlink">Forgotten Password</a>&nbsp;
			        </td>
						</tr>
						<tr><td colspan="3" class="error">
						    If you are new to this site, please click 'Register' to create a new account!
						    </td></tr>
						
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
	include(INCLUDES . 'footer.php');
?>
