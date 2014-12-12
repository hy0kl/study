<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
class DB
{
    public static function e($str)
    {
        return IsBinary($str) ? addslashes($str) : htmlspecialchars(trim($str));
    }
}

function IsBinary($str)
{
    $blk = substr($str, 0, 512);

    return (substr_count($blk, "\x00") > 0);
}

$mqg = get_magic_quotes_gpc();
var_dump($mqg);

$img_path = 'chinese.jpg';
$img_bin = file_get_contents($img_path);
echo ord($img_bin[0]) . "\n";
var_dump(ctype_print($img_bin));

var_dump(DB::e($img_bin));

$str = '中文<div class="">测试的</div>';
echo ord($str[0]) . "\n";
// ctype_print 不能识别中文,采用网上抄的一个方式.
var_dump(ctype_print($str));
var_dump(DB::e($str));

echo "---------\n";

var_dump(IsBinary($str));
var_dump(IsBinary($img_bin));

/* vi:set ts=4 sw=4 et fdm=marker: */

