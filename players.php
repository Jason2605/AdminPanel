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
$page1 = $_GET['page'];
if ($page1 == '' || $page1 == '1') {
    $page = 0;
} else {
    $page = ($page1 * 50) - 50;
}
$resultQ = 'SELECT uid FROM players';
$result = mysqli_query($dbcon, $resultQ) or die('Connection could not be established');
$count = mysqli_num_rows($result);
$amount = $count / 50;
$amount = ceil($amount) + 1;
$currentpage = $page1;
$minusPage = $currentpage - 1;
if ($minusPage < 1) {
    $minusPage = 1;
}
$addPage = $currentpage + 1;
if ($addPage > $amount) {
    $addPage = $amount;
}
$max = PHP_INT_MAX;
switch ($_GET['search']) {
    case 'cash':
        $search = 'cash';
        break;
    case 'bank':
        $search = 'bank';
        break;
    case 'cop':
        $search = 'cop';
        break;
    case 'medic':
        $search = 'medic';
        break;
    case 'admin':
        $search = 'admin';
        break;
    default:
        $search = 'Nope';
        break;
}
if (isset($_POST['search'])) {
    $valuetosearch = $_POST['SearchValue'];
    $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`playerid`,`uid`, `aliases`) LIKE '%".$valuetosearch."%'";
    $search_result = filterTable($dbcon, $sqlget);
    if ($search_result == '') {
        $sqlget = "SELECT * FROM players WHERE CONCAT (`name`,`pid`,`uid`, `aliases`) LIKE '%".$valuetosearch."%'";
        $search_result = filterTable($dbcon, $sqlget);
    }
} elseif (isset($_POST['orderBank']) || $_GET['search'] == 'bank') {
    $sqlget = 'SELECT * FROM players ORDER BY bankacc DESC limit '.$page.',50';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderCash']) || $_GET['search'] == 'cash') {
    $sqlget = 'SELECT * FROM players ORDER BY cash DESC limit '.$page.',50';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderCop']) || $_GET['search'] == 'cop') {
    $sqlget = 'SELECT * FROM players ORDER BY coplevel DESC limit '.$page.',50';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderMedic']) || $_GET['search'] == 'medic') {
    $sqlget = 'SELECT * FROM players ORDER BY mediclevel DESC limit '.$page.',50';
    $search_result = filterTable($dbcon, $sqlget);
} elseif (isset($_POST['orderAdmin']) || $_GET['search'] == 'admin') {
    $sqlget = 'SELECT * FROM players ORDER BY adminlevel DESC limit '.$page.',50';
    $search_result = filterTable($dbcon, $sqlget);
} else {
    $sqlget = 'SELECT * FROM players limit '.$page.',50';
    $search_result = filterTable($dbcon, $sqlget);
}
include 'header/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 style = "margin-top: 70px">Player Menu</h1>
    <p class="page-header">Player menu of the panel, allows you to change players database values.</p>
    <div id="alert-area"></div>

    <?php
    switch ($staffPerms) {
        case $staffPerms['ban'] == '1':
            echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
			              <FORM METHOD=\"LINK\" ACTION=\"rCon/player.php\">
			              <INPUT class='btn btn-primary btn-outline' TYPE=\"submit\" VALUE=\"Ban Player\">
		        	      </FORM>
		                  </div>";
        case $staffPerms['unban'] == '1':
            echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
			              <FORM METHOD=\"LINK\" ACTION=\"rCon/unBan.php\">
			              <INPUT class='btn btn-primary btn-outline' TYPE=\"submit\" VALUE=\"Unban Player\">
			              </FORM>
		                  </div>";
        case $staffPerms['kick'] == '1':
            echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
			              <FORM METHOD=\"LINK\" ACTION=\"rCon/Kmenu.php\">
			              <INPUT class='btn btn-primary btn-outline' TYPE=\"submit\" VALUE=\"Kick Player\">
			              </FORM>
		                  </div>";
        case $staffPerms['notes'] == '1':
            echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
			              <FORM METHOD=\"LINK\" ACTION=\"notes.php\" STYLE = \"display: inline;\">
			              <INPUT class='btn btn-primary btn-outline' TYPE=\"submit\" VALUE=\"Notes Menu\">
			              </FORM>
		                  </div>";
    }
    ?>

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
                <th><form action = "players.php?search=cash" method="post"><input class='btn-link' type='submit' name='orderCash' value="Player Cash"></form></th>
                <th><form action = "players.php?search=bank" method="post"><input class='btn-link' type='submit' name='orderBank' value="Player Bank"></form></th>
                <th><form action = "players.php?search=cop" method="post"><input class='btn-link' type='submit' name='orderCop' value="Cop Level"></form></th>
                <th><form action = "players.php?search=medic" method="post"><input class='btn-link' type='submit' name='orderMedic' value="Medic Level"></form></th>
                <th><form action = "players.php?search=admin" method="post"><input class='btn-link' type='submit' name='orderAdmin' value="Admin Level"></form></th>
                <th>View Stats</th>
            </tr>
            </thead>
            <tbody>
            <?php
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
                echo '<tr>';
                echo '<td>'.$row['uid'].'</td>';
                echo '<td>'.utf8_encode($row['name']).' </td>';
                echo '<td>'.utf8_encode($alias[1]).' </td>';
                echo '<td>'.$pid.' </td>';
                echo '<td>'.$return.'</td>';
                echo '<td>' ?>
                <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['uid']; ?>', 'cash', '<?php echo $row['cash']; ?>')"; type=text value= "<?php echo $row['cash']; ?>" >
                <?php
                echo '</td>';
                echo '<td>' ?>
                <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['uid']; ?>', 'bankacc', '<?php echo $row['bankacc']; ?>')"; type=text value= "<?php echo $row['bankacc']; ?>" >
                <?php
                echo '</td>';
                outputSelection($maxCop, 'coplevel', $row['coplevel'], $row['uid']);
                outputSelection($maxMedic, 'mediclevel', $row['mediclevel'], $row['uid']);
                outputSelection($maxAdmin, 'adminlevel', $row['adminlevel'], $row['uid']);
                echo '<form action=editPlayer.php method=post>';
                echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=edit id=edit value=View".' ></td>';
                echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['uid'].'> </td>';
                echo "<td style='display:none;'>".'<input type=hidden name=guid value='.$return.'> </td>';
                echo '</form>';
                echo '</tr>';
            }
            echo '</table></div>';
            ?>

            <nav>
                <ul class="pagination">
                    <?php if ($currentpage != 1) {
                        ?>
                        <li>
                            <a href="players.php?search=<?php echo $search; ?>&page=<?php echo $minusPage; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                    } else {
                        ?>

                        <li class = "disabled">
                            <a href="players.php?search=<?php echo $search; ?>&page=<?php echo $minusPage; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php
                    }
                    $amountPage = $currentpage + 2;
                    $pageBefore = $currentpage - 2;
                    if ($pageBefore == 0) {
                        $pageBefore = 1;
                        $amountPage = $amountPage + 1;
                    }
                    if ($pageBefore < 1) {
                        $pageBefore = 1;
                        $amountPage = $amountPage + 2;
                    }
                    for ($b = $pageBefore; $b <= $amountPage; ++$b) {
                    if ($b >= $amount) {
                        ?><li class = "disabled"><a href = "players.php?search=<?php echo $search; ?>&page=<?php echo $b; ?>" style = "text-decoration:none"><?php  echo $b.' '; ?></a><li><?php
                    } else {
                    if ($b == $currentpage) {
                        ?><li class = "active"><a href = "players.php?search=<?php echo $search; ?>&page=<?php echo $b; ?>" style = "text-decoration:none"><?php  echo $b.' '; ?></a><li><?php
                    } else {
                    ?><li><a href = "players.php?search=<?php echo $search; ?>&page=<?php echo $b; ?>" style = "text-decoration:none"><?php  echo $b.' '; ?></a><li><?php
                        }
                        }
                        }
                        if ($currentpage != $amount) {
                        ?>
                    <li>
                        <a href="players.php?search=<?php echo $search; ?>&page=<?php echo $addPage; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php
                } else {
                    ?>

                    <li class = "disabled">
                        <a href='players.php?search=<?php echo $search; ?>&page=<?php echo $minusPage; ?>' aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>

                    <?php
                }
                ?>
                </ul>
            </nav>
            <script>
                function newAlert (type, message) {
                    $("#alert-area").append($("<div class='alert " + type + " fade in' data-alert><p> " + message + " </p></div>"));
                    $(".alert").delay(2000).fadeOut("slow", function () { $(this).remove(); });
                }
                function dbSave(value, uid, column, original){
                    if (value != original) {
                        newAlert('alert-success', 'Value Updated!');
                        $.post('Backend/updatePlayers.php',{column:column, editval:value, uid:uid},
                            function(){
                                //alert("Sent values.");
                            });
                    };
                }
            </script>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>