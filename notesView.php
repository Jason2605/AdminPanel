<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

if ($staffPerms['notes'] != '1') {
    header('Location: lvlError.php');
    die();
}

include 'verifyPanel.php';
masterconnect();

if (isset($_POST['search'])) {
    $valuetosearch = $_POST['SearchValue'];
    $sqlget = "SELECT * FROM notes WHERE CONCAT (`name`) LIKE '%".$valuetosearch."%' ORDER BY note_id DESC";
    $search_result = filterTable($dbcon, $sqlget);
} else {
    $sqlget = 'SELECT * FROM notes ORDER BY note_id DESC';
    $search_result = filterTable($dbcon, $sqlget);
}

if (isset($_POST['update'])) {
    $noteID = $_POST['note_id'];
    $uid = $_POST['uid'];
    $name = $_POST['name'];
    $text = $_POST['note_text'];
    $admin = $_POST['admin'];

    if ($staffPerms['superUser'] == '1') {
        $sql = "DELETE FROM notes WHERE note_id='$noteID'";
        mysqli_query($dbcon, $sql);
        $message = 'Note ('.$text.') placed on user ('.$name.' ID - '.$uid.') by '.$admin.' was deleted by '.$user;
        logIt($user, $message, $dbcon);
    } else {
        $message = 'Note ('.$text.') placed on user ('.$name.' ID - '.$uid.') by '.$admin.' was attempted to be deleted by '.$user;
        logIt($user, $message, $dbcon);
    }
}
include 'header/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">Notes View</h1>
<p class="page-header">Notes View, allows you too see all of the notes set.</p>

<div class="btn-group" role="group" aria-label="...">
<FORM METHOD="LINK" ACTION="players.php">
<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
</FORM>
</div>


<form action = "notesView.php" method="post">
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
                    <th>Player ID</th>
                    <th>Player</th>
                    <th>Player Alias</th>
                    <th>Player Note</th>
                    <th>Staff Member</th>
                    <th>Timestamp</th>
                    <th>Delete</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<form action=notesView.php method=post>';
    switch ($row['warning']) {
        default:
            echo '<tr>';
            break;
        case 2:
            echo '<tr class = "warning">';
            break;
        case 3:
            echo '<tr class = "danger">';
            break;
        case 4:
            echo '<tr class = "success">';
            break;
    }
    echo '<td>'.$row['uid'].' </td>';
    echo '<td>'.$row['name'].' </td>';
    echo '<td>'.$row['alias'].' </td>';
    echo '<td>'.$row['note_text'].' </td>';
    echo '<td>'.$row['staff_name'].' </td>';
    echo '<td>'.$row['note_updated'].' </td>';
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Delete".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=note_id value='.$row['note_id'].' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=uid value='.$row['uid'].' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=name value='.$row['name'].' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=note_text value='.$row['note_text'].' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=admin value='.$row['staff_name'].' </td>';

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
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
