<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    var_dump($errno, $errstr, $errfile, $errline);
    exit();
});
test();
echo $a;

echo $b;
/* vim:set ts=4 sw=4 et fdm=marker: */

