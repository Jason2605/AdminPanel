<?php
session_start();
ob_start();
?>

<html>
<head>
<title>Admin Panel - Create</title>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type ="text/css" href="styles/global.css" />
<meta name="viewport" content="width=device-width, initial-scale: 1.0, user-scaleable=0" />
<script src="scripts/jquery-1.12.3.min.js"></script>
<script src="scripts/general.js"></script>
</head>
<body>

	<div id = "header">
		<div class ="logo"><a href="#">Admin<span>Panel</span></a></div>
		<div class ="logoE"><a href="#">By Jason_000</a></div>
	</div>

<div id = "login1">
<form action="verifyCheck.php" method="post">

<div class="logo"></div>
<div class="login-block">
    <h1>Create Server</h1>
    <input type="text" value="" placeholder="DB User" id="username1" name="user"/>
    <input type="text" value="" placeholder="DB Pass" id="password1" name="pass"/>
	<input type="text" value="" placeholder="DB Host" id="host" name="host"/>
	<input type="text" value="" placeholder="DB Name" id="name" name="name"/>
	<input type="text" value="" placeholder="RCON Host" id="RHost" name="RHost"/>
	<input type="text" value="" placeholder="RCON Pass" id="RPass" name="RPass"/>
	<input type="text" value="" placeholder="RCON Port" id="RPort" name="RPort"/>
	<button>Submit</button>
</div>


<script src="scripts/jquery.js"></script>
<script src="scripts/jquery.backstretch.js"></script>
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
</form>
</div>


</body>
</html>
