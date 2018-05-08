<?php
function checkSession(Session $session)
{
    if ($session->get('userID') == null) {
        return false;
    } else {
        return true;
    }
}
function getItems()
{
    require 'connection.php';
    $con = new PDO("mysql:host=" . $server . ";dbname=" . $db, $user, $pass);
    $items = array();
    $query = '  SELECT  `redeem`.`id` AS id,
                        `redeem`.`model` AS device,
                        `carphone`.`carphonePrice`,
                        `magpie`.`magpiePrice`,
                        `mazuma`.`mazumaPrice`,
                        `mpx`.`mpxPrice`,
                        `recyclee`.`recyclePrice`,
                        `vodafone`.`vodafonePrice`
                FROM `redeem`
                    LEFT JOIN `carphone`
                            ON `carphone`.`idCarphone` = `redeem`.`id`
                    LEFT JOIN `magpie`
                            ON `magpie`.`idMagpie` = `redeem`.`id`
                    LEFT JOIN `mazuma`
                            ON `mazuma`.`idMazuma` = `redeem`.`id`
                    LEFT JOIN `mpx`
                            ON `mpx`.`idMpx` = `redeem`.`id`
                    LEFT JOIN `recyclee`
                            ON `recyclee`.`idRecycle` = `redeem`.`id`
                    LEFT JOIN `vodafone`
                            ON `vodafone`.`idVodafone` = `redeem`.`id`';
    $result = $con->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row;
    }
    $con = null;
    return $items;
}

function getUsers()
{
    require 'connection.php';
    $con = new PDO("mysql:host=" . $server . ";dbname=" . $db, $user, $pass);
    $users = array();
    $query = 'SELECT * FROM `users`';
    $result = $con->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }
    $con = null;
    return $users;
}

function createLog()
{
    require 'connection.php';
    require 'Log.php';
    require 'Device.php';

    $date = date("d-m-Y", time());
    $logName = 'log_' . $date . '.json'; 
    $data = [];
    $log = new Log();
    $log->setDate(date('d-m-Y', time()));
    $con = new PDO("mysql:host=localhost;dbname=scrapeprices", 'Ricardo', 'admin');
    $query = '  SELECT  `redeem`.`id` AS id,
                        `redeem`.`model` AS device,
                        `carphone`.`carphonePrice`,
                        `magpie`.`magpiePrice`,
                        `mazuma`.`mazumaPrice`,
                        `mpx`.`mpxPrice`,
                        `recyclee`.`recyclePrice`,
                        `vodafone`.`vodafonePrice`
                FROM `redeem`
                    LEFT JOIN `carphone`
                            ON `carphone`.`idCarphone` = `redeem`.`id`
                    LEFT JOIN `magpie`
                            ON `magpie`.`idMagpie` = `redeem`.`id`
                    LEFT JOIN `mazuma`
                            ON `mazuma`.`idMazuma` = `redeem`.`id`
                    LEFT JOIN `mpx`
                            ON `mpx`.`idMpx` = `redeem`.`id`
                    LEFT JOIN `recyclee`
                            ON `recyclee`.`idRecycle` = `redeem`.`id`
                    LEFT JOIN `vodafone`
                            ON `vodafone`.`idVodafone` = `redeem`.`id`';
    $result = $con->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $prices = [$row['carphonePrice'] , $row['magpiePrice'], $row['mazumaPrice'], $row['mpxPrice'], $row['recyclePrice'], $row['vodafonePrice']];
        $dev = new Device($row['device'], $prices);
        array_push($data, $dev);
    }
    $log->setData($data);
    $logText = json_encode($log);
    $ref = fopen('logs/' . $logName, 'w+');
    fwrite($ref, $logText);
    fclose($ref);
}

function getLogs($id){
    $history = [];
    $names = scandir('logs');
    for($i = 0; $i < count($names); $i++) {
        if(strlen($names[$i]) > 3) {
            $aux = file_get_contents('logs/' . $names[$i]);
            $arr = json_decode($aux);
            $date = $arr->date;
            $data = $arr->data;
            $carPrice = $data[$id]->prices[0];
            $magPrice = $data[$id]->prices[1];
            $mazPrice = $data[$id]->prices[2];
            $mpxPrice = $data[$id]->prices[3];
            $recPrice = $data[$id]->prices[4];
            $vodPrice = $data[$id]->prices[5];
            $$date = [$date, $carPrice, $magPrice, $mazPrice, $mpxPrice, $recPrice, $vodPrice];
            $history[] = $$date;
        }
    }
    return $history;
}
?>