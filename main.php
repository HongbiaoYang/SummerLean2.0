<?php
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
?>
<style>
.catBox {
	border:#094080 solid 1px;
	float:left;
	background-color:#D2E1E6;
	width:300px;
	margin-right:20px;
	margin-bottom:20px;
	margin-left:20px;
	padding-left:10px;
	padding-top:10px;
	border-radius:10px;
	border-radius:10px;
}

.catBox img.cImage {
	border:0px;
	float:left;
	padding:4px;
}
.catBox a {
	font-size:14px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	color:#094080;
}

.catBox a:hover {color:#FF9966;}
.catBox p {
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	line-height:18px;
}
</style>

<div style="prepend-1 span-18 last">
<p>&nbsp;</p>
<p align="center" style="font-size:16px;font-weight:bold;">Welcome to Project Selection System</p>
<p align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:14px; margin-bottom:40px;">
	</p>

<div class="span-18">
</div>

<div style="span-18">

<?php 

if ($_SESSION["asset_user_type"] == 3)		// show team leaders the team info
{
     echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/team-icon.png\" class=\"cImage\" />
    <a href=\"menu.php?v=TEAM\">View Your Team</a>
    <p>View your team members and the company / projects</p>
    </div>";
}
else if ($_SESSION["asset_user_type"] == 0)		// show students project / teamleader info
{
    echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/ico_projects.png\" class=\"cImage\" width=\"48\" />
    <a href=\"menu.php?v=USER\">View Your Project</a>
    <p>View your project and the teamleader's information</p>
    </div>";
    	
    
    /*
    echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/process-icon.png\" class=\"cImage\" />
    <a href=\"../file/Process Simulator 2014 (9.1.0.2080) CD ROM Setup.exe\">Process Simulator</a>
    <p>Download the Process Simulator software file from here</p>
    </div>";
    */
    
    $sql = 'select surveyed, final_grade from tbl_students where stuindex = ' . $_SESSION["asset_user_id"];
    $result = dbQuery($sql);
		$row = dbFetchAssoc($result);
		extract($row);
    
    if ($surveyed == 0) {
        $showGrade = "N/A";
    } else {
        $showGrade = $final_grade;
    }
    
    echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/grade.png\" class=\"cImage\" width=\"96\" />
    <strong>Your Final Grade:<br/><br/></strong>
    <p>  &nbsp;&nbsp;<font color=\"red\" size=6>$showGrade</font> </p>
    </div>";
    
    
} 
else if ($_SESSION["asset_user_type"] == 4)		// show board menber info
{
 echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/board.png\" class=\"cImage\" />
<a href=\"menu.php?v=BOARD\">View Board Info</a>
<p>View your information as a board member of summer lean program</p>
</div>";
}


if ($_SESSION["asset_user_type"] == 3 || $_SESSION["asset_user_type"] == 0)  // eveybody can change password except admin[2] and utlean[1] (non leader participants)
{
	 echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/password.png\" class=\"cImage\" />
<a href=\"menu.php?v=PWD\">Change Password</a>
<p>Change Your current Password for better security</p>
</div>";

}



?>

<?php if ($_SESSION["asset_user_type"] >= 2)	// only teamleader and admin can see list
{
 echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/view.png\" class=\"cImage\" />
<a href=\"menu.php?v=LIST\">View List</a>
<p>View the student list and their choices of projects</p>
</div>";

/*
echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/process-icon.png\" class=\"cImage\" />
<a href=\"../file/Process Simulator 2014 (9.1.0.2080) CD ROM Setup.exe\">Process Simulator</a>
<p>Download the Process Simulator software file from here</p>
</div>";
*/

}

?>


<?php //if ($_SESSION["asset_user_type"] == 1)	// only utlean see registration
{
 echo "<div class=\"catBox\"><img src=\"".WEB_ROOT."images/create.png\" class=\"cImage\" />
<a href=\"menu.php?v=ADD\">Create New Account</a>
<p>View the student list and their choices of projects</p>
</div>";
}
?>



<div class="catBox">
<img src="<?php echo WEB_ROOT; ?>images/goback.png" class="cImage" />
<a href="http://utlean.utk.edu/current">Go Back</a>
<p>Go back to the UT lean main page of Lean Summer Program</p>

</div>


</div>


</div>
<p>&nbsp;</p><p>&nbsp;</p>
