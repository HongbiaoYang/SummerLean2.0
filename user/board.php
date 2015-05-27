<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql_board = "SELECT s.firstname as b_first, s.lastname as b_last, "
		. " s.email as b_email,   "
		. " r.trip_amazon, r.trip_toyota, r.trip_vw, r.trip_aqua, r.trip_neyland "
    . " FROM tbl_students s, tbl_trips r \n"
    . " WHERE 1  and s.stuIndex = r.stuIndex and  s.stuIndex = "
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


$aquarium = array(
		0 => "TBD",
);

$neyland = array(
		0 => "TBD",
);


?> 
<div class="prepend-1 span-17">
<p>&nbsp;</p>
<h2 class="catHead">Board Member Information</h2>
<p><img src="images/users.png" class="left"/>
	<p class="errorMessage"><?php echo $errorMessage; ?></p>
<strong>This page your information as a board member of summer lean program</strong>
<br/>

<?php 
	
		$result_board = dbQuery($sql_board);
		$row_board = dbFetchAssoc($result_board);
		extract($row_board);
?>

 <table  border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <td colspan = "2"><?php echo "Team Information";
   	?></td>
    </tr>


  <tr class="<?php echo $class; ?>"> 
  <td><?php echo "Your Name:";?></td>
   <td><?php 
   		echo ucfirst($b_first)." ".ucfirst($b_last); 
	  	?>
   	</td>
 </tr>
 
 	<tr>
 	<td>Email:</td>
 	<td align="center"><a href="mailto:<?php echo $b_email; ?>"><?php echo $b_email; ?></a></td>
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
  
</div>
