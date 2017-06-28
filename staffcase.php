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
include 'header/header.php';
?>



        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Staff Cases</h1>
		  <p class="page-header">Staff Case Logs of the panel, allows you to see staff cases.</p>

		  <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Your Name</th>
					<th>Person Reporting</th>
					<th>Person Being Reported</th>
					<th>Player UID</th>
					<th>Reported For</th>
					<th>OutCome</th>
					<th>Add Log</th>
                </tr>
              </thead>
              <tbody>
<?php
echo '<form action=staffcase.php method=post>';
  echo '<tr>';
  
  echo '<td>'."<input class='form-control' type=text name=staffn value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=personr value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=personbr value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=uid value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=report value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=outcome value=''</td>";
  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Add".' </td>';

  echo '</tr>';
  echo '</form>';

echo '</table></div>';

if (isset($_POST['update'])) {
	$staffn = $_POST['staffn'];
	$personr = $_POST['personr'];
	$personbr = $_POST['personbr'];
    $uid = $_POST['uid'];
    $report = $_POST['report'];
    $outcome = $_POST['outcome'];

}
$messageIdent = md5($_POST['update'] . $_POST['staffn'] . $_POST['personr'] . $_POST['personbr'] . $_POST['uid'] . $_POST['report'] . $_POST['outcome']);

$sessionMessageIdent = isset($_SESSION['messageIdent'])?$_SESSION['messageIdent']:'';

    if($messageIdent!=$sessionMessageIdent){//if its different:          
        //save the session var:
            $_SESSION['messageIdent'] = $messageIdent;
        //and...
            $UpdateQ = "INSERT INTO staff_logs (staffn,personr,personbr,playerid,report,outcome,staff_name) VALUES ('$staffn','$personr','$personbr','$uid','$report','$outcome','$user');";
			mysqli_query($dbcon, $UpdateQ);
    } else {
        //you've sent this already!
    }
?>

<br><br>

<?php

$sqlget = 'SELECT * FROM staff_logs';
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

?>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Case Id</th>
					<th>Staff Name</th>
					<th>Person Reporting</th>
					<th>Person Being Reported</th>
					<th>PlayerID</th>
					<th>Reported For</th>
					<th>Outcome</th>
					<th>Admin</th>
					<th>Time Stamp</th>

                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>'.$row['case_id'].'</td>';
	echo '<td>'.$row['staffn'].' </td>';
	echo '<td>'.$row['personr'].' </td>';
	echo '<td>'.$row['personbr'].' </td>';
    echo '<td>'.$row['playerid'].' </td>';
    echo '<td>'.$row['report'].' </td>';
    echo '<td>'.$row['outcome'].' </td>';
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
