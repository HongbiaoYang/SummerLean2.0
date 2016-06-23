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
            
            $errors = tep_validate_eval();
            if (!$errors[0]) {
            
                foreach ($_SESSION['eval_list'] as $eval_id) {
    
        				$sql_array = array(
        				   	   "q1" => $_POST[$eval_id.'-q1'],
        				   	   "q2" => $_POST[$eval_id.'-q2'],
        				   	   "q3" => $_POST[$eval_id.'-q3'],
        				   	   "q4" => $_POST[$eval_id.'-q4'],
        				   	   "q5" => $_POST[$eval_id.'-q5'],
        				   	   "q6" => $_POST[$eval_id.'-q6'],
        				   	   "done" => 1   				   	   
        				   	   
        				   	);
    
        
        				// enter user profile details
        				tep_db_perform(TABLE_EVALUATE, $sql_array, 'update', "evaluator='$user->id' and evaluatee = ".$eval_id);
                
                // header("Location: edit_profile.php");
        				// header("Location: view_profile.php?id=$user->id");
        				header("Location: evaluation.php");
    		    }
    			}
    			else
    			{
    				$access_error = true;
    				$error = PERMISSION_ERROR;
    			}
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
							<form enctype="multipart/form-data" name="profile" action="evaluation.php?id=<?php echo $_GET['id']; ?>" method="POST">
							<table width='100%'>
								<tr>
									<td width="60%">
										&nbsp;
									</td>
									<td colspan = 6>
										<?php if ($errors[0] == true) { ?>
										<span class="required">* <?php echo $errors[1]; ?></span>
										<?php }?>
									</td>
								</tr>
								
										
								<tr>
									<td colspan="2" align="left">
										<h4>Self / Peer Evaluation</h4>
									</td>
								</tr>
								
								<tr>
									<td colspan="7" align="center">
										<h4>Instructions</h4>
									</td>
								</tr>
								<tr>
									<td colspan="7" align="center">
										Instructions: Please read carefully the <a href="files/self_evaluation.docx">rubric</a>
								 below, 4 is the best grade and 1 is the worst for all sections. You should evaluate yourself (where your name is) as well as others as objectively as possible. You must complete the evaluation carefully as there is only one opportunity to do it. Failure to complete this form from you (or your teammates) will result in self-evaluation score of 0 and peer-evaluation score of 4.
									</td>
								</tr>
								
								<tr><td colspan="7"><hr></td></tr>
								
								<tr>
									<td colspan="7" align="center">
										<img src="files/evaluation.png" width=800>
									</td>
								</tr>
								
								
								<tr><td colspan="7"><hr></td></tr>
								
								
								      <tr>
							            <td><strong>Evaluatees</strong></td>   
							      <td>Q1.Participation</td>   <td>Q2.Leadership</td>   <td>Q3.Listening</td>   
							      <td>Q4.Feedback-<br>Communication</td>   <td>Q5.Cooperation</td>   <td>Q6.Time Management</td>   
							         </tr>
							         
							        <?php 
							            
							        $esql = "select * from tbl_evaluate where evaluator=".$user->id;
							        $result = tep_db_query($esql);
							        
							        $_SESSION['eval_list'] = array();
							        
							        if (tep_db_num_rows($result) > 0) {
                        		while ($row = tep_db_fetch_array($result)) {
                        		    $ename = tep_evaluatee_name($row['evaluatee']);
                        		    
                        		    if ($row["done"] == 1) {
                        		   
                        		        // already evaluated
                        		        $done = 1;
                        		        ?>
                        		        
                        		    <tr><td><?php echo $ename; ?></td>
                                <td>
                                    <?php echo $row["q1"]; ?>
                                </td>
                                 <td>
                                     <?php echo $row["q2"]; ?>
                                </td>
                                 <td>
                                     <?php echo $row["q3"]; ?>
                                </td>
                                 <td>
                                     <?php echo $row["q4"]; ?>
                                </td>
                                 <td>
                                     <?php echo $row["q5"]; ?>
                                </td>
                                 <td>
                                     <?php echo $row["q6"]; ?>
                                </td>
                                
                               </tr>
                               
                        		    <?php 
                        		    
                        		     } else {
                        		        // not submitted yet
                        		        $done = 0;
                        		        
                        		    array_push($_SESSION['eval_list'], $row['evaluatee']);
                        		    
                        		    ?>
                        		    
                               <tr><td><?php echo $ename; ?></td>
                                <td>
                                    <?php echo tep_dropdown_eval($row["evaluatee"]."-q1"); ?>
                                </td>
                                 <td>
                                    <?php echo tep_dropdown_eval($row["evaluatee"]."-q2"); ?>
                                </td>
                                 <td>
                                    <?php echo tep_dropdown_eval($row["evaluatee"]."-q3"); ?>
                                </td>
                                 <td>
                                    <?php echo tep_dropdown_eval($row["evaluatee"]."-q4"); ?>
                                </td>
                                 <td>
                                    <?php echo tep_dropdown_eval($row["evaluatee"]."-q5"); ?>
                                </td>
                                 <td>
                                    <?php echo tep_dropdown_eval($row["evaluatee"]."-q6"); ?>
                                </td>
                                
                               </tr>
						        <?php }
						        } 
						    }
								
								if ($done == 0) {       ?>
								    <tr><td><br></td></tr>
								  <tr><td colspan="6" align="center">
						        <input class="submit3" name="profile" type="submit" value="Submit Evaluation">
						        </td></tr>
						        
						        <?php } ?>
								
							</form>
						</td>
					</tr>

                        <tr><td colspan="7"><hr></td></tr>
                        

                        

								
								

				</table>
				
			<br><br>
			</td>
		</tr>
	</TABLE>
<?php
	include(INCLUDES . 'footer.php');
?>
