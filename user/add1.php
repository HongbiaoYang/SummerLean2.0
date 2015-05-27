<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

//$sql = "SELECT id, lname, room_name, floor, building FROM tbl_depts";
$sql = "SELECT p.ProjIndex, p.Title, p.ComIndex, c.CompanyName
	FROM tbl_companies c, tbl_projects p
	WHERE p.ComIndex = c.ComIndex";


?> 

<div class="prepend-1 span-18"> 
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="<?php echo WEB_ROOT; ?>user/add2.php?action=add" method="post" enctype="multipart/form-data" name="frmAddUser" id="frmAddUser">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr align="center" id="listTableHeader"> 
   <td colspan="2">Choose Your Projects</td><td colspan="2">
   </tr>
  <tr>
    <td class="label">Email</td>
    <td class="content"><input name="txtEmail" type="text" id="txtEmail" value="" size="20" maxlength="100" /></td>
  </tr>
  <tr> 
   <td width="150" class="label">Password</td>
   <td class="content"> <input name="txtPassword" type="password" id="txtPassword" value="" size="20" maxlength="100"></td>
  </tr>
  <tr>
    <td class="label">First Name </td>
    <td class="content"><input name="txtFname" type="text" id="txtFname" value="" size="20" maxlength="50" /></td>
  </tr>

	<tr>
    <td class="label">Middle Name </td>
    <td class="content"><input name="txtMname" type="text" id="txtMname" value="" size="20" maxlength="50" />(Optional)</td>
  </tr>  
    
  <tr>
    <td class="label">Last Name </td>
    <td class="content"><input name="txtLname" type="text" id="txtLname" value="" size="20" maxlength="50" /></td>
  </tr>
  
  <tr>
    <td class="label">Second Last Name</td>
    <td class="content"><input name="txt2Lname" type="text" id="txt2Lname" value="" size="20" maxlength="50" />(Optional)</td>
  </tr>  
  
  <tr>
    <td class="label">Full Name</td>
    <td class="content"><input name="txtFullname" type="text" id="txtFullname" value="" size="20" maxlength="50" />(Full name you want to display on your certificate)</td>
  </tr>  
  
  <tr>
    <td class="label">Country </td>
    <td class="content"><select name="cname">
    	<option value=""> --- Choose Your Country--- </option>
	<?php
	$csql = "SELECT * FROM `tbl_countries` WHERE 1 order by code";
	$result = dbQuery($csql);
	while($row = dbFetchAssoc($result)) {
		extract($row);
	?>
	<option value="<?php echo $code; ?>"><?php echo $name; ?></option>
	<?php
	}
	?>
	</select></td>
  </tr>
  
  <tr>
    <td class="label">Date of Birth </td>
    <td class="content"><input name="dob" type="date" id="dob"  size="20" maxlength="20" />
    	(Use format "mm/dd/yyyy" if calendar is not showing)</td>
  </tr>
  
  <tr>
    <td class="label">Semester</td>
    <td class="content"><input name="sem" type="text" id="sem" value="" size="20" maxlength="20" />(How many semesters of your degree have you completed?)</td>
  </tr>
  
   <tr>
    <td class="label">English Level - Writing</td>
    <td class="content">
	<select name="ewrite">
	<?php
	$esql = "SELECT * FROM `tbl_levels` WHERE 1";
	$result = dbQuery($esql);
	while($row = dbFetchAssoc($result)) {
		extract($row);
	?>
	<option value="<?php echo $id; ?>"><?php echo $level; ?></option>
	<?php
	}
	?>
	</select>
	</td>
  </tr>
     <tr>
    <td class="label">English Level - Listening</td>
    <td class="content">
	<select name="elisten">
	<?php
	$esql = "SELECT * FROM `tbl_levels` WHERE 1";
	$result = dbQuery($esql);
	while($row = dbFetchAssoc($result)) {
		extract($row);
	?>
	<option value="<?php echo $id; ?>"><?php echo $level; ?></option>
	<?php
	}
	?>
	</select>
	</td>
  </tr>
     <tr>
    <td class="label">English Level - Speaking</td>
    <td class="content">
	<select name="espeak">
	<?php
	$esql = "SELECT * FROM `tbl_levels` WHERE 1";
	$result = dbQuery($esql);
	while($row = dbFetchAssoc($result)) {
		extract($row);
	?>
	<option value="<?php echo $id; ?>"><?php echo $level; ?></option>
	<?php
	}
	?>
	</select>
	</td>
  </tr>
    
  <tr>
    <td class="label">Gender</td>
    <td class="content">
	<select name="gender">
	<option value="M">Male</option>
	<option value="F">Female</option>
	</select>
	</td>
  </tr>
   
  <tr>
    <td class="label">University</td>
    <td class="content"><input name="univ" type="text" id="univ" value="" size="20" maxlength="50" /></td>
  </tr>
  
  <tr>
    <td class="label">Major</td>
    <td class="content"><input name="maj" type="text" id="maj" value="" size="20" maxlength="50" /></td>
  </tr>
  
	<tr>
    <td class="label">GPA</td>
    <td class="content"><input name="gpa" type="text" id="gpa" value="" size="20" maxlength="50" />(Use this <u><a  target = '_blank' href="http://www.foreigncredits.com/Resources/GPA-Calculator/">LINK</a></u> to calculate your GPA)</td>
  </tr>
  
  <tr><td colspan ="2"><hr></td></tr>
  
  
 </table>
 <p align="center"> 
  <input name="btnAddUser" type="button"   class="button" id="btnAddUser" value="Continue" onClick="checkAddUserForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" class="button"  value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>


</div>
