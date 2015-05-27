<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql0 = "SELECT u.uid, u.uname, u.email, u.fname, u.lname
	FROM tbl_users u
	WHERE u.uid = ".$_SESSION['asset_user_id'].
	" ORDER BY uname;";

$sql = "Select s.StuIndex, s.Email, s.FirstName, s.LastName, s.LastName2, 
				s.MiddleName, s.fullName,  s.Choice1, s.Choice2, s.Choice3, s.Choice4
				From tbl_students s
				Where s.StuIndex = ".$_SESSION['asset_user_id'];


$result = dbQuery($sql); 

?> 
<div class="prepend-1 span-17">
<p>&nbsp;</p>
<h2 class="catHead">Projects Selection</h2>
<p><img src="images/users.png" class="left"/>
	<p class="errorMessage"><?php echo $errorMessage; ?></p>
<strong>This page shows the projects selection information</strong>
<br/>
<?//php echo " test".$_SESSION['asset_user_id']."test"
?>
<?//php echo " test".$sql."test "
?>
<?php 

		$row = dbFetchAssoc($result);
		extract($row);

if ($_SESSION["asset_user_type"] >= 1)
	echo "You haven't choose any projects yet. Please make your choices.";
else
	echo "You have already chosen your projects, here are your choices:"?>
</p>

<form action="processUser.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">
 <table  border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <td><?php if ($_SESSION["asset_user_type"] == 0) echo "Project Choices";
   					 else echo "Make your choices";
   	?></td>
    </tr>

  <tr class="<?php echo $class; ?>"> 
  <td><?php if ($_SESSION["asset_user_type"] == 0) echo "Full Name:";?></td>
   <td><?php 
   	if ($_SESSION["asset_user_type"] == 0) 
   		{
	   		echo ucfirst($FirstName);
	   		if ($MiddleName) echo " ".$MiddleName; 
	   		echo " ".$LastName; 
	   		if ($LastName2)  echo " ".$LastName2;
	   	}
	   		?>
   	</td>
 </tr>
 
 <tr>
 	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "Email:";?></td>
 	<td align="center"><a href="mailto:<?php echo $Email; ?>"><?php if ($_SESSION["asset_user_type"] == 0) echo $Email; ?></a></td>
 	</tr>

  <tr>
 	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "Country:";?></td>
 	<?php $nsql = "Select c.name, c.code
 								From tbl_countries c, tbl_students s
 								Where s.Nationality = c.code and s.StuIndex = ".$StuIndex;
 								$nresult = dbQuery($nsql);
 								$nrow = dbFetchAssoc($nresult);
 								extract($nrow);	
 								
 	?>
 	<td align="center"><?php if ($_SESSION["asset_user_type"] == 0) echo $name; ?></td>
 	</tr>


<tr>
 	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "Name on Certificate:";?></td>
 	<td align="center"><?php if ($_SESSION["asset_user_type"] == 0) echo $fullName; ?></td>
 	</tr>

 	
 	<tr>
	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "1st Choice:";?></td>
 	<?php $csql = "SELECT p.Title, c.CompanyName
		FROM tbl_projects p, tbl_companies c
		WHERE p.ComIndex = c.ComIndex
		AND p.ProjIndex = ".$Choice1;
		$cresult = dbQuery($csql);
		
		$crow = dbFetchAssoc($cresult);
		extract($crow);		
		
		?>		
 	<td align="center"><?php if ($_SESSION["asset_user_type"] == 0) echo $Title."(".$CompanyName.")"; ?></td>
 	</tr>
 	
 	<tr>
 	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "2nd Choice:";?></td>
 	<?php $csql = "SELECT p.Title, c.CompanyName
		FROM tbl_projects p, tbl_companies c
		WHERE p.ComIndex = c.ComIndex
		AND p.ProjIndex = ".$Choice2;
		$cresult = dbQuery($csql);
		$crow = dbFetchAssoc($cresult);
		extract($crow);				
		?>
 	<td align="center"><?php if ($_SESSION["asset_user_type"] == 0) echo $Title."(".$CompanyName.")"; ?></td>
 	</tr>

	 <tr>
 	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "3rd Choice:";?></td>
 	<?php $csql = "SELECT p.Title, c.CompanyName
		FROM tbl_projects p, tbl_companies c
		WHERE p.ComIndex = c.ComIndex
		AND p.ProjIndex = ".$Choice3;
		$cresult = dbQuery($csql);
		$crow = dbFetchAssoc($cresult);
		extract($crow);				
		?>
 	<td align="center"><?php if ($_SESSION["asset_user_type"] == 0) echo $Title."(".$CompanyName.")"; ?></td>
 	</tr>
 	
  	<tr>
 	<td><?php if ($_SESSION["asset_user_type"] == 0) echo "4th Choice:";?></td>
 	<?php $csql = "SELECT p.Title, c.CompanyName
		FROM tbl_projects p, tbl_companies c
		WHERE p.ComIndex = c.ComIndex
		AND p.ProjIndex = ".$Choice4;
		$cresult = dbQuery($csql);
		$crow = dbFetchAssoc($cresult);
		extract($crow);				
		?>
 	<td align="center"><?php if ($_SESSION["asset_user_type"] == 0) echo $Title."(".$CompanyName.")"; ?></td>
 	</tr>
 	
 	
 	

  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
  	<?php if ($_SESSION["asset_user_type"] >= 1)
   			echo '<td colspan="5" align="right"><input name="btnAddUser" type="button" id="btnAddUser" value="Choose Your Projects"  class="button" onClick="addUser()"></td>';
  	?>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>
</div>
