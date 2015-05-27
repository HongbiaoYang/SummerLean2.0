<?php
/*
 * Created on Aug 24, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include('includes/application_top.php');
 $dir = $_GET['path'].'/';
 $filename = $_GET['filename'];
 header("Content-type: application/force_download");
 header('Content-Disposition: inline; filename="'.$dir.$filename.'"');
 header('Content-Transfer-Encoding: Binary');
 header('Content-length: "'.filesize($dir.$filename));
 header('Content-Type: application/octet-stream');
 header('Content-Disposition: attachment; filename="'.$filename.'"');
 readfile("$dir$filename");


?>
