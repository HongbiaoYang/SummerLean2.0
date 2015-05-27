<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql_leader = "SELECT t.firstname as t_first, t.lastname as t_last, "
		. " t.email as t_email, t.pic as pic, t.biography as bio, "
		. " r.trip_amazon, r.trip_toyota, r.trip_vw, r.trip_aqua, r.trip_neyland "
    . " FROM tbl_students s, tbl_teamleaders t, tbl_trips r \n"
    . " WHERE 1 And t.leaderindex = s.team  and s.stuIndex = r.stuIndex and  s.stuIndex = "
    . $_SESSION['asset_user_id'];

$sql_project = " SELECT p.ProjIndex as pid, p.title as title, c.companyname as company, "
		. " t.firstname as t_first, t.lastname as t_last, t.email as t_email, t.leaderindex "
		. " FROM tbl_projects p, tbl_companies c, tbl_students s, tbl_teamleaders t"
		. " WHERE 1 And t.leaderindex = s.team and p.ComIndex = c.ComIndex and "
		. " c.teamleader = t.leaderindex and s.stuIndex = "
    . $_SESSION['asset_user_id'];




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
    1 => "Trip 1, leaves at 7 AM, July 11",
    2 => "Trip 2, leaves at 9 AM, July 11",
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

$schedule_final = array(
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


$aquarium = array(
		0 => "TBD",
);

$neyland = array(
		0 => "TBD",
);


?> 
<div class="prepend-1 span-17">
<p>&nbsp;</p>
<h2 class="catHead">Projects Information</h2>
<p><img src="images/users.png" class="left"/>
	<p class="errorMessage"><?php echo $errorMessage; ?></p>
<strong>This page shows your team and projects information</strong>
<br/>

<?php 
	
		$result_leader = dbQuery($sql_leader);
		$row_leader = dbFetchAssoc($result_leader);
		extract($row_leader);

		echo "Your projetcs and team members information is as below:"?>

 <table  border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <td colspan = "2"><?php echo "Team Information";
   	?></td>
    </tr>


  <tr class="<?php echo $class; ?>"> 
  <td><?php echo "Your Name:";?></td>
   <td><?php 
   		echo ucfirst($t_first)." ".ucfirst($t_last); 
	  	?>
   	</td>
 </tr>
 
 	<tr>
 	<td>Email:</td>
 	<td align="center"><a href="mailto:<?php echo $t_email; ?>"><?php echo $t_email; ?></a></td>
 	</tr>
 	<tr>
 	 	<td align="center"><p><img src="images/teamleader/<?php echo $pic; ?>" class="left" height = "240"/></td>
 		<td align="left"><?php echo $bio; ?></td>
 	</tr>
 	
 	 	<tr> <td colspan=2><hr></td></tr>
	 	
	 	
	<td>Trip Toyota:</td>
 	 	<td align="center"><?php 
 	 		echo $toyota[$trip_toyota];
 	 		?></td>
 	</tr>
 		
	<td>Trip Amazon:</td>
 	 	<td align="center"><?php 
 	 		echo $amazon[$trip_amazon];
 	 		?></td>
 	</tr>
 	
	<td>Trip Volkswagen:</td>
 	 	<td align="center"><?php 
 	 		echo $vw[$trip_vw];
 	 		?></td>
 	</tr>
 	
	<td>Trip Aquarium:</td>
 	 	<td align="center"><?php 
 	 		echo $aquarium[$trip_aqua];
 	 		?></td>
 	</tr>
 	
	<td>Trip Neyland Stadium:</td>
 	 	<td align="center"><?php 
 	 		echo $neyland[$trip_neyland];
 	 		?></td>
 	</tr>
 	
 	
 	
</table>
  
  <?php
  	$result_project = dbQuery($sql_project);
  	
  	$i = 0;
  	
  while($row_project = dbFetchAssoc($result_project)) {  // get each project for this teamleader
 				extract($row_project);
   			$i++;		
   	?>
  <tr>
	 	<td><strong><?php echo "Project ".$i;?></strong></td>
	 	<td align="center"><?php echo $title."(".$company.")"; ?></td>
 	</tr>
   
    <?php
 		$sql_stu =  "SELECT s.Email as s_email, s.fullName, c.name as country, s.Semester, s.EnglishWrite, "
    . " s.EnglishListen, s.EnglishSpeak, s.Gender, s.University, s.Major, s.GPA, "
    .	" s.netid, s.tnid, s.verify  "
    . " FROM tbl_students s, tbl_countries c"
    . " WHERE 1 and s.nationality = c.code and s.rank = 0 and Team = ".$pid;
		
		$result_stu = dbQuery($sql_stu);
	
	?>
	
	 <table  border="0" align="center" cellpadding="2" cellspacing="1" class="text">
	 	<tr align="center" id="listTableHeader"> 
	 		<td>Full Name</td>
	 		<td>Email</td>
	 		<td>NetID</td>
			<td>TNID</td>
	 		<td>Country</td>
	 		<td>Gender</td>
	 		<td>Name Verify</td>

	 		</tr>
	<?php
		while ($row_stu = dbFetchAssoc($result_stu)) {
				
			extract($row_stu);
   ?>
 
		<tr>
		  <td><?php echo $fullName; ?></td>
		  <td><a href="mailto:<?php echo $s_email; ?>"><?php echo $s_email; ?></a></td>
		 	<td><?php echo $netid; ?></td>
		  <td><?php echo $tnid; ?></td>
		  <td><?php echo $country; ?></td>
		  <td><?php echo $Gender; ?></td>
		  <td><?php if ($verify == 0) {echo "<font color=\"red\"> Not Yet</font>";}
		            else {echo "<font color=\"green\"> Verified</font>";} ?></td>

		  
		</tr>

	
   
   
   <?php   
 		}
   ?>
  	</table> 
    <div><strong><font size="3" color="orange">
    Final Presentation Schedule:  <br></font>
    
 <?php   
     echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo $schedule_final[$pid]."@Tickle 500<br>";//</strong></font></div> <br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo $schedule_final_company[$leaderindex]."@$company</strong></div> <br>";
	}
 ?>

</div>
