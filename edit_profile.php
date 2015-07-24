<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');
	if (!isset($_SESSION['learner'])) {
		header("Location: login.php");
	}
	$user = $_SESSION['learner'];
		
	if ($user->instructor == 1) {
	    $user = new instructor($user->username);  
	    $user->instructor_attributes();
	} else {
	    $user->set_profile();  
	}

	//include(FUNCTIONS . 'sessions.php');
	if (isset($_POST['profile'])) {
		
		//validate and record
//		$error = tep_validate_add_user('profile');
//
//
//			//lets fill database with user
//			if (isset($_SESSION['learner'])) {
//				$sql_array = array("username" => $_POST['email'],
//						   "admin" => $_POST['admin'],
//						   "center" => $_POST['center'],
//						   "type" => $_POST['type'],
//						   "instructor" => $_POST['instructor']);
//				// enter user into users database
//				tep_db_perform(TABLE_STUDENTS, $sql_array, 'update', "stuindex='$user->id'");
//				$user_id = mysql_insert_id();
        
        if ($user->instructor == 1) {
        	$sql_array = array(
				   	   "firstname" => $_POST['firstname'],
						   "lastname" => $_POST['lastname'],
						   "mobile" => $_POST['mobile'],
						   "bio" => $_POST['bio']);
                tep_db_perform(TABLE_TEAMLEADERS, $sql_array, 'update', "user_id='$user->id'");  
                header("Location: view_profile.php?id=$user->id");      
        } else {
        
        
            $backstr = gen_background_value($_POST['background']);
    				$sql_array = array(
    				   	   "firstname" => $_POST['firstname'],
    						   "lastname" => $_POST['lastname'],
    						   "fullname" => $_POST['fullname'],
    						   "mobile" => $_POST['mobile'],
    						   "facebook" => $_POST['facebook'],
    						   "twitter" => $_POST['twitter'],
    						   "whatsapp" => $_POST['whatsapp'],
    						   "google" => $_POST['google'],
    						   "insurance" => $_POST['insurance'],
    						   "insurance_no" => $_POST['insurance_no'],
    						   "departure" => $_POST['dep_date'],
    						   "dep_time" => $_POST['dep_time'],
    						   "flight" => $_POST['flight'],
    						   "background" => $backstr);
    
                $user_file_name = $user->id."-".$user->firstname."_".$user->lastname;
                
                if ($fname = do_upload_flight($_FILES['upload'], $user_file_name)) {
                    $sql_array['ticket'] = $fname;
                }
    
    				// enter user profile details
    				tep_db_perform(TABLE_STUDENTS, $sql_array, 'update', "stuindex='$user->id'");
            
            // header("Location: edit_profile.php");
    				header("Location: view_profile.php?id=$user->id");
		    }
			}
			else
			{
				$access_error = true;
				$error = PERMISSION_ERROR;
			}
	
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Edit Profile</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</TABLE>

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="middle">
				<br><br>
				<!-- main content starts here -->
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<form enctype="multipart/form-data" name="profile" action="edit_profile.php?id=<?php echo $_GET['id']; ?>" method="POST">
							<table width='100%'>
								<tr>
									<td width="60%">
										&nbsp;
									</td>
									<td>
										<span class="required">* Required fields</span>
									</td>
								</tr>
								
								<!--
								<?php
								if ($error[0]) {
								?>
								<tr>
									<td>
										<span class="required">The following errors has occured:
										<?php echo $error[1]; ?></span>
									</td>
								</tr>
								<?php
								}

								?>
								
								
								<tr>
									<td colspan="2" align="left">
										<h4>Login Details</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													E-Mail Address:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="email" size="40" value="<?php echo $user->username; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								-->
								
								<tr>
									<td colspan="2" align="left">
										<h4>Personal Details</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
							
											<tr>
												<td class="left">
													First Name:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="firstname" value="<?php echo $user->firstname; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Last Name:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="lastname" value="<?php echo $user->lastname; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											
											<?php if ($user->instructor == 0) { ?>
											<tr>
												<td class="left">
													Name on Certificate:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="fullname" value="<?php echo $user->fullname; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
										<?php }?>
											
											
											
											<tr>
												<td class="left">
													Mobile phone:
												</td>
												<td class="right">
													<input class="textbox1" type="text" name="mobile" value="<?php echo $user->mobile; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											
											
												<?php if ($user->instructor == 1) { ?>
											<tr>
												<td class="left">
													Biography:
												</td>
												<td class="right">
														<textarea name="bio" rows="5" cols="40"><?php echo $user->bio;?></textarea>
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
												<?php }?>
											
											
											
											<?php if ($user->instructor == 0)  { ?>
											<tr>
												<td class="left">
													Facebook:
												</td>
												<td class="right">
														<input class="textbox1" type="text" name="facebook" value="<?php echo $user->facebook; ?>">
												</td>
											</tr>
											
											<tr>
												<td class="left">
													Twitter:
												</td>
												<td class="right">
														<input class="textbox1" type="text" name="twitter" value="<?php echo $user->twitter; ?>">
												</td>
											</tr>
											
											<tr>
												<td class="left">
													Whatsapp:
												</td>
												<td class="right">
														<input class="textbox1" type="text" name="whatsapp" value="<?php echo $user->whatsapp; ?>">
												</td>
											</tr>
											
											<tr>
												<td class="left">
													Google Hangout:
												</td>
												<td class="right">
														<input class="textbox1" type="text" name="google" value="<?php echo $user->google; ?>">
												</td>
											</tr>
											
											
										</table>
									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Insurance Information:</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Primary Insurance Carrier:
												</td>
												<td class="right">
												 <input type="text" name="insurance" value="<?php echo $user->insurance; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
											<tr>
												<td class="left">
													Insurance Policy Number:
												</td>
												<td class="right">
													 <input type="text" name="insurance_no" value="<?php echo $user->insurance_no; ?>">
													&nbsp;<span class="required">*</span>
												</td>
											</tr>
						
										</table>
									</td>
								</tr>
								
									
										<tr>
									<td align="left">
										<h4>Background Information:</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Background Knowledge & Information
												</td>
												<td class="right">
        									<?php echo tep_build_checkbox(TABLE_BACKGROUND, 'background[]', $user->background);?>
												</td>
											</tr>
																
										</table>
									</td>
								</tr>
								
										<tr>
									<td align="left">
										<h4>Flight itinerary Information:</h4>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Departure Date:
												</td>
												<td class="right">
        											<select name="dep_date">
            								<option value="N">--Select--</option>
            								<option value="2015-08-01" <?php if ($user->dep_date == '2015-08-01') echo "SELECTED";?>>08/01/2015, Sartuday</option>
            								<option value="2015-08-02" <?php if ($user->dep_date == '2015-08-02') echo "SELECTED";?>>08/02/2015, Sunday</option>
            								</select> 	
												</td>
											</tr>
											
											  <tr>
            					    <td align="right" class="left">
            					    	Departure Time:
            					    </td>
            					    <td class="right">
            					    	<input name="dep_time" type="time" id="dep_time"  size="20" maxlength="20" value="<?php echo $user->dep_time;?>"
            					    	 /> &nbsp;<span class="required">*</span>   
            					    	</td>
            					  </tr>
            					  
            					    <tr>
            					    <td align="right" class="left">
            					    	Flight No. (Use comma to separate multiple flights):
            					    </td>
            					    <td class="right">
            					    	<input name="flight" type="text" size="20" maxlength="50" value="<?php echo $user->flight;?>"
            					    	 /> &nbsp;<span class="required">*</span>   
            					    	</td>
            					  </tr>
            					  
            					   <tr>
            					    <td align="right" class="left">
            					    	Itinerary screenshot:
            					    </td>
            					    <td class="right">
            					    	<input type="file" name="upload" id="upload" >
            					    	&nbsp;<span class="required">* </span>Upload Image smaller than 2.0MB
            					  </tr>
            					  
            					     <tr>
            					    <td align="right" class="left">
            					    	
            					    </td>
            					    <td class="right">
            					            <?php if ($user->ticket == "") 
            					    	        {
            					    	            echo 	"<img src=\"iternerary/flight_default.png\"  width=\"500\">";
            					    	        } 
            					    	        else if (check_picture_extension($user->ticket) == false) {
            					    	            echo "<a href=\"iternerary/$user->ticket\">$user->ticket</a>";
            					    	        }
            					    	        else {
            					    	            echo 	"<img src=\"iternerary/$user->ticket\"  width=\"500\">";
            					    	        }?>
            					  </tr>
					  
																
										</table>
									</td>
								</tr>
								
									<?php }?>
									
								<tr>
									<td>
										&nbsp;
									</td>
								</tr>
								<tr>
    												
									<td align="center">
									    
										<input class="submit3" name="profile" type="submit" value="Change Profile">
									</td>
    							</td>	
								</tr>
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
<?php
	include(INCLUDES . 'footer.php');
?>
