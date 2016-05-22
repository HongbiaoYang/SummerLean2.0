<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
 
 include('config.php');
 $password = md5('password');
 $query = "update users set password = '$password'";
 include('includes/application_top.php');
 $result = tep_db_query($query);
?>
