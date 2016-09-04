<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];

if ($adminLev != 8) {
    header('Location: lvlError.php');
}

session_destroy();
unlink('verifyPanel.php');
header('Location: logout.php');
