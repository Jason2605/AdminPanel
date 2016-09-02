<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])){
    header("Location: /index.php");
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev < 7){
  header("Location: ../lvlError.php");
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

    <title>Admin Panel - UnBan</title>

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
include('../header/header.php');
?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">UnBan Menu</h1>
		  <p class="page-header">UnBan menu of the panel, allows you to unban RCON banned players.</p>
		  
		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="/home.php">
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
					<th>Ban ID</th>
					<th>GUID</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
  echo "<form action=unBan.php method=post>";
  echo "<tr>";
	
  echo "<td>" ."<input class='form-control' type=text name=banid value='' </td>";
  echo "<td>" ."<input class='form-control' type=text name=guid value='' </td>";

  echo "<td>" . "<input class='btn btn-primary btn-outline' type=submit name=update value=Un-Ban". " </td>";
  //echo "<td>" ."<input type=hidden name=hidden value=" .$row['ID'] . " </td>";
	
  echo "</tr>";
  echo "</form>";
echo "</table></div>";

if (isset($_POST['update'])){
	
  $banid = $_POST['banid'];
  $guidUBan = $_POST['guidUBan'];
	
  $_SESSION['banid'] = $banid;
  $_SESSION['guidUBan'] = $guidUBan;
	
  //include('../verifyPanel.php');
  //masterconnect();
	
  if ($guidUBan != "" and $banid != ""){
	
  if ($_POST['banid'] != ""){
    $message = "Admin ".$user." has unbanned ".$guidUBan;
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  header("Location: rcon-unBan.php");
  }
};
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
