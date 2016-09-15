<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

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

    <title>Admin Panel - Vehicles</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/dashboard.css" rel="stylesheet">

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

include 'verifyPanel.php';
masterconnect();

$sqlget = 'SELECT * FROM vehicles';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

include 'header/header.php';
?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Vehicle Menu</h1>
		  <p class="page-header">Vehicle menu of the panel, allows you to change vehicle database values.</p>
<?php
if (isset($_POST['update'])) {
    if ($staffPerms['vehicles'] == '1') {
        $sql = "SELECT * FROM `vehicles` WHERE `id` = $_POST[hidden]";
        $result = mysqli_query($dbcon, $sql);
        $vehicle = $result->fetch_object();

        if ($_POST['classname'] != $vehicle->classname) {
            $message = 'Admin '.$user.' has changed the classname of vehicle '.$vehicle->id.' from '.$vehicle->classname.' to '.$_POST['classname'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['alive'] != $vehicle->alive) {
            $message = 'Admin '.$user.' has changed the alive status of vehicle '.$vehicle->id.' from '.$vehicle->alive.' to '.$_POST['alive'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['active'] != $vehicle->active) {
            $message = 'Admin '.$user.' has changed the active status of vehicle '.$vehicle->id.' from '.$vehicle->active.' to '.$_POST['active'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['plate'] != $vehicle->plate) {
            $message = 'Admin '.$user.' has changed the the plate of vehicle '.$vehicle->id.' from '.$vehicle->plate.' to '.$_POST['plate'];
            logIt($user, $message, $dbcon);
        }

        $UpdateQ = "UPDATE vehicles SET classname='$_POST[classname]', alive='$_POST[alive]', active='$_POST[active]', plate='$_POST[plate]' WHERE id='$_POST[hidden]'";
        mysqli_query($dbcon, $UpdateQ);
    } else {
        $sql = "SELECT * FROM `vehicles` WHERE `id` = $_POST[hidden]";
        $result = mysqli_query($dbcon, $sql);
        $vehicle = $result->fetch_object();

        if ($_POST['classname'] != $vehicle->classname) {
            $message = 'Admin '.$user.' tried to change the classname of vehicle '.$vehicle->id.' from '.$vehicle->classname.' to '.$_POST['classname'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['alive'] != $vehicle->alive) {
            $message = 'Admin '.$user.' tried to change the alive status of vehicle '.$vehicle->id.' from '.$vehicle->alive.' to '.$_POST['alive'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['active'] != $vehicle->active) {
            $message = 'Admin '.$user.' tried to change the active status of vehicle '.$vehicle->id.' from '.$vehicle->active.' to '.$_POST['active'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['plate'] != $vehicle->plate) {
            $message = 'Admin '.$user.' tried to change the the plate of vehicle '.$vehicle->id.' from '.$vehicle->plate.' to '.$_POST['plate'];
            logIt($user, $message, $dbcon);
        }
    }
}
?>
          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>ID</th>
					<th>Side</th>
					<th>Class Name</th>
					<th>UID</th>
					<th>Type</th>
					<th>Alive</th>
					<th>Active</th>
					<th>Plate</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo '<form action=vehicles.php method=post>';
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
    echo '<td>'.$row['side'].' </td>';

    echo '<td>'."<input class='form-control' type=text name=classname value=".$row['classname'].' </td>';
    echo '<td>'.$row['pid'].' </td>';
    echo '<td>'.$row['type'].' </td>';

    echo '<td>'."<input class='form-control' type=text name=alive value=".$row['alive'].' </td>';
    echo '<td>'."<input class='form-control' type=text name=active value=".$row['active'].' </td>';
    echo '<td>'."<input class='form-control' type=text name=plate value=".$row['plate'].' </td>';

    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Update".' </td>';
    echo "<td  style='display:none;'>".'<input type=hidden name=hidden value='.$row['id'].' </td>';

    echo '</tr>';
    echo '</form>';
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
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
