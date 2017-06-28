<?php
session_start();
ob_start();
?>

<html>
<head>
<title>Admin Panel - Create</title>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type ="text/css" href="styles/global.css" />
<link href="dist/css/bootstrap.css" rel="stylesheet">

<!-- Insert this line above script imports  -->
<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>

<!-- normal script imports etc  -->
<script src="scripts/jquery-1.12.3.min.js"></script>
<script src="scripts/jquery.backstretch.js"></script>
<!-- Insert this line after script imports -->
<script>if (window.module) module = window.module;</script>
</head>
<body>
	<div id = "header">
		<div class ="logo"><a href="#">Admin<span>Panel</span></a></div>
		<div class ="logoE"><a href="#">By Jason_000</a></div>
	</div>

	<div id = "login1">
		<form class = "form-inline" action="verifyCheck.php" method="post">
			<div class="logo"></div>
			<div class="login-block">
			    <h1>Create Server</h1>

				<div class="panel panel-info">
				    <div class="panel-heading">Database Settings</div>
				    <div class="panel-body">
					<input type="text" value="" placeholder="DB User" id="username1" name="user"/>
					<input type="password" value="" placeholder="DB Pass" id="password1" name="pass"/>
					<input type="text" value="" placeholder="DB Host" id="host" name="host"/>
					<input type="text" value="" placeholder="DB Name" id="name" name="name"/>
					<input type="text" value="" placeholder="DB Port... Leave blank for 3306" id="port" name="port"/>
				    </div>
				</div>


				<div class="panel panel-info">
				    <div class="panel-heading">RCON Settings</div>
				    <div class="panel-body">
					<input type="text" value="" placeholder="RCON Host" id="RHost" name="RHost"/>
					<input type="password" value="" placeholder="RCON Pass" id="RPass" name="RPass"/>
					<input type="text" value="" placeholder="RCON Port" id="RPort" name="RPort"/>
				     </div>
				</div>

				<div class="panel panel-info">
				    <div class="panel-heading">General Settings</div>
				    <div class="panel-body">
					<input type="text" value="" placeholder="Max Cop Level" id="maxCop" name="maxCop"/>
					<input type="text" value="" placeholder="Max Medic Level" id="maxMedic" name="maxMedic"/>
					<input type="text" value="" placeholder="Max Admin Level" id="maxAdmin" name="maxAdmin"/>
					<input type="text" value="" placeholder="Max Donator Level" id="maxDonator" name="maxDonator"/>
				    </div>
				</div>

				<div class="panel panel-info">
				    <div class="panel-heading">API Settings</div>
				    <div class="panel-body">
					<input type="text" value="" placeholder="API Enable (1 or 0)" id="apiEnable" name="apiEnable"/>
					<input type="text" value="" placeholder="API Username" id="apiUser" name="apiUser"/>
					<input type="password" value="" placeholder="API Password" id="apiPass" name="apiPass"/>
				    </div>
				</div>

				<button>Submit</button>
			</div>
		</form>
	</div>
</body>
<script>
	$.backstretch([
	  "images/img4.jpg",
	  "images/img5.jpg",
	  "images/img7.jpg",
	  "images/img1.jpg",
	  "images/img10.jpg",
	  "images/img9.jpg",
	  "images/img3.jpg",
	  "images/img4.jpg",
	  "images/img6.jpg",
	  "images/img8.jpg"
	], {
	    fade: 750,
	    duration: 4000
	});
</script>
</html>
