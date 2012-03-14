<?php
$sum = 0;
$N   = 3;
for($i =0; $i < 3; $i ++)
{
    echo $i.'|';
    for($j = 0; $j < $i; $j++ )
    {
        echo $j.'|';
        for($k = 0; $k < $j; $k++)
        {
            echo $k.'|';
            echo 'Now,I am '.$sum.'<br>';
            $sum++;
        }
    }
}
?>