<?php

//Start musicmagpie

function magpieScan($search, $id)
{
    error_reporting(0);
    require 'connection.php';

    $inserted = 0;
    $updated = 0;
    $filters = ['Tab ', 'Gear', 'iPad', 'iPod', 'AMD', 'Watch', 'iMac'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.musicmagpie.co.uk/usercontrols/SearchTech.asmx/GetSearchResults",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 50000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{prefixText: \"" . $search . "\", count: 20}",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: 1a11a547-94fc-4b6b-a597-fe474e751c9d",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $data = json_decode($response);
    $con = new mysqli($server, $user, $pass, $db);

    $perc = 0;
    $correctName = '';
    $generalUrl = 'https://www.musicmagpie.co.uk/';
    $correctUrl = '';
    foreach ($data as $d => $arr) {
        for ($i = 0; $i < count($arr); $i++) {
            for ($i = 0; $i < count($arr); $i++) {
                $name = getMagpieName($arr[$i]);
                similar_text($search, $name, $percentage);
                if ($percentage > $perc) {
                    $perc = $percentage;
                    $correctName = $name;
                    $correctUrl = rtrim(substr($arr[$i], 37, 56), '\u\u00 ');
                }
            }
        }
    }
    if (strpos($search, 'Xperia') !== false) {
        if (strlen($correctUrl !== 52)) {
            $rem = strlen($correctUrl) - 52;
            for ($rem; $rem > 0; $rem--) {
                $correctUrl = substr_replace($correctUrl, '', -1);
            }
            $fullUrl = $generalUrl . $correctUrl;
        }
    } else {
        if (strlen($correctUrl !== 56)) {
            $add = 56 - strlen($correctUrl);
            for ($add; $add > 0; $add--) {
                $correctUrl .= '0';
            }
            $fullUrl = $generalUrl . $correctUrl;
        }
    }
    $webpage = file_get_contents($fullUrl);
    $price = getMagpiePrice($webpage);

    if ($name !== 'noName') {
        $query = "SELECT COUNT(*) AS matches FROM `magpie` WHERE `magpieName` = '" . $correctName . "'";
        $result = $con->query($query);
        $row = $result->fetch_assoc();
        if ($row['matches'] === '0') {
            $insrt = "INSERT INTO `magpie`(`idMagpie`, `magpieName`, `magpiePrice`) VALUES (" . $id . ", '" . $correctName . "', " . $price . ")";
            $con->query($insrt);
            $inserted++;
        } else {
            $updt = "UPDATE `magpie` SET `magpiePrice`= '" . $price . "' WHERE `magpieName`= '" . $correctName . "'";
            $con->query($updt);
            $updated++;
        }
    }
}

function getMagpieName($str)
{
    $startPos = strpos($str, 'u003e') + 5;
    $endPos = (strpos($str, 'u003c/a') - 1);
    $length = ($endPos - $startPos);
    $nameAux1 = substr($str, $startPos, $length);
    $nameAux2 = str_replace('(', '', $nameAux1);
    $name = str_replace(')', '', $nameAux2);
    return $name;
}

function getMagpiePrice($webpage)
{
    $priceContainerStart = '<span id="ctl00_ctl00_ctl00_ContentPlaceHolderDefault_mainContent_itemCondition3_10_lblItemPrice" class="itemConditionPrice">';
    $priceContainerStart2 = '<span class="blue strong">';
    $priceContainerEnd = '</span>';
    $priceContainerStartPos = (strpos($webpage, $priceContainerStart, strlen($priceContainerStart)));
    $priceContainerStartPos2 = (strpos($webpage, $priceContainerStart2) + 26);
    if ($priceContainerStartPos) {
        $priceContainerEndPos = (strpos($webpage, $priceContainerEnd, $priceContainerStartPos));
        $length = $priceContainerEndPos - $priceContainerStartPos;
        $priceAux = substr($webpage, $priceContainerStartPos, $length);
        $price = floatval(str_replace($priceContainerStart, '', $priceAux));
        return $price;
    } else if ($priceContainerStartPos2) {
        $priceContainerEndPos2 = (strpos($webpage, $priceContainerEnd, $priceContainerStartPos2));
        $length = $priceContainerEndPos2 - $priceContainerStartPos2;
        $priceAux = substr($webpage, $priceContainerStartPos2, 6);
        $price = floatval(trim(str_replace($priceContainerStart2, '', $priceAux), '£'));
        return $price;
    } else {
        return 'noPrice';
    }
}

//End musicagpie
//Start mazumamobile

function mazumaScan($search, $id)
{
    error_reporting(0);
    require 'connection.php';
    $search = str_replace('Edge Plus', 'Edge+', $search);
    $inserted = 0;
    $updated = 0;
    $filters = ['Tab ', 'Gear', 'iPad', 'iPod', 'AMD', 'Watch', 'iMac'];

    $searchNew = str_replace('Edge Plus', 'Edge+', str_replace(' ', '+', $search));
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.mazumamobile.com/js/ajaxAutoSuggest/autoSuggest.search.php?q=" . $searchNew . "&_=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 50,
        CURLOPT_TIMEOUT => 50000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Postman-Token: b6f0b372-60b0-41e2-9ceb-338c7f883eb1",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $DOM = new DOMDocument;
    $DOM->loadHTML($response);
    $con = new mysqli($server, $user, $pass, $db);
    $items = $DOM->getElementsByTagName('a');
    $perc = 0;
    $correctName = '';
    $correctPrice = 0;
    for ($j = 0; $j < $items->length; $j++) {
        $name = $items->item($j)->nodeValue;
        similar_text($search, $name, $percentage);
        if ($percentage > $perc) {
            $perc = $percentage;

            $correctName = $name;
            $correctUrl = $items->item($j)->getAttribute('href');
        }
    }

    //$url = 'http://localhost/MazumaMobile/www.mazumamobile.com' . $items->item($j)->getAttribute('href') . '.html';
    $url = 'https://www.mazumamobile.com' . $correctUrl;
    $web = file_get_contents($url);
    $correct = true;
    for ($f = 0; $f < count($filters); $f++) {
        if ((strpos($correctName, $filters[$f])) !== false) {
            $correct = false;
            break;
        }
    }

    if ($correct) {
        $price = getMazumaPrice($web);
        if ($price !== 'noPrice') {
            $query = "SELECT COUNT(*) AS matches FROM `mazuma` WHERE `mazumaName` = '" . $correctName . "'";
            $result = $con->query($query);
            $row = $result->fetch_assoc();
            if ($row['matches'] == 0) {
                $insrt = "INSERT INTO `mazuma`(`idMazuma`, `mazumaName`, `mazumaPrice`) VALUES (" . $id . ", '" . $correctName . "', " . $price . ")";
                $con->query($insrt);
                $inserted++;
            } else {
                $updt = "UPDATE `mazuma` SET `mazumaPrice`= '" . $price . "' WHERE `mazumaName`= '" . $correctName . "'";
                $con->query($updt);
                $updated++;
            }
        }
    }

}

function getMazumaPrice($webpage)
{
    $priceContainerStart = '<span class="value">';
    $priceContainerEnd = '</span>';
    $priceContainerStartPos = (strpos($webpage, $priceContainerStart, 20));
    if (!empty($priceContainerStartPos)) {
        $priceContainerEndPos = (strpos($webpage, $priceContainerEnd, $priceContainerStartPos));
        $length = $priceContainerEndPos - $priceContainerStartPos;
        $priceAux = substr($webpage, $priceContainerStartPos, $length);
        $price = floatval(str_replace($priceContainerStart, '', $priceAux));
        return $price;
    } else {
        return 'noPrice';
    }
}

//End mazumamobile
//Start Recycle.ee

function recycleScan($search, $id)
{
    error_reporting(0);
    require 'connection.php';

    $inserted = 0;
    $updated = 0;
    $filters = ['Tab ', 'Gear', 'iPad', 'iPod', 'AMD', 'Watch', 'iMac'];
    if(strpos($search, 'Galaxy')){
        if (strpos($search, '16GB')){
            $newSearch = str_replace('16GB', '', $search);
        } elseif (strpos($search, '32GB')){
            $newSearch = str_replace('32GB', '', $search);
        } elseif (strpos($search, '64GB')){
            $newSearch = str_replace('64GB', '', $search);
        } elseif (strpos($search, '128GB')){
            $newSearch = str_replace('128GB', '', $search);
        } else {
            $newSearch = $search;
        }
    } else {
        $newSearch = $search;
    }
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://recycle.ee.co.uk/AutoComplete.asmx/GetCompletionList",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 50000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "prefixText=" . $newSearch . "&count=500",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 83999cf2-69d3-42c5-bd11-c26ef17a1a8c",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $con = new mysqli($server, $user, $pass, $db);
    $xml = new SimpleXMLElement($response);
    $index = 0;

    $perc = 0;
    $correctName = '';
    $correctPrice = 0;
    foreach ($xml as $name => $arr) {
        $name = getRecycleName($arr[$index]);
        similar_text($search, $name, $percentage);
        if ($percentage > $perc) {
            $perc = $percentage;
            $correctName = $name;
            $correctPrice = getRecyclePrice($name);
        }
    }

    $correct = true;
    for ($f = 0; $f < count($filters); $f++) {
        if ((strpos($name, $filters[$f])) !== false) {
            $correct = false;
            break;
        }
    }
    if ($correct) {
        if ($correctPrice !== 'noPrice') {
            $query = "SELECT COUNT(*) AS matches FROM `recyclee` WHERE `recycleName` = '" . $correctName . "'";
            $result = $con->query($query);
            $row = $result->fetch_assoc();
            if ($row['matches'] == 0) {
                $insrt = "INSERT INTO `recyclee`(`idRecycle`, `recycleName`, `recyclePrice`) VALUES (" . $id . ", '" . $correctName . "', " . $correctPrice . ")";
                $con->query($insrt);
                $inserted++;
            } else {
                $updt = "UPDATE `recyclee` SET `recyclePrice`= '" . $correctPrice . "' WHERE `recycleName`= '" . $correctName . "'";
                $con->query($updt);
                $updated++;
            }
        }
    }
}

function getRecycleName($str)
{
    $startPos = strpos($str, 'First":"') + 8;
    $endPos = strpos($str, '","Second');
    $length = ($endPos - $startPos);
    $nameAux = substr($str, $startPos, $length);
    $name = str_replace('(', '', (str_replace(')', '', $nameAux)));
    return $name;
}

function getRecyclePrice($name)
{
    $brand = substr($name, 0, (strpos($name, ' ')));
    $model = str_replace(' ', '_', str_replace($brand . ' ', '', $name));
    $url = 'https://recycle.ee.co.uk/sell-mobile-phone/Phones/' . $brand . '/' . $model . '.html';
    $web = file_get_contents($url);
    if ($web !== false) {
        $startPos = (strpos($web, '<span id="ContentPlaceHolder1_PhoneModelInspection_EE_spnQuoteValueBacsOld" class="quote-value">&#163; ')) + 103;
        $endPos = (strpos($web, '</span>', $startPos));
        $length = ($endPos - $startPos);
        $priceAux1 = substr($web, $startPos, $length);
        $priceAux2 = str_replace('£ ', '', $priceAux1);
        $price = floatval($priceAux2);
        return $price;
    } else {
        return 'noPrice';
    }
}

// End Recycle.ee
//Start carphonewarehouse

function carphoneScan($search, $id)
{
    error_reporting(0);
    require 'connection.php';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sellmyphone.carphonewarehouse.com/api/typesearch",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 50000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n" . $search . "\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Postman-Token: 8df22336-044e-45c1-a0e6-75221ff2aa09",
            "X-Requested-With: XMLHttpRequest",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $data = json_decode($response);
    $con = new mysqli($server, $user, $pass, $db);
    $perc = 0;
    $correctName = '';
    $correctPrice = 0;
    foreach ($data as $product => $obj) {
        foreach ($obj as $index => $arr) {
            for ($i = 0; $i < count($arr); $i++) {
                $make = ucfirst(strtolower($arr->make));
                $name = str_replace('(', '', str_replace(')', '', ($make . ' ' . $arr->model)));
                similar_text($search, $name, $percentage);
                if ($percentage > $perc) {
                    $perc = $percentage;
                    $correctName = $name;
                    $correctPrice = floatval($arr->working);
                }
            }
        }
    }
    $query = "SELECT COUNT(*) AS matches FROM `carphone` WHERE `carphoneName` = '" . $correctName . "'";
    $result = $con->query($query);
    $row = $result->fetch_assoc();
    if ($row['matches'] == 0) {
        $insrt = "INSERT INTO `carphone`(`idCarphone`, `carphoneName`, `carphonePrice`) VALUES (" . $id . ", '" . $correctName . "', " . $correctPrice . ")";
        $con->query($insrt);
    } else {
        $updt = "UPDATE `carphone` SET `carphonePrice`= '" . $correctPrice . "' WHERE `carphoneName`= '" . $correctName . "'";
        $con->query($updt);
    }
}

//End carphonewarehouse
//Start vodafone

function vodafoneScan($search, $id)
{
    error_reporting(0);
    require 'connection.php';

    $inserted = 0;
    $updated = 0;
    $filters = ['Tab ', 'Gear', 'iPad', 'iPod', 'AMD', 'Watch', 'iMac'];
    if(strpos($search, 'Galaxy')){
        if (strpos($search, ' 16GB')){
            $newSearch = str_replace(' 16GB', '', $search);
        } elseif (strpos($search, ' 32GB')){
            $newSearch = str_replace(' 32GB', '', $search);
        } elseif (strpos($search, ' 64GB')){
            $newSearch = str_replace(' 64GB', '', $search);
        } elseif (strpos($search, ' 128GB')){
            $newSearch = str_replace(' 128GB', '', $search);
        } else {
            $newSearch = $search;
        }
    } else {
        $newSearch = $search;
    }
    $brandSearch = str_replace(' ', '%20', $newSearch);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://tradein.vodafone.co.uk/api/SearchedPhoneModelDetails/vouk/" . $brandSearch . "/callback?callback=5000&_=1523370366395",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 50000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Postman-Token: eaf04e69-ed9e-4868-8fc4-708a394ec2ab",
        ),
    ));

    $responseAux = curl_exec($curl);
    $response = str_replace(')', '', str_replace('callback(', '', $responseAux));
    $err = curl_error($curl);

    curl_close($curl);

    $data = json_decode($response);
    $con = new mysqli($server, $user, $pass, $db);
    $devices = $data->Data;
    $perc = 0;
    $correctName = '';
    $correctPrice = 0;
    for ($i = 0; $i < count($devices); $i++) {
        $make = $devices[$i]->Manufacturer;
        $model = $devices[$i]->Model;
        $name = str_replace('(', '', str_replace(')', '', ($make . ' ' . $model)));
        //echo $newSearch . ' ?? ' . $name . '<br>';
        similar_text($search, $name, $percentage);
        if ($percentage > $perc) {
            $perc = $percentage;
            $correctName = $name;
            $correctPrice = floatval($devices[$i]->UptoCashPrice);
        }
    }
    //echo $newSearch . ' <==> ' . $correctName . '<br>';
    $correct = true;
    for ($f = 0; $f < count($filters); $f++) {
        if ((strpos($name, $filters[$f])) !== false) {
            $correct = false;
            break;
        }
    }
    if ($correct) {
        $query = "SELECT COUNT(*) AS matches FROM `vodafone` WHERE `vodafoneName` = '" . $correctName . "'";
        $result = $con->query($query);
        $row = $result->fetch_assoc();
        if ($row['matches'] === '0') {
            $insrt = "INSERT INTO `vodafone`(`idVodafone`, `vodafoneName`, `vodafonePrice`) VALUES (" . $id . ", '" . $correctName . "', " . $correctPrice . ")";
            $con->query($insrt);
            $inserted++;
        } else {
            $updt = "UPDATE `vodafone` SET `vodafonePrice`= '" . $correctPrice . "' WHERE `vodafoneName`= '" . $correctName . "'";
            $con->query($updt);
            $updated++;
        }
    }

}

