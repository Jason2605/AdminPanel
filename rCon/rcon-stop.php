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

ob_start();

require_once '../ArmaRConClass/rcon.php'; 
 
include('../verifyPanel.php');
Rconconnect();

$command = "#shutdown";

$stop = $rcon->command($command);

header("Location: ../home.php");


//if ($addBan){
//	echo "Sent";
//}else
//{
//echo "Failed";
//}

//header("Location: /home.php");
?>
