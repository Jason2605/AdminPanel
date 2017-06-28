<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$user = $_SESSION['user'];
$staffPerms = $_SESSION['perms'];
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

    <title>Admin Panel - Gangs</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
    <!-- normal script imports etc  -->
    <script src="scripts/jquery-1.12.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="scripts/jquery.backstretch.js"></script>
    <!-- Insert this line after script imports -->
    <script>if (window.module) module = window.module;</script>
  </head>

  <body>

<?php

include 'verifyPanel.php';
masterconnect();

$sqlget = 'SELECT * FROM vehicles';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

include 'header/header.php';
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Gang Menu</h1>
		  <p class="page-header">Gang menu of the panel, allows you to change gang database values.</p>
          <div id="alert-area"></div>
<?php
$sqlget = 'SELECT * FROM gangs';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

?>
          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Owner</th>
					<th>Name</th>
					<th>Members</th>
					<th>Max Members</th>
					<th>Bank</th>
					<th>Active</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>'.$row['owner'].' </td>';
    echo '<td>'.$row['name'].' </td>';

    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'members', '<?php echo $row['members']; ?>')"; type=text value= '<?php echo $row['members']; ?>' >
    <?php
    echo '</td>';

    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'maxmembers', '<?php echo $row['maxmembers']; ?>')"; type=text value= "<?php echo $row['maxmembers']; ?>" >
    <?php
    echo '</td>';

    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'bank', '<?php echo $row['bank']; ?>')"; type=text value= "<?php echo $row['bank']; ?>" >
    <?php
    echo '</td>';


    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'active', '<?php echo $row['active']; ?>')"; type=text value= "<?php echo $row['active']; ?>" >
    <?php
    echo '</td>';

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

    <script>
    function newAlert (type, message) {
        $("#alert-area").append($("<div class='alert " + type + " fade in' data-alert><p> " + message + " </p></div>"));
        $(".alert").delay(2000).fadeOut("slow", function () { $(this).remove(); });
    }


    function dbSave(value, uid, column, original){

            if (value != original) {

                newAlert('alert-success', 'Value Updated!');

                $.post('Backend/updateGangs.php',{column:column, editval:value, id:uid},
                function(){
                    //alert("Sent values.");
                });
            };

    }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>
