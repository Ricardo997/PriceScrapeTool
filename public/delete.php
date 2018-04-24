<?php
$con = new PDO("mysql:host=localhost;dbname=scrapeprices", 'Ricardo', 'admin');
$query = "DELETE FROM `carphone` WHERE `carphone`.`idCarphone` = " . $_POST['idDevice'];
$con->query($query);
$query = "DELETE FROM `magpie` WHERE `magpie`.`idMagpie` = " . $_POST['idDevice'];
$con->query($query);
$query = "DELETE FROM `mazuma` WHERE `mazuma`.`idMazuma` = " . $_POST['idDevice'];
$con->query($query);
$query = "DELETE FROM `recyclee` WHERE `recyclee`.`idRecycle` = " . $_POST['idDevice'];
$con->query($query);
$query = "DELETE FROM `vodafone` WHERE `vodafone`.`idVodafone` = " . $_POST['idDevice'];
$con->query($query);
$query = "DELETE FROM `redeem` WHERE `redeem`.`id` = " . $_POST['idDevice'];
$con->query($query);
?>