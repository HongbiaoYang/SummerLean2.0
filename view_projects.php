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
	$user->set_choices();
	
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');



	if (isset($_POST['register'])) {


	//validate and record
		$errors = tep_validate_projects();
   
    if ($errors[0] == false) {
    

		$sql_array = array(
        		           "choice1" => $_POST['choice1'],
        						   "choice2" => $_POST['choice2'],
        						   "choice3" => $_POST['choice3'],
        						   "choice4" => $_POST['choice4'],
        						   "choice5" => $_POST['choice5'],
        						   "trip1" => $_POST['trip1'],
        						   "trip2" => $_POST['trip2'], 
        						   "weekend1" => $_POST['weekend1'], 
        						   "weekend2" => $_POST['weekend2'] );
	  
        tep_db_perform(TABLE_CHOICES, $sql_array, 'update', 'stuindex ='.$user->id);	

        $user->set_choices();
        
    } else {
        echo "<span class=\"required\">".$errors[1]."</span>";
    }
    
	}
	
	//filter to show courses only valid for this users job title
	
	//Disabled view of only courses applicable to job title 
	If (JOB_REQUIREMENTS=='true') {
		If (($where_clause>0)||($where_clause<>"")) $where_clause .= " and ";
			$where_clause .= " requirement_type='job' and requirement_id=".$user->job_title_id;
	}		
	
	// page to display all courses with filter
