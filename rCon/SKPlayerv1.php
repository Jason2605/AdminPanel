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
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
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

if (isset($_POST['update'])) {
    $guid = $_POST['hiddenUID'];

    $sql = 'SELECT uid,guid FROM whitelist';
    $sqlinfo = mysqli_query($dbcon, $sql) or die('Connection could not be established');

    while ($row = mysqli_fetch_array($sqlinfo, MYSQLI_ASSOC)) {
        if ($row['uid'] == $guid) {
            $whitelist = true;
        }
    }
    if ($whitelist) {
        echo '<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">This is a whitelisted staff member!</a></div>';
        $message = 'Admin '.$user.' tried to kick a whitelisted staff member - '.$guid;
        logIt($user, $message, $dbcon);
    } else {
        $name = $_POST['hiddenName'];
        $_SESSION['SKguid'] = $guid;

        $message = 'Admin '.$user.' has kicked '.$player->name.'('.$guid.')';
        logIt($user, $message, $dbcon);
        header('Location: rcon-Skick.php');
    }
}

$sqlget = 'SELECT * FROM players';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    if ($row['playerid'] != '' || $row['pid'] != '') {
        if ($row['playerid'] == '') {
            $pid = $row['pid'];
        } else {
            $pid = $row['playerid'];
        }
    }

    echo '<form action=SKPlayerv1.php method=post>';
    echo '<tr>';

    echo "<td style='display:none;'>".'<input type=hidden name=hiddenUID value='.$pid.' </td>';
    echo '<td>'.$row['name'].' </td>'; ?>
    <td>
    <?php echo '<button class="btn btn-primary btn-outline" type="button" data-toggle="collapse" data-target="#'.$row['uid'].'" aria-expanded="false" aria-controls="'.$row['uid'].'" >'; ?>
      Toggle Aliases
    </button>
    <?php echo '<div class="collapse" id='.$row['uid'].' >' ?>
      <div class="well">
        <?php echo $row['aliases']; ?>
      </div>
    </div>
</td>
    <?php


    echo '<td>'.$pid.' </td>';
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Kick".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hiddenName value='.$row['name'].' </td>';

    echo '</tr>';
    echo '</form>';
}

echo '</table></div>';
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
    <script src="../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
