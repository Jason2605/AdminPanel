<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: /index.php');
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev < 3) {
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

    <title>Admin Panel - Kick Menu</title>

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
          <h1 style = "margin-top: 70px">Kick Menu</h1>
		  <p class="page-header">Kick menu - This allows you to chose to kick the user through the use of RCON or the use of the server command, RCON allows you to give a reason for your kick however is a little more compilcated to use. Server kick however is very simple to use but is unable to give a reason!</p>

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
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="Kplayer.php">
			<div class="btn-group" role="group">
			<button class="btn btn-primary btn-outline" type="submit">RCON Kick</button>
			</div>
			</FORM>


			<FORM METHOD="LINK" ACTION="SKPlayerv1.php">
			<div class="btn-group" role="group">
			<button class="btn btn-primary btn-outline" type="submit">Server Kick</button>
			</div>
			</FORM></div>
-->


<div class="btn-group btn-group-justified" role="group" aria-label="...">

  <div class="btn-group" role="group">
  <FORM METHOD="LINK" ACTION="Kplayer.php">
    <button type="submit" class="btn btn-primary btn-outline">RCON Kick</button>
  </FORM>
  </div>


  <div class="btn-group" role="group">
  <FORM METHOD="LINK" ACTION="SKPlayerv1.php">
    <button type="submit" class="btn btn-primary btn-outline">Server Kick</button>
  </FORM>
  </div>

</div>


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
