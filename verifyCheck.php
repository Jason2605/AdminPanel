<?php
if (!file_exists('verifyPanel.php')) {

$fail = false;
  if ($_POST['user'] != "") {
    $user = $_POST['user'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['pass'] != "") {
    $pass = $_POST['pass'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['host'] != "") {
    $host = $_POST['host'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['name'] != "") {
    $name = $_POST['name'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['lName'] != "") {
    $lName = $_POST['lName'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['RHost'] != "") {
    $RHost = $_POST['RHost'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['RPass'] != "") {
    $RPass = $_POST['RPass'];
  } else
  {
    echo "error?";
    $fail = true;
  }

  if ($_POST['RPort'] != "") {
    $RPort = $_POST['RPort'];
    $RPort = (int) $RPort;
  }else
  {
    echo "error?";
    $fail = true;
  }

if (!$fail) {
$filename = "verifyPanel.php";
$ourFileName = $filename;
$ourFileHandle = fopen($ourFileName, 'w');

$written = "<?php

function masterconnect(){

	global "."$"."dbcon;
	"."$"."dbcon = mysqli_connect('$host', '$user', '$pass', '$name') or die ('Database connection failed');
}

function loginconnect(){

	global "."$"."dbconL;
	"."$"."dbconL = mysqli_connect('$host', '$user', '$pass', '$lName');
}

function Rconconnect(){

	global "."$"."rcon;
	"."$"."rcon = new \Nizarii\ArmaRConClass\ARC('$RHost', $RPort, '$RPass');
}
global "."$"."DBHost;
"."$"."DBHost = '$host';
global "."$"."DBUser;
"."$"."DBUser = '$user';
global "."$"."DBPass;
"."$"."DBPass = '$pass';
global "."$"."DBName;
"."$"."DBName = '$name';
global "."$"."DBLName;
"."$"."DBLName = '$lName';

global "."$"."RconHost;
"."$"."RconHost = '$RHost';
global "."$"."RconPort;
"."$"."RconPort = $RPort;
global "."$"."RconPass;
"."$"."RconPass = '$RPass';


?>
";

fwrite($ourFileHandle, $written);
fclose($ourFileHandle);

$dbconnect = mysqli_connect($host, $user, $pass, $name) or die ('Database connection failed');

$sqlDel = "DROP TABLE users;";
$sqldata = mysqli_query($dbconnect, $sqlDel);

$sqlDel1 = "DROP TABLE log;";
$sqldata1 = mysqli_query($dbconnect, $sqlDel1);

$sqlDel2 = "DROP TABLE notes;";
$sqldata2 = mysqli_query($dbconnect, $sqlDel2);

$sqlDel3 = "DROP TABLE reimbursement_log;";
$sqldata3 = mysqli_query($dbconnect, $sqlDel3);

$sqlmake = "
CREATE TABLE IF NOT EXISTS `log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(64) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`logid`),
  UNIQUE KEY `logid` (`logid`),
  KEY `logid_2` (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
";

$sqldata = mysqli_query($dbconnect, $sqlmake) or die ('Connection could not be established - LOG');

$sqlmake2 = "

CREATE TABLE IF NOT EXISTS `users` (
`ID` mediumint(9) NOT NULL AUTO_INCREMENT,
`username` varchar(60) NOT NULL,
`password` varchar(60) NOT NULL,
`level` enum('1','2','3','4','5','6','7','8') NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

$sqldata1 = mysqli_query($dbconnect, $sqlmake2) or die ('Connection could not be established - USERS!');

$sqlmake3 = "

CREATE TABLE IF NOT EXISTS `notes` (
	`note_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing note_id of each user, unique index',
	`uid` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`staff_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`note_text` VARCHAR(255) NOT NULL,
	`warning` ENUM('1','2','3') NOT NULL,
	`note_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`note_id`),
	UNIQUE INDEX `note_id` (`note_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6;

";

$sqldata100 = mysqli_query($dbconnect, $sqlmake3) or die ('Connection could not be established - NOTES!');

$sqlmake4 = "

CREATE TABLE IF NOT EXISTS `reimbursement_log` (
	`reimbursement_id` INT(11) NOT NULL AUTO_INCREMENT,
	`playerid` VARCHAR(50) NOT NULL,
	`comp` INT(100) NOT NULL DEFAULT '0',
	`reason` VARCHAR(255) NOT NULL,
	`staff_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`reimbursement_id`),
	UNIQUE INDEX `reimbursement_id` (`reimbursement_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;
";

$sqldata9 = mysqli_query($dbconnect, $sqlmake4) or die ('Connection could not be established - REIM!');

$sqldeluser = "DELETE FROM users WHERE username='AdminPanel';";

$sqldatadel = mysqli_query($dbconnect, $sqldeluser) or die ('Connection could not be established - USER!');

$sqlinsert = "INSERT INTO `users` (`ID`, `username`, `password`, `level`) VALUES (1, 'AdminPanel','2b12e1a2252d642c09f640b63ed35dcc5690464a', '8');";

$sqldata2 = mysqli_query($dbconnect, $sqlinsert) or die ('Connection could not be established or user already exists!');

//$sqldel = "ALTER TABLE players DROP COLUMN notes;";

//$sqldata5 = mysqli_query($dbconnect, $sqldel); //or die ('Connection could not be established or error deleting notes column!');

//$sqledit = "ALTER TABLE players ADD notes VARCHAR(60);";

//$sqldata3 = mysqli_query($dbconnect, $sqledit) or die ('Connection could not be established or column "notes" already exists!');

$sqldelTime = "ALTER TABLE players DROP COLUMN joined;";

$sqldata8 = mysqli_query($dbconnect, $sqldelTime); //or die ('Connection could not be established or error deleting joined column!');

$sqldel1 = "ALTER TABLE players DROP COLUMN warning;";

$sqldata6 = mysqli_query($dbconnect, $sqldel1); //or die ('Connection could not be established or error deleting warning column!');

$sqledit1 = "ALTER TABLE players ADD warning ENUM('1','2','3') NOT NULL;";

$sqldata4 = mysqli_query($dbconnect, $sqledit1) or die ('Connection could not be established or column "warning" already exists!');

header("Location: index.php");
} else {

  echo "There has been an error setting up your database, please recheck all inputs";
}

} else
{
  header("Location: index.php");
}
