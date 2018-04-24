<?php

use Crunz\Schedule;

$schedule = new Schedule();
$schedule->run('scan.php')
    ->dailyAt('08:00');
return $schedule;
?>