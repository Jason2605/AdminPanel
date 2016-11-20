<?php

include '../verifyPanel.php';
if ($apiEnable == 1) {
    if ($apiUser == $_GET['user'] && $apiPass == $_GET['pass']) {
        $debug = false;

        if ($debug) {
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $start = $time;
        }

        $request = $_GET['request'];
        if ($request == 'search') {
            $uid = $_GET['id'];
            $len = strlen($uid);
            if ($len != 17) {
                $uid = '';
            }
        }
        include 'apiFunctions.php';

        switch ($request) {

    case all:
        masterconnect();
        $allArray = allPlayerFunctions($dbcon);
        $all = [];
        $all[totalMoney] = 0;
        $all[playerCount] = 0;
        while ($row = mysqli_fetch_array($allArray, MYSQLI_ASSOC)) {
            $i = $row['pid'];
            $all[totalMoney] = $all[totalMoney] + $row['cash'] + $row['bankacc'];
            $all[player][$i][name] = $row['name'];
            $all[player][$i][pid] = $row['pid'];
            $all[player][$i][aliases] = $row['aliases'];
            $all[player][$i][cash] = $row['cash'];
            $all[player][$i][bank] = $row['bankacc'];
            $all[player][$i][coplevel] = $row['coplevel'];
            $all[player][$i][mediclevel] = $row['mediclevel'];
            $all[player][$i][donorlevel] = $row['donorlevel'];
            $all[player][$i][adminlevel] = $row['adminlevel'];
            $all[player][$i][arrested] = $row['arrested'];
            $all[player][$i][blacklist] = $row['blacklist'];
            ++$all[playerCount];
        }

        echo json_encode($all, JSON_PRETTY_PRINT);
        break;

    case search:
        masterconnect();
        $allArray = searchPlayer($dbcon, $uid);
        if ($allArray != 'NoID') {
            $all = [];
            while ($row = mysqli_fetch_array($allArray, MYSQLI_ASSOC)) {
                $i = $row['pid'];
                $all[player][$i][name] = $row['name'];
                $all[player][$i][pid] = $row['pid'];
                $all[player][$i][aliases] = $row['aliases'];
                $all[player][$i][cash] = $row['cash'];
                $all[player][$i][bank] = $row['bankacc'];
                $all[player][$i][coplevel] = $row['coplevel'];
                $all[player][$i][mediclevel] = $row['mediclevel'];
                $all[player][$i][donorlevel] = $row['donorlevel'];
                $all[player][$i][adminlevel] = $row['adminlevel'];
                $all[player][$i][arrested] = $row['arrested'];
                $all[player][$i][blacklist] = $row['blacklist'];
            }

            echo json_encode($all, JSON_PRETTY_PRINT);
        } else {
            echo 'rip';
        }
        break;

    case money:
        masterconnect();
        $money = 0;
        $sqldata = searchMoney($dbcon);

        while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
            $money = $money + $row['cash'] + $row['bankacc'];
        }
        echo $money;
        break;

    case players:
        masterconnect();
        $count = countPlayers($dbcon);
        echo $count;
        break;

    case wanted:
        masterconnect();
        $sqldata = wantedList($dbcon);
        $wanted = [];
        while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
            $i = $row['wantedID'];
            $wanted[wanted][$i][name] = $row['wantedName'];
            $wanted[wanted][$i][crimes] = $row['wantedCrimes'];
            $wanted[wanted][$i][bounty] = $row['wantedBounty'];
        }
        echo json_encode($wanted, JSON_PRETTY_PRINT);
        break;

    case vehicles:
        masterconnect();
        $count = countVehicles($dbcon);
        echo $count;
        break;

    case coplevel:
        masterconnect();
        $copArray = searchLevel($dbcon, 'coplevel');
        $player = returnLevel($copArray, 'coplevel');
        echo json_encode($player, JSON_PRETTY_PRINT);
        break;

    case mediclevel:
        masterconnect();
        $medicArray = searchLevel($dbcon, 'mediclevel');
        $player = returnLevel($medicArray, 'mediclevel');
        echo json_encode($player, JSON_PRETTY_PRINT);
        break;

    case donorlevel:
        masterconnect();
        $donorArray = searchLevel($dbcon, 'donorlevel');
        $player = returnLevel($donorArray, 'donorlevel');
        echo json_encode($player, JSON_PRETTY_PRINT);
        break;

    case adminlevel:
        masterconnect();
        $adminArray = searchLevel($dbcon, 'adminlevel');
        $player = returnLevel($adminArray, 'adminlevel');
        echo json_encode($player, JSON_PRETTY_PRINT);
        break;

    case gangs:
        masterconnect();
        $gangArray = searchGangs($dbcon);
        $i = 0;
        $gangs = [];
        while ($row = mysqli_fetch_array($gangArray, MYSQLI_ASSOC)) {
            $i = $row['name'];
            $gangs[$i][owner] = $row['owner'];
            $gangs[$i][name] = $row['name'];
            $gangs[$i][members] = $row['members'];
            $gangs[$i][maxmembers] = $row['maxmembers'];
            ++$i;
        }
        echo json_encode($gangs, JSON_PRETTY_PRINT);
        break;

    default: echo 'rip';
}

        if ($debug) {
            echo '<br>';
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 4);
            echo 'Page generated in '.$total_time.' seconds.';
        }
    } else {
        echo 'Invalid credentials';
    }
} else {
    echo 'Disabled';
}
