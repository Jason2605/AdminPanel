<?php
error_reporting(0);
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include 'verifyPanel.php';
masterconnect();

$max = PHP_INT_MAX;
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Admin Panel - Players</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>

<?php

if (isset($_POST['search'])) {
    $valuetosearch = $_POST['SearchValue'];
    $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`playerid`,`uid`) LIKE '%".$valuetosearch."%'";
    $search_result = filterTable($dbcon, $sqlget);
    if ($search_result == '') {
        $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`pid`,`uid`) LIKE '%".$valuetosearch."%'";
        $search_result = filterTable($dbcon, $sqlget);
    }
} elseif (isset($_POST['orderBank'])) {
    $sqlget = 'SELECT * FROM players ORDER BY bankacc DESC';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderCash'])) {
    $sqlget = 'SELECT * FROM players ORDER BY cash DESC';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderCop'])) {
    $sqlget = 'SELECT * FROM players ORDER BY coplevel DESC';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderMedic'])) {
    $sqlget = 'SELECT * FROM players ORDER BY mediclevel DESC';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderAdmin'])) {
    $sqlget = 'SELECT * FROM players ORDER BY adminlevel DESC';
    $search_result = filterTable($dbcon, $sqlget);
} else {
    $sqlget = 'SELECT * FROM players';
    $search_result = filterTable($dbcon, $sqlget);
}

include 'header/header.php';
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Player Menu</h1>
		  <p class="page-header">Player menu of the panel, allows you to change players database values.</p>

		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rCon/player.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Ban Player">
			</FORM>
		  </div>
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rCon/unBan.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Unban Player">
			</FORM>
		  </div>
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="rCon/Kmenu.php">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Kick Player">
			</FORM>
		  </div>
		  <div class="btn-group" role="group" aria-label="...">
			<FORM METHOD="LINK" ACTION="notes.php" STYLE = "display: inline;">
			<INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Notes Menu">
			</FORM>
		  </div>

<form action = "players.php" method="post">
		  <div class ="searchBar">
			<div class="row">
			  <div class="col-lg-6">
				<div class="input-group">
				  <input type="text" class="form-control" style = "width: 300px;" name="SearchValue" placeholder="Player name/UID/ID...">
				  <span class="input-group-btn">
					<input class="btn btn-default" name="search" type="submit" value="Search">
				  </span>
				</div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
		  </div>
</form>

			<br>


          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: 0px">
              <thead>
                <tr>
					<th>ID</th>
					<th>Player Name</th>
					<th>Alias</th>
					<th>UID</th>
					<th>GUID</th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderCash' value="Player Cash"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderBank' value="Player Bank"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderCop' value="Cop Level"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderMedic' value="Medic Level"></form></th>
					<th><form action = "players.php" method="post"><input class='btn-link' type='submit' name='orderAdmin' value="Admin Level"></form></th>
					<th>Update</th>
					<th>Edit</th>
                </tr>
              </thead>
              <tbody>
<?php

