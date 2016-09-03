<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

include('verifyPanel.php');
masterconnect();

$max = PHP_INT_MAX;
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

    <title>Admin Panel - Players</title>

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

if (isset($_POST['search']))
{
  $valuetosearch = $_POST['SearchValue'];
  $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`playerid`) LIKE '%".$valuetosearch."%'";
  $search_result = filterTable($dbcon, $sqlget);
}elseif (isset($_POST['orderBank']))
{
  $sqlget = "SELECT * FROM players ORDER BY bankacc DESC";
  $search_result = filterTable($dbcon, $sqlget);
}elseif (isset($_POST['orderCash']))
{
  $sqlget = "SELECT * FROM players ORDER BY cash DESC";
  $search_result = filterTable($dbcon, $sqlget);
}elseif (isset($_POST['orderCop']))
{
  $sqlget = "SELECT * FROM players ORDER BY coplevel DESC";
  $search_result = filterTable($dbcon, $sqlget);
}elseif (isset($_POST['orderMedic']))
{
  $sqlget = "SELECT * FROM players ORDER BY mediclevel DESC";
  $search_result = filterTable($dbcon, $sqlget);
}elseif (isset($_POST['orderAdmin']))
{
  $sqlget = "SELECT * FROM players ORDER BY adminlevel DESC";
  $search_result = filterTable($dbcon, $sqlget);
}
else {
  $sqlget = "SELECT * FROM players";
  $search_result = filterTable($dbcon, $sqlget);
}


if (isset($_POST['edit'])) {
  $uid = $_POST['hidden'];
  $guid = $_POST['guid'];
  $_SESSION['uidPlayer'] = $uid;
  $_SESSION['guidPlayer'] = $guid;
  //setcookie('uidPlayer', $uid);
  $url = '/editPlayer.php';
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
}
/*
if(isset($_POST['orderCash']))
{
	//$valuetosearch = $_POST['SearchValue'];
	$sqlget = "SELECT * FROM players ORDER BY cash DESC";
	$search_result = filterTable($dbcon, $sqlget);
}
else {
	$sqlget = "SELECT * FROM players";
	$search_result = filterTable($dbcon, $sqlget);
}
*/
function filterTable($dbcon, $sqlget)
{
  $sqldata = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');
  return $sqldata;
}



include('header/header.php');
?>



        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Player Menu</h1>
		  <p class="page-header">Player menu of the panel, allows you to change players database values.</p>
		  
		  
		  
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rCon/player.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Ban Player">
			</FORM>
		  </div>
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rCon/unBan.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Unban Player">
			</FORM>
		  </div>
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rCon/Kmenu.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Kick Player">
			</FORM>
		  </div>
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="notes.php" STYLE = "display: inline;">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Notes Menu">
			</FORM>
		  </div>
		 

<!--			
			<form action = "players.php" method="post">
				<div class ="searchBar"><input class='form-control' type = "text" name="SearchValue" placeholder="Player Name/UID"></div>
				<div class ="search"><input class='btn btn-primary' type = "submit" name="search" value="Filter"></div>
			</form>
-->		
<form action = "players.php" method="post">
		  <div class ="searchBar">
			<div class="row">
			  <div class="col-lg-6">
				<div class="input-group">
				  <input type="text" class="form-control" style = "width: 300px;" name="SearchValue" placeholder="Player name/UID...">
				  <span class="input-group-btn">
					<input class="btn btn-default" name="search" type="submit" value="Search">
				  </span>
				</div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
		  </div>
</form>
			
			<br>
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
            <table class="table table-striped" style = "margin-top: 0px">
              <thead>
                <tr>
					<th>ID</th>
					<th>Player Name</th>
					<th>Alias</th>
					<th>UID</th>
					<th>GUID</th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderCash' value="Player Cash"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderBank' value="Player Bank"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderCop' value="Cop Level"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderMedic' value="Medic Level"></form></th>
			
					
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderAdmin' value="Admin Level"></form></th>
					<th>Update</th>
					<th>Edit</th>
                </tr>
              </thead>
              <tbody>
<?php

