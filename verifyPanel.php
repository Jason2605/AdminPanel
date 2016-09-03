<?php
 
function masterconnect(){
	
	global $dbcon;
	$dbcon = mysqli_connect('77.98.39.61', 'jason_000', 'knight11', 'arma3life') or die ('Database connection failed');
}

function loginconnect(){
	
	global $dbconL;
	$dbconL = mysqli_connect('77.98.39.61', 'jason_000', 'knight11', 'arma3life');
}

function Rconconnect(){
	
	global $rcon;
	$rcon = new \Nizarii\ArmaRConClass\ARC('77.98.39.61', 2416, 'test');
}
global $DBHost;
$DBHost = '77.98.39.61';
global $DBUser;
$DBUser = 'jason_000';
global $DBPass;
$DBPass = 'knight11';
global $DBName;
$DBName = 'arma3life';
global $DBLName;
$DBLName = 'arma3life';

global $RconHost;
$RconHost = '77.98.39.61';
global $RconPort;
$RconPort = 2416;
global $RconPass;
$RconPass = 'test';

 
?>
