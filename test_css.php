<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
//this is a new page built by the use of css layers
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> -->
	<link rel="stylesheet" href="stylesheet.css" type="text/css">
	<link rel="stylesheet" href="menu/menu_style.css" type="text/css">
	<title>Chelsea and Westminster Simulation Centre</title>
<!-- /tinyMCE -->

<script type="text/javascript">
<!--
function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=10; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}
//-->
</script>
<style type="text/css">
<!-- 
/* CSS from tutorials of www.alsacreations.com/articles */
body {
margin: 0;
padding: 0;
background: white;
font: 80% verdana, arial, sans-serif;
}
dl, dt, dd, ul, li {
margin: 0;
padding: 0;
list-style-type: none;
}
#menu {
position: absolute;
top: 143px;
left: 50px;
z-index:100;
width: 100%; /* precision for Opera */
padding : 10px;
}
#menu dl {
float: left;
width: 12em;
}
#menu dt {
cursor: pointer;
text-align: center;
font-weight: bold;
background: #ccc;
border: 1px solid gray;
margin: 1px;
}
#menu dd {
display: none;
border: 1px solid gray;
}
#menu li {
text-align: center;
background: #fff;
}
#menu li a, #menu dt a {
color: #000;
text-decoration: none;
display: block;
height: 100%;
border: 0 none;
}
#menu li a:hover, #menu dt a:hover {
background: #eee;
}

.header {
position : absolute;
background-color : #0277B4;
border : 1px solid grey;
top : 10px;
left : 50px;
width : 780px;
height : 133px;
}

.content {
position : absolute;
border : 1px solid grey;
top : 178px;
left : 50px;
width : 764px;
padding : 8px;
}

.navbar {
position : absolute;
top : 143px;
left : 50px;
width : 780px;
height : 35px;
border : 1px solid grey;
background-image: url('images/nav.gif');
}

.headimageblock {
background-color : #0277B4;
width : 325px;
float : right;
}

.logoblock {
width : 455px;
height : 133px;
float : left; 
}

.headerimage {
float : right;
}


-->
</style>

</head>
<body>
	<div class="header">
		<img src="images/logo.jpg" class="logoblock">
		<div class="headimageblock">
			<img src="images/4.jpg" class="headerimage">
			<img src="images/7.jpg" class="headerimage">
		</div>
	</div>
	<div class="navbar">
	</div>
	<div id="menu">
			<dl>
				<dt onmouseover="javascript:montre();"><a href="" title="Retour � l'accueil">Home</a></dt>
			</dl>
			
			<dl>			
				<dt onmouseover="javascript:montre('smenu1');">Menu 1</dt>
					<dd id="smenu1">
						<ul>
							<li><a href="#">Sub Menu 1.1</a></li>
							<li><a href="#">Sub Menu 1.2</a></li>
							<li><a href="#">Sub Menu 1.3</a></li>
							<li><a href="#">Sub Menu 1.4</a></li>
							<li><a href="#">Sub Menu 1.5</a></li>
							<li><a href="#">Sub Menu 1.6</a></li>
						</ul>
		
					</dd>
			</dl>
			
			
			<dl>	
				<dt onmouseover="javascript:montre();"><a href="">Menu 2</a></dt>
			</dl>
			
			<dl>	
				<dt onmouseover="javascript:montre('smenu3');">Menu 3</dt>
					<dd id="smenu3">
						<ul>
		
							<li><a href="#">Sub Menu 3.1</a></li>
							<li><a href="#">Sub Menu 3.2</a></li>
							<li><a href="#">Sub Menu 3.3</a></li>
							<li><a href="#">Sub Menu 3.4</a></li>
							<li><a href="#">Sub Menu 3.5</a></li>
						</ul>
		
					</dd>
			</dl>
			
			<dl>	
				<dt onmouseover="javascript:montre('smenu4');">Menu 4</dt>
					<dd id="smenu4">
						<ul>
							<li><a href="#">Sub Menu 4.1</a></li>
							<li><a href="#">Sub Menu 4.2</a></li>
		
							<li><a href="#">Sub Menu 4.3</a></li>
						</ul>
					</dd>
			</dl>
		</div>
		<div class="content">
			<h3>heading 3</h3>
			<p>More Content</p>
		</div>
		
</body>
</html>