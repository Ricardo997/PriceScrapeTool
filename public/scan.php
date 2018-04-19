<?php
    require 'connection.php';
    require 'scans/webFunctions.php';
    $con = new mysqli($server, $user, $pass, $db);
    $query = 'SELECT * FROM `redeem`';
    $result = $con->query($query);
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $model = $row['model'];
        recycleScan($model, $id);
        mazumaScan($model, $id);
        magpieScan($model, $id);
        if (strpos($model, 'Edge Plus') !== false) {
            carphoneScan((str_replace('Edge Plus', 'Edge+', $model)), $id);
        } else if (strpos($model, 'S8 Plus') !== false) {
            carphoneScan((str_replace('S8 Plus', 'S8+', $model)), $id);
        } else {
            carphoneScan($model, $id);
        }
        vodafoneScan($model, $id);
    }
    echo 'Database updated.';
?>