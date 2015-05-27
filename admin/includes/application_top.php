<?php

/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/

	require('config.php');

	require(FUNCTIONS . 'database.php');
	require(INCLUDES . 'database_names.php');


	require(FUNCTIONS . 'sessions.php');
	require(FUNCTIONS . 'validations.php');
	require(FUNCTIONS . 'courses.php');
	require(FUNCTIONS . 'general.php');
	require(FUNCTIONS . 'calendar.php');
	require(FUNCTIONS . 'users.php');
	require(FUNCTIONS . 'surveys.php');
	require(FUNCTIONS . 'resources.php');
	require(FUNCTIONS . 'reporting.php');
	require(FUNCTIONS . 'folder.php');
	require(FUNCTIONS . 'files.php');
	require(FUNCTIONS . 'timedate.php');
	require(FUNCTIONS . 'user_export.php');

	require(CLASSES . 'course.php');
	require(CLASSES . 'scheduled.php');
	require(CLASSES . 'user.php');
	require(CLASSES . 'instructor.php');
	require(CLASSES . 'center.php');
	require(CLASSES . 'report.php');
	require(CLASSES . 'bus_report.php');
	require(CLASSES . 'note.php');
	require(CLASSES . 'folder.php');
	require(CLASSES . 'file_instance.php');
	require(CLASSES . 'group.php');



	tep_db_connect() or die('Unable to connect to database server!');

	session_start();

	define('PERMISSION_ERROR', '<font color="red">* You do not have permission to perform that action</font>');

	// the 5 possible stages a candidate can have

	define('STATUS1', '<font color="green">app_top1</font>');
	define('STATUS2', '<font color = "orange">app_top2</font>');
	define('STATUS3', '<font color="green">app_top3</font>');
	define('STATUS4', '<font color="green">app_top4</font>');
	define('STATUS5', '<font color="red">app_top5</font>');

	define('STATUS1_MENU', 'app_top1_menu');
	define('STATUS2_MENU', 'app_top2_menu');
	define('STATUS3_MENU', 'app_top3_menu');
	define('STATUS4_MENU', 'app_top4_menu');
	define('STATUS5_MENU', 'app_top5_menu');


?>