if (isset($_POST['update'])) {
	


if ($adminLev > 6) {
	
$sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();	

  if ($_POST['csh'] != $player->cash) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." cash from ".$player->cash." to ".$_POST['csh'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['bankacc'] != $player->bankacc) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." bank from ".$player->bankacc." to ".$_POST['bankacc'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['coplevel'] != $player->coplevel) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." cop level from ".$player->coplevel." to ".$_POST['coplevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['mediclevel'] != $player->mediclevel) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." medic level from ".$player->mediclevel." to ".$_POST['mediclevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['adminlevel'] != $player->adminlevel) {
    $message = "Admin ".$user." changed ".$player->name."(".$player->playerid.")"." admin level from ".$player->adminlevel." to ".$_POST['adminlevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }

	
$UpdateQ = "UPDATE players SET coplevel='$_POST[coplevel]', mediclevel='$_POST[mediclevel]', adminlevel='$_POST[adminlevel]', cash='$_POST[csh]', bankacc='$_POST[bankacc]' WHERE uid='$_POST[hidden]'";
mysqli_query($dbcon, $UpdateQ);	
} elseif ($adminLev > 5) {

$sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();	

	
  if ($_POST['coplevel'] != $player->coplevel) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." cop level from ".$player->coplevel." to ".$_POST['coplevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['mediclevel'] != $player->mediclevel) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." medic level from ".$player->mediclevel." to ".$_POST['mediclevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }

	
$UpdateQ = "UPDATE players SET coplevel='$_POST[coplevel]', mediclevel='$_POST[mediclevel]' WHERE uid='$_POST[hidden]'";
mysqli_query($dbcon, $UpdateQ);
} elseif ($adminLev > 4) {
	
$sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();	
	
	
  if ($_POST['coplevel'] != $player->coplevel) {
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." cop level from ".$player->coplevel." to ".$_POST['coplevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	


$UpdateQ = "UPDATE players SET coplevel='$_POST[coplevel]' WHERE uid ='$_POST[hidden]'";
mysqli_query($dbcon, $UpdateQ);
}else {
	
$sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();	

  if ($_POST['csh'] != $player->cash) {
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." cash from ".$player->cash." to ".$_POST['csh'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['bankacc'] != $player->bankacc) {
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." bank from ".$player->bankacc." to ".$_POST['bankacc'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['coplevel'] != $player->coplevel) {
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." cop level from ".$player->coplevel." to ".$_POST['coplevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['mediclevel'] != $player->mediclevel) {
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." medic level from ".$player->mediclevel." to ".$_POST['mediclevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['adminlevel'] != $player->adminlevel) {
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." admin level from ".$player->adminlevel." to ".$_POST['adminlevel'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
}


}; //End of update button



while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {

if ($max != 2147483647) {

$steamID = $row['playerid'];
$temp = '';

for ($i = 0; $i < 8; $i++) {
  $temp .= chr($steamID & 0xFF);
  $steamID >>= 8;
}

$return = md5('BE'.$temp);
}else {
$return = "GUID can not be used with 32 bit php!";
}
  echo "<form action=players.php method=post>";
  echo "<tr>";
  echo "<td style='display:none;'>"."<input type=hidden name=hiddenUID value=".$row['playerid']." </td>";
  echo "<td>".$row['uid']."</td>";
  echo "<td>".$row['name']." </td>";
  echo "<td>".$row['aliases']." </td>";
  echo "<td>".$row['playerid']." </td>";
  echo "<td>".$return."</td>";
	
  echo "<td>"."<input class='form-control' type=text name=csh value=".$row['cash']." </td>";
  
  echo "<td>"."<input class='form-control' type=text  name=bankacc value=".$row['bankacc']." </td>";
	
  echo "<td>"."<input class='form-control' type=text style = 'width: 100%;' name=coplevel value=".$row['coplevel']." </td>";
  echo "<td>"."<input class='form-control' type=text style = 'width: 100%;' name=mediclevel value=".$row['mediclevel']." </td>";

  //if ($row['warning'] == 1){
  //echo "<td style=background-color:#00FF00;>Fine</td>";
  echo "<td><input class='form-control' type=text style = 'width: 100%;' name=adminlevel value='$row[adminlevel]' .</td>";
  //}elseif ($row['warning'] == 2){
  //echo "<td style=background-color:#FFA500;>Strike</td>";
  //echo "<td style=background-color:#FFA500;><input type=text name=warn value='$row[warning]' .</td>";	
  //}elseif ($row['warning'] == 3){
  //echo "<td style=background-color:#FF0000;><input type=text name=warn value='$row[warning]' .</td>";
  //}

	
  echo "<td>"."<input class='btn btn-primary btn-outline' type=submit name=update value=Update"." </td>";

  echo "<td>"."<input class='btn btn-primary btn-outline' type=submit name=edit id=edit value=Edit Player"." </td>";

  echo "<td style='display:none;'>"."<input type=hidden name=hidden value=".$row['uid']." </td>";
  echo "<td style='display:none;'>"."<input type=hidden name=guid value=".$return." </td>";
	
	
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
