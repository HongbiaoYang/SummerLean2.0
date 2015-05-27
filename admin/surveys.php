<?php

/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	include('includes/survey_mapping_vars.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'remove') {
			$survey_id = $_GET['survey_id'];
			$query = "delete from surveys where phpesp_id = '$survey_id'";
			$result = tep_db_query($query);
		}
		if ($_GET['action'] == 'export') {
			//lets export into a csv file
			$file_name = tep_export_survey($_GET['survey_id']);
		}
	}

	$survey_array = tep_get_surveys();
	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	//include(INCLUDES . 'leftmenu.php');





?>


	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Survey Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Surveys</td>
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
					<?php
					if (!isset($_GET['survey_id'])||($_GET['action']=='remove')) {
						?>
						<tr>
							<td align="right" class="left" width="4px" valign="middle">*</td>
							<td class="right" width="97%" align="left" id="sectionLinks" colspan="2"><a href="add_survey.php">Add a survey</a></td>
						</tr>
						<?php
						foreach ($survey_array as $a=>$s) {
						?>

							<tr>
								<td align="right" class="left" width="4px" valign="middle">*</td>
								<td class="right" width="77%" align="left" id="sectionLinks"><a href="surveys.php?survey_id=<?php echo $s['phpesp_id']; ?>"><?php echo $s['name']; ?></a></td>
								<td class="right" width="20%" align="right"><a href="surveys.php?action=remove&survey_id=<?php echo $s['phpesp_id']; ?>">Remove</a>&nbsp;|&nbsp;<a href="surveys.php?action=export&survey_id=<?php echo $s['phpesp_id']; ?>">Export</a></td>
							</tr>

						<?php
						}
						?>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
								<td colspan="3" class="right"><a href="<?php echo PHPESP_APP; ?>" target="_blank">phpEsp login</a></td>
						</tr>
						<?php
					}
					else if ($_GET['action'] != 'export')
					{
						?>
						<tr>
							<td>
								<table width="80%" align="left">
									<tr>
										<td align="left">
					<?php
											$sid = $_GET['survey_id'];
											include(PHPESP_PATH);
					?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php
					}
					else
					{
						?>
						<tr>
							<td>
								<table width="80%" align="center">
									<tr>
										<td class="right">
											Your survey has been successfully exported. Click <a href="download_export.php?filename=<?php echo $file_name; ?>">here</a> to download the csv file.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php
					}
					?>
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

	<!-- main content ends here -->

	<!--MAIN TABLE ENDS HERE---><!--BOTTOM TABLE STARTS HERE--->

<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>

