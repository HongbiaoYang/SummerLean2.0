<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$fkey = (isset($_GET['key']) && $_GET['key'] != '') ? $_GET['key'] : '&nbsp;';
$fvalue = (isset($_GET['value']) && $_GET['value'] != '') ? $_GET['value'] : '&nbsp;';

$condition = "";

if ($fkey == '' || $fkey == '&nbsp;')
{
	$condition = "";
}
else 
{
	if ($fkey == "firstname" || $fkey == "lastname")
	{
		$condition = " And s.".$fkey." = '".$fvalue."'";	
	}
	else if ($fkey == "ComIndex")
	{
		$condition = " And c.".$fkey." = ".$fvalue;	
	}
	else if ($fkey == "ProjIndex")
	{
		$condition = " And p.projIndex = ".$fvalue;	
	}
	else if ($fkey == "Team")
	{
		$condition = " And t.leaderindex = ".$fvalue;	
	}
	else if ($fkey == "Country")
	{
		$condition = " And n.code = ".$fvalue;			
	}
}



$sql = "SELECT s.firstname as s_first, s.lastname as s_last, s.fullname as fname, "
        . " s.email as s_email, s.netid, s.tnid, s.university, "
			  . " p.projindex as pid, p.title, c.companyname, n.name as countryname, t.firstname as t_first, "
			  . " t.lastname as t_last "
			  . " FROM tbl_students s, tbl_projects p, tbl_countries n, " 
			  . " tbl_companies c, tbl_teamleaders t  "
			  . " WHERE 1 And s.team = p.projIndex and p.ComIndex = c.ComIndex and  "
			  . " c.teamleader = t.leaderindex and n.code = s.nationality and s.rank = 0 ".$condition;

$result = dbQuery($sql);

$total = mysqli_num_rows($result);

if(!isset($_GET["page"])) //whether get page parameter
{
	$thispage = 1; // use 1 by default
}
else
{
	$thispage = $_GET["page"];
}

$perpage = 200; // records per page
$limit = $perpage*($thispage-1); //start position

?> 

<script language="javascript">
	function showOption(id){

		$.get("ajaxQuery.php",
			{id: id},
			function(data){
				$("div#type").html(data);
			},
			"html");
	}

</script>



<form action="<?php echo WEB_ROOT; ?>user/processUser.php?action=list" method="post" enctype="multipart/form-data" name="frmAddUser" id="frmAddUser">
<div class="prepend-1 span-17">
<table>
<tr>
<td colspan = "2">
<strong>List of students and projects informatoin</strong>
<?php //echo $sql;
?>
<br>
You can view the list of student information by different category.
<?php // echo $condition;
?>
</td>
<td>
<p><img src="<?php echo WEB_ROOT; ?>images/filter.png" class="right"/>
</td>
</tr>
<tr>
	<td>
	<select name="cate" onchange="showOption(this.value)">
		<option value="">--Show All--</option>		
		<option value="ProjIndex">By Project</option>
		<option value="ComIndex">By Company</option>
		<option value="Team">By Teamleader</option>
		<option value="Country">By Country</option>
		<option value="firstname">By First Name</option>
		<option value="lastname">By Last Name</option>
		</select>
	</td>
		
	<td colspan="1" align="left"><div id="type"></div>	</td>
	<td colspan="1" align="left">
		<input name="filter" type="submit" id="filter" value="Filter" class="button">
		</td>
</tr>
</table>
</form>
<?php


$nsql = $sql. " order by t.porder, pid ";
		
$result = dbQuery($nsql);

?>

 <table  border="0" align="left" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <!--
   <td>Name</td>
   <td>NetID</td>
   <td>TN ID</td>
   <td>Email</td>
   <td>Project</td>   
   <td>Company</td>
   <td>Country</td>
   <td>Teamleader</td>
   -->
   <td>Teamleader</td>
   <td>ProjectIndex</td>
   <td>Name</td>
   <td>University</td>
   
  </tr>
<?php
$order = 1;
while($row = dbFetchAssoc($result)) {
	extract($row);
	
	if ($i%2) {
		$class = 'row1';
	} else {
		$class = 'row2';
	}
	$i += 1;
?>
   <tr class="<?php echo $class; ?>"> 
  
   <td align="center"><?php echo $t_first." ".$t_last; ?></td>
   <td align="center"><?php echo $pid; ?></td>
   <td align="center"><?php echo $fname; ?></td>
   <td align="center"><?php echo $university; ?></td>
    <!--
   <td align="center"><?php echo $fname; ?></td>
   <td align="center"><?php echo $netid; ?></td>
   <td align="center"><?php echo $tnid; ?></td>
   <td align="center"><?php echo $s_email; ?></td>
   <td align="center"><?php echo $title; ?></td>   
   <td align="center"><?php echo $companyname; ?></td>
   <td align="center"><?php echo $countryname; ?></td>
   <td align="center"><?php echo $t_first." ".$t_last; ?></td>
   -->
   
  </tr>
  <?php 
  } // end of while
  
  ?>
  <tr> 
   <td colspan="3">&nbsp;</td>
  </tr>
 </table> 

	 <tr><td colspan = "3"><?php page($total, $perpage, $thispage,"?v=LIST&page=");?></td></tr>
	 <br>
     <tr><td colspan="1" align="right">
     	<input name="btnSendOrder" type="button" id="btnSendOrder" value="Back" class="button" onClick="BacktoList()">
     	</td></tr>

 
	<!--  <FONT COLOR="blue"><?php echo "-".$fkey."-".$fvalue."-";?></FONT><br> !-->
<p>&nbsp;</p>
</div>

