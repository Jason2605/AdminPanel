<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: /index.php');
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev < 3) {
    header('Location: ../lvlError.php');
}
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

    <title>Admin Panel - Kick</title>

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/styles/dashboard.css" rel="stylesheet">

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

<?php
include '../header/header.php';
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Kick Menu</h1>
		  <p class="page-header">Gives you the ability to kick a player off the server. This can be sent to the server for any player in the database, obviously if they are offline nothing will happen... Check the battleye list for players online!.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="Kmenu.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
			</FORM>
			</div>

			<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rcon-check.php">
			<button class="btn btn-primary btn-outline" type="submit">Check battleye list</button>
			</FORM></div> <br><br><br>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Name</th>
					<th>Alias</th>
					<th>UID</th>
					<th>Kick</th>
                </tr>
              </thead>
              <tbody>
<?php
include '../verifyPanel.php';
masterconnect();

$sqlget = 'SELECT * FROM players';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo '<form action=SKPlayerv1.php method=post>';
    echo '<tr>';

    echo "<td style='display:none;'>".'<input type=hidden name=hiddenUID value='.$row['playerid'].' </td>';
    echo '<td>'.$row['name'].' </td>';
    echo '<td>'.$row['aliases'].' </td>';
    echo '<td>'.$row['playerid'].' </td>';
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Kick".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hiddenName value='.$row['name'].' </td>';

    echo '</tr>';
    echo '</form>';
}

echo '</table></div>';

if (isset($_POST['update'])) {
    $sql = "SELECT * FROM `players` WHERE `playerid` = $_POST[hiddenUID]";
    $result = mysqli_query($dbcon, $sql);
    $player = $result->fetch_object();

    $name = $_POST['hiddenName'];
    $guid = $_POST['hiddenUID'];
    $_SESSION['SKguid'] = $guid;

    $message = 'Admin '.$user.' has kicked '.$player->name.'('.$guid.')';
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
    header('Location: rcon-Skick.php');
}
?>
<p><br></p>
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
    <script src="/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
