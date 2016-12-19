<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

if ($staffPerms['notes'] != '1') {
    header('Location: lvlError.php');
}

include 'verifyPanel.php';
masterconnect();

if (isset($_POST['search'])) {
    $valuetosearch = $_POST['SearchValue'];
    $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`playerid`,`uid`) LIKE '%".$valuetosearch."%'";
    $search_result = filterTable($dbcon, $sqlget);
    if ($search_result == '') {
        $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`pid`,`uid`) LIKE '%".$valuetosearch."%'";
        $search_result = filterTable($dbcon, $sqlget);
    }
} else {
    $sqlget = 'SELECT * FROM players';
    $search_result = filterTable($dbcon, $sqlget);
}

include 'header/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">Notes Menu</h1>
<p class="page-header">Notes Menu of the panel, allows you to set notes on players. Warning - 1 = no colour, nothing too bad. 2 = orange, small caution. 3 = Red, big caution.</p>

<div class="btn-group" role="group" aria-label="...">
<FORM METHOD="LINK" ACTION="players.php">
<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
</FORM>
</div>


<form action = "notes.php" method="post">
		  <div class ="searchBar">
			<div class="row">
			  <div class="col-lg-6">
				<div class="input-group">
				  <input type="text" class="form-control" style = "width: 300px; " name="SearchValue" placeholder="Player name/UID/ID...">
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
                    			<th>UID</th>
					<th>Warning</th>
					<th>New Notes</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<form action=notes.php method=post>';
    echo '<tr>';

    echo '<td>'.$row['name'].' </td>';
    echo '<td>'.$row['aliases'].' </td>';
    echo '<td>'.$row['uid'].' </td>';
    echo '<td><div class="form-group"><label>Select Type:</label><select class="form-control" name="warn"><option>1</option><option>2</option><option>3</option></select></div></td>';
    echo '<td>'."<input class='form-control' type=text name=warn value='1' </td>";
    echo '<td>'."<input class='form-control' type=text name=note value='' </td>";
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Update".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['uid'].' </td>';
    echo '</tr>';
    echo '</form>';
}

if (isset($_POST['update'])) {
    $sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
    $result = mysqli_query($dbcon, $sql);
    $player = $result->fetch_object();

    $pid = playerID($player);

    if ($_POST['note'] != $player->note_text) {
        $message = 'Admin '.$user.' has added the note ('.$_POST['note'].') to '.$player->name.'('.$pid.')';
        logIt($user, $message, $dbcon);
        $note = $_POST['note'];
        $note = '"'.$note.'"';
        $UpdateN = "INSERT INTO notes (uid, staff_name, name, alias, note_text, warning) VALUES ('$_POST[hidden]', '$user', '$player->name', '$player->aliases', '$note','$_POST[warn]')";
        mysqli_query($dbcon, $UpdateN);
    }
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
