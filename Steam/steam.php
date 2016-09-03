<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev < 1) {
  header("Location: ../index.php");
}

if ($adminLev < 2) {
  header("Location: ../lvlError.php");
}

$max = PHP_INT_MAX;

include('../header/header.php');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Panel - Steam</title>

    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../styles/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Steam Menu</h1>
		  <p class="page-header">Steam menu of the panel, allows you to see steam accounts.</p>
<?php

include('../verifyPanel.php');
masterconnect();


$sqlget = "SELECT * FROM players";
$sqldata = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');

if (isset($_POST['delete'])) {
  $sql = "DELETE FROM users WHERE ID='$_POST[hidden]'";
  mysqli_query($dbconL, $sql);
}


if (isset($_POST['update'])) {
  $UpdateQ = "UPDATE users SET username='$_POST[username]', password='$_POST[password]', level='$_POST[adminlevel]' WHERE ID='$_POST[hidden]'";
  mysqli_query($dbconL, $UpdateQ);
};

?>
          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Name</th>
					<th>Alias</th>
					<th>UID</th>
					<th>GUID</th>
					<th>Steam Account</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
if ($max != 2147483647) {

$steamID = $row['playerid'];
$temp = '';

for ($i = 0; $i < 8; $i++) {
  $temp .= chr($steamID & 0xFF);
  $steamID >>= 8;
}

$return = md5('BE'.$temp);
}else {
$return = "32 bit PHP, GUID will not work!";
}
  echo "<form action=logs.php method=post>";
  echo "<tr>";
  echo "<td>".$row['name']."</td>";
  echo "<td>".$row['aliases']." </td>";
  echo "<td>".$row['playerid']." </td>";
  echo "<td>".$return."</td>";
  echo "<td><a href='http://steamcommunity.com/profiles/".$row["playerid"]."' target='_blank' class='btn btn-primary btn-outline' role='button'>Steam Accounts</a></td>";
  echo "</tr>";
  echo "</form>";
}

echo "</table></div>";
?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
