<?php
require_once 'library/config.php';
require_once 'library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['v']) && $_GET['v'] != '') ? $_GET['v'] : '';

ob_start();
	
switch ($view) {
	case 'adduser' :
		$content 	= 'user/add.php';		
		$pageTitle 	= 'Lean Summer Program - Choose Projects';
		break;

	case 'addvendor' :
		$content 	= 'vendor/add.php';		
		$pageTitle 	= 'Lean Summer Program - Choose Projects';
		break;
		
	case 'addcat' :
		$content 	= 'category/add.php';		
		$pageTitle 	= 'Lean Summer Program - Choose Projects';
		break;	

	case 'search' :
		$content 	= 'search/search.php';		
		$pageTitle 	= 'Asset Management - Search Asset';
		break;	

	case 'addlab' :
		$content 	= 'labs/add.php';		
		$pageTitle 	= 'Asset Management - Add Laboratory';
		break;	

	case 'assign' :
		$content 	= 'assign/add.php';		
		$pageTitle 	= 'Asset Management - Assign Asset';
		break;	

	case 'addhardware' :
		$content 	= 'hardware/add.php';		
		$pageTitle 	= 'Asset Management - Add Hardware';
		break;	
		
	case 'addinventory' :
		$content 	= 'inventory/add.php';		
		$pageTitle 	= 'Inventory Management - Add Inventory';
		break;	
	case 'sendorder' :
		$content 	= 'shoplist/send.php';		
		$pageTitle 	= 'Order Management - Place an Order';
		break;	
	case 'consumeinventory' :
		$content 	= 'inventory/consume.php';		
		$pageTitle 	= 'Inventory Management - Consume Inventory';
		break;
	case 'addsoftware' :
		$content 	= 'software/add.php';		
		$pageTitle 	= 'Asset Management - Add New Product';
		break;	

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Users';
}

$script    = array('user.js','category.js','hardware.js', 'inventory.js');

require_once 'template.php';

?>
