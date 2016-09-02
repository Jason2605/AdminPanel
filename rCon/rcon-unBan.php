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

session_id ("user");
session_start();
ob_start();

include('../verifyPanel.php');
Rconconnect();

$banid = $_SESSION['banid'];

if($banid == ''){
	header("Location: ../home.php");
}
else{

$reason = $_SESSION['reason'];


$delBan = $rcon->remove_ban($banid);

header("Location: unBan.php");
}

//if ($addBan){
//	echo "Sent";
//}else
//{
//echo "Failed";
//}

//header("Location: /home.php");
?>
