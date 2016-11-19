<?php
session_start();
include 'verifyPanel.php';
masterconnect();

$sqlget = "UPDATE access SET failed = 5 WHERE address = '$_SERVER[REMOTE_ADDR]'";
$res = mysqli_query($dbcon, $sqlget);

session_destroy();
?>

<html>
<head>
<title>Admin Panel - Locked</title>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type ="text/css" href="styles/global.css" />
<link rel="stylesheet" type ="text/css" href="styles/dashboard.css" />
<link href="dist/css/bootstrap.css" rel="stylesheet">

<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
<!-- normal script imports etc  -->
<script src="scripts/jquery-1.12.3.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="scripts/jquery.backstretch.js"></script>
<!-- Insert this line after script imports -->
<script>if (window.module) module = window.module;</script>

<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
</head>
<body>
<meta name="viewport" content="width=device-width">
<div id="background"></div>
	<div id = "header">
        <div class ="logo"><a href="#">Admin<span>Panel</span></a></div>
		<div class ="logoE"><a href="#">By Jason_000</a></div>
	</div>
<center><div id="txt"></div>
<script>startTime();</script>
<div class="alert alert-danger" role="alert">Your network has been suspended due to too many invalid login attempts, please see the administrator of the website to be unblocked.</div></center>
</div>

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

</body>
</html>
