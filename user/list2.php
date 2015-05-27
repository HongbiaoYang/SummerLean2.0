   
<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql0 = "SELECT u.uid, u.uname, u.email, u.fname, u.lname
	FROM tbl_users u
	WHERE u.uid = ".$_SESSION['asset_user_id'].
	" ORDER BY uname;";

$sql =	"SELECT `t`.`FirstName` as t_first , `t`.`LastName` as t_last, t.leaderindex, "
				."`t`.`Email` as t_email, `t`.`Biography` as bio, `Pic`, s.StuIndex, s.Email as s_email, "
				." s.FirstName as s_first, s.netid, s.tnid, s.LastName as s_last, s.LastName2 as s_last2, s.verify, "
				." s.MiddleName as s_middle, s.fullName as s_full, r.trip_amazon, r.trip_toyota, r.trip_vw, "
				." r.trip_aqua, r.trip_neyland, r.present, r.sim1, r.sim2, r.sit, r.simqa, r.final_campus, r.final_company , "
				."  n.name as country, p.title as title, c.CompanyName as company "
		    ." FROM `tbl_teamleaders` `t` , `tbl_students` `s` , `tbl_projects` `p` ,  "
		    ." tbl_trips r, `tbl_companies` `c`, `tbl_countries` `n` "
		    ."WHERE 1\n"
		    ."AND t.LeaderIndex = c.teamleader and p.Comindex = c.ComIndex and r.stuindex = s.stuindex "
		    ."and n.code = s.nationality and s.Team = p.projIndex and s.StuIndex = "
     		.$_SESSION['asset_user_id'];


$amazon = array(
		0 => "TBD",
		11 => "Trip 1a, leaves at 7:30 AM, July 21, Driver: Kaveri",
		12 => "Trip 1b, leaves at 7:30 AM, July 21, Driver: Ali",
		13 => "Trip 1c, leaves at 7:30 AM, July 21, Driver: Girish",
		14 => "Trip 1d, leaves at 7:30 AM, July 21, Driver: Dhanush",
		21 => "Trip 2a, leaves at 7:30 AM, July 28, Driver: Enrique",
		22 => "Trip 2b, leaves at 7:30 AM, July 28, Driver: Ryan",
		31 => "Trip 3a, leaves at 10:30 AM, July 28, Driver: Abhishek",
		32 => "Trip 3b, leaves at 10:30 AM, July 28, Driver: Vahid",
		33 => "Trip 3c, leaves at 10:30 AM, July 28, Driver: Dinesh",
		41 => "Trip 4a, leaves at 12:30 AM, July 28, Driver: Bharadwaj",
		42 => "Trip 4b, leaves at 12:30 AM, July 28, Driver: MohammedAli",
		43 => "Trip 4c, leaves at 12:30 AM, July 28, Driver: Jason",
);

$toyota = array(
		0 => "TBD",
    1 => "Trip 1, leaves at 7:00 AM, July 11",
    2 => "Trip 2, leaves at 9:00 AM, July 11",
);


$vw = array(
		0 => "TBD",
		11 => "Trip 1a, leaves at 6:30 AM, July 21, Driver: Mostafa",
		12 => "Trip 1b, leaves at 6:30 AM, July 21, Driver: Enrique",
		2  => "Trip 2, leaves at 9:00 AM, July 21, Driver: MohammedAli",
		31 => "Trip 3a, leaves at 11:00 AM, July 21, Driver: Ryan",
		32 => "Trip 3b, leaves at 11:00 AM, July 21, Driver: Dinesh",
		41 => "Trip 4a, leaves at 6:30 AM, July 28, Driver: Vahid",
		42 => "Trip 4b, leaves at 6:30 AM, July 28, Driver: Abhishek",
		51 => "Trip 5a, leaves at 9:00 AM, July 28, Driver: Ali",
		52 => "Trip 5b, leaves at 9:00 AM, July 28, Driver: Jason",
    61 => "Trip 6a, leaves at 11:00 AM, July 28, Driver: Wolday",
    62 => "Trip 6b, leaves at 11:00 AM, July 28, Driver: Dhanush",
    63 => "Trip 6c, leaves at 11:00 AM, July 28, Driver: Ninad",
);

$aquarium = array(
		0 => "Not going",
		1 => "Leaving at 8:30 AM on July 26, Saturday to Gatlinburg, TN",
);

$neyland = array(
		0 => "TBD",
		1 => "Trip 1, 12:30 PM ~ 1:45 PM, July 24, ",
		2 => "Trip 2, 1:45 PM ~ 3:00 PM, July 24, ",
		3 => "Trip 3, 3:00 PM ~ 4:15 PM, July 24, ",
);


