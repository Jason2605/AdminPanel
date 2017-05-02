<?php

function searchMoney($dbcon)
{
    $sqlget = 'SELECT cash,bankacc FROM players';
    $sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

    return $sqldata;
}

function showRich($dbcon, $amount)
{
    $sqlget = 'SELECT name,pid,aliases,cash,bankacc FROM players ORDER BY bankacc DESC limit '.$amount;
    $sqldata = mysqli_query($dbcon, $sqlget);
    if (!$sqldata) {
        $sqlget = 'SELECT name,playerid,aliases,cash,bankacc FROM players ORDER BY bankacc DESC limit '.$amount;
        $sqldata = mysqli_query($dbcon, $sqlget);
    }

    return $sqldata;
}

function wantedList($dbcon)
{
    $sqlget = 'SELECT wantedID,wantedName,wantedCrimes,wantedBounty FROM wanted';
    $sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

    return $sqldata;
}

function searchGangs($dbcon)
{
    $sqlget = 'SELECT owner,name,members,maxmembers FROM gangs';
    $sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

    return $sqldata;
}

function countPlayers($dbcon)
{
    $sqlget = 'SELECT uid FROM players';
    $sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');
    $count = mysqli_num_rows($sqldata);

    return $count;
}

function countVehicles($dbcon)
{
    $sqlget = 'SELECT id FROM vehicles';
    $sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');
    $count = mysqli_num_rows($sqldata);

    return $count;
}

function returnLevel($array, $search)
{
    $player = [];
    while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)) {
        if ($row['pid']) {
            $i = $row['pid'];
        } else {
            $i = $row['playerid'];
        }
        $player[$i]['name'] = $row['name'];
        $player[$i]['uid'] = $i;
        $player[$i]['level'] = $row[$search];
    }

    return $player;
}

function searchLevel($dbcon, $value)
{
    $sqlget = 'SELECT name,pid,'.$value.' FROM players ORDER BY '.$value.' DESC';
    $sqldata = mysqli_query($dbcon, $sqlget);
    if (!$sqldata) {
        $sqlget = 'SELECT name,playerid,'.$value.' FROM players ORDER BY '.$value.' DESC';
        $sqldata = mysqli_query($dbcon, $sqlget);
    }

    return $sqldata;
}

function allPlayerFunctions($dbcon)
{
    $sqlget = 'SELECT name,pid,aliases,cash,bankacc,coplevel,mediclevel,donorlevel,adminlevel,arrested,blacklist FROM players';
    $sqldata = mysqli_query($dbcon, $sqlget);
    if (!$sqldata) {
        $sqlget = 'SELECT name,playerid,aliases,cash,bankacc,coplevel,mediclevel,donorlevel,adminlevel,arrested,blacklist FROM players';
        $sqldata = mysqli_query($dbcon, $sqlget);
    }

    return $sqldata;
}

function searchPlayer($dbcon, $uid)
{
    if ($uid != '') {
        $sqlget = "SELECT name,pid,aliases,cash,bankacc,coplevel,mediclevel,donorlevel,adminlevel,arrested,blacklist FROM players WHERE pid = '$uid'";
        $sqldata = mysqli_query($dbcon, $sqlget);
        if (!$sqldata) {
            $sqlget = "SELECT name,playerid,aliases,cash,bankacc,coplevel,mediclevel,donorlevel,adminlevel,arrested,blacklist FROM players WHERE playerid = '$uid'";
            $sqldata = mysqli_query($dbcon, $sqlget);
        }

        return $sqldata;
    }

    return 'NoID';
}
