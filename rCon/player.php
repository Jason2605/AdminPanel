<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: /index.php');
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev < 4) {
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

    <title>Admin Panel - Ban</title>

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
          <h1 style = "margin-top: 70px">Ban Menu</h1>
		  <p class="page-header">Ban menu of the panel, allows you to RCON ban players.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="/players.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
			</FORM>
			</div>

			<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rcon-check.php">
			<button class="btn btn-primary btn-outline" type="submit">Check battleye list</button>
			</FORM></div> <br><br><br>

<!--
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div>
-->

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Battle Eye GUID</th>
					<th>Reason</th>
					<th>Time</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
echo '<form action=player.php method=post>';
echo '<tr>';

echo '<td>'."<input class='form-control' type=text name=guid value='' </td>";
echo '<td>'."<input class='form-control' type=text name=reason value=''</td>";
echo '<td>'."<input class='form-control' type=text name=time value='' </td>";

echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Ban".' </td>';

echo '</tr>';
echo '</form>';

echo '</table></div>';

if (isset($_POST['update'])) {
    $guid = $_POST['guid'];
    $reason = $_POST['reason'];
    $time = $_POST['time'];

    $_SESSION['guid'] = $guid;
    $_SESSION['reason'] = $reason;
    $_SESSION['time'] = $time;

    include '../verifyPanel.php';
    masterconnect();

    if ($_POST['guid'] != '') {
        $message = 'Admin '.$user.' has banned '.$guid.' for '.$time.' minutes under the reason of ('.$reason.')';
        $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
        mysqli_query($dbcon, $logQ);
    }

    header('Location: rcon-ban.php');
}
?>
<p><br><br><br>To use the ban feature, batteye needs to use the GUID and not a player UID<br>NOTE: if the player is currently on the server please make sure you kick them else they will be banned however still playing until they have left!</p>
<p>0 - Perm Ban, and the time is scaled in minutes!</p>
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
