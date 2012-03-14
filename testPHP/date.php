<?php
$date = date('Y-m-d H:i:s', strtotime(date('Y-m', time())));
echo $date;
echo '<br />';
$day = 60 * 60 * 24;
echo 'one day equal 60 * 60 * 24 = '. $day;
echo '<br />';
$week = $day * 7;
echo 'one week equal one day multiply 7, day * 7 = '. $week;
echo '<br />';
$month = $day * 30;
echo 'one month equal one day multiply 30, day * 30 = '. $month;
echo '<br />';
$year = $day * 365;
echo 'one year equal one day multiply 365, day * 365 = '. $year;
?>