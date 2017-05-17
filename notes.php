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
    $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`playerid`,`warning`,`uid`,`aliases`) LIKE '%".$valuetosearch."%'";
    $search_result = filterTable($dbcon, $sqlget);
    if ($search_result == '') {
        $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`pid`,`warning`,`uid`,`aliases`) LIKE '%".$valuetosearch."%'";
        $search_result = filterTable($dbcon, $sqlget);
    }
} else {
    $sqlget = 'SELECT * FROM players';
    $search_result = filterTable($dbcon, $sqlget);
}

include 'header/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">Warning Panel</h1>
<p class="page-header">Warning Menu of the panel, allows you to set points and notes on players.<br> If warning points are 30+ please go to SMT to get them banned from the server.</p>

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
			        <th>UID</th>
					<th>Name</th>
					<th>Current Points</th>
					<th>Warning Points</th>
					<th>Case Notes</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<form action=notes.php method=post>';

    echo '<tr>';
    echo '<td>'.$row['uid'].' </td>';
    echo '<td>'.$row['name'].' </td>';
    echo '<td>'.$row['warning'].' </td>';
	echo '<td>'."<input class='form-control' type=warning name=warning value=''> </td>";
    echo '<td>'."<input class='form-control' type=text name=note value=''> </td>";
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Update".'> </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['uid'].'> </td>';
    echo '</tr>';
    echo '</form>';
}

if (isset($_POST['update'])) {
    $sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
    $result = mysqli_query($dbcon, $sql);
    $player = $result->fetch_object();

    $pid = playerID($player);

    if ($_POST['note'] != $player->note_text) {
        $message = 'Admin '.$user.' has added '.$_POST['warning'].' warning points and the note ('.$_POST['note'].') to '.$player->name.'('.$_POST['hidden'].')';
        logIt($user, $message, $dbcon);
        $note = $_POST['note'];
        $note = '"'.$note.'"';
		$warning = $_POST['warning'];
        $warning = '"'.$warning.'"';
        
		$UpdateN = 'INSERT INTO notes (uid, staff_name, name, alias, note_text, warning)'
            . ' VALUES ( ?, ? , ? , ? , ? , ? )';

		if( $sth = mysqli_prepare($dbcon,$UpdateN) ) {
		  mysqli_stmt_bind_param($sth,'ssssss'
			 ,$_POST['hidden']
			 ,$user
			 ,$player->name
			 ,$player->aliases
			 ,$_POST['note']
			 ,$_POST['warning']
		  );
		  if( mysqli_stmt_execute($sth) ) {
			 // statement execution successful
		  } else {
			 printf("Error: %s\n",mysqli_stmt_error($sth));
		  }
		} else {
		  printf("Error: %s\n",mysqli_error($dbcon));
		}
		
		$UpdateN2 = 'UPDATE players SET warning = warning + ? WHERE uid = ? ';
		
		if( $sth2 = mysqli_prepare($dbcon,$UpdateN2) ) {
		  mysqli_stmt_bind_param($sth2,'ss'
			,$_POST['warning']
			,$_POST['hidden']
		  );
		  if( mysqli_stmt_execute($sth2) ) {
			 // statement execution successful
		  } else {
			 printf("1Error: %s\n",mysqli_stmt_error($sth2));
		  }
		} else {
		  printf("2Error: %s\n",mysqli_error($dbcon));
		}
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
