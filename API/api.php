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
        loginconnect();

        switch ($request) {

            case 'all':

                $allArray = allPlayerFunctions($dbconL);
                $all = [];
                $all['totalMoney'] = 0;
                $all['playerCount'] = 0;
                while ($row = mysqli_fetch_array($allArray, MYSQLI_ASSOC)) {
                    if ($row['pid']) {
                        $i = $row['pid'];
                    } else {
                        $i = $row['playerid'];
                    }
                    $all['totalMoney'] = $all['totalMoney'] + $row['cash'] + $row['bankacc'];
                    $all['player'][$i]['name'] = $row['name'];
                    $all['player'][$i]['pid'] = $i;
                    $all['player'][$i]['aliases'] = $row['aliases'];
                    $all['player'][$i]['cash'] = $row['cash'];
                    $all['player'][$i]['bank'] = $row['bankacc'];
                    $all['player'][$i]['coplevel'] = $row['coplevel'];
                    $all['player'][$i]['mediclevel'] = $row['mediclevel'];
                    $all['player'][$i]['donorlevel'] = $row['donorlevel'];
                    $all['player'][$i]['adminlevel'] = $row['adminlevel'];
                    $all['player'][$i]['arrested'] = $row['arrested'];
                    $all['player'][$i]['blacklist'] = $row['blacklist'];
                    ++$all['playerCount'];
                }

                echo json_encode($all, JSON_PRETTY_PRINT);
                break;

            case 'search':

                $allArray = searchPlayer($dbconL, $uid);
                if ($allArray != 'NoID') {
                    $all = [];
                    while ($row = mysqli_fetch_array($allArray, MYSQLI_ASSOC)) {
                        if ($row['pid']) {
                            $i = $row['pid'];
                        } else {
                            $i = $row['playerid'];
                        }
                        $all['player'][$i]['name'] = $row['name'];
                        $all['player'][$i]['pid'] = $i;
                        $all['player'][$i]['aliases'] = $row['aliases'];
                        $all['player'][$i]['cash'] = $row['cash'];
                        $all['player'][$i]['bank'] = $row['bankacc'];
                        $all['player'][$i]['coplevel'] = $row['coplevel'];
                        $all['player'][$i]['mediclevel'] = $row['mediclevel'];
                        $all['player'][$i]['donorlevel'] = $row['donorlevel'];
                        $all['player'][$i]['adminlevel'] = $row['adminlevel'];
                        $all['player'][$i]['arrested'] = $row['arrested'];
                        $all['player'][$i]['blacklist'] = $row['blacklist'];
                    }

                    echo json_encode($all, JSON_PRETTY_PRINT);
                } else {
                    echo 'rip';
                }
                break;

            case 'money':

                $money = 0;
                $sqldata = searchMoney($dbconL);

                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                    $money = $money + $row['cash'] + $row['bankacc'];
                }
                echo $money;
                break;

            case 'richlist':
                if (isset($_GET['limit'])) {
                    $limit = $_GET['limit'];
                } else {
                    $limit = 10;
                }
                $money = 0;
                $sqldata = showRich($dbconL, $limit);

                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                    if ($row['pid']) {
                        $i = $row['pid'];
                    } else {
                        $i = $row['playerid'];
                    }
                    $all['player'][$i]['name'] = $row['name'];
                    $all['player'][$i]['pid'] = $i;
                    $all['player'][$i]['aliases'] = $row['aliases'];
                    $all['player'][$i]['cash'] = $row['cash'];
                    $all['player'][$i]['bank'] = $row['bankacc'];
                }
                echo json_encode($all, JSON_PRETTY_PRINT);
                break;

            case 'players':

                $count = countPlayers($dbconL);
                echo $count;
                break;

            case 'wanted':

                $sqldata = wantedList($dbconL);
                $wanted = [];
                while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                    $i = $row['wantedID'];
                    $wanted['wanted'][$i]['name'] = $row['wantedName'];
                    $wanted['wanted'][$i]['crimes'] = $row['wantedCrimes'];
                    $wanted['wanted'][$i]['bounty'] = $row['wantedBounty'];
                }
                echo json_encode($wanted, JSON_PRETTY_PRINT);
                break;

            case 'vehicles':

                $count = countVehicles($dbconL);
                echo $count;
                break;

            case 'coplevel':

                $copArray = searchLevel($dbconL, 'coplevel');
                $player = returnLevel($copArray, 'coplevel');
                echo json_encode($player, JSON_PRETTY_PRINT);
                break;

            case 'mediclevel':

                $medicArray = searchLevel($dbconL, 'mediclevel');
                $player = returnLevel($medicArray, 'mediclevel');
                echo json_encode($player, JSON_PRETTY_PRINT);
                break;

            case 'donorlevel':

                $donorArray = searchLevel($dbconL, 'donorlevel');
                $player = returnLevel($donorArray, 'donorlevel');
                echo json_encode($player, JSON_PRETTY_PRINT);
                break;

            case 'adminlevel':

                $adminArray = searchLevel($dbconL, 'adminlevel');
                $player = returnLevel($adminArray, 'adminlevel');
                echo json_encode($player, JSON_PRETTY_PRINT);
                break;

            case 'gangs':

                $gangArray = searchGangs($dbconL);
                $i = 0;
                $gangs = [];
                while ($row = mysqli_fetch_array($gangArray, MYSQLI_ASSOC)) {
                    $i = $row['name'];
                    $gangs[$i]['owner'] = $row['owner'];
                    $gangs[$i]['name'] = $row['name'];
                    $gangs[$i]['members'] = $row['members'];
                    $gangs[$i]['maxmembers'] = $row['maxmembers'];
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
