<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

$user = $_SESSION['user'];
$staffPerms = $_SESSION['perms'];

if ($staffPerms['kick'] != '1') {
    header('Location: ../lvlError.php');
    die();
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
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../styles/dashboard.css" rel="stylesheet">
    <script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
    <script src="scripts/jquery-1.12.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="scripts/jquery.backstretch.js"></script>
    <script>if (window.module) module = window.module;</script>
  </head>

  <body>

<?php

include 'header/header.php';

?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Kick Menu</h1>
		  <p class="page-header">Kick menu of the panel, allows you to RCON kick players.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="Kmenu.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
			</FORM>
			</div>

			<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rcon-check.php">
			<button class="btn btn-primary btn-outline" type="submit">Check battleye list</button>
			</FORM></div> <br><br><br>
<?php
if (isset($_POST['update'])) {
    $guid = $_POST['guid'];
    $uid = $_POST['uid'];
    $reason = $_POST['reason'];
    if ($guid != '' || $uid != '') {
        include '../verifyPanel.php';
        masterconnect();

        $sqlget = 'SELECT uid,guid FROM whitelist';
        $sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

        while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
            if ($row['uid'] == $uid) {
                $whitelist = true;
            }
        }
        if ($whitelist) {
            echo '<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">This is a whitelisted staff member!</a></div>';
            $message = 'Admin '.$user.' tried to kick a whitelisted staff member - '.$uid;
            logIt($user, $message, $dbcon);
        } else {
            $_SESSION['guid'] = $guid;
            $_SESSION['reason'] = $reason;

            header('Location: rcon-kick.php');
        }
    } else {
        echo '<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">Please fill in Battleye ID and UID!</a></div>';
    }
}
?>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Battleye ID</th>
                    <th>UID</th>
					<th>Reason</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
  echo '<form action=Kplayer.php method=post>';
  echo '<tr>';

  echo '<td>'."<input class='form-control' type=text name=guid value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=uid value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=reason value=''</td>";

  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Kick".' </td>';

  echo '</tr>';
  echo '</form>';

echo '</table></div>';
?>
<p>To use the kick feature you need to find the player ID, this is found by pressing the battleye list and typing in the [#] value. This is betwen 0-amount of players on server. So please check, this is NOT uid or GUID!</p>
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
