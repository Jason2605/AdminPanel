<?php
error_reporting(0);
session_start();
ob_start();
$version = '';

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

$uidPlayer = $_POST['hidden'];
$guidPlayer = $_POST['guid'];

include 'verifyPanel.php';
masterconnect();

$sql = "SELECT * FROM `players` WHERE uid = '$uidPlayer'";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();

$username = utf8_encode($player->name);
$pid = playerID($player);
include 'header/header.php';
?>


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Edit Player</h1>
		  <p class="page-header">Edit player menu of the panel, allows you to change values in more depth.</p>
          <div id="alert-area"></div>
		  <form action='editPlayer.php' method='post'>
		  <div class="btn-group" role="group" aria-label="...">
		  <input class = 'btn btn-primary btn-outline' type='submit' name='remove' value='Reset Civ Licenses'>
	   	  </div>
          <div class="btn-group" role="group" aria-label="...">
          <input class = 'btn btn-primary btn-outline' type='submit' name='give' value='Give All Civ Licenses'>
          </div>
          <input type=hidden name=hidden value= <?php echo $uidPlayer; ?> >
          <input type=hidden name=guid value= <?php echo $guidPlayer; ?> >
          <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#myModal">Player Inventory</button>
          </form>
    </div>
          <br>



<div class="modal fade bd-example-modal-lg" id='myModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title" id="myModalLabel">Player Inventory</h4>
    </div>
    <div class="modal-body">

        <div class='panel panel-info'>
            <div class='panel-heading'>
                <h3 class='panel-title'>Civilian Inventory</h3>
            </div>
            <div class='panel-body'>
                <div class="well well-lg"><pre> <?php echo $player->civ_gear; ?> </pre></div>
            </div>
        </div>

        <div class='panel panel-info'>
            <div class='panel-heading'>
                <h3 class='panel-title'>Cop Inventory</h3>
            </div>
            <div class='panel-body'>
                <div class="well well-lg"><pre> <?php echo $player->cop_gear; ?> </pre></div>
            </div>
        </div>

        <div class='panel panel-info'>
            <div class='panel-heading'>
                <h3 class='panel-title'>Medic Inventory</h3>
            </div>
            <div class='panel-body'>
                <div class="well well-lg"><pre> <?php echo $player->med_gear; ?> </pre></div>
            </div>
        </div>

    </div>
  </div>
</div>
</div>

<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Player Info</h3>
  </div>
  <div class='panel-body'>
<?php
echo "<div class='lic'>";
echo "<div id ='editPlayer'><center><h1>".$username.'</h1></center>';
echo '<center><h4>UID: '.$player->uid.'</h3></center>';
echo '<center><h4>Player ID: '.$pid.'</h3></center>';
echo '<center><h4>GUID: '.$guidPlayer.'</h3></center>';
echo '<center><h4>Bank: $'.$player->bankacc.'</h3></center>';
echo '<center><h4>Cash: $'.$player->cash.'</h3></center>';
echo '<center><h4>Cop Level: '.$player->coplevel.'</h3></center>';
echo '<center><h4>Medic Level: '.$player->mediclevel.'</h3></center>';
echo '<center><h4>Admin Level: '.$player->adminlevel.'</h3></center>';

echo '</div>';
echo '  </div> </div> </div>';

echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Edit Player</h3>
  </div>
  <div class='panel-body'>";

?>
            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Donator Level</th>
					<th>Blacklisted</th>
                </tr>
              </thead>
              <tbody>

<?php

$sqlget = "SELECT * FROM players WHERE uid='$uidPlayer';";
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    if ($row['donorlevel'] != '' || $row['donatorlvl'] != '') {
        if ($row['donorlevel'] == '') {
            $don = $row['donatorlvl'];
            $version = 'donatorlvl';
        } else {
            $don = $row['donorlevel'];
            $version = 'donorlevel';
        }
    }

    echo '<tr>';
    outputSelection($maxDonator, $version, $don, $row['uid']);
    outputSelection(1, 'blacklist', $row['blacklist'], $row['uid']);
    echo '</tr>';
}
  echo '</table></div>';

