<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}
$staffPerms = $_SESSION['perms'];

if ($staffPerms['unban'] != '1') {
    header('Location: ../lvlError.php');
    die();
}

  require_once '../ArmaRConClass/rcon.php';

include '../verifyPanel.php';
Rconconnect();

$banid = $_SESSION['banid'];

if ($banid == '') {
    header('Location: ../home.php');
} else {
    $reason = $_SESSION['reason'];

    $delBan = $rcon->remove_ban($banid);

    header('Location: unBan.php');
}
