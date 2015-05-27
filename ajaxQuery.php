<?php 

$id = $_GET['id'];
if ($id == "")
{
	return;
}
else if ($id == "firstname" || $id == "lastname")
{
	echo "<input name=\"ckey\" id=\"ckey\"  value=\"\" size=\"20\" maxlength=\"100\" \\>";
	return;
}
else
{
	$dbHost = 'localhost';
	$dbUser = 'lean';
	$dbPass = 'lean2015';
	$dbName = 'lean';

	$dbConn = mysqli_connect ($dbHost, $dbUser, $dbPass, $dbName) or die ('MySQL connect failed. ' . mysqli_error());
	
	
		if ($id == "ProjIndex")
	  {
			$psql =  "SELECT p.ProjIndex as skey, p.Title as svalue
								FROM tbl_projects p
								WHERE 1";
		}
		else if ($id == "ComIndex")
		{
			$psql =  "SELECT c.ComIndex as skey, c.CompanyName as svalue
								FROM tbl_companies c
								WHERE 1";
		}
		else if ($id == "Team")
		{
			$psql = "SELECT t.leaderIndex as skey, concat(t.firstname, \" \", t.lastname) as svalue
							 From tbl_teamleaders t
							 Where 1";
		}
		else if ($id == "Country")
		{
			$psql = "SELECT n.code as skey, n.name as svalue
							 From tbl_countries n
							 Where 1";
		}
			
		$result = mysqli_query($dbConn ,$psql);
		$data = "<select name=\"ckey\" id=\"ckey\">";

		while($row = mysqli_fetch_assoc($result)){
			extract($row);
			$data .= "<option value=\"$skey\">".$svalue."</option>";
		}
		$data .="</select>";
	
	
	echo $data;
}


?>
