<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Panel</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
    <!-- normal script imports etc  -->
    <script src="scripts/jquery-1.12.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="scripts/jquery.backstretch.js"></script>
    <!-- Insert this line after script imports -->
    <script>if (window.module) module = window.module;</script>

</head>

<body>

<nav class="navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarside" aria-expanded="false" aria-controls="navbarside">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="navbar-brand"><a>Admin<span>Panel</span></a></div>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="home.php" style="color: #fff">Dashboard</a></li>
                <li><a href="settings.php" style="color: #fff">Settings</a></li>
                <li><a href="profile.php" style="color: #fff">Profile</a></li>
                <li><a href="help.php" style="color: #fff">Help</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div id="navbarside" class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="players.php">Players</a></li>
                <?php
                $staffPerms = $_SESSION['perms'];
                switch ($staffPerms) {
                    case $staffPerms['vehicles'] == '1':
                        echo "<li><a href=\"vehicles.php\">Vehicles</a></li>";
                    case $staffPerms['gangs'] == '1':
                        echo "<li><a href=\"gangs.php\">Gangs</a></li>";
                    case $staffPerms['housing'] == '1':
                        echo "<li><a href=\"houses.php\">Houses</a></li>";
                    case $staffPerms['logs'] == '1':
                        echo "<li><a href=\"logs.php?page=1\">Logs</a></li>";
                    case $staffPerms['money'] == '1':
                        echo "<li><a href=\"reimbursement.php\">Reimbursement Logs</a></li>";
                    case $staffPerms['notes'] == '1':
                        echo "<li><a href=\"notesView.php\">Notes</a></li>";
                    case $staffPerms['superUser'] == '1':
                        echo "<li><a href=\"staff.php\">Staff</a></li>";
                    case $staffPerms['steamView'] == '1':
                        echo "<li><a href=\"steam.php\">Steam Accounts</a></li>";
                }
                ?>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>