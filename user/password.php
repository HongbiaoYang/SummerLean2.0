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
<form action="<?php echo WEB_ROOT; ?>user/processUser.php?action=pwd" method="post" enctype="multipart/form-data" name="frmAddUser" id="frmAddUser">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr>
    <td width="200" class="label">Enter your current Password:</td>
    <td class="content"><input name="oldpass" type="password" id="oldpass" value="" size="20" maxlength="100" /></td>
  </tr>
  <tr> 
   <td width="200" class="label">Enter your new Password:</td>
   <td class="content"> <input name="newpass1" type="password" id="newpass1" value="" size="20" maxlength="100"></td>
  </tr>
  
  <tr> 
   <td width="200" class="label">Enter your new Password again:</td>
   <td class="content"> <input name="newpass2" type="password" id="newpass2" value="" size="20" maxlength="100"></td>
  </tr>
  
 </table>
 <p align="center"> 
  <input name="btnAddUser" type="button"   class="button" id="btnAddUser" value="Confirm" onClick="checkPassword();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" class="button"  value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>


</div>
