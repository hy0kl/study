<?php
/**
 * @describe: 自行捕获出错,保存现场
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
//set_error_handler('cus_error_handler');
set_error_handler('cus_error_handler', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

function cus_error_handler($errno, $errstr, $errfile, $errline, $errcontext) {
    print_r(sprintf("errno: %d | errstr: %s | errfile: %s | errline: %d | errcontext: %s | request_uri: %s\n",
        $errno, $errstr, $errfile, $errline, json_encode($errcontext),
        isset($_SERVER['REQUEST_URI']) ? json_encode($_SERVER['REQUEST_URI']) : 'cli'));
}

echo $abc;
echo sprintf("Just 4 test %s %d\n");
/* vim:set ts=4 sw=4 et fdm=marker: */

