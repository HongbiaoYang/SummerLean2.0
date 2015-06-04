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
        $contact_tel_ab = "+" . $_POST['contact_tel_ab1']. "-" .$_POST['contact_tel_ab2'];

				$sql_array = array("stuindex" => $user_id,
						   "email" => $_POST['email'],
						   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "lastname2" => $_POST['lastname2'],
						   "middlename" => $_POST['middlename'],
						   "fullname" => $_POST['fullname'],
						   "gender" => $_POST['gender'],
						   "martial" => $_POST['martial'],		
						   "mobile" => $_POST['mobile'],
						   "facebook" => $_POST['facebook'],
						   "twitter" => $_POST['twitter'],
						   "whatsapp" => $_POST['whatsapp'],
						   "google" => $_POST['google'],
						   "wechat" => $_POST['wechat'],
						   "sns_name" => $_POST['sns_name'],
						   "sns_id" => $_POST['sns_id'],
						   
						   "insurance" => $_POST['insurance'],
						   "insurance_no" => $_POST['insurance_no'],
						   "contact_name_ab" => $_POST['contact_name_ab'],
						   "contact_relation_ab" => $_POST['contact_relation_ab'],
						   "contact_tel_ab" => $contact_tel_ab,
						   "contact_lan" => $_POST['contact_lan'],
						   "toefl" => $_POST['toefl'],
						   
						   "Englishwrite" => $_POST['ewrite'],
						   "Englishlisten" => $_POST['elisten'],
						   "Englishspeak" => $_POST['espeak'],
						   "university" => $_POST['university'],
						   "major" => $_POST['major'],
						   "country" => $_POST['country'],
						   "pob" => $_POST['pob'],
						   "gpa" => $_POST['gpa'],
						   "semester" => $_POST['semester'],
						   "dob" => $_POST['dob'],
						   "background" => $backstr,		
						   				   
						   "arrival" => $_POST['arrival'],
						   "departure" => $_POST['departure']
						   );


        if ($fname = do_upload($_FILES['upload'], $user_id)) {
            $sql_array['picture'] = $fname;
        }
        
         echo "<script> alert_msg($fname); </script>";

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
									&nbsp;(Optional)
								</td>
							</tr>
							
								<tr>
								<td align="right" class="left">
									Name on Certificate:
								</td>
								<td class="right">
									<input type="text" name="fullname" value="<?php echo $_POST['fullname'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
									&nbsp;Type your full name exactly as you wish to have it in your certificate. Special characters are allowed
								</td>
							</tr>
							
							
							<tr>
							<td align="right" class="left">
								Gender:
							</td>
							<td class="right">
							<select name="gender">
								<option value="N">--Select--</option>
								<option value="M" <?php if ($_POST['gender'] == 'M') echo "SELECTED";?>>Male</option>
								<option value="F" <?php if ($_POST['gender'] == 'F') echo "SELECTED";?>>Female</option>
								</select>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
							
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
									Nationality:
								</td>
								<td class="right">
									<!-- pulldown menu of vegitarian, halal, kosher -->
									<?php  echo   tep_build_dropdown(TABLE_COUNTRIES, 'country', false, '1', '', true, $_POST['country']);?>
									
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
								<tr>
								<td align="right" class="left">
								Place of Birth(City, State/Province, Country):
								</td>
								<td class="right">
									<input type="text" name="pob" value="<?php echo $_POST['pob'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
						<tr>
							<td align="right" class="left">
								Martial Status:
							</td>
							<td class="right">
							<select name="martial" selected=<?php echo $_POST['martial'];?> >
								<option value="N">--Select--</option>
								<option value="S" <?php if ($_POST['martial'] == 'S') echo "SELECTED";?>>Single</option>
								<option value="M" <?php if ($_POST['martial'] == 'M') echo "SELECTED";?>>Married</option>
								</select>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
									
						</table>
					</td>
				</tr>
				
				<tr>
					<td>
						<h4>Contact and Emergency Information:
					</td>
				</tr>
				<tr>
				
							<tr>
								<td align="right" class="left">
								 Mobile Phone:
								</td>
								<td class="right">
									<input type="text" name="mobile" value="<?php echo $_POST['mobile'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
								 Facebook ID/URL:
								</td>
								<td class="right">
									<input type="text" name="facebook" value="<?php echo $_POST['facebook'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
								 Twitter ID/URL:
								</td>
								<td class="right">
									<input type="text" name="twitter" value="<?php echo $_POST['twitter'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
								 Whatsapp ID:
								</td>
								<td class="right">
									<input type="text" name="whatsapp" value="<?php echo $_POST['whatsapp'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
								 Google Hangout ID/URL:
								</td>
								<td class="right">
									<input type="text" name="google" value="<?php echo $_POST['google'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							<tr>
								<td align="right" class="left">
								 Wechat ID:
								</td>
								<td class="right">
									<input type="text" name="wechat" value="<?php echo $_POST['wechat'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
								 <tr><td class="left"> <strong>Other SNS (if any):</strong</td><td>
							       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    </td></tr>
							 <tr>
								<td align="right" class="left">
								 SNS Name:
								</td>
								<td class="right">
									<input type="text" name="sns_name" value="<?php echo $_POST['sns_name'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							 <tr>
								<td align="right" class="left">
								 SNS ID:
								</td>
								<td class="right">
									<input type="text" name="sns_id" value="<?php echo $_POST['sns_id'] ?>" class="textbox1">
									&nbsp;
								</td>
							</tr>
							
							
							<tr><td></td><td></td></tr>
							<tr><td></td><td></td></tr>
							
							 <tr><td class="left"> <strong>Insurance Information:</strong</td><td></td></tr>
							 
								<tr>
								<td align="right" class="left">
									Primary Insurance Carrier:
								</td>
									<td class="right">
									<input type="text" name="insurance" value="<?php echo $_POST['insurance'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
								<tr>
								<td align="right" class="left">
									Insurance Policy Number:
								</td>
									<td class="right">
									<input type="text" name="insurance_no" value="<?php echo $_POST['insurance_no'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
								</td>
							</tr>
							
							<tr><td></td><td></td></tr>
							<tr><td></td><td></td></tr>
							
							
							<tr><td></td><td></td></tr>
							<tr><td></td><td></td></tr>
							
							<tr></tr>
							   <tr><td class="left"> <strong>Emergency Contact  Abroad:</strong</td><td></td></tr>
							 
								<tr>
								<td align="right" class="left">
									Name:
								</td>
									<td class="right">
									<input type="text" name="contact_name_ab" value="<?php echo $_POST['contact_name_ab'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
									&nbsp;
								</td>
							</tr>
							
								<tr>
								<td align="right" class="left">
									Relationship to you:
								</td>
									<td class="right">
									<input type="text" name="contact_relation_ab" value="<?php echo $_POST['contact_relation_ab'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>
									&nbsp;
								</td>
							</tr>
							
													
							<tr>
								<td align="right" class="left">
									Phone Number:
								</td>
									<td class="right">
									    <select name="contact_tel_ab1" class="textbox1" >
									        <option value="0">--select--</option>
									        <?php 
									            $query = 'select distinct id from tbl_countries where id > 0 order by id asc';
									            $result = tep_db_query($query);
									            while ($row = tep_db_fetch_array($result)) {
									                extract($row);
    									        ?>
    									         <option value="<?php echo $id."\""; 
    									            if ($id==$_POST['contact_tel_ab1']) {echo "Selected";}
    									            echo ">(+".$id.")";
    									            ?></option>
                             <?php 
                                }
    									        ?>
									    </select>

										<input type="text" name="contact_tel_ab2" value="<?php echo $_POST['contact_tel_ab2'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>									
								</td>
								
							</tr>
							
							
							
							
								<tr>
								<td align="right" class="left">
									Prefered Language:
								</td>
									<td class="right">
									<input type="text" name="contact_lan" value="<?php echo $_POST['contact_lan'] ?>" class="textbox1">
									&nbsp;<span class="required">*</span>   
									&nbsp;
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
								TOEFL score:
							</td>
							<td class="right">
							<input type="text" name="toefl" value="<?php echo $_POST['toefl'] ?>" class="textbox1">
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
  
					
						<tr>
							<td align="right" class="left">
								English Level - Writing:
							</td>
							<td class="right">
								<!-- pulldown menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_dropdown(TABLE_LEVELS, 'ewrite', false, '1', '', true, $_POST['ewrite']);?>
								
								
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
							<tr>
							<td align="right" class="left">
								English Level - Listening:
							</td>
							<td class="right">
								<!-- pulldown menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_dropdown(TABLE_LEVELS, 'elisten', false, '1', '', true, $_POST['elisten']);?>
								&nbsp;<span class="required">*</span>
							</td>
						</tr>
						
							<tr>
							<td align="right" class="left">
								English Level - Speaking:
							</td>
							<td class="right">
								<!-- pulldown menu of vegitarian, halal, kosher --> 	
								<?php echo tep_build_dropdown(TABLE_LEVELS, 'espeak', false, '1', '', true, $_POST['espeak']);?>
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
							
								<tr>
								<td align="right" class="left">
									Semesters completed:
								</td>
								<td class="right">
									<select name="semester">
								<option value="N">--Select--</option>
								<option value="1" <?php if ($_POST['semester'] == '1') echo "SELECTED";?>>1</option>
								<option value="2" <?php if ($_POST['semester'] == '2') echo "SELECTED";?>>2</option>
									<option value="3" <?php if ($_POST['semester'] == '3') echo "SELECTED";?>>3</option>
								<option value="4" <?php if ($_POST['semester'] == '4') echo "SELECTED";?>>4</option>
									<option value="5" <?php if ($_POST['semester'] == '5') echo "SELECTED";?>>5</option>
								<option value="6" <?php if ($_POST['semester'] == '6') echo "SELECTED";?>>6</option>
									<option value="7" <?php if ($_POST['semester'] == '7') echo "SELECTED";?>>7</option>
								<option value="8" <?php if ($_POST['semester'] == '8') echo "SELECTED";?>>8</option>
									<option value="9" <?php if ($_POST['semester'] == '9') echo "SELECTED";?>>9</option>
								<option value="10" <?php if ($_POST['semester'] == '10') echo "SELECTED";?>>10</option>
									<option value="11" <?php if ($_POST['semester'] == '11') echo "SELECTED";?>>11</option>
								<option value="12" <?php if ($_POST['semester'] == '12') echo "SELECTED";?>>12</option>
									<option value="13" <?php if ($_POST['semester'] == '13') echo "SELECTED";?>> >12</option>
								<option value="14" <?php if ($_POST['semester'] == '14') echo "SELECTED";?>>Graduated</option>
								</select>
									&nbsp;<span class="required">* </span>
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
					    	<input name="arrival" type="date" id="arrival"  size="20" maxlength="20" value="<?php echo $_POST['arrival']?>"/>&nbsp;<span class="required">*</span> </td>
					  </tr>
					  
					  <tr>
					    <td align="right" class="left">
					    	Arrival Time:
					    </td>
					    <td class="right">
					    	<input name="arr_time" type="time" id="arr_time"  size="20" maxlength="20" value="<?php echo $_POST['arr_time']
					    	?>"
					    	 /> &nbsp;<span class="required">*</span>   
					    	</td>
					  </tr>
					  
					  <tr>
					    <td align="right" class="left">
					    	Departure Date:
					    </td>
					    <td class="right">
					    	<input name="departure" type="date" id="departure"  size="20" maxlength="20" value="<?php echo $_POST['departure']?>"
					    	 /> 
					    	
					    	 &nbsp;<span class="required">*</span> 
					    	</td>
					  </tr>
					  
					    <tr>
					    <td align="right" class="left">
					    	Departure Time:
					    </td>
					    <td class="right">
					    	<input name="dep_time" type="time" id="dep_time"  size="20" maxlength="20" value="<?php echo $_POST['dep_time']
					    	?>"
					    	 /> &nbsp;<span class="required">*</span>   
					    	  <button  Onmouseup ="clickButton()" >Check Duration</button>
					    	</td>
					  </tr>
					  

					  					  
					    <tr>
					    <td align="right" class="left">
					    	Profile Picture:
					    </td>
					    <td class="right">
					    	<input type="file" name="upload" id="upload">
					  &nbsp;<span class="required">* </span> Upload Image smaller than 2.0MB
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
