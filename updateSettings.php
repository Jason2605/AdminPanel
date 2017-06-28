<?php

session_start();

$staffPerms = $_SESSION['perms'];

if ($staffPerms['superUser'] != '1') {
    header('Location: lvlError.php');
    die();
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

  //max level checks

  if ($_POST['maxCop'] != '') {
      $maxCop = $_POST['maxCop'];
      $maxCop = (int) $maxCop;
  } else {
      $maxCop = 7;
  }

  if ($_POST['maxMedic'] != '') {
      $maxMedic = $_POST['maxMedic'];
      $maxMedic = (int) $maxMedic;
  } else {
      $maxMedic = 5;
  }

  if ($_POST['maxAdmin'] != '') {
      $maxAdmin = $_POST['maxAdmin'];
      $maxAdmin = (int) $maxAdmin;
  } else {
      $maxAdmin = 5;
  }

  if ($_POST['maxDonator'] != '') {
      $maxDonator = $_POST['maxDonator'];
      $maxDonator = (int) $maxDonator;
  } else {
      $maxDonator = 5;
  }

  if ($_POST['apiUser'] != '') {
      $apiUser = $_POST['apiUser'];
  } else {
      $apiUser = 'default';
  }

  if ($_POST['apiPass'] != '') {
      $apiPass = $_POST['apiPass'];
  } else {
      $apiPass = 5;
  }

  if ($_POST['apiEnable'] != '') {
      if ($_POST['apiEnable'] == '1' || $_POST['apiEnable'] == '0') {
          $apiEnable = $_POST['apiEnable'];
          $apiEnable = (int) $apiEnable;
      } else {
          $apiEnable = 1;
      }
  } else {
      $apiEnable = 1;
  }

if (!$fail) {
    $filename = 'verifyPanel.php';
    $ourFileName = $filename;
    $ourFileHandle = fopen($ourFileName, 'w');

    $written = '<?php

include "functions.php";

function masterconnect(){

global '.'$'.'dbcon;
'.'$'."dbcon = mysqli_connect('$host', '$user', '$pass', '$name') or die ('Database connection failed');
}

function loginconnect(){

global ".'$'.'dbconL;
'.'$'."dbconL = mysqli_connect('$host', '$user', '$pass', '$name');
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

global ".'$'.'RconHost;
'.'$'."RconHost = '$RHost';
global ".'$'.'RconPort;
'.'$'."RconPort = $RPort;
global ".'$'.'RconPass;
'.'$'."RconPass = '$RPass';

global ".'$'.'maxCop;
'.'$'."maxCop = $maxCop;
global ".'$'.'maxMedic;
'.'$'."maxMedic = $maxMedic;
global ".'$'.'maxAdmin;
'.'$'."maxAdmin = $maxAdmin;
global ".'$'.'maxDonator;
'.'$'."maxDonator = $maxDonator;

global ".'$'.'apiUser;
'.'$'."apiUser = '$apiUser';
global ".'$'.'apiPass;
'.'$'."apiPass = '$apiPass';
global ".'$'.'apiEnable;
'.'$'."apiEnable = $apiEnable;

?>
";

    fwrite($ourFileHandle, $written);
    fclose($ourFileHandle);

    header('Location: settings.php');
    die();
} else {
    echo $fail;
}
