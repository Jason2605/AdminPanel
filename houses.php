<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
}

$adminLev = $_SESSION['adminLevel'];
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

    <title>Admin Panel - Houses</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

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

include('verifyPanel.php');
masterconnect();

$sqlget = "SELECT * FROM houses";
$sqldata = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');

include('header/header.php');
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">House Menu</h1>
		  <p class="page-header">House menu of the panel, allows you to change house database values.</p>

<?php
$sqlget = "SELECT * FROM houses";
$sqldata = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');

if (isset($_POST['update'])) {

if ($adminLev > 6) {

$id = $_POST['hidden'];

$sql = "SELECT * FROM `houses` WHERE `id` =$id ";
$result = mysqli_query($dbcon, $sql);
$house = $result->fetch_object();

  if ($_POST['inventory'] != $house->inventory) {
    $message = "Admin ".$user." has changed the inventory of house ".$house->id." from ".$house->inventory." to ".$_POST['inventory'];
    logIt($user, $message, $dbcon);
  }

  if ($_POST['containers'] != $house->containers) {
    $message = "Admin ".$user."  has changed the containers of house ".$house->id;
    logIt($user, $message, $dbcon);
  }

  if ($_POST['owned'] != $house->owned) {
    $message = "Admin ".$user." has changed the owned status of house".$house->id." from ".$house->owned." to ".$_POST['owned'];
    logIt($user, $message, $dbcon);
  }


$UpdateQ = "UPDATE houses SET inventory='$_POST[inventory]', containers='$_POST[containers]', owned='$_POST[owned]' WHERE id='$_POST[hidden]'";
mysqli_query($dbcon, $UpdateQ);
}else {

$id = $_POST['hidden'];

$sql = "SELECT * FROM `houses` WHERE `id` =$id ";
$result = mysqli_query($dbcon, $sql);
$house = $result->fetch_object();

  if ($_POST['inventory'] != $house->inventory) {
    $message = "Admin ".$user." tried to change the inventory of house ".$house->id." from ".$house->inventory." to ".$_POST['inventory'];
    logIt($user, $message, $dbcon);
  }

  if ($_POST['containers'] != $house->containers) {
    $message = "Admin ".$user." tried to change the containers of house ".$house->id;
    logIt($user, $message, $dbcon);
  }

  if ($_POST['owned'] != $house->owned) {
    $message = "Admin ".$user." tried to change the owned status of house".$house->id." from ".$house->owned." to ".$_POST['owned'];
    logIt($user, $message, $dbcon);
  }

}

};

?>
          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>ID</th>
					<th>Owner UID</th>
					<th>House Pos</th>
					<th>Inventory</th>
					<th>Containers</th>
					<th>Owned</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
  echo "<form action=houses.php method=post>";
  echo "<tr>";
  echo "<td>".$row['id']."</td>";
  echo "<td>".$row['pid']." </td>";
  echo "<td>".$row['pos']." </td>";

  echo "<td>"."<input class='form-control' type=text name=inventory value=".$row['inventory']." </td>";
  echo "<td>"."<input class='form-control' type=text name=containers value=".$row['containers']." </td>";

  echo "<td>"."<input class='form-control' type=text name=owned value=".$row['owned']." </td>";

  echo "<td>"."<input class='btn btn-primary btn-outline' type=submit name=update value=Update"." </td>";
  echo "<td style='display:none;'>"."<input type=hidden name=hidden value=".$row['id']." </td>";

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
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
