<?php
require 'scans/webFunctions.php';
require 'functions.php';
createLog();
echo addDevice($_POST['deviceName']);
?>