<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}
$staffPerms = $_SESSION['perms'];

if ($staffPerms['globalMessage'] != '1') {
    header('Location: ../lvlError.php');
    die();
}

require_once '../ArmaRConClass/rcon.php';

include '../verifyPanel.php';
Rconconnect();

$mess = $_SESSION['send'];

if ($mess == '') {
    header('Location: ../home.php');
} else {
    $mess = $rcon->say_global($mess);
    header('Location: ../home.php');
}
