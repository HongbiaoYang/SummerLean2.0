<?php
require('config.php');
$gmaplat=$_GET['lat'];
$gmaplon=$_GET['lon'];
$gmapzoom=5;	
$text=explode(',',$_GET['add1']);
$message='';
Foreach ($text as $name=>$value) If (!empty($value)) $message.="$value<br>"; 
?>   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>My Locations</title>
	<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?phpEcho GOOGLE_MAP_KEY; ?>" 
                type="text/javascript"></script>
	<script type="text/javascript">

		function load() 
		{
		      if (GBrowserIsCompatible()) {
		        var point;
		        var map=new GMap2(document.getElementById("map"));
			    map.enableDoubleClickZoom();
			    map.enableScrollWheelZoom();
			    map.addControl(new GSmallMapControl());
			    var address='<font size="2" face="Arial"><?phpEcho $message; ?></font>';
				var marker = new GMarker(new GLatLng(<?phpEcho "$gmaplat,$gmaplon";?>));
		      	map.setCenter(new GLatLng(<?phpEcho "$gmaplat,$gmaplon";?>),15);
		        map.addOverlay(marker);
		        map.setMapType(G_NORMAL_MAP);
		        GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(address);});
		        marker.openInfoWindowHtml(address); 
		               
		      }
		    }
	</script>
</head>
<body onload="load();" onunload="GUnload()" style=" background-color:Transparent">
<div id="map" style="width: <?phpEcho $_GET['width']."px; height: ".$_GET['height']."px"; ?>"
	></div>
</body>
</html>
