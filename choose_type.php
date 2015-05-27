<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/



	include('includes/application_top.php');

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
			<form enctype="multipart/form-data" name="register" action="choose_type.php" method="POST">
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
						<h4>Identify yourself</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%">
								<tr>
									<td  align="center" class="center" colspan="3">
								Are you from Brazil <Strong>Science Without Border (SWB)</Strong> program?
									</td>
									
								</tr>
							<tr>
								<td align="right" class="left">
								
                    <input type="button" onclick="window.location.href='add_swb.php';" value="Yes">                
                
								</td>
								<td align="right" class="left" width="5%">
								</td>
								<td class="right">
								<input type="button" onclick="window.location.href='add_user.php';" value="No">
								</td>
							</tr>

						</table>
					</td>
				</tr>


	</TABLE>


<?php
	//include(INCLUDES . 'rightmenu.php');
	include(INCLUDES . 'footer.php');
?>
