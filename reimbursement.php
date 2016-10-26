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

if ($staffPerms['money'] != '1') {
    echo "<script src='scripts/na.js'></script>";
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

    <title>Admin Panel - Reimbursement Logs</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

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



        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Reimbursement Logs</h1>
		  <p class="page-header">Reimbursement Logs of the panel, allows you to see reimbursements.</p>

		  <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Player UID</th>
					<th>Amount Given</th>
					<th>Comp Reason</th>
					<th>Add Log</th>
                </tr>
              </thead>
              <tbody>
<?php
echo '<form action=reimbursement.php method=post>';
  echo '<tr>';

  echo '<td>'."<input class='form-control' type=text name=uid value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=amount value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=reason value=''</td>";
  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Add".' </td>';

  echo '</tr>';
  echo '</form>';

echo '</table></div>';

if (isset($_POST['update'])) {
    $uid = $_POST['uid'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];

    $UpdateQ = "INSERT INTO reimbursement_log (playerid,comp,reason,staff_name) VALUES ('$uid','$amount','$reason','$user');";
    mysqli_query($dbcon, $UpdateQ);
}
?>

<br><br>

<?php

$sqlget = 'SELECT * FROM reimbursement_log';
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');
include 'header/header.php';

?>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Reimbursement Id</th>
					<th>PlayerID</th>
					<th>Amount Given</th>
					<th>Reason</th>
					<th>Admin</th>
					<th>Time Stamp</th>

                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>'.$row['reimbursement_id'].'</td>';
    echo '<td>'.$row['playerid'].' </td>';
    echo '<td>'.$row['comp'].' </td>';
    echo '<td>'.$row['reason'].' </td>';
    echo '<td>'.$row['staff_name'].' </td>';
    echo '<td>'.$row['timestamp'].' </td>';
    echo '</tr>';
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
