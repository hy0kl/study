<?php
function cov($str)
{
    $temp = '';
    for($i=0;;$i++)
    {
        if($str[$i] ==='')
        {
            break;
        }else
        {
            @$temp = $str[$i].$temp;
        }
    }
    return $temp;
}

$str = '13sdf02360sdf02';
echo $str.'<br>';
$str = cov($str);
echo $str;
?>