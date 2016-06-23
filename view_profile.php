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
	$user->set_profile();
	
	if ($user->instructor == 1) {
	    
		ChromePhp::log('Hello console!');
		ChromePhp::log($_SESSION['learner']);

	    $user = new instructor($user->username);  
	    $user->instructor_attributes();
	    	    
	     //print_r($user);
	     //print_r($_SESSION['learner']);
	    // echo "is instructor++++";
	}
	
	// require_once('something.php');
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');


	// algorith to determine this user's courses

	$schedule_array = array();
	$query = "select ca.id, ca.course_id, ca.start_date, ca.dates, ca.start_time, ca.end_time, ca.resources, ca.reg_online, c.center, c.type, c.name, r.id'registration_id', r.status from calendar as ca left join registrations as r on (r.calendar_id = ca.id) left join courses as c on (ca.course_id = c.id) where r.user_id = '$user->id' order by ca.start_date, c.center, c.type, ca.start_time, c.name";
	$result = tep_db_query($query);
	$courses_error = false;
	if (tep_db_num_rows($result) > 0) {
		while ($row = tep_db_fetch_array($result)) {
			if (date("Y-m-d", mktime(0, 0, 0, substr($row['start_date'],5,2), substr($row['start_date'],-2,2)+$row['duration']-1, substr($row['start_date'],0,4))) >= date("Y-m-d"))
				$past = false;
			else
				$past = true;

			//if ((substr($row['start_date'],5,2) == date("m") && (substr($row['start_date'],-2,2)+$row['duration']-1) >= date("d")) || (substr($row['start_date'],5,2) > date("m") && substr($row['start_date'],0,4) >= date("Y"))) {
				$schedule_array[] = array('id' => $row['id'],
							  'date' => $row['start_date'],
							  'course_id' => $row['course_id'],
							  'center' => $row['center'],
							  'type' => $row['type'],
							  'name' => $row['name'],
							  'dates' => unserialize($row['dates']),
							  'start_time' => $row['start_time'],
							  'end_time' => $row['end_time'],
							  'resources' => unserialize($row['resources']),
							  'reg_online' => $row['reg_online'],
							  'status' => $row['status'],
							  'registration_id' => $row['registration_id'],
							  'past' => $past);
		}
	}
	else
	{
		$courses_error = true; //no courses have been registered for.
	}


	// template for page build

	?>

  <!-- Table 1( -->
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Profile Management 
				<?php  // print_r($_SESSION['learner']); echo  '++++++++++++';$user = $_SESSION['learner'];  print_r($user); ?>
				 </td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing Profile</td>
			<td width="83%"><IMG src="images/right.gif"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</TABLE>
	<!-- Table 1) -->
	
	<!-- Table 2( -->
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="middle">
				<br><br>
				<!-- main content starts here -->
				<!-- Table 21( -->
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
						  <!-- Table 211( -->
							<table width='100%'>
								<!-- CONTENT -->
								<tr>
									<td>
									  <!-- Table 2111( -->
										<table width="100%">
											<tr>
												<td class="center" colspan="2">
													<span class="subtitle2"><?php echo $user->username; ?>&nbsp;&nbsp;&nbsp;</span>(<a href="edit_profile.php">Edit Profile</a>)
												</td>
										</tr>
										<tr><td colspan="2"><hr></td></tr>
										
										<!--	
											<?php if ($user->instructor ==  0) { ?>
											<tr>
												<td class="center" colspan="2" background="green">
													<span class="fronttitle"><a href="evaluation.php">Self/Peer Evaluation</a></span> 
													<?php echo tep_check_evaluated($user->id);?>
												</td>
										</tr>
								<?php } ?>
								-->
	

										
										<?php if($user->instructor == 1) { ?>
										<tr>
												<td class="center" colspan = "2">
													<?php
													if ($user->instructor == '1') {
														$instructor = new instructor($user->username);
														$instructor->instructor_attributes();
														?><img src="<?php echo "uploads/".$instructor->picture;?>" width="200"><?php
													}
													else
														echo '&nbsp';
													?>
												</td>
											</tr>
										<?php } ?>
											
										</table>
										<!-- Table 2111) -->
									</td>
								</tr>
								<tr>
									<td>&nbsp;

									</td>
								</tr>
								<tr>
									<td align="left">
										<h4>Personal Information:</h4>
									</td>
								</tr>
								<tr>
									<td>
									  <!-- Table 2112( -->
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													Name:
												</td>
												<td class="right">
													<?php echo $user->firstname.' '.$user->middlename.' '.$user->lastname.' '.$user->lastname2; ?>
												</td>
											</tr>
											
										  <tr>
												<td width="30%" class="left">
													Email:
												</td>
												<td class="right">
													<?php echo $user->email; ?>
												</td>
											</tr>
											
											<?php if ($user->instructor==1) { ?>
											
											<tr>
												<td width="30%" class="left">
													Biography:
												</td>
												<td class="right">
													<?php echo htmlspecialchars ($user->bio); ?>
												</td>
											</tr>
											
											<?php }?>
											
											
											<?php if ($user->instructor==0) { ?>
											
											<tr>
												<td width="30%" class="left">
													Country:
												</td>
												<td class="right">
													<?php echo tep_get_name(TABLE_COUNTRIES, $user->country); ?>
												</td>
											</tr>
											
																					
											<tr>
												<td width="30%" class="left">
													Name of Certificate:
												</td>
												<td class="right">
													<?php echo $user->fullname; ?>
												</td>
											</tr>
											
											<tr>
												<td width="30%" class="left">
													Net ID:
												</td>
												<td class="right">
													<a href = "https://oit.utk.edu/help/areyounew/Pages/netidpassword.aspx" target="_blank">
													    <?php echo $user->netid; ?></a>
												</td>
											</tr>
											
												<tr>
												<td width="30%" class="left">
													TNID:
												</td>
												<td class="right">
													<?php echo $user->tnid; ?>
												</td>
											</tr>
											
												<tr>
												<td width="30%" class="left">
													Primary Insurance Carrier:
												</td>
												<td class="right">
													<?php echo $user->insurance; ?>
												</td>
											</tr>
											
												<tr>
												<td width="30%" class="left">
													Insurance Policy Number:
												</td>
												<td class="right">
													<?php echo $user->insurance_no; ?>
												</td>
											</tr>
											
										<?php }
										?>
											<!--
											<tr>
												<td class="left">
													IIE ID:
												</td>
												<td class="right">
													<?php echo $user->iieid; ?>
												</td>
											</tr>
											-->

											<tr>
												<td class="left">
													Mobile Phone:
												</td>
												<td class="right">
													<?php echo $user->mobile; ?>
												</td>
											</tr>
											
											<?php 
											if ($user->instructor == 0) {
											?>
											
											<tr>
												<td class="left">
													Facebook:
												</td>
												<td class="right">
													<?php echo $user->facebook; ?>
												</td>
											</tr>
											
											<tr>
												<td class="left">
													Twitter:
												</td>
												<td class="right">
													<?php echo $user->twitter; ?>
												</td>
											</tr>
											
											<tr>
												<td class="left">
													Whatsapp:
												</td>
												<td class="right">
													<?php echo $user->whatsapp; ?>
												</td>
											</tr>
											
											<tr>
												<td class="left">
													Google Hangout:
												</td>
												<td class="right">
													<?php echo $user->google; ?>
												</td>
											</tr>
											
											
											<tr>
												<td class="left">
													Profile:
												</td>
												<td class="right">
												    <Img src="uploads/<?php echo $user->picture; ?>" width ="200" />
												</td>
											</tr>
											
											
												<tr>
												<td class="left">
													Semesters Completed:
												</td>
												<td class="right">
												    <?php 
												    if ($user->semester <= 12) {
												        echo $user->semester;
												    } else if ($user->semester == 13)  {
												        echo ">12";
												    } else if ($user->semester == 14) {
												        echo "Graduated";
												    }
												    
												    ?>
												</td>
											</tr>
											
											
												<tr>
												<td class="left">
													Background Knowledge:
												</td>
												<td class="right">
												    <?php 
												    $back_array = explode(".", $user->background);
												    foreach (array_slice($back_array, 0, count($back_array) - 1) as $item)
												    {
												        echo tep_get_name(TABLE_BACKGROUND, $item).";";
												    }
												  ?>
												    
												    
												</td>
											</tr>
											
												<tr>
												<td class="left">
													Preferred Roommate:
												</td>
												<td class="right">
												    <?php 
											  echo tep_get_name_pro(TABLE_STUDENTS, 'stuindex', 'fullname', $user->roommate);

												  ?>
												    
												    
												</td>
											</tr>

										</table>
										<!-- Table 2112) -->
									</td>
								</tr>
							
								<!--
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
        									<?php 		echo $user->dep_date; ?>
												</td>
											</tr>
											
											  <tr>
            					    <td align="right" class="left">
            					    	Departure Time:
            					    </td>
            					    <td>
            					        <?php  echo $user->dep_time; ?>
            					    	</td>
            					  </tr>
            					  
            					    <tr>
            					    <td align="right" class="left">
            					    	Flight No. (Use comma to separate multiple flights):
            					    </td>
            					    <td>
            					   <?php echo $user->flight;?>
            					    	</td>
            					  </tr>
            					  
            					   <tr>
            					    <td align="right" class="left">
            					    	Itinerary screenshot:
            					    </td>
            					    <td class="right">
            					            <?php if ($user->ticket == "") 
            					    	        {
            					    	            echo "You haven't upload any itinerary screenshot." .
            					    	            "<br>Please upload one by  <a href=\"edit_profile.php\">Edit</a>".
            					    	            " your profile";
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
							
							
								<tr>
									<td align="left">
										<h4>Project Information:</h4>
									</td>
								</tr>
								
								<?php if ($user->team != 0) { ?>
								
									<tr>
									<td colspan="3">
									    <!-- Table 2114( -->
										<table width="100%">
										    <?php $proj_array = tep_get_team_leader($user->id);?>
										    
								        <tr>
        										<td width="50%" class="left">
        													Project:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['title']; ?>
        												</td>
        							 </tr>	
        							 
        							  <tr>
        										<td width="50%" class="left">
        													Company:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['CompanyName']; ?>
        												</td>
        							 </tr>	
        							 
        							  <tr>
        										<td width="50%" class="left">
        													Project Description:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['ProjDesc']; ?>
        												</td>
        							    </tr>	
        							 
        							 
        							 	  <tr>
        										<td width="50%" class="left">
        													Additional Comments:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['comments']; ?>
        												</td>
        							    </tr>	
        							 
        							 
        							 
        							    <tr>
        										<td width="50%" class="left">
        													Team Leader:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['firstname']." ".$proj_array['lastname']; ?>
        												</td>
        							    </tr>	
        							    
        							     <tr>
        										<td width="50%" class="left">
        													Telephone:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['mobile']; ?>
        												</td>
        							    </tr>	
        							    
        							         <tr>
        										<td width="50%" class="left">
        													Email:
        												</td>
        												<td class="right">
        													<?php echo $proj_array['email']; ?>
        												</td>
        							    </tr>	
        							    
        							     <tr>
        									
        												<td  class="left">
        													<img src="<?php echo "uploads/".$proj_array['picture'];?>" width="200">
        												</td>
        												<td  class="right">
        													<?php echo $proj_array['bio']; ?>
        												</td>
        							    </tr>	
                            
                            <tr>
            										<td width="50%" class="left">
            													Teammates:
            												</td>
        												<td class="right">
        													<?php 
        													    $mates_array = tep_get_teammates($user->id, $user->team);        													
        													    foreach ($mates_array as $mate) {
        													        echo $mate['firstname']." ".$mate['lastname'].
        													        ", ".$mate['mobile'].
        													        ", <a href=\"mailto:".$mate['email']."\">".$mate['email']."</a>".
        													        "<br>";  
        													    }
        													    
        													 ?>
        												</td>
        							    </tr>							    
       							 
        							 				
        							  </table>
        						</td>
        				</tr>
							
							  <?php }?>
						
								<!-- The schedule of this user -->
								
								<tr>
									<td align="left">
										<h4>Course Schedule:</h4>
									</td>
								</tr>
								<tr>
									<td colspan="3">
									    <!-- Table 2114( -->
										<table width="100%">
											<tr>
												<td class="hright">
													Date
												</td>
												<td class="hright">
													Course
												</td>
												<td class="hright">
													Centre
												</td>
												<td class="hright">
													Start Time
												</td>
												<td class="hright">
													Status
												</td>
												<td class="hright">
													Action
												</td>
											</tr>
											<?php
											$date_temp = '';
											$center_temp = '';
											$type_temp = '';
											foreach ($schedule_array as $x=>$y) {
													if ($date_temp != $y['date']) {
														$date_temp = $y['date'];
														?>
														<tr>
															<td class="right"><span class="heading"><?php if ($y['past']) { echo '<font color="orange">'; } echo $y['date'] ?></td>
														<?php
														$center_temp = '';
														$type_temp = '';
													}
													else
													{
														?><td class="right">&nbsp;</td><?php
													}
													?><td class="right"><?php echo '<a href="view_course.php?id='.$y['course_id'].'">'.$y['name']; ?></a></td><?php
													if ($center_temp != $y['center']) {
														$center_temp = $y['center'];
														?>
															<td class="right"><?php echo tep_get_name(TABLE_CENTERS, $y['center']); ?></span></td>
														<?php
														$type_temp = '';
													}
													else
													{
														?><td class="right">&nbsp;</td><?php
													}
													if ($type_temp != $y['type']) {
														$type_temp = $y['type'];
													}
													?>



														<td class="right"><?php echo substr($y['start_time'],0,5) ?></td>
														<td class="right"><?php
															if ($y['past'])
																echo '<font color="red"><a href="reporting.php?calendar_id='.$y['id'].'&user_id='.$user->id.'">Report</a></font>';
															else
																echo tep_get_name(TABLE_STATUS, $y['status']);


															?>
														</td>
														<td class="left">
															<a href="course_registrations.php?id=<?php echo $y['id']; ?>">View Details</a>
														</td>
													</tr>
													<?php
												}
											//}
											if ($user->instructor == 0 && $courses_error) { ?>
												<tr>
													<td colspan="6" class="right">
														<font color="red">You do not yet have any courses. Use the menu to view the schedule and select courses to register for.</font>
													</td>
												</tr>
												<?php
											}
											?>
										</table>
										<!-- Table 2114) -->
								</td>
						</tr>
						<?php  } else   { 
						        // for team leaders
						    ?>    
						           
                       <!-- Table 2115( -->
											<table width="100%">
												<tr>
													<td colspan="5"><h4>Team Information:</h4></td>
												</tr>
												
						
											    <?php
											    $query = "select * from tbl_projects where 1 and teamleader = ".$user->team;
											    $result = tep_db_query($query);
											    
                        	if (tep_db_num_rows($result) > 0) {
                        		while ($row = tep_db_fetch_array($result)) {
                        		 ?>
                        		 <tr><td colspan="2">
                        		    
                        		 <!-- Table 21151( -->
                        		 <table width="100%">
                        		    <tr>
                        		    <td class="center" width="50%"><strong>Project Name:</strong></td>    
                        		    <td class="center" width="50%"><?php echo $row['Title'];?></td>    
                        		    </tr>
                        		    
                        		    <tr>
                        		    <td class="center" width="50%"><strong>Company Name:</strong></td>    
                        		    <td class = "center" width="50%"><?php echo tep_get_name_pro(TABLE_COMPANIES, 'ComIndex', 'CompanyName', $row['ComIndex']);?></td>   
                        		    </tr>
                        		    
                        		    <tr>
                        		    <td colspan="2" class="center"><strong>Team Members</strong></td>    
                        		    </tr>
                        		    
                        		    
                        		     <tr>
                        		        <!-- Table 211511( -->
                       		          <table width="100%">
                       		                
                       		                
                        		    <?php 
                        		    $query2 = "select email ".
                        		              "From tbl_students ".
                        		              "Where 1 and team=".$row['ProjIndex'];
                        		    $result2 = tep_db_query($query2);
                        		    if (tep_db_num_rows($result2) > 0) {
                            		while ($row2 = tep_db_fetch_array($result2)) {
                            		    $student = new user($row2['email']);
                            		    $student->set_profile();
                            		    ?>
                        		    
                        		   
                       		            <tr>
                       		                <td class="center"><?php echo $student->firstname." ".$student->lastname.
                       		                    ' <strong>('.$student->fullname.')</strong>';?></td>
                       		                <td class="center"><a href="mailto:<?php echo $student->email."\">".$student->email;?></a></td>
                       		                <td class="center"><?php echo $student->gender == "F" ? "Female":"Male";?></td>
                       		                <td class="center"><?php echo tep_get_name(TABLE_COUNTRIES,$student->country); 
                       		                    if ($student->swb == 1) {echo "(SWB)";}?></td>
                       		            </tr>                       		                
                       		           
                        		    
                        		    <?php 
                        		}
                        }?>
                        
                                </table>
                       		       <!-- Table 211511) -->
                        		    </tr>
                        		    
                        		    <tr>
                        		    <td colspan="2"><hr></td>
                        		    </tr>
                        		    
                        		 </table>   
                        		 <!-- Table 21151) -->
                        		    </td>
                        		</tr>
                        		    
                        		   
                        <?php 
                        		}
                          }
										    
											    ?>
											
																						

											</table>
											<!-- Table 2115) -->
										<?php
										}
										?>
									</td>
								</tr>
							</table>
							<!-- Table 211) -->
						</td>
					</tr>
				</table>
				<!-- Table 21) -->
				<br><br>
				
				<!-- Table 22( -->
				<table width="96%" align="center" cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td colspan=3 align=right></td>
					</tr>
				</table>
				<!-- Table 22) -->
				<br><br>
			</td>
		</tr>
	</TABLE>
	<!-- Table 2) -->
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
