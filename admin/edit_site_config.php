<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	// access level 2
	
	$access_level = '3';
	$access_error = false;
	$File = "../config.php";
	
	include('includes/application_top.php');
	
	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}

	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	
	
	if (isset($_POST['new_name'])) {
		//make entry into centers
		if (tep_validate_user($_SESSION['admin_user'], $access_level)) {
			//update file
			$Handle = fopen($File, 'w');
			fwrite($Handle, "<?php\r\n");
			Foreach ($_POST as $key=> $value){
				If (stristr($key,'comment')){
				 	$Data = $value."\r\n";
					fwrite($Handle, $Data);
				}
				Elseif ($key!='new_name' and $key!='new_value' and $key!='Save'){
				 	$Data = "	define('".$key."', '".trim($value)."');\r\n";
					fwrite($Handle, $Data);
				}
			}
			If (!empty($new_name)) fwrite($Handle, "	define('$new_name', '$new_value');\r\n");
			fwrite($Handle, "include('site_config.php');\r\n?>");
			fclose($Handle); 			
		}
		else
		{
			$access_error = true;
			$error = PERMISSION_ERROR;
		}
	}
	
//Grab the contents of the config file;
$lines = file($File);
?>
	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Manage Site Variables</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Configuration</td>
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
				<table width=<?php echo SEC_TABLE_WIDTH; ?> align="center" cellspacing="1" cellpadding="3">
					<tr>
						<td>
							<table width='100%'>
								<!-- CONTENT -->
								<?php
								if ($access_error) {
								?>
									<tr>
										<td>
											<?php echo $error; ?>
										</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td align="left">
										<form action="edit_site_config.php" name="edit_config" method="POST">
										
										<table width="100%">
										<?php
											$comment=0;
											foreach ($lines as $line_num => $line)
											{
												If ($line!='<?php' && $line!='?>' and !empty($line)){
													If (stristr($line,'//') and !stristr($line,'define')){
													$comment++;
													Echo "<tr>
														<td colspan='2'>
															<h4>".trim(substr($line,2,strlen($line)))."</h4>
															<input type='hidden' name='comment$comment' value=\"$line\">
															</td>
														</tr>";	
														}
													Elseif(stristr($line,'define')){
														$line=explode(',',substr($line,8,strlen($line)));
													$setting=trim(str_replace("'",'',$line[0]));
													$value=str_replace("'",'',substr($line[1],0,strlen($line[1])-4));	
													Echo "<tr>
														<td class='left' width='30%'>$setting</td>
														<td class='right'><input name='$setting' type='text' value=\"$value\" size='50'></td>
													</tr>";
													}	
													
												}
											}
										?>
										</table>
										<h4>Add a Setting</h4>
										<table width="100%">
											<tr>
												<td width="30%" class="left">
													<input name="new_name" type="text">
												</td>
												<td class="right">
													<input name="new_value" type="text">
												</td>
											</tr>
											<tr>
												<td colspan="2">&nbsp;
													
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input name="Save" type="submit" value="Save" class="submit3">&nbsp;<a href="site_admin.php">Back</a>
												</td>
											</tr>
										</table>
										</form>
										
									</td>
								</tr>
							</table>
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
	include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