$schedule_time = array(    
    0 => "TBD",
		1 => "8:00 AM, July 18, Friday",
		2 => "9:30 AM, July 18, Friday",
		3 => "11:00 AM, July 18, Friday",
		4 => "8:00 AM, July 22, Tuesday",
		5 => "9:30 AM, July 22, Tuesday",
		6 => "11:00 AM, July 22, Tuesday"
);

$schedule_simqa =  array(    
    0 => "TBD",
		1 => "1:20 PM ~ 2:50 PM, July 24, Thursday",
		2 => "3:00 PM ~ 4:30 PM, July 24, Thursday",
		3 => "4:30 PM ~ 6:00 PM, July 24, Thursday",
); 

$schedule_final_campus = array(
    0 => "TBD",
		6 => "3:00 PM, July 30, Wednesday",
		18 => "3:25 PM, July 30, Wednesday",
		11 => "3:50 PM, July 30, Wednesday",
		23 => "4:15 PM, July 30, Wednesday",
		9 => "4:40 PM, July 30, Wednesday",
		21 => "5:05 PM, July 30, Wednesday",
		1 => "8:00 AM, July 31, Thursday",
		13 => "8:25 AM, July 31, Thursday",
		2 => "8:50 AM, July 31, Thursday",
	 14 => "9:15 AM, July 31, Thursday",
	 3 => "9:40 AM, July 31, Thursday",
	 15 => "10:05 AM, July 31, Thursday",
	 4 => "10:30 AM, July 31, Thursday",
	 16 => "10:55 AM, July 31, Thursday",
	 7 => "11:20 AM, July 31, Thursday",
	 19 => "11:45 AM, July 31, Thursday",
	 5 => "2:05 PM, July 31, Thursday",
	 8 => "2:30 PM, July 31, Thursday",
	 20 => "2:55 PM, July 31, Thursday",
	 10 => "3:20 PM, July 31, Thursday",
	 22 => "3:45 PM, July 31, Thursday",
	 12 => "4:10 PM, July 31, Thursday",
	 24 => "4:35 PM, July 31, Thursday",
);


$schedule_final_company = array (
    11 => "10:30 AM - 11:30 AM, July 31, Thursday",
    3	 => "11:00 AM - 12:00 NOON, July 31, Thursday",
    12 => "8:00 AM - 9:00 AM, August 1, Friday",
    10 => "9:00 AM - 10:00 AM, August 1, Friday",
    7	 => "9:00 AM - 10:00 AM, August 1, Friday",
    6	 => "9:00 AM - 10:00 AM, August 1, Friday",
    9	 => "9:00 AM - 10:00 AM, August 1, Friday",
    8	 => "10:00 AM - 11:00 AM, August 1, Friday",
    1	 => "10:00 AM - 11:00 AM, August 1, Friday",
    2	 => "10:00 AM - 11:30 AM, August 1, Friday",
    5	 => "10:40 AM - 11:40 AM, August 1, Friday",
    4	 => "10:00 AM - 11:00 NOON, August 1, Friday",
);


?> 
<div class="prepend-1 span-17">
<p>&nbsp;</p>
<h2 class="catHead">Projects Information</h2>
<p><img src="images/ico_projects.png" class="left" width="72"/>
	<p class="errorMessage"><?php echo $errorMessage; ?></p>
<strong>This page shows the projects selection information</strong>
<br/>

<?php 
	
		$result = dbQuery($sql);
		$row = dbFetchAssoc($result);
		extract($row);

		echo "Your projetcs and team leader information is as below:"?>




 <table  border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <td><?php echo "Project Information";
   	?></td>
    </tr>

  <tr class="<?php echo $class; ?>"> 
  <td width=160><?php echo "Full Name:";?></td>
   <td><?php 
   		echo ucfirst($s_first);
   		if ($s_middle) echo " ".$s_middle; 
   		echo " ".$s_last; 
   		if ($s_last2)  echo " ".$s_last2;
	  ?>	    
   	</td>
 </tr>
 
 <tr>
 	<td><?php echo "Email:";?></td>
 	<td align="center"><a href="mailto:<?php echo $s_email; ?>"><?php echo $s_email; ?></a></td>
 	</tr>

  <tr>
 	<td><?php echo "Country:";?></td>
 	<td align="center"><?php echo $country; ?></td>
 	</tr>