?>	<!--
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;All Courses</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Viewing all courses</td>
			<td width="83%"><IMG src="images/right.gif"></td>
		</tr>
		
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</TABLE>
	-->
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td align="middle">
				<br><br>
				<!-- main content starts here -->
				<table width="<?php echo SEC_TABLE_WIDTH; ?>" align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<table width='100%'>
							
								<!-- CONTENT -->
								<tr>
									<table width="100%">
										<tr>
										
										</tr>
									</table>
								</tr>
            
               
								
								<!--
								<tr><td align="center" ><font color="red" size="6">Projects will be available later</font></td></tr>
							-->
							
								<tr>
									<td>
									<?php
									
									if ($user->instructor == 1) {
									   ?>			
									   <!--						    
									    		 <tr><td align="right" class="left"><Strong>Ripley's Aquarium Trip</Strong></td><td class="right" align="left">
									    		    <strong> 9:30 AM </strong>@Laurel downstairs</td></tr>
											     
											     <tr><td align="right" class="left"><Strong>Tanger Outlet Trip</Strong></td><td class="right" align="left">
											  <strong> 8:30 AM </strong> boarding, <strong> 9:00 AM </strong> departure @Laurel downstairs </td></tr>
											  -->
								  <?php
								  }
								  	
									if ($user->instructor == 0) {
									
									if ($user->choice1 == 0) {
									?>  
									    <form enctype="multipart/form-data" name="register" action="view_projects.php" method="POST">
									    <table width="100%" align="center">
									     <tr>
    									<td align="left">
    										<h4>Projects</h4>
    									</td>
    								</tr>
    								
    								  <tr>
        									<td align="left" colspan="2"><h5>
    								Please select the top 5 choices you have for affinity of projects. Remember that there is no guarantee or warranty that you will end up working in these projects.</h5>
									        </td>
        								</tr>
									        
									        
									    <?php
									    for ($i=1; $i <= 5; $i++) {
									    ?>
									    <tr><td class="left" width="30%">
									        Choice<?php echo ($i); ?></td><td class="right" align="left">
									       <?php
									       echo tep_build_project_dropdown('choice'.$i, true, $_POST['choice'.$i], '--Select--'); ?>	<span class="required">*</span>								    
									    </td></tr>
									    <?php
									        }    		
									        ?>
               				  
                				  <tr><td colspan=2><hr></td> </tr>
                				  
                				  
                				  <!--
                				  <tr>
        										<td align="left" colspan="2">
        										<h4>Facility Trips</h4>
        									</td>
        								</tr>
        								
        									  
                				  <tr>
        									<td align="left" colspan="2">
        										<h5>Please select only 2 facility tours. Only one tour per scheduled date is allowed.</h5>
        									</td>
        								</tr>
        							        
        							    <tr>
                							<td align="right" class="left">
                								Field Trip Choice 1:
                							</td>
                							<td class="right">

                								<?php echo tep_build_trip_dropdown(TABLE_TRIPTYPE, 'trip1', false, '1', ' date = 9', true, $_POST['trip1']);?>
                								&nbsp;<span class="required">*</span>
                							</td>
                						</tr>	
                						
                						  <tr>
                							<td align="right" class="left">
                								Field Trip Choice 2:
                							</td>
                							<td class="right">

                								<?php echo tep_build_trip_dropdown(TABLE_TRIPTYPE, 'trip2', false, '1', 'date = 10 or date = 23', true, $_POST['trip2']);?>
                								&nbsp;<span class="required">*</span>
                							</td>
                						</tr>	
                						
                						  <tr>
        									<td align="left">
        										<h4>Weekend Trips</h4>
        									</td>
        								</tr>
        								 <tr>
        									<td align="left" colspan="2">
        										<h5>Please select the weekend trips you will be attending. These trips are included as part of your program at no additional cost. However, once your selection is made, there are no changes or cancelations. Failure to attend signed up trips will incur a $30 USD penalty fee.</h5>
        									</td>
        								</tr>
                						
                						
                						 <tr>
                							<td align="right" class="left">
                								Ripley's Aquarium trip (July 18th):
                							</td>
                							<td class="right">
                							    <input type="checkbox" name="weekend1" value="1"
                							    <?php if ($_POST['weekend1'] == 1) echo "checked";?>>
                							</td>
                						</tr>	
                						
                						<tr>
                							<td align="right" class="left">
                								Tanger Outlet trip (July 25th):
                							</td>
                							<td class="right">
                							    <input type="checkbox" name="weekend2" value ="1" 
                							    <?php if ($_POST['weekend2'] == 1) echo "checked";?>>
                							</td>
                						</tr>	
        							
        								  --> 
        								  
                				    <tr>
                					<td colspan="2" align="center">
                						<input name="register" type="submit" value="Register" class="submit3">
                					</td>
                				  </tr>
                				  
									        </table>
									        </form>
									        
									        <?php							    								    
									     } 
											 else {
		    
											   ?>
											   
											   <table width="100%" align="center">
											    <tr><td align="right" class="left"><Strong>Choice1</Strong></td><td class="right" align="left"><?php echo $user->choice1.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice1);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice2</Strong></td><td class="right" align="left"><?php echo $user->choice2.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice2);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice3</Strong></td><td class="right" align="left"><?php echo $user->choice3.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice3);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice4</Strong></td><td class="right" align="left"><?php echo $user->choice4.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice4);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice5</Strong></td><td class="right" align="left"><?php echo $user->choice5.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice5);?></td></tr>
											   
											    
											     <tr><td align="right" class="left"><Strong>Your Project</Strong></td><td class="right" align="left"><?php echo tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->team);?></td></tr>
											    
											    <!-- <tr><td align="right" class="left"><Strong>Your Final Score</Strong></td><td class="right" align="left">
											        <Strong><?php echo $user->score;?></Strong></td></tr>
											    
											     <tr><td align="right" class="left"><Strong>Trip 1</Strong></td><td class="right" align="left"><?php echo tep_get_name(TABLE_TRIPTYPE,$user->trip1);?></td></tr>											     
											     <tr><td align="right" class="left"><Strong>Trip 2</Strong></td><td class="right" align="left"><?php echo tep_get_name(TABLE_TRIPTYPE,$user->trip2);?></td></tr>
											     
											     <tr><td align="right" class="left"><Strong>Ripley's Aquarium Trip</Strong></td><td class="right" align="left"><?php echo $user->weekend1 == 0?"Not Going":"Going,<strong> 9:30 AM </strong>@Laurel downstairs";?></td></tr>
											     
											     <tr><td align="right" class="left"><Strong>Tanger Outlet Trip</Strong></td><td class="right" align="left"><?php echo $user->weekend2 == 0?"Not Going":"Going,<strong> 8:30 AM </strong> boarding, <strong> 9:00 AM </strong> departure @Laurel downstairs  ";?>&nbsp; 
											      </td></tr>
											      -->
											      <!-- <a href="edit_trip.php">Modify</a> -->
											     
											     
											     
											     
		                    <?php } ?>		
								</tr>
							
							</table>

						</td>
					</tr>
					
					
					
					
				</table>
				<hr>
				
				<?php  
				if ($user->team != 0 && $user->choice1 != 0) {
				$leader = tep_get_leader($user->team);
				
				?>
				<table>
				    <tr><td width="25%"><td align="right" class="left"><Strong>Team Leader:</Strong></td><td class="right" align="left"><?php echo $leader['FirstName']; ?></td><td width="25%"></tr>
				    <tr><td width="25%"><td align="right" class="left"><Strong>Email:</Strong></td><td class="right" align="left"><?php echo $leader['Email']; ?></td><td width="25%"></tr>
            <tr><td width="25%"><td align="right" class="left" width="25%"><Strong>Biography:</Strong></td><td class="right" align="left" width="25%"><?php echo $leader['bio']; ?></td><td width="25%"></td></tr>
            <tr><td width="25%"><td align="right" class="left"><Strong>Profile:</Strong></td><td class="right" align="left">
                <img src="uploads/<?php echo $leader['picture']; ?>" class="left" height="240"/>
            </td><td width="25%"></tr>
                
                
			  </table>
				<?php }
				
				
		}
				?>
				
				
			</td>
		</tr> 
	</TABLE>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
