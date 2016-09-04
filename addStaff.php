<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$adminLev = $_SESSION['adminLevel'];

if ($adminLev != 8) {
    echo "<script src='scripts/na.js'></script>";
    header('Location: lvlError.php');
}

include 'verifyPanel.php';
loginconnect();
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

    <title>Admin Panel - Staff</title>

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

<?php

include 'header/header.php';

?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px"> Menu</h1>
		  <p class="page-header">Staff menu of the panel, allows you to see and delete staff members.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="staff.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
			</FORM>
			</div><br><br><br>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Username</th>
					<th>Password</th>
					<th>Admin Level</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
echo '<form action=addStaff.php method=post>';
  echo '<tr>';

  echo '<td>'."<input class='form-control' type=text name=username value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=password value=''</td>";
  echo '<td>'."<input class='form-control' type=text name=adminlevel value='' </td>";

  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Add".' </td>';

  echo '</tr>';
  echo '</form>';

echo '</table></div>';

if (isset($_POST['update'])) {
    if ($adminLev == '8') {
        $username = mysqli_real_escape_string($dbconL, $_POST['username']);
        $password = mysqli_real_escape_string($dbconL, $_POST['password']);
        $admin = mysqli_real_escape_string($dbconL, $_POST['adminlevel']);

        $intAdmin = (int) $admin;
        $encPass = sha1($password);

        $UpdateQ = "INSERT INTO users (username, password, level) VALUES ('$username', '$password', '$intAdmin')";
        mysqli_query($dbconL, $UpdateQ);
    }
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
