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

$sql = "SELECT * FROM `gangs` WHERE `id` = $_POST[id]";
$result = mysqli_query($dbcon, $sql);
$gang = $result->fetch_object();

switch ($_POST['column']) {

    case 'maxmembers':
        $maxmembers = logs($staffPerms['gangs'], $_POST['column'], $gang->pid, $user, $dbcon, $gang, $_POST['editval']);
        $UpdateQ = "UPDATE gangs SET $_POST[column]='$maxmembers' WHERE id='$_POST[id]'";
    break;

    case 'members':
        $members = logs($staffPerms['gangs'], $_POST['column'], $gang->pid, $user, $dbcon, $gang, $_POST['editval']);
        $UpdateQ = "UPDATE gangs SET $_POST[column]='$members' WHERE id='$_POST[id]'";
    break;

    case 'bank':
        $bank = logs($staffPerms['gangs'], $_POST['column'], $gang->pid, $user, $dbcon, $gang, $_POST['editval']);
        $UpdateQ = "UPDATE gangs SET $_POST[column]='$bank' WHERE id='$_POST[id]'";
    break;

    case 'active':
        $active = logs($staffPerms['gangs'], $_POST['column'], $gang->pid, $user, $dbcon, $gang, $_POST['editval']);
        $UpdateQ = "UPDATE gangs SET $_POST[column]='$active' WHERE id='$_POST[id]'";
    break;

    default:
        $message = 'ERROR';
        logIt($user, $message, $dbcon);
    break;
}

mysqli_query($dbcon, $UpdateQ);
