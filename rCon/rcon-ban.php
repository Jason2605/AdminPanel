<?php
session_start();
ob_start();

$adminLev = $_SESSION['adminLevel'];

if (!isset($_SESSION['logged'])){
    header("Location: ../index.php");
}
if ($adminLev < 4){
	header("Location: ../lvlError.php");
}

 require_once '../ArmaRConClass/rcon.php'; 

include('../verifyPanel.php');
Rconconnect();

$guid = $_SESSION['guid'];


if($guid == ''){
	header("Location: ../home.php");
}
else{

echo $guid;
echo "<br>";

$reason = $_SESSION['reason'];

echo $reason;
echo "<br>";

$time = $_SESSION['time'];


if($time == ''){
	$time = 0;
}

echo $time;
echo "<br>";

$intTime = (int)$time;

echo $intTime;

$addBan = $rcon->add_ban($guid, $reason, $intTime);

header("Location: player.php");
}

//if ($addBan){
//	echo "Sent";
//}else
//{
//echo "Failed";
//}

//header("Location: /home.php");
?>