if (isset($_POST['update'])) {
    $sql = "SELECT * FROM `players` WHERE `uid` = $_POST[hidden]";
    $result = mysqli_query($dbcon, $sql);
    $player = $result->fetch_object();

    $cash = $player->cash;
    $bank = $player->bankacc;
    $cop = $player->coplevel;
    $medic = $player->mediclevel;
    $admin = $player->adminlevel;

    if ($player->playerid != '' || $player->pid != '') {
        if ($player->playerid == '') {
            $pid = $player->pid;
        } else {
            $pid = $player->playerid;
        }
    }

    if ($staffPerms['money'] == '1') {
        if ($_POST['csh'] != $player->cash) {
            $message = 'Admin '.$user.' has changed '.utf8_encode($player->name).'('.$pid.')'.' cash from '.$player->cash.' to '.$_POST['csh'];
            logIt($user, $message, $dbcon);

            $cash = $_POST['csh'];
        }

        if ($_POST['bankacc'] != $player->bankacc) {
            $message = 'Admin '.$user.' has changed '.utf8_encode($player->name).'('.$pid.')'.' bank from '.$player->bankacc.' to '.$_POST['bankacc'];
            logIt($user, $message, $dbcon);

            $bank = $_POST['bankacc'];
        }
    } else {
        if ($_POST['csh'] != $player->cash) {
            $message = 'Admin '.$user.' tried to change '.utf8_encode($player->name).'('.$pid.')'.' cash from '.$player->cash.' to '.$_POST['csh'];
            logIt($user, $message, $dbcon);

            $cash = $player->cash;
        }

        if ($_POST['bankacc'] != $player->bankacc) {
            $message = 'Admin '.$user.' tried to change '.utf8_encode($player->name).'('.$pid.')'.' bank from '.$player->bankacc.' to '.$_POST['bankacc'];
            logIt($user, $message, $dbcon);

            $bank = $player->bankacc;
        }
    }

    if ($staffPerms['cop'] == '1') {
        if ($_POST['coplevel'] != $player->coplevel) {
            $message = 'Admin '.$user.' has changed '.utf8_encode($player->name).'('.$pid.')'.' cop level from '.$player->coplevel.' to '.$_POST['coplevel'];
            logIt($user, $message, $dbcon);

            $cop = $_POST['coplevel'];
        }
    } else {
        if ($_POST['coplevel'] != $player->coplevel) {
            $message = 'Admin '.$user.' tried to change '.utf8_encode($player->name).'('.$pid.')'.' cop level from '.$player->coplevel.' to '.$_POST['coplevel'];
            logIt($user, $message, $dbcon);

            $cop = $player->coplevel;
        }
    }

    if ($staffPerms['medic'] == '1') {
        if ($_POST['mediclevel'] != $player->mediclevel) {
            $message = 'Admin '.$user.' has changed '.utf8_encode($player->name).'('.$pid.')'.' medic level from '.$player->mediclevel.' to '.$_POST['mediclevel'];
            logIt($user, $message, $dbcon);

            $medic = $_POST['mediclevel'];
        }
    } else {
        if ($_POST['mediclevel'] != $player->mediclevel) {
            $message = 'Admin '.$user.' tried to change '.utf8_encode($player->name).'('.$pid.')'.' medic level from '.$player->mediclevel.' to '.$_POST['mediclevel'];
            logIt($user, $message, $dbcon);

            $medic = $player->mediclevel;
        }
    }

    if ($staffPerms['IG-Admin'] == '1') {
        if ($_POST['adminlevel'] != $player->adminlevel) {
            $message = 'Admin '.$user.' changed '.utf8_encode($player->name).'('.$pid.')'.' admin level from '.$player->adminlevel.' to '.$_POST['adminlevel'];
            logIt($user, $message, $dbcon);

            $admin = $_POST['adminlevel'];
        }
    } else {
        if ($_POST['adminlevel'] != $player->adminlevel) {
            $message = 'Admin '.$user.' tried to change '.utf8_encode($player->name).'('.$pid.')'.' admin level from '.$player->adminlevel.' to '.$_POST['adminlevel'];
            logIt($user, $message, $dbcon);

            $admin = $player->adminlevel;
        }
    }

    $UpdateQ = "UPDATE players SET coplevel='$cop', mediclevel='$medic', adminlevel='$admin', cash='$cash', bankacc='$bank' WHERE uid='$_POST[hidden]'";
    mysqli_query($dbcon, $UpdateQ);
}

while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    if ($row['playerid'] != '' || $row['pid'] != '') {
        if ($row['playerid'] == '') {
            $pid = $row['pid'];
        } else {
            $pid = $row['playerid'];
        }
    }
    $return = guid($max, $pid);
    $alias = explode('`', $row['aliases']);
    echo '<form action=players.php method=post>';
    echo '<tr>';
    echo "<td style='display:none;'>".'<input type=hidden name=hiddenUID value='.$pid.' </td>';
    echo '<td>'.$row['uid'].'</td>';
    echo '<td>'.utf8_encode($row['name']).' </td>';
    echo '<td>'.utf8_encode($alias[1]).' </td>';
    echo '<td>'.$pid.' </td>';
    echo '<td>'.$return.'</td>';
    //inputs
    echo '<td>'."<input class='form-control' type=text name=csh value=".$row['cash'].' </td>';
    echo '<td>'."<input class='form-control' type=text  name=bankacc value=".$row['bankacc'].' </td>';
    outputSelection($maxCop, 'coplevel', $row['coplevel']);
    outputSelection($maxMedic, 'mediclevel', $row['mediclevel']);
    outputSelection($maxAdmin, 'adminlevel', $row['adminlevel']);
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Update".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['uid'].' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=guid value='.$return.' </td>';
    echo '</form>';
    echo '<form action=editPlayer.php method=post>';
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=edit id=edit value=Edit Player".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['uid'].' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=guid value='.$return.' </td>';
    echo '</form>';
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
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
