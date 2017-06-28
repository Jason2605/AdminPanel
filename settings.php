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

if ($staffPerms['superUser'] != '1') {
    header('Location: lvlError.php');
    die();
}

include 'header/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">Settings Menu</h1>
    <p class="page-header">Settings menu of the panel, allows you to change panel settings.</p>
<div class='panel panel-info'>
    <div class='panel-heading'>
        <h3 class='panel-title'>Server Info</h3>
    </div>
<div class='panel-body'>

<form action = "updateSettings.php" method="post">
  <h4>Database Host</h4>
  <input type="text" name= "host" class="form-control" value="<?php echo $DBHost; ?>">

  <br>
  <h4>Username</h4>
  <input type="text" name= "user" class="form-control" value="<?php echo $DBUser; ?>">

  <br>
  <h4>Password</h4>
  <input type="password" name= "pass" class="form-control" value="<?php echo $DBPass; ?>">

  <br>
  <h4>Database Name</h4>
  <input type="text" name= "name" class="form-control" value="<?php echo $DBName; ?>">

  <h4>RCON Host</h4>
  <input type="text" name= "RHost" class="form-control" value="<?php echo $RconHost; ?>">

  <br>
  <h4>RCON Pass</h4>
  <input type="password" name= "RPass" class="form-control" value="<?php echo $RconPass; ?>">

  <br>
  <h4>RCON Port</h4>
  <input type="text" name= "RPort" class="form-control" value="<?php echo $RconPort; ?>">

  <br>
  <h4>Max Cop Level</h4>
  <input type="text" name= "maxCop" class="form-control" value="<?php echo $maxCop; ?>">

  <br>
  <h4>Max Medic Level</h4>
  <input type="text" name= "maxMedic" class="form-control" value="<?php echo $maxMedic; ?>">

  <br>
  <h4>Max Admin Level</h4>
  <input type="text" name= "maxAdmin" class="form-control" value="<?php echo $maxAdmin; ?>">

  <br>
  <h4>Max Donator Level</h4>
  <input type="text" name= "maxDonator" class="form-control" value="<?php echo $maxDonator; ?>">

  <br>
  <h4>API Username</h4>
  <input type="text" name= "apiUser" class="form-control" value="<?php echo $apiUser; ?>">

  <br>
  <h4>API Password</h4>
  <input type="text" name= "apiPass" class="form-control" value="<?php echo $apiPass; ?>">

  <br>
  <h4>API Enabled</h4>
  <select class='form-control'name = 'apiEnable'>
     <?php if ($apiEnable == 1) {
    echo '<option>0</option>';
    echo '<option selected="selected">1</option>';
} else {
    echo '<option selected="selected">0</option>';
    echo '<option>1</option>';
}

     ?>

  </select>


  <br>
  <button type="submit" name="updateButton" class="btn btn-primary btn-lg btn-block btn-outline">Update</button>
</form>

</div>
</div>
<?php


?>


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
