<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}
$staffPerms = $_SESSION['perms'];

if ($staffPerms['kick'] != '1') {
    header('Location: lvlError.php');
    die();
}

  require_once '../ArmaRConClass/rcon.php';

session_id('user');
session_start();
ob_start();

include '../verifyPanel.php';
Rconconnect();

$uid = $_SESSION['SKguid'];
$name = $_SESSION['name'];

if ($uid == '') {
    header('Location: ../home.php');
    echo 'wtf';
} else {
    echo 'worked?';
}

if ($name == '') {
    echo 'wtf';
} else {
    echo 'worked?';
    echo $name;
}

echo $uid;
echo '<br><br><br><br><br><br>';

$command = '#kick '.$uid;
echo $command;
$kick = $rcon->command($command);

header('Location: ../players.php');
