<?php

session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include '../verifyPanel.php';
masterconnect();

$sql = "SELECT * FROM `houses` WHERE `id` = $_POST[id]";
$result = mysqli_query($dbcon, $sql);
$houses = $result->fetch_object();

switch ($_POST['column']) {

    case 'owned':
        $owned = logs($staffPerms['housing'], $_POST['column'], $houses->pid, $user, $dbcon, $houses, $_POST['editval']);
        $UpdateQ = "UPDATE houses SET $_POST[column]='$owned' WHERE id='$_POST[id]'";
    break;

    default:
        $message = 'ERROR';
        logIt($user, $message, $dbcon);
    break;
}

mysqli_query($dbcon, $UpdateQ);
