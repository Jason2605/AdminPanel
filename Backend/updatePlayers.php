<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include '../verifyPanel.php';
masterconnect();

$sql = "SELECT * FROM `players` WHERE `uid` = $_POST[uid]";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();

$cash = $player->cash;
$bank = $player->bankacc;
$cop = $player->coplevel;
$medic = $player->mediclevel;
$admin = $player->adminlevel;

if ($player->playerid != '' || $player->pid != '') {
    if ($player->playerid == '') {
        $pid = $player->pid;
    } else {
        $pid = $player->playerid;
    }
}

switch ($_POST['column']) {
    case 'cash':
        $cash = logs($staffPerms['money'], 'cash', $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$cash' WHERE uid='$_POST[uid]'";
    break;
    case 'bankacc':
        $bankacc = logs($staffPerms['money'], 'bankacc', $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$bankacc' WHERE uid='$_POST[uid]'";
    break;
    case 'coplevel':
        $coplevel = logs($staffPerms['cop'], 'coplevel', $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$coplevel' WHERE uid='$_POST[uid]'";
    break;
    case 'mediclevel':
        $mediclevel = logs($staffPerms['medic'], 'mediclevel', $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$mediclevel' WHERE uid='$_POST[uid]'";
    break;
    case 'adminlevel':
        $adminlevel = logs($staffPerms['IG-Admin'], 'adminlevel', $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$adminlevel' WHERE uid='$_POST[uid]'";
    break;
    case 'donatorlvl':
        $donatorlvl = logs($staffPerms['editPlayer'], $_POST['column'], $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$donatorlvl' WHERE uid='$_POST[uid]'";
    break;
    case 'donorlevel':
        $donorlevel = logs($staffPerms['editPlayer'], $_POST['column'], $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$donorlevel' WHERE uid='$_POST[uid]'";
    break;
    case 'blacklist':
        $blacklist = logs($staffPerms['editPlayer'], $_POST['column'], $pid, $user, $dbcon, $player, $_POST['editval']);
        $UpdateQ = "UPDATE players SET $_POST[column]='$blacklist' WHERE uid='$_POST[uid]'";
    break;

    default:
        $message = 'ERROR';
        logIt($user, $message, $dbcon);
    break;
}

mysqli_query($dbcon, $UpdateQ);
