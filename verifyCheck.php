<?php

if (!file_exists('verifyPanel.php')) {
    $fail = false;
    if ($_POST['user'] != '') {
        $user = $_POST['user'];
    } else {
        echo 'Invalid User ';
        $fail = true;
    }

    if ($_POST['pass'] != '') {
        $pass = $_POST['pass'];
    } else {
        $pass = '';
    }

    if ($_POST['host'] != '') {
        $host = $_POST['host'];
    } else {
        echo 'Invalid Host ';
        $fail = true;
    }

    if ($_POST['name'] != '') {
        $name = $_POST['name'];
    } else {
        echo 'Invalid DB Name ';
        $fail = true;
    }
	
    if ($_POST['port'] != '') {
        $port = $_POST['port'];
    } else {
        $port = 3306;
    }

    if ($_POST['RHost'] != '') {
        $RHost = $_POST['RHost'];
    } else {
        echo 'Invalid RCON Host ';
        $fail = true;
    }

    if ($_POST['RPass'] != '') {
        $RPass = $_POST['RPass'];
    } else {
        echo 'Invalid RCON Password ';
        $fail = true;
    }

    if ($_POST['RPort'] != '') {
        $RPort = $_POST['RPort'];
        $RPort = (int) $RPort;
    } else {
        echo 'Invalid RCON Port ';
        $fail = true;
    }

    //max level checks

    if ($_POST['maxCop'] != '') {
        $maxCop = $_POST['maxCop'];
        $maxCop = (int) $maxCop;
    } else {
        $maxCop = 7;
    }
	
	if ($_POST['maxWarning'] != '') {
        $maxWarning = $_POST['maxWarning'];
        $maxWarning = (int) $maxWarning;
    } else {
        $maxWarning = 30;
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
        $apiPass = 'password';
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
	'.'$'."dbcon = mysqli_connect('$host', '$user', '$pass', '$name', '$port') or die ('Database connection failed');
}

function loginconnect(){

	global ".'$'.'dbconL;
	'.'$'."dbconL = mysqli_connect('$host', '$user', '$pass', '$name', '$port');
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
global ".'$'.'maxWarning;
'.'$'."MaxWarning = $Warning;
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

        $dbconnect = mysqli_connect($host, $user, $pass, $name) or die('Database connection failed');

        $sqlDel = 'DROP TABLE users;';
        $sqldata = mysqli_query($dbconnect, $sqlDel);

        $sqlDel1 = 'DROP TABLE log;';
        $sqldata1 = mysqli_query($dbconnect, $sqlDel1);

        $sqlDel2 = 'DROP TABLE notes;';
        $sqldata2 = mysqli_query($dbconnect, $sqlDel2);

        $sqlDel3 = 'DROP TABLE reimbursement_log;';
        $sqldata3 = mysqli_query($dbconnect, $sqlDel3);

        $sqlDel4 = 'DROP TABLE whitelist;';
        $sqldata4 = mysqli_query($dbconnect, $sqlDel4);

        $sqlDel5 = 'DROP TABLE access;';
        $sqldata5 = mysqli_query($dbconnect, $sqlDel5);

        $sqlmake = '
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
	';

        $sqldata = mysqli_query($dbconnect, $sqlmake) or die('Connection could not be established - LOG');

        $sqlmake2 = '
		CREATE TABLE IF NOT EXISTS `users` (
			`ID` mediumint(9) NOT NULL AUTO_INCREMENT,
			`username` varchar(60) NOT NULL,
			`password` varchar(80) NOT NULL,
			`permissions` text NOT NULL,
			PRIMARY KEY (`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';

        $sqldata1 = mysqli_query($dbconnect, $sqlmake2) or die('Connection could not be established - USERS!');

        $sqlmake3 = "
		CREATE TABLE IF NOT EXISTS `notes` (
			`note_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing note_id of each user, unique index',
			`uid` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
			`staff_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
			`name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
			`alias` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
			`note_text` VARCHAR(255) NOT NULL,
			`warning` ENUM('1','2','3','4') NOT NULL DEFAULT '0',
			`note_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`note_id`),
			UNIQUE INDEX `note_id` (`note_id`)
		) COLLATE='latin1_swedish_ci' ENGINE=InnoDB AUTO_INCREMENT=6;
	";

        $sqldata100 = mysqli_query($dbconnect, $sqlmake3) or die('Connection could not be established - NOTES!');

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

        $sqldata9 = mysqli_query($dbconnect, $sqlmake4) or die('Connection could not be established - REIM!');

        $sqlmake5 = '
        CREATE TABLE IF NOT EXISTS `whitelist` (
            `id` int(0) NOT NULL AUTO_INCREMENT,
            `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `user` varchar(64) DEFAULT NULL,
            `guid` varchar(64) DEFAULT NULL,
            `uid` varchar(64) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
	';
        $sqldata10 = mysqli_query($dbconnect, $sqlmake5) or die('Connection could not be established - Whitelist!');

        $sqlmake6 = '
        CREATE TABLE `access` (
            `accessID` int(11) NOT NULL AUTO_INCREMENT,
            `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `address` varchar(64) DEFAULT NULL,
            `failed` int(11) NOT NULL,
            PRIMARY KEY (`accessID`),
            UNIQUE KEY `accessID` (`accessID`),
            KEY `accessID_1` (`accessID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
	';
	$sqldata11 = mysqli_query($dbconnect, $sqlmake6) or die('Connection could not be established - Staff Logs!');

        $sqlmake7 = '
        CREATE TABLE `staff_logs` (
			`case_id` int(11) NOT NULL AUTO_INCREMENT,
			`staffn` varchar(50) NOT NULL,
			`personr` varchar(50) NOT NULL,
			`personbr` varchar(50) NOT NULL,
			`playerid` varchar(64) NOT NULL,
			`report` varchar(100) NOT NULL,
			`outcome` varchar(255) NOT NULL,
			`staff_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			`timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`case_id`),
			UNIQUE KEY `case_id` (`case_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

	';
	
        $sqldata12 = mysqli_query($dbconnect, $sqlmake7) or die('Connection could not be established - Player Warning!');

        $sqlmake8 = ("ALTER TABLE `players` ADD `warning` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') NOT NULL DEFAULT '0' AFTER `last_seen`");
	';
	
';		
	
        $sqlMakeAccess = mysqli_query($dbconnect, $sqlmake6) or die('Connection could not be established - Access!');

        $sqldeluser = "DELETE FROM users WHERE username='AdminPanel';";

        $sqldatadel = mysqli_query($dbconnect, $sqldeluser) or die('Connection could not be established - USER!');

        $sqlinsert = "INSERT INTO `users` (`ID`, `username`, `password`, `permissions`) VALUES (1, 'AdminPanel','60fe74406e7f353ed979f350f2fbb6a2e8690a5fa7d1b0c32983d1d8b3f95f67', '\"[[`notes`,1],[`cop`,1],[`medic`,1],[`money`,1],[`IG-Admin`,1],[`editPlayer`,1],[`housing`,1],[`gangs`,1],[`vehicles`,1],[`logs`,1],[`steamView`,1],[`ban`,1],[`kick`,1],[`unban`,1],[`globalMessage`,1],[`restartServer`,1],[`stopServer`,1],[`superUser`,1]]\"');";

        $sqldata2 = mysqli_query($dbconnect, $sqlinsert) or die('Connection could not be established or user already exists!');

        header('Location: index.php');
    } else {
        echo 'There has been an error setting up your database, please recheck all inputs';
    }
} else {
    header('Location: index.php');
}
