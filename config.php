<?php
//Database configuration

date_default_timezone_set('America/New_York');

	define('DB_NAME', 'lean');
	define('DB_USER', 'lean');
	define('DB_PASS', 'lean2015');
	define('DB_HOST', 'localhost');
	define('USE_PCONNECT', 'false');
//CourseMS Paths

	define('HTTP_SERVER', 'http://mydesk.desktops.utk.edu/lean/');
	define('HTTP_PATH', '/var/www/lean/');
	define('EXPORT_PATH', '/var/www/lean/exports/');
	define('REL_EXPORT_PATH', 'exports/');
// PHPESP database configuration

	define('ESP_DB_NAME', 'book1');
	define('ESP_DB_USER', 'root');
	define('ESP_DB_PASS', '');
	define('ESP_DB_HOST', 'localhost');
	//phpESP paths

	define('PHPESP_PATH', '/web/htdocs/course/public/handler.php');
	define('PHPESP_APP', 'http://localhost/esp/');
	//Google Map Key file

	define('GOOGLE_MAP_KEY', 'AIzaSyCtQ9qzI33vE2LkSM1-XJH7s-F_Aesikuk');
	//Email settings

	define('FROM', 'utlean@utk.edu');
	define('SIGNATURE', 'Lean Summer Program Support Team');
	define('RANDOM_STRING', 'bob');
	// Site Configuration Settings

	define('TABLE_WIDTH', '100%');
	define('SEC_TABLE_WIDTH', '90%');
	define('JOB_REQUIREMENTS', 'false');
	// Requirement Levels

	define('LEVEL1_NAME', 'Jobs');
	define('LEVEL2_NAME', 'Specialties');
	define('LEVEL3_NAME', 'Bands');
	define('LEVEL1_REQUIRED', 'true');
	define('LEVEL2_REQUIRED', 'true');
	define('LEVEL3_REQUIRED', 'true');
include('site_config.php');
?>
