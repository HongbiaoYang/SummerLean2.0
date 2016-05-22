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
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'front_header.php');



	if (isset($_POST['register'])) {

		$sql_array = array(
        		           "choice1" => $_POST['choice0'],
        						   "choice2" => $_POST['choice1'],
        						   "choice3" => $_POST['choice2'],
        						   "choice4" => $_POST['choice3']);
    $sql_values = array_values($sql_array);
    if (in_array(0, $sql_values)) {
    echo ' <span class="required">
                Please select legal projects!
               </span>';
    
    } else if (count($sql_values) != count(array_unique($sql_values))) {
        echo ' <span class="required">
                You have chosen duplicated projects!
               </span>';
    } else {
    						  
        tep_db_perform(TABLE_STUDENTS, $sql_array, 'update', 'stuindex ='.$user->id);	
        $user->set_profile();
    }
	}
	
	//filter to show courses only valid for this users job title
	
	//Disabled view of only courses applicable to job title 
	If (JOB_REQUIREMENTS=='true') {
		If (($where_clause>0)||($where_clause<>"")) $where_clause .= " and ";
			$where_clause .= " requirement_type='job' and requirement_id=".$user->job_title_id;
	}		
	
	// page to display all courses with filter
?>
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
            
                <tr>
									<td align="left">
										<h4>Projects</h4>
									</td>
								</tr>
							
								<tr>
									<td>
									<?php
									
									if ($user->choice1 == 0) {
									?>  
									    <form enctype="multipart/form-data" name="register" action="all_courses.php" method="POST">
									    <table width="100%" align="center">
									    <?php
									    for ($i=0; $i < 4; $i++) {
									    ?>
									    <tr><td align="right" class="left">
									        Choice<?php echo ($i+1); ?></td><td class="right" align="left">
									       <?php
									       echo tep_build_project_dropdown(TABLE_PROJECTS, 'choice'.$i, false, '1', '', false, '', 'ProjIndex', 'Title', '--Select--'); ?>									    
									    </td></tr>
									    <?php
									        }    		
									        ?>
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
											   echo "You already chosen your projects."; 											    
											   ?>
											   <table width="100%" align="center">
											    <tr><td align="right" class="left"><Strong>Choice1</Strong></td><td class="right" align="left"><?php echo $user->choice1.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice1);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice2</Strong></td><td class="right" align="left"><?php echo $user->choice2.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice2);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice3</Strong></td><td class="right" align="left"><?php echo $user->choice3.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice3);?></td></tr>
											    <tr><td align="right" class="left"><Strong>Choice4</Strong></td><td class="right" align="left"><?php echo $user->choice4.'-'.tep_get_name_pro(TABLE_PROJECTS, 'ProjIndex', 'Title', $user->choice4);?></td></tr>
		                    <?php } ?>
		
								</tr>

							
							
								<tr>
									<td>
									
									</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</TABLE>
<?php
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
