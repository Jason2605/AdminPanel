<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include 'verifyPanel.php';
masterconnect();

if ($staffPerms['money'] != '1') {
    echo "<script src='scripts/na.js'></script>";
    header('Location: lvlError.php');
    die();
}

include 'header/header.php';
?>



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
