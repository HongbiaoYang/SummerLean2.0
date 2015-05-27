<?php
include('includes/application_top.php');
define("MAPS_HOST", "maps.google.com");


If (isset($_GET['add1'])) {
	// Initialize delay in geocode speed
	$delay = 0;
	$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . GOOGLE_MAP_KEY;
	
	// Iterate through the rows, geocoding each address
	  $geocode_pending = true;
	
	  while ($geocode_pending) {
	    $address = $_GET['add1'];
	    $request_url = $base_url . "&q=" . urlencode($address);
	    $xml = simplexml_load_file($request_url) or die("url not loading");
	
	    $status = $xml->Response->Status->code;
	    if (strcmp($status, "200") == 0) {
	      // Successful geocode
	      $geocode_pending = false;
	      $coordinates = $xml->Response->Placemark->Point->coordinates;
	      $coordinatesSplit = split(",", $coordinates);
	      // Format: Longitude, Latitude, Altitude
	      $lat = $coordinatesSplit[1];
	      $lng = $coordinatesSplit[0];
	      If (!tep_db_query("update centers set gmaplat=$lat,gmaplon=$lng where id=".$_GET['id'])) Echo "Could not resolve the centre address.";
			 Echo "<iframe src='gmap.php?lat=$lat&lon=$lng&height=".$_GET['height']."&width=".$_GET['width']."&add1=$address' width='".$_GET['width']."' height='".$_GET['height']."' frameborder='0' scrolling=no></iframe><br>";
	    } else if (strcmp($status, "620") == 0) {
	      // sent geocodes too fast
	      	$delay += 100000;
	    } else {
	      // failure to geocode
	      	$geocode_pending = false;
	      	echo "Address " . $address . " failed to geocoded. ";
	      	echo "Received status " . $status . "\n";
	    }
	    usleep($delay);
	  }
	}
Else {
	Echo "<form name='georesolver' method='post' action='resolve.php'>
			Enter address: <input type='text' name='add1'>
			<input type='submit' value='search'></form>";
}
?>
