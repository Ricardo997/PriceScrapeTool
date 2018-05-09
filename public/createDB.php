<?php
require_once 'connection.php';
$con = new PDO("mysql:host=" . $server, $user, $pass);
$createDB = "CREATE DATABASE " . $db;
$carphone = "CREATE TABLE `carphone` (
            `idCarphone` int(9) NOT NULL,
            `carphoneName` varchar(80) DEFAULT NULL,
            `carphonePrice` float(5,2) DEFAULT NULL
            )";
$magpie = "CREATE TABLE `magpie` (
            `idMagpie` int(9) NOT NULL,
            `magpieName` varchar(80) DEFAULT NULL,
            `magpiePrice` float(5,2) DEFAULT NULL
            )";
$mazuma = "CREATE TABLE `mazuma` (
    `idMazuma` int(9) NOT NULL,
    `mazumaName` varchar(80) DEFAULT NULL,
    `mazumaPrice` float(5,2) DEFAULT NULL
  )";
$mpx = "CREATE TABLE `mpx` (
    `idMpx` int(9) NOT NULL,
    `mpxName` varchar(80) DEFAULT NULL,
    `mpxPrice` float(5,2) DEFAULT NULL
  )";
$rec = "CREATE TABLE `recyclee` (
    `idRecycle` int(9) NOT NULL,
    `recycleName` varchar(80) DEFAULT NULL,
    `recyclePrice` float(5,2) DEFAULT NULL
  )";
$redeem = "CREATE TABLE `redeem` (
    `id` int(9) NOT NULL,
    `model` varchar(80) DEFAULT NULL
  )";
$users = "CREATE TABLE `users` (
    `userID` int(9) NOT NULL,
    `firstName` varchar(80) NOT NULL,
    `lastName` varchar(80) NOT NULL,
    `mail` varchar(80) NOT NULL,
    `password` varchar(80) NOT NULL
  )";
$vodafone = "CREATE TABLE `vodafone` (
    `idVodafone` int(9) NOT NULL,
    `vodafoneName` varchar(80) DEFAULT NULL,
    `vodafonePrice` float(5,2) DEFAULT NULL
  )";
