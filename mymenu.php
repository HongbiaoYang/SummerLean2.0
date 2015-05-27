<div class="span-24">
   <div id="underlinemenu">
	<ul>
	<?php 
	$fullname = 'Guest';
	$sql = "Select email, rank, fullname from tbl_students
					Where stuIndex = ".$_SESSION["asset_user_id"];
	
	$result = dbQuery($sql);
	if ($result)
	{
		$row = dbFetchAssoc($result);
		extract($row);
	}
				
	?>
		<li><a href="<?php echo WEB_ROOT; ?>" title="Home">Home</a></li>
		<li><a href="<?php echo WEB_ROOT; ?><?php if ($rank == 0) {echo "menu.php?v=USER";} else if ($rank == 3){echo "menu.php?v=TEAM";} ?>" title="View Project Information">View Project</a></li>
		<li><a href="<?php echo WEB_ROOT; ?>" title="Home"><?php echo  "Welcome, ".$fullname;?></a></li>
		<li><a href="<?php echo $self; ?>?logout" class="leftnav">Logout</a></li>
		

	</ul>
	</div>
</div>
