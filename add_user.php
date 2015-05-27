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
		$errors = tep_validate_registration();
    
    
		// replace with moodle class upload.

		if (!$errors[0]) {

			//lets fill database with user
				$sql_array = array("username" => prepare_input($_POST['email']),
						   "password" => md5($_POST['password']),
						   "admin" => $_POST['admin'],
						   "center" => $_POST['center'],
						   "type" => $_POST['type'],
						   "instructor" => $_POST['instructor']);
						   
				// enter user into users database
				tep_db_perform(TABLE_USERS, $sql_array);
				$user_id = mysql_insert_id();

        // generate background string
        $backstr = gen_background_value($_POST['background']);
        

				$sql_array = array("stuindex" => $user_id,
						   "email" => $_POST['email'],
						   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "lastname2" => $_POST['lastname2'],
						   "middlename" => $_POST['middlename'],
						   "fullname" => $_POST['fullname'],
						   "work_telephone" => $_POST['work_tel'],
						   "Englishwrite" => $_POST['ewrite'],
						   "Englishlisten" => $_POST['elisten'],
						   "Englishspeak" => $_POST['espeak'],
						   "gender" => $_POST['gender'],
						   "university" => $_POST['university'],
						   "major" => $_POST['major'],
						   "country" => $_POST['country'],
						   "gpa" => $_POST['gpa'],
						   "dob" => $_POST['dob'],
						   "background" => $backstr,						   
						   "insurance" => $_POST['insurance'],
						   "arrival" => $_POST['arrival'],
						   "departure" => $_POST['departure']
           /*     "hospital_name" => $_POST['hosp_name'],
						   "address_line1" => $_POST['addr1'],
						   "address_line2" => $_POST['addr2'],
						   "city" => $_POST['city'],
						   "postcode" => $_POST['postcode'],
						   "cDate" => date("Y-m-d H:i:s"),
						   "mDate" => date("Y-m-d H:i:s"),         
						   "home_telephone" => $_POST['home_tel'],
						   "mobile_telephone" => $_POST['mobile_tel'],
						   "job_title_id" => $_POST['job_title'],
						   "specialty_id" => $_POST['specialty'],
						   "band" => $_POST['band'],
						   "gmc_reg" => $_POST['gmc_reg'],
						   "diet" => $_POST['diet'],
						   "how_hear" => $_POST['how_hear'],
						   "qualifications" => $_POST['qualifications'],
						   "photo" => $filename,
						   "instructor" => $_POST['instructor']*/
						   );


        if ($fname = do_upload($_FILES['upload'], $user_id)) {
            $sql_array['visa'] = $fname;
        }
        

				// enter user profile details
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
			<form enctype="multipart/form-data" name="register" action="add_user.php" method="POST">
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
									Middle Name:
								</td>
								<td class="right">
									<input type="text" name="middlename" value="<?php echo $_POST['middlename'] ?>" class="textbox1">
									 &nbsp;(Optional)
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
									Second Last Name:
								</td>
								<td class="right">
									<input type="text" name="lastname2" value="<?php echo $_POST['lastname2'] ?>" class="textbox1">
									&nbsp;(Optioal)
								</td>
							</tr>
							
							
						<tr>
							<td align="right" class="left">
								Gender:
							</td>
							<td class="right">
							<select name="gender">
								<option value="N">--Select--</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
								</select>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
							
							<tr>
								<td align="right" class="left">
									Name on Certificate:
								</td>
								<td class="right">
									<input type="text" name="fullname" value="<?php echo $_POST['fullname'] ?>" class="textbox1">
									&nbsp;(accept native language)
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
									Country:
								</td>
								<td class="right">
									<!-- pulldown menu of vegitarian, halal, kosher -->
									<?php  echo   tep_build_dropdown(TABLE_COUNTRIES, 'country', false, '1', 'id != 555'); ?>
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
									Work Tel:
								</td>
								<td class="right">
									<input type="text" name="work_tel" value="<?php echo $_POST['work_tel'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
									Insurance:
								</td>
									<td class="right">
									<input type="text" name="insurance" value="<?php echo $_POST['insurance'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
			
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<h4>Background Information
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
						
					  <tr>
					    <td align="right" class="left">
					    	Date of Birth 
					    </td>
					    <td class="right">
					    	<input name="dob" type="date" id="dob"  size="20" maxlength="20" value="<?php echo $_POST['dob']?>"/>
					    	(Use format "mm/dd/yyyy" if calendar is not showing)</td>
					  </tr>
  
						<tr>
							<td align="right" class="left">
								English Level - Writing:
							</td>
							<td class="right">
								<!-- pulldown menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_dropdown(TABLE_LEVELS, 'ewrite');?>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
							<tr>
							<td align="right" class="left">
								English Level - Listening:
							</td>
							<td class="right">
								<!-- pulldown menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_dropdown(TABLE_LEVELS, 'elisten');?>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
							<tr>
							<td align="right" class="left">
								English Level - Speaking:
							</td>
							<td class="right">
								<!-- pulldown menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_dropdown(TABLE_LEVELS, 'espeak');?>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
						
						<tr>
							<td align="right" class="left">
								Background Knowledge:
							</td>
							<td class="right">
								<!-- checkbox menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_checkbox(TABLE_BACKGROUND, 'background[]');?>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
							
							
						
							<tr>
								<td align="right" class="left">
									University:
								</td>
								<td class="right">
									<input type="text" name="university" value="<?php echo $_POST['university'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
								<tr>
								<td align="right" class="left">
									Major:
								</td>
								<td class="right">
									<input type="text" name="major" value="<?php echo $_POST['major'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
						  	</tr>
							
								<tr>
								<td align="right" class="left">
									GPA:
								</td>
								<td class="right">
									<input type="text" name="gpa" value="<?php echo $_POST['gpa'] ?>" class="textbox1">
									&nbsp;<span class="required">* (Use this <u><a  target = '_blank' href="http://www.foreigncredits.com/Resources/GPA-Calculator/">LINK</a></u> to calculate your GPA)</span>
								</td>
							  </tr>
							
						</table>
					</td>
				</tr>
				
	<tr>
					<td colspan="2">
						<h4>Travel Information</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
							
										
						<tr>
					    <td align="right" class="left">
					    	Arrival Date:
					    </td>
					    <td class="right">
					    	<input name="arrival" type="date" id="arrival"  size="20" maxlength="20" value="<?php echo $_POST['arrival']?>"/></td>
					  </tr>
					  
					  <tr>
					    <td align="right" class="left">
					    	Departure Date:
					    </td>
					    <td class="right">
					    	<input name="departure" type="date" id="departure"  size="20" maxlength="20" value="<?php echo $_POST['departure']?>"
					    	 /> 
					    	 <button  Onmouseup ="clickButton('lala')" >Check Duration</button>
					    	</td>
					  </tr>

					  					  
					    <tr>
					    <td align="right" class="left">
					    	Visa Document:
					    </td>
					    <td class="right">
					    	<input type="file" name="upload" id="upload">
					  </tr>
							
			
						</table>
					</td>
				</tr>

				
				<tr>
					<td colspan="2" align="center">
						<input name="register" type="submit" value="Register" class="submit3 ">
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
