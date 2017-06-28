<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

$staffPerms = $_SESSION['perms'];

if ($staffPerms['kick'] != '1') {
    header('Location: ../lvlError.php');
    die();
}

require_once '../ArmaRConClass/rcon.php';

include '../verifyPanel.php';
Rconconnect();

$guid = $_SESSION['guid'];

if ($guid == '') {
    header('Location: ../home.php');
} else {
    echo $guid;
    echo '<br>';

    $reason = $_SESSION['reason'];

    echo $reason;
    echo '<br>';

    $addBan = $rcon->kick_player($guid, $reason);

    header('Location: ../players.php');
}
