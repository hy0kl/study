<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
//$cipher_methods = openssl_get_cipher_methods();
//print_r($cipher_methods);

$method = 'AES-256-CBC';

$key = 'qwaszx!@';
//$key = substr(sha1($key, true), 0, 16);
$key = substr(md5($key), 0, 16);
echo sprintf("key: %s\n", $key);
//$iv = openssl_random_pseudo_bytes(16);
$iv = substr(md5(mt_rand()), 0, 16);
echo sprintf("iv: %s\n", $iv);

$plaintext = 'hello, I use AES.加密传输更安全.';
echo sprintf("plaintext: %s\n", $plaintext);

echo str_repeat('-', 80), PHP_EOL;

$ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
$ciphertext = base64_encode($ciphertext);
echo sprintf("ciphertext: %s\n", $ciphertext);

$des_plaintext = openssl_decrypt(base64_decode($ciphertext), $method, $key, OPENSSL_RAW_DATA, $iv);
echo sprintf("des_plaintext: %s \n", $des_plaintext);
/* vim:set ts=4 sw=4 et fdm=marker: */

