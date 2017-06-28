<?php

session_start();
ob_start();

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

if ($staffPerms['superUser'] == '1') {

    include 'verifyPanel.php';
    masterconnect();

    $id = $_POST['id'];
    $staffId = $_POST['uid'];

    $change = explode('_', $_POST['id']);

    $sql = "SELECT * FROM `users` WHERE ID = $staffId";
    $result = mysqli_query($dbcon, $sql);
    $user = $result->fetch_object();

    $licences = $user->permissions;
    $num = strpos($licences, $change['0']) + strlen($change['0']) + 2;

    if ($licences[$num] == 0) {
        $licences[$num] = 1;
    } elseif ($licences[$num] == 1) {
        $licences[$num] = 0;
    }

    $sql = "UPDATE `users` SET `permissions` = '$licences' WHERE ID = $staffId";
    $result = mysqli_query($dbcon, $sql);

}
