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
    $con = new PDO("mysql:host=localhost;dbname=scrapeprices", 'Ricardo', 'admin');
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
    $con = new PDO("mysql:host=localhost;dbname=scrapeprices", 'Ricardo', 'admin');
    $users = array();
    $query = 'SELECT * FROM `users`';
    $result = $con->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }
    $con = null;
    return $users;
}
