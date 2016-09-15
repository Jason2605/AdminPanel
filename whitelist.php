<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include 'verifyPanel.php';
masterconnect();

if ($staffPerms['superUser'] != '1') {
    header('Location: lvlError.php');
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

    <title>Admin Panel - Whitelist</title>

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/bootstrap.css" rel="stylesheet">

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

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Battleye Whitelist</h1>
		  <p class="page-header">Battleye whitelist, add GUID's which are immune to commands.</p>

          <div class="btn-group" role="group" aria-label="...">
          <FORM METHOD="LINK" ACTION="staff.php">
          <INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
          </FORM>
          </div><br><br>

		  <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Staff UID</th>
                    <th>Staff GUID</th>
                    <th>Add Whitelist</th>
                </tr>
              </thead>
              <tbody>
<?php
echo '<form action=whitelist.php method=post>';
  echo '<tr>';
  echo '<td>'."<input class='form-control' type=text name=uid value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=guid value='' </td>";
  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Add".' </td>';

  echo '</tr>';
  echo '</form>';

echo '</table></div>';

if (isset($_POST['update'])) {
    $guid = $_POST['guid'];
    $uid = $_POST['uid'];

    $UpdateQ = "INSERT INTO whitelist (user,uid,guid) VALUES ('$user','$uid','$guid');";
    mysqli_query($dbcon, $UpdateQ);
}

if (isset($_POST['delete'])) {
    $sql = "DELETE FROM whitelist WHERE ID='$_POST[hidden]'";
    mysqli_query($dbcon, $sql);

    echo '<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Staff GUID deleted!</a></div>';
}
?>

<br><br>

<?php

$sqlget = 'SELECT * FROM whitelist';
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');
include 'header/header.php';

?>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Whitelist Id</th>
                    <th>UID</th>
					<th>GUID</th>
					<th>Staff Added</th>
					<th>Time Stamp</th>
                    <th>Delete</th>

                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<form action=whitelist.php method=post>';
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
    echo '<td>'.$row['uid'].'</td>';
    echo '<td>'.$row['guid'].' </td>';
    echo '<td>'.$row['user'].' </td>';
    echo '<td>'.$row['date_time'].' </td>';

    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=delete value=Delete".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['id'].' </td>';
    echo '</tr>';
    echo '</form>';
}

echo '</table></div>';
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
