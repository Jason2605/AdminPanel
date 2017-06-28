<?php

session_start();
ob_start();

$staffPerms = $_SESSION['perms'];

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    die();
}

if ($staffPerms['editPlayer'] == '1') {
    $adminLev = $_SESSION['adminLevel'];
    $user = $_SESSION['user'];

    include '../verifyPanel.php';
    masterconnect();

    $id = $_POST['id'];
    $uid = $_POST['uid'];

    $change = explode('_', $_POST['id']);
    $col = $change['1'].'_licenses';

    $sql = "SELECT * FROM `players` WHERE uid = '$_POST[uid]'";
    $result = mysqli_query($dbcon, $sql);
    $player = $result->fetch_object();

    $licences = $player->$col;
    $num = strpos($licences, $change['2']) + strlen($change['2']) + 2;

    $pid = playerID($player);

    if ($licences[$num] == 0) {
        $licences[$num] = 1;
        $message = 'Admin '.$user.' has added license '.$id.' to '.$player->name.'('.$pid.')';
        logIt($user, $message, $dbcon);
    } elseif ($licences[$num] == 1) {
        $message = 'Admin '.$user.' has removed license '.$id.' from '.$player->name.'('.$pid.')';
        logIt($user, $message, $dbcon);
        $licences[$num] = 0;
    }

    $sql = 'UPDATE `players` SET `'.$col."`='$licences' WHERE uid ='$uid'";
    $result = mysqli_query($dbcon, $sql);
}
