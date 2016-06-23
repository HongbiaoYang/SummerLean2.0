<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	include('includes/application_top.php');


	if (isset($_POST['register'])) {
	    
  	//validate and record
		$errors = tep_validate_registration_teamleader();
		
	
		if (!$errors[0]) {

			//lets fill database with user
				$sql_array = array("username" => prepare_input($_POST['email']),
						   "password" => md5($_POST['password']),
						   "admin" => $_POST['admin'],
						   "center" => $_POST['center'],
						   "type" => $_POST['type'],
						   "instructor" => 1);
						   
				// enter user into users database
				tep_db_perform(TABLE_USERS, $sql_array);
				$user_id = mysql_insert_id();
                
				$sql_array = array("user_id" => $user_id,
						   "email" => $_POST['email'],
						   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "mobile" => $_POST['mobile'],
						   "bio"=>$_POST['bio']
						   );

        
        if ($fname = do_upload($_FILES['upload'], $user_id)) {
            $sql_array['picture'] = $fname;
        }

				// enter user profile details
				tep_db_perform(TABLE_TEAMLEADERS, $sql_array);
				
				
				// insert into tbl_students
				$sql_array = array("email" => prepare_input($_POST['email']),
						   "stuindex" => $user_id);
						   
				// enter user into users database
				tep_db_perform(TABLE_STUDENTS, $sql_array);
				
				$email = $_POST['email'];
	//			$_SESSION['learner'] = new user($_POST['email']);
					header("Location: account_pending.php?username=".$_POST['email'].
							"&title=".$_POST['title'].
							"&first=".$_POST['firstname'].
							"&last=".$_POST['lastname']);
			}
			else
			{
				$access_error = true;
				$error = PERMISSION_ERROR;
			}
	}


	include(INCLUDES . 'header.php');
//	include(INCLUDES . 'front_header.php');
	//include(INCLUDES . 'leftmenu.php');
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr><td colspan=3><IMG height=10 src="images/blank.gif" width=1></td></tr>
		<tr>
			<td rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Registration</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>

			<td height="18" class="subtitle" valign="bottom" width="18%"></td>
			<td width="76%"><IMG src="images/right.gif"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan=3>&nbsp;</td>
		</tr>
	</TABLE>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
	<tr>
		<td>
			<form enctype="multipart/form-data" name="register" action="register_teamleader.php" method="POST">
			<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center">
				<?php
				if ($errors[0]) {
				?>
				<tr>
					<td colspan="2">
						<span class="required">The following errors has occured:
						<?php echo $errors[1];  ?></span>
						
					</td>
				</tr>
				<?php
				}
				?>

				<tr>
					<td colspan="2">
						<h4>Login Details</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
								<tr>
									<td width="30%" align="right" class="left">
										E-Mail Address:
									</td>
									<td class="right">
										<input type="text" name="email" size="40" 
										value="<?php echo $_POST['email'] ?>" class="textbox1">
										&nbsp;<span class="required">*</span> 
										<span class="error">Remind: Please try to AVOID using Hotmail as your register email.</span>
									</td>
								</tr>
							<tr>
								<td align="right" class="left">
									Password:
								</td>
								<td class="right">
									<input type="password" name="password" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							<tr>
								<td align="right" class="left">
									Confirm Password:
								</td>
								<td class="right">
									<input type="password" name="c_password" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h4>Personal Details</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
													<tr>
								<td align="right" class="left">
									First Name:
								</td>
								<td class="right">
									<input type="text" name="firstname" value="<?php echo $_POST['firstname'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
						
							<tr>
								<td align="right" class="left">
									Last Name:
								</td>
								<td class="right">
									<input type="text" name="lastname" value="<?php echo $_POST['lastname'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
  
						<tr>
								<td align="right" class="left">
								 Mobile Phone:
								</td>
								<td class="right">
									<input type="text" name="mobile" value="<?php echo $_POST['mobile'] ?>" class="textbox1">
									&nbsp;<span class="required">* </span>(Numbers Only)
								</td>
							</tr>
							
											<tr>
								<td align="right" class="left">
								 Biography:
								</td>
								<td class="right">
									<textarea name="bio" rows="5" cols="40"><?php echo $_POST['bio'];?></textarea>
									&nbsp;<span class="required">* </span>
								</td>
							</tr>
							
					     <tr>
					    <td align="right" class="left">
					    	Profile Picture (A picture of you):
					    </td>
					    <td class="right">
					    	<input type="file" name="upload" id="upload" >
					    	&nbsp;<span class="required">* </span>Upload Image smaller than 2.0MB
					  </tr>
					  
						</table>
					</td>
				</tr>
								
				<tr>
					<td colspan="2" align="center">
						<input name="register" type="submit" value="Register" class="submit3">
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	</TABLE>


<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
