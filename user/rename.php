<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql = "SELECT fullname from tbl_students WHERE 1 and stuindex = " . $_SESSION['asset_user_id']; 
$result = dbQuery($sql);
$row = dbFetchAssoc($result);
extract($row);

?> 

<div class="prepend-1 span-18"> 
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="<?php echo WEB_ROOT; ?>user/processUser.php?action=rename" method="post" enctype="multipart/form-data" name="frmAddUser" id="frmAddUser">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr>
    <td width="200" class="label">Enter your Password:</td>
    <td class="content"><input name="oldpass" type="password" id="oldpass" value="" size="50" maxlength="100" /></td>
  </tr>
  <tr> 
   <td width="200" class="label">Enter your name on certificate:</td>
   <td class="content"> <input name="newname" id="newname" value="<?php echo $fullname;?>" size="50" maxlength="100"></td>
  </tr>

  
 </table>
 <p align="center"> 
  <input name="btnAddUser" type="button"   class="button" id="btnAddUser" value="Confirm" onClick="changefullname();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" class="button"  value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>


</div>
