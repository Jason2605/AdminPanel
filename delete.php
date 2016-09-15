<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$user = $_SESSION['user'];
$staffPerms = $_SESSION['perms'];

if ($staffPerms['superUser'] != '1') {
    header('Location: lvlError.php');
}

session_destroy();
unlink('verifyPanel.php');
header('Location: logout.php');
