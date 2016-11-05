<?php

session_start();
ob_start();
$version = '';

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

$houseID = $_POST['hidden'];

include 'verifyPanel.php';
masterconnect();

$sql = "SELECT * FROM `containers` WHERE id = '$uidPlayer'";
$result = mysqli_query($dbcon, $sql);
$house = $result->fetch_object();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Panel - Houses</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

<?php
include 'header/header.php';
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Edit Houses</h1>
		  <p class="page-header">Edit houses menu of the panel, allows you to change values in more depth.</p>






            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Container Inventory</th>
					<th>Container Gear</th>
                    <th>Container Active</th>
                    <th>Container Owned</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>

<?php

if (isset($_POST['houseUpdate'])) {
    $sql = "SELECT * FROM `players` WHERE `uid` = '$uidPlayer'";
    $result = mysqli_query($dbcon, $sql);
    $player = $result->fetch_object();

    if ($staffPerms['editPlayer'] == '1') {
        if ($_POST['donatorlvl'] != $don) {
            $message = 'Admin '.$user.' has changed '.$player->name.'('.$pid.')'.' donator level from '.$player->donatorlvl.' to '.$_POST['donatorlvl'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['blacklist'] != $player->blacklist) {
            $message = 'Admin '.$user.' has changed '.$player->name.'('.$pid.')'.' blacklist status from '.$player->blacklist.' to '.$_POST['blacklist'];
            logIt($user, $message, $dbcon);
        }
        if ($version == '4.0') {
            $UpdateQ = "UPDATE players SET blacklist='$_POST[blacklist]', donatorlvl='$_POST[donatorlvl]' WHERE uid='$uidPlayer'";
        } else {
            $UpdateQ = "UPDATE players SET blacklist='$_POST[blacklist]', donorlevel='$_POST[donatorlvl]' WHERE uid='$uidPlayer'";
        }
        mysqli_query($dbcon, $UpdateQ);
    } else {
        if ($_POST['donatorlvl'] != $don) {
            $message = 'Admin '.$user.' tried to change '.$player->name.'('.$pid.')'.' donator level from '.$player->donatorlvl.' to '.$_POST['donatorlvl'];
            logIt($user, $message, $dbcon);
        }

        if ($_POST['blacklist'] != $player->blacklist) {
            $message = 'Admin '.$user.' tried to change '.$player->name.'('.$pid.')'.' blacklist status from '.$player->blacklist.' to '.$_POST['blacklist'];
            logIt($user, $message, $dbcon);
        }
    }
}

$sqlget = "SELECT * FROM containers WHERE id='$houseID';";
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<form action=editPlayer.php method=post>';
    echo '<td>'."<input class='form-control' type=text style = 'width: 100%;' name=inv value=".$row['inventory'].' </td>';
    echo '<td>'."<input class='form-control' type=text style = 'width: 100%;' name=gear value=".$row['gear'].' </td>';
    echo '<td>'."<input class='form-control' type=text style = 'width: 100%;' name=active value=".$row['active'].' </td>';
    echo '<td>'."<input class='form-control' type=text style = 'width: 100%;' name=owned value=".$row['owned'].' </td>';
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=houseUpdate value=Update".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$houseID.' </td>';
    echo '</form>';

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
    <script src="/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
