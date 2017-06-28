<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

$user = $_SESSION['user'];
$staffPerms = $_SESSION['perms'];

if ($staffPerms['unban'] != '1') {
    header('Location: ../lvlError.php');
    die();
}

include '../verifyPanel.php';
masterconnect();
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

    <title>Admin Panel - UnBan</title>

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
          <h1 style = "margin-top: 70px">UnBan Menu</h1>
		  <p class="page-header">UnBan menu of the panel, allows you to unban RCON banned players.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="../players.php">
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
					<th>Ban ID</th>
					<th>GUID</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
  echo '<form action=unBan.php method=post>';
  echo '<tr>';

  echo '<td>'."<input class='form-control' type=text name=banid value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=guid value='' </td>";

  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Un-Ban".' </td>';

  echo '</tr>';
  echo '</form>';
echo '</table></div>';

if (isset($_POST['update'])) {
    $banid = $_POST['banid'];
    $guidUBan = $_POST['guid'];

    $_SESSION['banid'] = $banid;
    $_SESSION['guidUBan'] = $guidUBan;

    if ($guidUBan != '' and $banid != '') {
        $message = 'Admin '.$user.' has unbanned '.$guidUBan;
        logIt($user, $message, $dbcon);
        header('Location: rcon-unBan.php');
    }
}
?>
<p><br><br><br>To unban a player you will need to get the ban ID from the Battleye List, and their GUID from the player menu!</p>

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
