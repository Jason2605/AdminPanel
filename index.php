<?php
session_start();

if (!file_exists('verifyPanel.php')) {
  header("Location: create.php");
}
?>

<html>
<head>
<title>Admin Panel - Home</title>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type ="text/css" href="styles/global.css" />

<meta name="viewport" content="width=device-width, initial-scale: 1.0, user-scaleable=0" />
<script src="scripts/jquery-1.12.3.min.js"></script>

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
<center><div id="txt"></div></center>
<script>startTime();</script>
<div id = "login">
<form action="login.php" method="post">
<div class="logo"></div>
<div class="login-block">
    <h1>Login</h1>
    <input type="text" value="" placeholder="Username" id="username" name="username"/>
    <input type="password" value="" placeholder="Password" id="password" name="password"/>
<?php
$divStyle1='bobfdd';

if (isset($_COOKIE['conecFail']) && $_COOKIE['conecFail'] == '1'){
  //$divStyle1='style="display:none;"'; //hide div
  print'<div style="color:red"><center>Database connection failed!</center></div>';
}

if (isset($_COOKIE['fail'])){
  //$divStyle='style="display:none;"'; //hide div
  print'<div style="color:red"><center>Username or password incorrect.</center></div>';
}
?>
    <button>Submit</button>
</div>

</form>
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