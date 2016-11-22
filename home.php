<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

$conecG = 'work';
$_SESSION['conecFail'] = $conecG;

include 'verifyPanel.php';
masterconnect();

$players = 0;
$money = 0;

$sqlget = 'SELECT * FROM players';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    ++$players;
    $money = $money + $row['cash'] + $row['bankacc'];
}

$sqlgetVeh = 'SELECT * FROM vehicles';
$sqldataVeh = mysqli_query($dbcon, $sqlgetVeh) or die('Connection could not be established');
$vehicles = mysqli_num_rows($sqldataVeh);

include 'header/header.php';
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Dashboard</h1>
     	  <p class="page-header">Dashboard of the panel.</p>
<?php
    //Max players
    echo '
    <div class="row">
    <div class="col-md-4">
    ';

    echo    "<div id='rcorners1'>";
    echo        "<div class='box-top'><center><h1>Players</h1></div>";
    echo        "<div class='box-panel'><p></p>";
    echo        '<p><br><center>There are currently '.$players.' players signed up on the server.</p>';
    echo        '</div>';
    echo    '</div>';

    echo    '</div>';
    echo '<div class="col-md-4">';

    //Vehicles

    echo    "<div id='rcorners2'>";
    echo        "<div class='box-top'><center><h1>Vehicles</h1></div>";
    echo        "<div class='box-panel'><p></p>";
    echo        '<p><br><center>There are currently '.$vehicles.' vehicles.</p>';
    echo        '</div>';
    echo    '</div>';

    echo    '</div>';
    echo '<div class="col-md-4">';

    //?
$money = '$'.number_format($money, 2);

    echo    "<div id='rcorners3'>";
    echo        "<div class='box-top'><center><h1>Total Money</h1></div>";
    echo        "<div class='box-panel'><p></p>";
    echo        '<p><br><center>There is a total of '.$money.' on the server.</p>';
    echo        '</div>';
    echo    '</div>';

    echo    '</div>';
    echo    '</div>';
    echo    '<div class="row">';
    echo '<div class="col-lg-4">';

    echo    "<div id='rcorners5'>";
    echo        "<div class='box-top'><center><h1>Restart Server</h1></div>";
    echo        "<div class='box-panel'><p></p>";
    echo            '<form action=home.php method=post>';
    echo        "<div class = 'textSend'><td>"."<center><input class='btn btn-primary btn-outline' type=submit name=restart value=Restart".' </td></div>';
    echo        '</div>';
    echo    '</div>';
    echo  '</form>';

    echo    '</div>';
    echo '<div class="col-lg-4">';

    echo    "<div id='rcorners4'>";
    echo        "<div class='box-top'><center><h1>Global Message</h1></div>";
    echo        "<div class='box-panel'><p></p>";
    echo            '<form action=home.php method=post>';
    echo        "<div class = 'textInput'><td>"."<center><input class='form-control' type=text name=global value='' < /td></div><br>";
    echo        "<div class = 'textSend'><td>"."<center><input class='btn btn-primary btn-outline' type=submit name=send value=Send".' </td></div>';
    echo        '</div>';
    echo    '</div>';
    echo  '</form>';

    echo    '</div>';
    echo '<div class="col-lg-4">';

    echo    "<div id='rcorners6'>";
    echo        "<div class='box-top'><center><h1>Stop Server</h1></div>";
    echo        "<div class='box-panel'><p></p>";
    echo            '<form action=home.php method=post>';
    echo        "<div class = 'textSend'><td>"."<center><input class='btn btn-primary btn-outline' type=submit name=stop value=Stop".' </td></div>';
    echo        '</div>';
    echo    '</div>';
    echo  '</form>';

    echo    '</div>';
    echo    '</div>';
    echo    '<div class="row">';
    echo    '<div class="col-md-2">';
    echo    '</div>';
    echo    '<div class="col-lg-4">';

    echo    "<div id='rcorners8'>";
    echo        "<div class='box-top'><center><h1>Help</h1></div>";
    echo        "<div class='box-top'><center><h4>For general help on the panel!</h4></div>";
    echo        "<div class='box-panel'><p></p>";
    echo            '<form action=home.php method=post>';
    echo        "<div class = 'textSend'><td>"."<center><input class='btn btn-primary btn-outline' type=submit name=help value=Help".' </td></div>';
    echo        '</div>';
    echo    '</div>';
    echo  '</form>';

    echo    '</div>';
    echo '<div class="col-lg-4">';

if (isset($_POST['send'])) {
    if ($staffPerms['globalMessage'] == '1') {
        $send = $_POST['global'];
        $_SESSION['send'] = $send;
        header('Location: rCon/rcon-mess.php');
        $message = 'Admin '.$user.' has sent a global message ('.$send.')';
        logIt($user, $message, $dbcon);
    } else {
        header('Location: lvlError.php');
    }
}

if (isset($_POST['restart'])) {
    if ($staffPerms['restartServer'] == '1') {
        $message = 'Admin '.$user.' has restarted the server.';
        logIt($user, $message, $dbcon);
        header('Location: rCon/rcon-restart.php');
    } else {
        header('Location: lvlError.php');
    }
}

if (isset($_POST['stop'])) {
    if ($staffPerms['stopServer'] == '1') {
        $message = 'Admin '.$user.' has stopped the server.';
        logIt($user, $message, $dbcon);
        header('Location: rCon/rcon-stop.php');
    } else {
        header('Location: lvlError.php');
    }
}

if (isset($_POST['help'])) {
    header('Location: help.php');
}
ob_end_flush();
?>
<div class = "donate">
<div class ="headD"><center><h3>Donate to see further updates!<h3></center></div>
	<div class ="donateB"><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="jasonhall96686@yahoo.com">
	<input type="hidden" name="lc" value="GB">
	<input type="hidden" name="item_name" value="AdminPanel">
	<input type="hidden" name="no_note" value="0">
	<input type="hidden" name="currency_code" value="GBP">
	<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
	<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
	</form></div>
</div>

</div>
</div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