echo '</div>';
echo '</div>';

echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Player Notes</h3>
  </div>
  <div class='panel-body'>";
  ?>
            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Added by</th>
					<th>Note</th>
					<th>Date added</th>
                </tr>
              </thead>
              <tbody>

<?php

$sqlget = "SELECT * FROM notes WHERE uid=$uidPlayer;";
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    if ($row['warning'] == 2) {
        echo '<tr class = "warning">';
    } elseif ($row['warning'] == 3) {
        echo '<tr class = "danger">';
    } else {
        echo '<tr>';
    }

    echo '<td>'.$row['staff_name'].' </td>';
    echo '<td>'.$row['note_text'].' </td>';
    echo '<td>'.$row['note_updated'].' </td>';
    echo '</tr>';
}
echo '</table></div>';
echo '</div>';
echo '</div>';

echo "<div id ='civlic'>";

  if ($player->civ_licenses !== '"[]"' && $player->civ_licenses !== '') {
      $return = explode('],[', $player->civ_licenses);

      echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Civ Licenses</h3>
  </div>
  <div class='panel-body'>";

      foreach ($return as $value) {
          license($value, $staffPerms);
      }
      echo '  </div>
</div>';
  }
echo '</div>';

echo "<div id ='civlic1'>";
  if ($player->med_licenses !== '"[]"' && $player->med_licenses !== '[]') {
      $return = explode('],[', $player->med_licenses);

      echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Medic Licenses</h3>
  </div>
  <div class='panel-body'>";

      foreach ($return as $value) {
          license($value, $staffPerms);
      }
      echo '  </div>
</div>';
  }
echo '</div>';
echo "<div id ='civlic2'>";
  if ($player->cop_licenses !== '"[]"' && $player->cop_licenses !== '') {
      $return = explode('],[', $player->cop_licenses);

      echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Cop Licenses</h3>
  </div>
  <div class='panel-body'>";

      foreach ($return as $value) {
          license($value, $staffPerms);
      }
      echo '</div></div>';
  }
echo '</div></div>';
echo "<div id ='licCheck'><h5></h5>";
echo '</div>';

if (isset($_POST['remove'])) {
    if ($staffPerms['editPlayer'] == '1') {
        $licReset = str_replace('1', '0', $player->civ_licenses);
        $sql = "UPDATE `players` SET `civ_licenses`='$licReset' WHERE uid ='$uidPlayer'";
        $result = mysqli_query($dbcon, $sql);

        $message = 'Admin '.$user.' has removed all licenses from '.utf8_encode($player->name).'('.$pid.')';
        logIt($user, $message, $dbcon);
    }
}
if (isset($_POST['give'])) {
    $uidPlayer = $_POST['hidden'];
    if ($staffPerms['editPlayer'] == '1') {
        $licReset = str_replace('0', '1', $player->civ_licenses);
        $sql = "UPDATE `players` SET `civ_licenses`='$licReset' WHERE uid ='$uidPlayer'";
        $result = mysqli_query($dbcon, $sql);

        $message = 'Admin '.$user.' has added all licenses to '.utf8_encode($player->name).'('.$pid.')';
        logIt($user, $message, $dbcon);
    }
}
?>


<script>

function post (id)
{
var newid = "#" + id;

	$(newid).toggleClass("btn-danger btn-success");

	$.post('Backend/changeLicense.php',{id:id,uid:'<?php echo $uidPlayer; ?>'},
	function(data)
	{


	});
}

function post1 (id)
{
var newid = "#" + id;

	 $(newid).toggleClass("btn-danger btn-success");

	var newid = id;
	$.post('Backend/changeLicense.php',{id:id,uid:'<?php echo $uidPlayer; ?>'},
	function(data)
	{

	});
}

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>
