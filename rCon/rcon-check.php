<?php
session_start();
$debug = false;

if ($debug) {
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $start = $time;
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

require_once '../ArmaRConClass/rcon.php';

include '../verifyPanel.php';
Rconconnect();

$check = $rcon->get_players();
preg_match_all("#(\d+)\s+(\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}:\d+\b)\s+(\d+)\s+([0-9a-fA-F]+)\(\w+\)\s([\S ]+)$#im", $check, $players);

$bansRaw = $rcon->get_bans();
preg_match_all("#(\d+)\s+([0-9a-fA-F]+)\s([perm|\d]+)\s([\S ]+)$#im", $bansRaw, $str);
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

    <title>Admin Panel - Battleye</title>
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>

<?php


?>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarside" aria-expanded="false" aria-controls="navbarside">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <div class="navbar-brand"><a href="#">Admin<span>Panel</span></a></div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../home.php" style="color: #fff">Dashboard</a></li>
            <li><a href="../settings.php" style="color: #fff">Settings</a></li>
            <li><a href="../profile.php" style="color: #fff">Profile</a></li>
            <li><a href="../help.php" style="color: #fff">Help</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div id="navbarside" class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
				<li><a href="../home.php">Dashboard</a></li>
				<li><a href="../players.php">Players</a></li>
				<li><a href="../vehicles.php">Vehicles</a></li>
				<li><a href="../gangs.php">Gangs</a></li>
				<li><a href="../houses.php">Houses</a></li>
				<li><a href="../logs.php">Logs</a></li>
                <li><a href="../reimbursement.php">Reimbursement Logs</a></li>
				<li><a href="../notesView.php">Notes</a></li>
				<li><a href="../staff.php">Staff</a></li>
				<li><a href="../Steam/steam.php">Steam Accounts</a></li>
				<li><a href="../logout.php">Log Out</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">BattleEye Logs</h1>
		  <p class="page-header">BattleEye Logs.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="../players.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
			</FORM>
			</div><br><br><br>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Battle ID</th>
					<th>Player Name</th>
                </tr>
              </thead>
              <tbody>
<?php
$i = 0;
foreach ($players[1] as $match) {
    echo '<tr><td>'.$players[1][$i].'</td>';
    echo '<td>'.$players[5][$i].'</td></tr>';
    ++$i;
}
echo '</table></div>';
?>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Ban ID</th>
					<th>GUID</th>
					<th>Time</th>
					<th>Reason</th>
                </tr>
              </thead>
              <tbody>
<?php
$ii = 0;
foreach ($str[0] as $ban) {
    echo '<tr><td>'.$str[1][$ii].'</td>';
    echo '<td>'.$str[2][$ii].'</td>';
    echo '<td>'.$str[3][$ii].'</td>';
    echo '<td>'.$str[4][$ii].'</td></tr>';
    ++$ii;
}

echo '</table></div>';

if ($debug) {
    echo '<br>';
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $finish = $time;
    $total_time = round(($finish - $start), 4);
    echo 'Page generated in '.$total_time.' seconds.';
}
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
