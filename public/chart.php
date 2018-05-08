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
echo '<div class="table-responsive"><table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0"><thead><tr><th>DATE</th><th>Carphone Warehouse</th><th>MusicMagpie</th><th>Mazuma Mobile</th><th>Mobile Phone Xchange</th><th>EE</th><th>Vodafone</th></tr></thead><tbody>';
foreach($section as $time => $val) {
    echo '<tr><td><strong>' . $time . '</strong></td><td>&pound;' . $val[0] . '</td><td>&pound;' . $val[1] . '</td><td>&pound;' . $val[2] . '</td><td>&pound;' . $val[3] . '</td><td>&pound;' . $val[4] . '</td><td>&pound;' . $val[5] . '</td></tr>';
}
echo '</tbody></table></div>';
?>