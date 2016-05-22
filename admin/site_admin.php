<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
	include('includes/application_top.php');

	if (!isset($_SESSION['admin_user']) || $_SESSION['admin_user']->admin_class == '0') {
		header("Location: login.php");
	}


	// template for page build
	include(INCLUDES . 'header.php');
	include(INCLUDES . 'admin_header.php');
	//include(INCLUDES . 'leftmenu.php');


?>




	<!--MAIN TABLE STARTS HERE--->

	<TABLE width=<?php echo TABLE_WIDTH; ?> cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff">
		<tr>
			<td colspan=3><IMG height=10 src="images/blank.gif" width=1></td>
		</tr>
		<tr>
			<td width="3%" rowspan=2><IMG height=45 src="images/line.gif" width=24></td>
			<td class="title" height="27" colspan=3>&nbsp;Site Management</td>
		</tr>
		<tr>
			<td width="2%"><IMG src="images/left.gif"></td>
			<td height="18" class="subtitle" valign="bottom" width="12%">Alter Site Parameters</td>
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
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_center.php">Add/Remove Centre</a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_resource_type.php">Add/Remove Resource Type</a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_resource.php">Add/Remove Resource</a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_status.php">Add/Remove User Status</a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_jobs.php">Add/Remove <?php echo LEVEL1_NAME; ?></a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_specialty.php">Add/Remove <?php echo LEVEL2_NAME; ?></a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_bands.php">Add/Remove <?php echo LEVEL3_NAME; ?></a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_diet.php">Add/Remove Special Requirements</a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="add_how_hear.php">Add/Remove How Hear Option</a></td>
					</tr>
					<tr>
						<td align="right" class="left" width="4px" valign="middle">*</td>
						<td class="right" width="97%" id="sectionLinks"><a href="edit_site_config.php">Site Parameters</a></td>
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

	<!-- main content ends here -->

	<!--MAIN TABLE ENDS HERE---><!--BOTTOM TABLE STARTS HERE--->


<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