//End vodafone
//Start mpx

function mpxScan($search, $id)
{
    error_reporting(0);
    require 'connection.php';

    $inserted = 0;
    $updated = 0;
    $filters = ['Tab ', 'Gear', 'iPad', 'iPod', 'AMD', 'Watch', 'iMac'];
    if(strpos($search, 'Galaxy')){
        if (strpos($search, ' 16GB')){
            $newSearch = str_replace(' 16GB', '', $search);
        } elseif (strpos($search, ' 32GB')){
            $newSearch = str_replace(' 32GB', '', $search);
        } elseif (strpos($search, ' 64GB')){
            $newSearch = str_replace(' 64GB', '', $search);
        } elseif (strpos($search, ' 128GB')){
            $newSearch = str_replace(' 128GB', '', $search);
        } else {
            $newSearch = $search;
        }
        // if (strpos($search, ' Plus')){
        //     $newSearch = str_replace(' Plus', '', $newSearch);
        // }
    } else {
        $newSearch = $search;
    }
    if (strpos($newSearch,'Edge')){
        $newSearch = str_replace(' Edge', '', $newSearch);
    }
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.mobilephonexchange.co.uk/AutoComplete.asmx/GetCompletionList",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 50000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "prefixText=" . $newSearch . "&count=500",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 83999cf2-69d3-42c5-bd11-c26ef17a1a8c",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $con = new mysqli($server, $user, $pass, $db);
    $xml = new SimpleXMLElement($response);
    $perc = 0;
    $correctName = '';
    $correctPrice = 0;
    foreach ($xml as $data => $device) {
        $name = getMpxName($device);
        similar_text($search, $name, $percentage);
        if ($percentage > $perc) {
            $perc = $percentage;
            $correctName = $name;
            $correctPrice = getMpxPrice($correctName);
        }
    }
    $correct = true;
    for ($f = 0; $f < count($filters); $f++) {
        if ((strpos($correctName, $filters[$f])) !== false) {
            $correct = false;
            break;
        }
    }
    if ($correct) {
        if ($correctPrice !== 'noPrice') {
            $query = "SELECT COUNT(*) AS matches FROM `mpx` WHERE `mpxName` = '" . $correctName . "'";
            $result = $con->query($query);
            $row = $result->fetch_assoc();
            if ($row['matches'] == 0) {
                $insrt = "INSERT INTO `mpx`(`idMpx`, `mpxName`, `mpxPrice`) VALUES (" . $id . ", '" . $correctName . "', " . $correctPrice . ")";
                $con->query($insrt);
                $inserted++;
            } else {
                $updt = "UPDATE `mpx` SET `mpxPrice`= '" . $correctPrice . "' WHERE `mpxName`= '" . $correctName . "'";
                $con->query($updt);
                $updated++;
            }
        }
    }
}
function getMpxName($str)
{
    $startPos = strpos($str, 'First":"') + 8;
    $endPos = strpos($str, '","Second');
    $length = ($endPos - $startPos);
    $nameAux = substr($str, $startPos, $length);
    $name = str_replace('(', '', (str_replace(')', '', $nameAux)));
    return $name;
}

