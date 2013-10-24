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
echo "\n\n";
echo date("Y-m-d H:i:s", strtotime("now")), "\n";
echo date("Y-m-d H:i:s", strtotime("-1 week Monday")), "\n";
echo date("Y-m-d H:i:s", strtotime("-1 week Sunday")), "\n";
echo date("Y-m-d H:i:s", strtotime("-1 week Friday")), "\n";
echo date("Y-m-d H:i:s", strtotime("+0 week Monday")), "\n";
echo date("Y-m-d H:i:s", strtotime("+0 week Sunday")), "\n";
echo date("Y-m-d H:i:s", strtotime("this week Monday")), "\n";
echo date("Y-m-d H:i:s", strtotime("this week Friday")), "\n";
echo date("Y-m-d H:i:s", strtotime("last week Friday 6pm")), "\n";


//date('n') 第几个月
//date("w") 本周周几
//date("t") 本月天数

echo '<br>上周:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))),"\n";
echo '<br>本周:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))),"\n";

echo '<br>上月:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))),"\n";
echo '<br>本月:<br>';
echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))),"\n";
echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))),"\n";

$getMonthDays = date("t",mktime(0, 0 , 0,date('n')+(date('n')-1)%3,1,date("Y")));//本季度未最后一月天数
echo '<br>本季度:<br>';
echo date('Y-m-d H:i:s', mktime(0, 0, 0,date('n')-(date('n')-1)%3,1,date('Y'))),"\n";
echo date('Y-m-d H:i:s', mktime(23,59,59,date('n')+(date('n')-1)%3,$getMonthDays,date('Y'))),"\n";
