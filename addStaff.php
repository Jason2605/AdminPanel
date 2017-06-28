<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$perms = '"[[`notes`,0],[`cop`,0],[`medic`,0],[`money`,0],[`IG-Admin`,0],[`editPlayer`,0],[`housing`,0],[`gangs`,0],[`vehicles`,0],[`logs`,0],[`steamView`,0],[`ban`,0],[`kick`,0],[`unban`,0],[`globalMessage`,0],[`restartServer`,0],[`stopServer`,0],[`superUser`,0]]"';

if ($staffPerms['superUser'] != '1') {
    header('Location: lvlError.php');
    die();
}

include 'verifyPanel.php';
loginconnect();
?>

<?php

include 'header/header.php';

?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Staff Menu</h1>
		  <p class="page-header">Staff menu of the panel, allows you to see and delete staff members.</p>

		  	<div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="staff.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
			</FORM>
			</div><br><br><br>

<?php
if (isset($_POST['update'])) {
    if ($staffPerms['superUser'] == '1') {
        $username = mysqli_real_escape_string($dbconL, $_POST['username']);
        $password = mysqli_real_escape_string($dbconL, $_POST['password']);

        $encPass = hash('sha256', $password);

        $UpdateQ = "INSERT INTO users (username, password, permissions) VALUES ('$username', '$encPass', '$perms')";
        mysqli_query($dbconL, $UpdateQ);

        echo '<div class="alert alert-success" role="alert"><a href="#" class="alert-link">User successfully added!</a></div>';
    } else {
        echo '<div class="alert alert-danger" role="alert"><a href="#" class="alert-link">Nope...</a></div>';
    }
}
?>

          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Username</th>
					<th>Password</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
echo '<form action=addStaff.php method=post>';
  echo '<tr>';

  echo '<td>'."<input class='form-control' type=text name=username value='' </td>";
  echo '<td>'."<input class='form-control' type=text name=password value=''</td>";

  echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Add".' </td>';

  echo '</tr>';
  echo '</form>';

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
  </body>
</html>