function getMpxPrice($name)
{
    $brand = substr($name, 0, (strpos($name, ' ')));
    $model = str_replace(' ', '_', str_replace($brand . ' ', '', $name));
    $url = 'https://www.mobilephonexchange.co.uk/sell-mobile-phone/Phones/' . $brand . '/' . $model;
    $web = file_get_contents($url);
    if ($web !== false) {
        $startPos = (strpos($web, '<div id="handset-valuation-amount">')) + 111;
        $endPos = (strpos($web, '</h3>', $startPos));
        $length = ($endPos - $startPos);
        $priceAux1 = substr($web, $startPos, $length);
        $priceAux2 = str_replace('£ ', '', $priceAux1);
        $price = floatval($priceAux2);
        return $price;
    } else {
        return 'noPrice';
    }
}

//End mpx

function addDevice($deviceName)
{
    // Inserts device in the db and search the prices for that device.
    require 'connection.php';

    $con = new mysqli($server, $user, $pass, $db);
    $query = 'SELECT * FROM `redeem`';
    $result = $con->query($query);
    $found = false;
    while ($row = $result->fetch_assoc()) {
        if ((strpos($deviceName, $row['model']) !== false)) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $select = "SELECT COUNT(*) AS total FROM `redeem`";
        $resul = $con->query($select);
        $row = $resul->fetch_assoc();
        $insrt = "INSERT INTO `redeem`(`id`, `model`) VALUES (" . $row['total'] . " + 1, '" . $deviceName . "')";
        $con->query($insrt);
        $select = "SELECT * FROM `redeem` WHERE `model`='" . $deviceName . "'";
        $resul = $con->query($select);
        while ($row2 = $resul->fetch_assoc()) {
            $id = $row2['id'];
            recycleScan($deviceName, $id);
            mazumaScan($deviceName, $id);
            magpieScan($deviceName, $id);
            carphoneScan($deviceName, $id);
            vodafoneScan($deviceName, $id);
            break;
        }
        return 'Device added successfully.';
    } else {
        return 'The device is already registered';
    }
}


?>