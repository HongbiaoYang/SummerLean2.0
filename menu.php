<?php
require_once 'library/config.php';
require_once 'library/functions.php';

/*
$page = $_SERVER['PHP_SELF'];
$sec = "10";
header("Refresh: $sec; url=$page"."?v=INVR");
*/

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
//alwaysUpdateDebug();

$view = (isset($_GET['v']) && $_GET['v'] != '') ? $_GET['v'] : '';

switch ($view) {
	case 'USER' :
		$content 	= 'user/list2.php';		
		$pageTitle 	= 'Lean Summer Project - Choose Your Projects';
		break;
		
	case 'LIST' :
		$content 	= 'user/history.php';		
		$pageTitle 	= 'Lean Summer Project - Choose Your Projects';
		break;

	case 'TEAM' :
		$content 	= 'user/team.php';		
		$pageTitle 	= 'Lean Summer Project - Choose Your Projects';
		break;
	case 'BOARD' :
		$content 	= 'user/board.php';		
		$pageTitle 	= 'Lean Summer Project - View Your Info';
		break;
		
	case 'PWD' :
		$content 	= 'user/password.php';		
		$pageTitle 	= 'Lean Summer Project - Change Your Password';
		break;

	case 'HOME' :
		$content 	= 'index.php';		
		$pageTitle 	= 'Lean Summer Project - Welcome Home!';
		break;
		
	case 'RENAME' :
		$content 	= 'user/rename.php';		
		$pageTitle 	= 'Lean Summer Project - Welcome Home!';
		break;
		
	case 'ADD' :
		$content 	= 'user/add1.php';		
		$pageTitle 	= 'Lean Summer Project - Register New Account!';
		break;

	case 'CNTC' :
		$content 	= 'user/contact.php';		
		$pageTitle 	= 'Lean Summer Project - Contact Us';
		break;
		

	case 'HRWR' :
		$content 	= 'hardware/list.php';		
		$pageTitle 	= 'Asset Management - View Hardwares';
		break;

	case 'SFWR' :
		$content 	= 'software/list.php';		
		$pageTitle 	= 'Asset Management - View Softwares List';
		break;

	case 'LABS' :
		$content 	= 'labs/list.php';		
		$pageTitle 	= 'Asset Management - View Labs List';
		break;

	case 'STCK' :
		$content 	= 'stock/list.php';		
		$pageTitle 	= 'Asset Management - View Labs List';
		break;		
		
	case 'SHOPLIST' :
		$content 	= 'shoplist/list.php';		
		$pageTitle 	= 'Shopping List Management - What you need to buy';
		break;		
	case 'HISTORYORDER' :
		$content 	= 'shoplist/history.php';		
		$pageTitle 	= 'Shopping List Management - What you have purchased before';
		break;		
	case 'INVR' :
		$content 	= 'inventory/list.php';		
		$pageTitle 	= 'Inventory Management - Check Current Inventory';
		break;
}

$script    = array('user.js', 'hardware.js', 'software.js', 'inventory.js');

require_once 'template.php';

?>
