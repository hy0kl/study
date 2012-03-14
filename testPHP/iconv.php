<?php
//header('Content-type: text/html; charset=UTF-8');
header('Content-type: text/html; charset=UTF-8');

function check_is_gbk_chinese($str)
{        
    return preg_match('/[\x80-\xff]./', $str);        
}

$str = '我是UTF-8中文,被转成GBK了.';
echo $str;

$gbk_str = iconv('UTF-8', 'GBK', $str);
echo $gbk_str;

if (check_is_gbk_chinese($gbk_str))
{
    echo 'It is GBK character.';
}
else
{
    echo 'Unknow character.';
}
?>