<tr>
 	<td><?php echo "Name on Certificate:";?></td>
 	<td align="center"><?php echo $s_full."  "; 
 	    if ($verify == 0)
 	    {
 	        echo  "<form action=\"".WEB_ROOT."user/processUser.php?action=verify\" method=\"post\"  name=\"frmAddUser\" id=\"frmAddUser\" onsubmit=\"return verifyName();\">";
 	        // echo "<a href=javascript:verifyName()> <u>Authorize</u></a>"; 	            
 	        echo "<input name=\"btnAddUser\" type=\"submit\"  id=\"btnAddUser\" value=\"Authorize\" >";
 	        echo  " <u><a href=\"menu.php?v=RENAME\">Modify</a></u>";
 	        echo "</form>";
 	        
 	        //echo "form action=".WEB_ROOT."user/processUser.php?action=verify  method=\"post\"  name=\"frmAddUser\" id=\"frmAddUser\"";
        
 	    }
 	    else
 	    {
 	        echo "<u><strong><font color =\"green\"> Authorized</font></strong></u></td>";
 	    }
 	    ?>
 	</tr>
 	
 	<tr>
 	<td><a target="_blank" href="https://oit.utk.edu/accounts/net-id/" >NetID</a>:</td>  
 	<td align="center"><?php echo $netid; ?>  (<a target="_blank" href="https://directory.utk.edu/setup">Setup Password</a>)</td>
 	</tr>

	<tr>
	<td>TNID:</td>
	<td><?php echo $tnid; ?></td>
	
	</tr>

	<tr> <td colspan=2><hr></td></tr>
	<td>Project</td>
 	 	<td align="center"><?php echo $title; ?></td>
 	</tr>
 	
 	<tr>
 	<td>Company</td>
 	 	<td align="center"><?php echo $company; ?></td>
 	</tr>
	 	
	 	<tr> <td colspan=2><hr></td></tr>
	<tr> <td colspan=2><strong ><font size="3" color="lightgray">
 	    Online session information
 	    </font></strong>
 	    <span groupshow="1"  id="hid4" onClick="toggle('nameit4');" > 
 	        <font size="3" color="blue"><u>Hide</u></font></span><br/><br/> 
 	    </td></tr>
 	    
	
 	<tr group-s="4"  nameit4="fred" id="hidethis"> <td>Online Session:</td><td><a target="_blank" href="https://bblearn.utk.edu/webapps/bb-collaborate-BBLEARN/launchSession/guest?uid=503f664d-5543-447d-9035-420d4bb01294">https://bblearn.utk.edu/webapps/bb-collaborate-BBLEARN/launchSession/guest?uid=503f664d-5543-447d-9035-420d4bb01294</a></td></tr>
 	<tr group-s="4" nameit4="fred" id="hidethis"> <td>System Requirements</td><td>Click <a target="_blank" href="https://oit.utk.edu/instructional/tools/liveonline/Pages/Collaborate-Requirements.aspx">HERE</a> to see if your computer meets the system requirements</td></tr>
 	
	 	
	 	<tr> <td colspan=2><hr></td></tr>
	 	
	 	
	 	
	 	 	<tr> <td colspan=2><strong ><font size="3" color="lightgray">
 	    Your schedules for company visits and trips </font></strong>
 	    <span groupshow="1" id="hid1" onClick="toggle('nameit');"> 
 	        <font size="3" color="blue"><u>Hide</u></font></span><br/><br/> 
 	    </td></tr>
 	    
  <tr  group-s="1" nameit="fred" id="hidethis">
	<td>Trip Toyota:</td>
 	 	<td align="center"><?php 
 	 		echo $toyota[$trip_toyota];
 	 		?></td>
 	</tr>
 		
  <tr group-s="1" nameit="fred" id="hidethis">
	<td>Trip Amazon:</td>
 	 	<td align="center"><?php 
 	 		echo $amazon[$trip_amazon];
 	 		?></td>
 	</tr>
 	
 	<tr group-s="1" nameit="fred" id="hidethis">
	<td>Trip Volkswagen:</td>
 	 	<td align="center"><?php 
 	 		echo $vw[$trip_vw];
 	 		?></td>
 	</tr>
 	
 	<div id="Layer1" style="display: none; position: absolute; z-index: 100;">
    </div>
    
  <tr group-s="1" nameit="fred" id="hidethis">
	<td>Trip  <a href="" onmouseout="hiddenPic();" onmousemove="showPic(event,'images/neyland-gate.jpg');">
            Neyland Stadium</a>:</td>
 	 	<td align="center"><?php 
 	 		echo $neyland[$trip_neyland];
 	 		?>
 	 		
        <a href="" onmouseout="hiddenPic();" onmousemove="showPic(event,'images/Gate21-final-hdr.jpg');">
            Gate 21</a>
