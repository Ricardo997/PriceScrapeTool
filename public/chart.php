<?php
include 'functions.php';
$his = getLogs($_POST['idDevice']);
$car = [];
$mag = [];
$maz = [];
$mpx = [];
$rec = [];
$vod = [];
$dates = [];
$section = [];
foreach($his as $index => $data) {
//    var_dump($data);
    array_push($dates, $data[0]);
    array_push($car, $data[1]);
    array_push($mag, $data[2]);
    array_push($maz, $data[3]);
    array_push($mpx, $data[4]);
    array_push($rec, $data[5]);
    array_push($vod, $data[6]);
}
for($i = 0; $i < count($dates); $i++) {
    if(!isset($secion[$dates[$i]])) {
        $section[$dates[$i]] = [$car[$i], $mag[$i], $maz[$i], $mpx[$i], $rec[$i], $vod[$i]];
    }
}
echo '<canvas id="myCanvas" class="canvas" width="1280" height="650">Sorry, your browser does not support the &lt;canvas&gt; element.</canvas>'
?>