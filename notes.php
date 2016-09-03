<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev < 2) {
  header("Location: /lvlError.php");
}

include('verifyPanel.php');
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

  </head>

  <body>

<?php

if (isset($_POST['search']))
{
  $valuetosearch = $_POST['SearchValue'];
  $sqlget = "SELECT * FROM players WHERE CONCAT (`name`) LIKE '%".$valuetosearch."%'";
  $search_result = filterTable($dbcon, $sqlget);
}
else {
  $sqlget = "SELECT * FROM players";
  $search_result = filterTable($dbcon, $sqlget);
}

function filterTable($dbcon, $sqlget)
{
  $sqldata = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');
  return $sqldata;
}

include('header/header.php');
?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Notes Menu</h1>
		  <p class="page-header">Notes Menu of the panel, allows you to set notes on players. Warning - 1 = no colour, nothing too bad. 2 = orange, small caution. 3 = Red, big caution.</p>

<div class="btn-group" role="group" aria-label="...">
<FORM METHOD="LINK" ACTION="/players.php">
<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
</FORM>
</div>


<form action = "notes.php" method="post">
		  <div class ="searchBar">
			<div class="row">
			  <div class="col-lg-6">
				<div class="input-group">
				  <input type="text" class="form-control" style = "width: 300px; " name="SearchValue" placeholder="Player name...">
				  <span class="input-group-btn">
					<input class="btn btn-default"  name="search" type="submit" value="Search">
				  </span>
				</div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
		  </div>
</form>

			<br>


          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Name</th>
					<th>Alias</th>

					<th>Warning</th>
					<th>New Notes</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
  echo "<form action=notes.php method=post>";
  echo "<tr>";


  echo "<td>".$row['name']." </td>";
  echo "<td>".$row['aliases']." </td>";
  echo "<td>"."<input class='form-control' type=text name=warn value='1' </td>";
  echo "<td>"."<input class='form-control' type=text name=note value='' </td>";
  echo "<td>"."<input class='btn btn-primary btn-outline' type=submit name=update value=Update"." </td>";
  echo "<td style='display:none;'>"."<input type=hidden name=hidden value=".$row['uid']." </td>";
  echo "</tr>";
  echo "</form>";
}


if (isset($_POST['update'])) {

$sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();

  if ($_POST['note'] != $player->notes) {
    $message = "Admin ".$user." has added the note (".$_POST['note'].") to ".$player->name."(".$player->playerid.")";
    logIt($user, $message, $dbcon);
  }
  $UpdateN = "INSERT INTO notes (uid, staff_name, note_text, warning) VALUES ('$_POST[hidden]', '$user', '$_POST[note]','$_POST[warn]')";
  mysqli_query($dbcon, $UpdateN);
};

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
