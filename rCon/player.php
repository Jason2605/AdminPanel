<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

if ($staffPerms['ban'] != '1') {
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

    <title>Admin Panel - Ban</title>

    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../styles/dashboard.css" rel="stylesheet">
    <script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
    <!-- normal script imports etc  -->
    <script src="scripts/jquery-1.12.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="scripts/jquery.backstretch.js"></script>
    <!-- Insert this line after script imports -->
    <script>if (window.module) module = window.module;</script>
  </head>

  <body>

<?php
include 'header/header.php';
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Ban Menu</h1>
		  <p class="page-header">Ban menu of the panel, allows you to RCON ban players.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="../players.php">
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
    $reason = $_POST['reason'];
    $time = $_POST['time'];

    include '../verifyPanel.php';
    masterconnect();

    $sql = 'SELECT uid,guid FROM whitelist';
    $sqlinfo = mysqli_query($dbcon, $sql) or die('Connection could not be established');

    while ($row = mysqli_fetch_array($sqlinfo, MYSQLI_ASSOC)) {
        if ($row['guid'] == $guid) {
            $whitelist = true;
        }
    }
    if ($whitelist) {
        echo '<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">This is a whitelisted staff member!</a></div>';
        $message = 'Admin '.$user.' tried to ban a whitelisted staff member - '.$guid;
        logIt($user, $message, $dbcon);
    } else {
        $_SESSION['guid'] = $guid;
        $_SESSION['reason'] = $reason;
        $_SESSION['time'] = $time;

        if ($_POST['guid'] != '') {
            $message = 'Admin '.$user.' has banned '.$guid.' for '.$time.' minutes under the reason of ('.$reason.')';
            logIt($user, $message, $dbcon);
            header('Location: rcon-ban.php');
        }
    }
}
?>

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
