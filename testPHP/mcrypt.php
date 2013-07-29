<?php

/*
* 实现AES加密
* $str : 要加密的字符串
* $keys : 加密密钥
* $iv : 加密向量
* $cipher_alg : 加密方式
*/
function ecryptdString($str, $keys = "6461772803150152", $iv = "8105547186756005", $cipher_alg = MCRYPT_RIJNDAEL_128)
{
    $encrypted_string = bin2hex(mcrypt_encrypt($cipher_alg, $keys, $str, MCRYPT_MODE_CBC, $iv));
    return $encrypted_string;
}
/*
* 实现AES解密
* $str : 要解密的字符串
* $keys : 加密密钥
* $iv : 加密向量
* $cipher_alg : 加密方式
*/
function decryptString($str, $keys = "6461772803150152", $iv = "8105547186756005", $cipher_alg = MCRYPT_RIJNDAEL_128)
{
    $decrypted_string = mcrypt_decrypt($cipher_alg, $keys, pack("H*",$str), MCRYPT_MODE_CBC, $iv);
    return $decrypted_string;
}

echo ecryptdString('agc') . "\n";

$str = 'e7596e0b1e617dd8a90158f21591c30b';
echo decryptString($str) . "\n";
