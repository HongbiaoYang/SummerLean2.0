<?php

/**
 * @author Andrew Boulanger
 * @copyright 2009
 */

//folder configurations

	define('CLASSES' , HTTP_PATH . 'classes/');
	define('INCLUDES' , HTTP_PATH . 'includes/');
	define('FUNCTIONS' , HTTP_PATH . 'functions/');
	define('ADMIN' , HTTP_SERVER . 'admin/');

	// upload functionality is currently disabled
	// once enabled this will allow administrators to make course download material avaialable to learners
	//uploads directory needs to have 777 permissions
	// UPLOAD_DIR and RELATIVE_UPLOAD_DIR is where photos of instructors will be uploaded to.
	define('UPLOAD_DIR' , HTTP_PATH. 'admin/images/uploads');	//should be put outside htdocs directory
	define('RELATIVE_UPLOAD_DIR' , 'admin/images/uploads/');

	// FILE_DIR and RELATIVE_FILE_DIR is where files and other information related to courses will be uploaded to.
	define('FILE_DIR' , HTTP_PATH .'admin/uploads');		//should be put outside htdocs directory
	define('RELATIVE_FILE_DIR', 'admin/uploads');

	// EXPORT_PATH and REL_EXPORT_PATH is where exports will be saved on the server.

	
	

?>