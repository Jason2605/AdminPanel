<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

$staffPerms = $_SESSION['perms'];

if ($staffPerms['restartServer'] != '1') {
    header('Location: lvlError.php');
    die();
}

ob_start();
require_once '../ArmaRConClass/rcon.php';

include '../verifyPanel.php';
Rconconnect();

$command = '#restart';

$restart = $rcon->command($command);

header('Location: ../home.php');
