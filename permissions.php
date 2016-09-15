<?php

session_start();
ob_start();
$version = '';

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}
$user = $_SESSION['user'];
$id = $_POST['hiddenId'];

include 'verifyPanel.php';
masterconnect();

$sql = "SELECT * FROM `users` WHERE `ID` = $_POST[hiddenId]";
$result = mysqli_query($dbcon, $sql);
$user = $result->fetch_object();

function stripArray($input, $type)
{
    $array = array();

    switch ($type) {
        case 0:
            $array = explode('],[', $input);
            $array = str_replace('"[[', '', $array);
            $array = str_replace(']]"', '', $array);
            $array = str_replace('`', '', $array);
            break;
    }

    return $array;
}

function before($this, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this));
}

function replace($text)
{
    return str_replace('[[', '', $text);
}
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

    <title>Admin Panel - Permissions</title>
    <link href="/dist/css/bootstrap.css" rel="stylesheet">
    <link href="/styles/dashboard.css" rel="stylesheet">

  </head>

  <body>

<?php
include 'header/header.php';
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 style = "margin-top: 70px">Permission Menu</h1>
		<p class="page-header">Permission menu of the panel, allows you to change individual staff permissions.</p>

        <div class="btn-group" role="group" aria-label="...">
        <FORM METHOD="LINK" ACTION="/staff.php">
        <INPUT class='btn btn-primary btn-outline' TYPE="submit" VALUE="Back">
        </FORM>
        </div>
        <br><br>
<?php

echo "<div id ='civlic'>";

  if ($user->permissions !== '"[]"' && $user->permissions !== '') {
      $return = stripArray($user->permissions, 0);
      $return = replace($return);

      echo "<div class='panel panel-info'>
  <div class='panel-heading'>
  <h3 class='panel-title'>Permissions</h3>
  </div>
  <div class='panel-body'>";

      foreach ($return as $value) {
          $pos = strpos($value, '1');
          if ($pos !== false) {
              $name = before(',', $value);
              echo "<button type='button' id=".$name." class='license btn btn-success btn-sm' style='margin-bottom: 5px;' onClick='post1(this.id);'>".$name.'</button> ';
          } else {
              $name = before(',', $value);
              echo "<button type='button' id=".$name." class='btn btn-danger btn-sm' style='margin-bottom: 5px;' onClick='post(this.id);'>".$name.'</button> ';
          }
      }

      echo '</div>
      <div class="panel-footer">For changes to take place the staff user must re-log, if they are currently logged in. Also be aware that superUser only gives access to staff pages - meaning you still need other permissions to change the values. (IG-Admin = In-Game Admin on the players page. Logs = Admin Logs, not reimbursement logs. EditPlayer = Everything on the editPlayer page on players.)</div>
      </div>';
  }
echo '</div>';
echo '</div>';
?>
<script>

$("button").click(function(){
    $("button").toggleClass("btn-danger btn-success");
});

function post (id)
{
var newid = "#" + id;

	$(newid).toggleClass("btn-danger btn-success");

	$.post('changePerms.php',{id:id,uid:<?php echo $id?>},
	function(data)
	{


	});
}

function post1 (id)
{
var newid = "#" + id;

	 $(newid).toggleClass("btn-danger btn-success");

	var newid = id;
	$.post('changePerms.php',{id:id,uid:<?php echo $id?>},
	function(data)
	{

	});
}

</script>
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