$con->query($createDB);
$con->query('use ' . $db);
$con->query($carphone);
$con->query($magpie);
$con->query($mazuma);
$con->query($mpx);
$con->query($rec);
$con->query($redeem);
$con->query($users);
$con->query($vodafone);
$alt = "ALTER TABLE `carphone` ADD KEY `idCarphone` (`idCarphone`)";
$con->query($alt);
$alt = "ALTER TABLE `magpie` ADD KEY `idMagpie` (`idMagpie`)";
$con->query($alt);
$alt = "ALTER TABLE `mazuma` ADD KEY `idMazuma` (`idMazuma`)";
$con->query($alt);
$alt = "ALTER TABLE `mpx` ADD KEY `idMpx` (`idMpx`)";
$con->query($alt);
$alt = "ALTER TABLE `recyclee` ADD KEY `idRecycle` (`idRecycle`)";
$con->query($alt);
$alt = "ALTER TABLE `redeem` ADD PRIMARY KEY (`id`)";
$con->query($alt);
$alt = "ALTER TABLE `users` ADD PRIMARY KEY (`userID`), ADD KEY `userID` (`userID`)";
$con->query($alt);
$alt = "ALTER TABLE `vodafone` ADD KEY `idVodafone` (`idVodafone`)";
$con->query($alt);
$alt = "ALTER TABLE `redeem` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT";
$con->query($alt);
$alt = "ALTER TABLE `users` MODIFY `userID` int(9) NOT NULL AUTO_INCREMENT";
$con->query($alt);
$alt = "ALTER TABLE `carphone` ADD CONSTRAINT `carphone_ibfk_1` FOREIGN KEY (`idCarphone`) REFERENCES `redeem` (`id`)";
$con->query($alt);
$alt = "ALTER TABLE `magpie` ADD CONSTRAINT `magpie_ibfk_1` FOREIGN KEY (`idMagpie`) REFERENCES `redeem` (`id`)";
$con->query($alt);
$alt = "ALTER TABLE `mazuma` ADD CONSTRAINT `mazuma_ibfk_1` FOREIGN KEY (`idMazuma`) REFERENCES `redeem` (`id`)";
$con->query($alt);
$alt = "ALTER TABLE `mpx` ADD CONSTRAINT `mpx_ibfk_1` FOREIGN KEY (`idMpx`) REFERENCES `redeem` (`id`)";
$con->query($alt);
$alt = "ALTER TABLE `recyclee` ADD CONSTRAINT `recyclee_ibfk_1` FOREIGN KEY (`idRecycle`) REFERENCES `redeem` (`id`)";
$con->query($alt);
$alt = "ALTER TABLE `vodafone` ADD CONSTRAINT `vodafone_ibfk_1` FOREIGN KEY (`idVodafone`) REFERENCES `redeem` (`id`)";
$con->query($alt);
$insrt = "INSERT INTO `redeem` (`id`, `model`) VALUES
(null, 'Apple iPhone 5S 16GB'),
(null, 'Apple iPhone 5S 32GB'),
(null, 'Apple iPhone 5S 64GB'),
(null, 'Apple iPhone 6 128GB'),
(null, 'Apple iPhone 6 16GB'),
(null, 'Apple iPhone 6 32GB'),
(null, 'Apple iPhone 6 64GB'),
(null, 'Apple iPhone 6 Plus 128GB'),
(null, 'Apple iPhone 6 Plus 16GB'),
(null, 'Apple iPhone 6 Plus 64GB'),
(null, 'Apple iPhone 6S 128GB'),
(null, 'Apple iPhone 6S 16GB'),
(null, 'Apple iPhone 6S 32GB'),
(null, 'Apple iPhone 6S 64GB'),
(null, 'Apple iPhone 6S Plus 128GB'),
(null, 'Apple iPhone 6S Plus 16GB'),
(null, 'Apple iPhone 6S Plus 32GB'),
(null, 'Apple iPhone 6S Plus 64GB'),
(null, 'Apple iPhone 7 128GB'),
(null, 'Apple iPhone 7 256GB'),
(null, 'Apple iPhone 7 32GB'),
(null, 'Apple iPhone 7 Plus 128GB'),
(null, 'Apple iPhone 7 Plus 256GB'),
(null, 'Apple iPhone 7 Plus 32GB'),
(null, 'Apple iPhone 8 256GB'),
(null, 'Apple iPhone 8 64GB'),
(null, 'Apple iPhone 8 Plus 256GB'),
(null, 'Apple iPhone 8 Plus 64GB'),
(null, 'Apple iPhone SE 128GB'),
(null, 'Apple iPhone SE 16GB'),
(null, 'Apple iPhone SE 32GB'),
(null, 'Apple iPhone SE 64GB'),
(null, 'Apple iPhone X 256GB'),
(null, 'Apple iPhone X 64GB'),
(null, 'Samsung Galaxy A3'),
(null, 'Samsung Galaxy A3 (2016)'),
(null, 'Samsung Galaxy J3 (2016)'),
(null, 'Samsung Galaxy J5'),
(null, 'Samsung Galaxy Note 4'),
(null, 'Samsung Galaxy S5'),
(null, 'Samsung Galaxy S6 Edge'),
(null, 'Samsung Galaxy S6 Edge 64GB'),
(null, 'Samsung Galaxy S6 Edge Plus'),
(null, 'Samsung Galaxy S6 G920'),
(null, 'Samsung Galaxy S7 Edge 32GB'),
(null, 'Samsung Galaxy S7 32GB'),
(null, 'Samsung Galaxy S8'),
(null, 'Samsung Galaxy S8 Plus'),
(null, 'Sony Xperia Z5'),
(null, 'Sony Xperia Z5 Compact')";
$con->query($insrt);
$insUser = "INSERT INTO `users` (`userID`, `firstName`, `lastName`, `mail`, `password`) VALUES
(null, 'Admin', 'Admin', 'admin@admin.com', '$2y$10\$XfJhPYO3yhSp48O/wci8MeSAN5Ce0dpLd1pb3RCepxuYpKKJ4UsSW')";
$con->query($insUser);
