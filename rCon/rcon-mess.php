<?php
session_start();
ob_start();
$adminLev = $_SESSION['adminLevel'];

if (!isset($_SESSION['logged'])){
    header("Location: ../index.php");
}
if ($adminLev < 7){
  header("Location: ../lvlError.php");
}

require_once '../ArmaRConClass/rcon.php'; 
 
include('../verifyPanel.php');
Rconconnect();

$mess = $_SESSION['send'];


if($mess == ''){
  header("Location: ../home.php");
}
else{

echo $mess;
echo "<br>";

$mess = $rcon->say_global($mess);

header("Location: /home.php");
}

//if ($addBan){
//	echo "Sent";
//}else
//{
//echo "Failed";
//}

//header("Location: /home.php");
?>
