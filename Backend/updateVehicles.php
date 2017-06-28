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

$sql = "SELECT * FROM `vehicles` WHERE `id` = $_POST[id]";
$result = mysqli_query($dbcon, $sql);
$vehicles = $result->fetch_object();

switch ($_POST['column']) {

    case 'classname':
        $classname = logs($staffPerms['vehicles'], $_POST['column'], $vehicles->pid, $user, $dbcon, $vehicles, $_POST['editval']);
        $UpdateQ = "UPDATE vehicles SET $_POST[column]='$classname' WHERE id='$_POST[id]'";
    break;

    case 'alive':
        $alive = logs($staffPerms['vehicles'], $_POST['column'], $vehicles->pid, $user, $dbcon, $vehicles, $_POST['editval']);
        $UpdateQ = "UPDATE vehicles SET $_POST[column]='$alive' WHERE id='$_POST[id]'";
    break;

    case 'active':
        $active = logs($staffPerms['vehicles'], $_POST['column'], $vehicles->pid, $user, $dbcon, $vehicles, $_POST['editval']);
        $UpdateQ = "UPDATE vehicles SET $_POST[column]='$active' WHERE id='$_POST[id]'";
    break;

    case 'plate':
        $plate = logs($staffPerms['vehicles'], $_POST['column'], $vehicles->pid, $user, $dbcon, $vehicles, $_POST['editval']);
        $UpdateQ = "UPDATE vehicles SET $_POST[column]='$plate' WHERE id='$_POST[id]'";
    break;

    default:
        $message = 'ERROR';
        logIt($user, $message, $dbcon);
    break;
}

mysqli_query($dbcon, $UpdateQ);
