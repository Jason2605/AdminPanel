<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$user = $_SESSION['user'];

$staffPerms = $_SESSION['perms'];

if ($staffPerms['steamView'] != '1') {
    header('Location: lvlError.php');
}

$max = PHP_INT_MAX;

include 'header/header.php';
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
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Steam Menu</h1>
		  <p class="page-header">Steam menu of the panel, allows you to see steam accounts.</p>
<?php

include 'verifyPanel.php';
masterconnect();

$sqlget = 'SELECT * FROM players';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

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
    if ($row['playerid'] != '' || $row['pid'] != '') {
        if ($row['playerid'] == '') {
            $pid = $row['pid'];
        } else {
            $pid = $row['playerid'];
        }
    }

    $return = guid($max, $pid);

    echo '<tr>';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['aliases'].' </td>';
    echo '<td>'.$pid.' </td>';
    echo '<td>'.$return.'</td>';
    echo "<td><a href='http://steamcommunity.com/profiles/".$pid."' target='_blank' class='btn btn-primary btn-outline' role='button'>Steam Accounts</a></td>";
    echo '</tr>';
}

echo '</table></div>';
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