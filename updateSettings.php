<?php

session_start();

$adminLev = $_SESSION['adminLevel'];

if ($adminLev != 8) {
    header('Location: lvlError.php');
}

$fail = false;
  if ($_POST['user'] != '') {
      $user = $_POST['user'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['pass'] != '') {
      $pass = $_POST['pass'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['host'] != '') {
      $host = $_POST['host'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['name'] != '') {
      $name = $_POST['name'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['lName'] != '') {
      $lName = $_POST['lName'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['RHost'] != '') {
      $RHost = $_POST['RHost'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['RPass'] != '') {
      $RPass = $_POST['RPass'];
  } else {
      echo 'error?';
      $fail = true;
  }

  if ($_POST['RPort'] != '') {
      $RPort = $_POST['RPort'];
      $RPort = (int) $RPort;
  } else {
      echo 'error?';
      $fail = true;
  }

if (!$fail) {
    $filename = 'verifyPanel.php';
    $ourFileName = $filename;
    $ourFileHandle = fopen($ourFileName, 'w');

    $written = '<?php

function masterconnect(){

	global '.'$'.'dbcon;
	'.'$'."dbcon = mysqli_connect('$host', '$user', '$pass', '$name') or die ('Database connection failed');
}

function loginconnect(){

	global ".'$'.'dbconL;
	'.'$'."dbconL = mysqli_connect('$host', '$user', '$pass', '$lName');
}

function Rconconnect(){

	global ".'$'.'rcon;
	'.'$'."rcon = new \Nizarii\ArmaRConClass\ARC('$RHost', $RPort, '$RPass');
}
global ".'$'.'DBHost;
'.'$'."DBHost = '$host';
global ".'$'.'DBUser;
'.'$'."DBUser = '$user';
global ".'$'.'DBPass;
'.'$'."DBPass = '$pass';
global ".'$'.'DBName;
'.'$'."DBName = '$name';
global ".'$'.'DBLName;
'.'$'."DBLName = '$lName';

global ".'$'.'RconHost;
'.'$'."RconHost = '$RHost';
global ".'$'.'RconPort;
'.'$'."RconPort = $RPort;
global ".'$'.'RconPass;
'.'$'."RconPass = '$RPass';


?>
";

    fwrite($ourFileHandle, $written);
    fclose($ourFileHandle);

    header('Location: settings.php');
} else {
    echo $fail;
}