</td>
 	</tr>
 	
	<tr group-s="1" nameit="fred" id="hidethis">
	<td>Trip Aquarium:</td>
 	 	<td align="center"><?php 
 	 		echo $aquarium[$trip_aqua];
 	 		?></td>
 	</tr>
 	

 	<tr> <td colspan=2><hr></td></tr>
 	
 	<tr> <td colspan=2><strong ><font size="3" color="lightgray">
 	    Your schedules for middle-term presentation and simulation class
 	    </font></strong>
 	    <span groupshow="1" id="hid2" onClick="toggle('nameit2');" > 
 	        <font size=groupid="1" "3" color="blue"><u>Hide</u></font></span><br/><br/> 
 	    </td></tr>
 	    
 		<tr group-s="2" nameit2="fred" id="hidethis" >
 	<td>Your Presentation:</td>
 	 	<td align="center"><?php 
 	 		echo $schedule_time[$present]." in Tickle 405";
 	 		?></td>
 	</tr>
 	
 	 		<tr group-s="2" nameit2="fred" id="hidethis" >
 	<td>Watch Others' Presentation:</td>
 	 	<td align="center"><?php 
 	 		echo $schedule_time[$sit]." in Tickle 405";
 	 		?></td>
 	</tr>
 	
 		<tr group-s="2" nameit2="fred" id="hidethis" >
 	<td>1st Simulation Class:</td>
 	 	<td align="center"><?php 
 	 		echo $schedule_time[$sim1]." in Tickle 402";
 	 		?></td>
 	</tr>
 	
 		<tr group-s="2" nameit2="fred" id="hidethis" >
 	<td>2nd Simulation Class:</td>
 	 	<td align="center"><?php 
 	 		echo $schedule_time[$sim2]." in Tickle 402";
 	 		?></td>
 	</tr>
			<tr group-s="2"  nameit2="fred" id="hidethis">
 	<td>Simulation Q&A Class:</td>
 	 	<td align="center"><?php 
 	 		echo $schedule_simqa[$simqa]." in SERF 307";
 	 		?></td>
 	</tr>
 	
 	<tr> <td colspan=2><hr></td></tr>
 	<tr> <td colspan=2><strong ><font size="3" color="orange">
 	    Your schedules for final presentations:
 	    </font></strong>
 	    <span grouphide="1" hide="0" id="hid3" onClick="toggle('nameit3');" > 
 	        <font size="3" color="blue"><u>Hide</u></font></span><br/><br/> 
 	    </td></tr>
 	    
 		<tr group-h="3" nameit3="fred" id="hidethis" >
 	<td>Final Presentation at Campus:</td>
 	 	<td align="center"><?php 
 	 		echo $schedule_final_campus[$final_campus]. " @Tickle 500";
 	 		?></td>
 	</tr>
 	<tr group-h="3" nameit3="fred" id="hidethis" >
 	<td>Final Presentation at Company:</td>
 	 	<td align="center"><?php 
 	 		echo "<font >".$schedule_final_company[$leaderindex]. "</font> @".$company;
 	 		?></td>
 	</tr>
	
	<tr> <td colspan=2><hr></td></tr>
 	
 	<tr>
	<td><?php echo "Team Leader:";?></td>
 	 	<td align="center"><?php echo $t_first." ".$t_last; ?></td>
 	</tr>
 	
 	<tr>
 	<td><?php echo "Email:";?></td>
 	<td align="center"><a href="mailto:<?php echo $t_email; ?>"><?php echo $t_email; ?></a></td>
 	</tr>

	 <tr>
 	<td><?php echo "Biography:";?></td>
 	<td align="center"><?php echo $bio; ?></td>
 	</tr>
 	
  	<tr>
 	<td><?php echo "Profile:";?></td>
 	
 	<td align="center"><img src="images/teamleader/<?php echo $Pic?>" class="left" height="240"/></td>
 	</tr>
 	
 	
 	

  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
  	<?php //if ($_SESSION["asset_user_type"] >= 1)
   			//echo '<td colspan="5" align="right"><input name="btnAddUser" type="button" id="btnAddUser" value="Choose Your Projects"  class="button" onClick="addUser()"></td>';
  	?>
  </tr>
 </table>
 <p>&nbsp;</p>
</div>

<script>
 // initialize the section hidden. Set the default switch status / text
 spans = document.getElementsByTagName('span');
 for (i=0;i<spans.length;i++) {
    if (spans[i].getAttribute('groupshow')) {
        spans[i].innerHTML = "<font size=\"3\" color=\"blue\"><u>Show</u></font></span>";
    } else if (spans[i].getAttribute('grouphide')) {
        spans[i].innerHTML = "<font size=\"3\" color=\"blue\"><u>Hide</u></font></span>";
    }
 }
 
 tr=document.getElementsByTagName('tr')
 for (i=0;i<tr.length;i++){
  if (tr[i].getAttribute('group-s')){
    tr[i].style.display = 'none';
  } else if (tr[i].getAttribute('group-s')) {
    tr[i].style.display = '';
  }
 }
 
   
</script>