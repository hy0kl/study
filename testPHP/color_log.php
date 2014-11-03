<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */

/* vi:set ts=4 sw=4 et fdm=marker: */
$color_off    = "\033[0m";
$color_red    = "\033[31m";
$color_green  = "\033[32m";
$color_yellow = "\033[33m";
$color_purple = "\033[35m";
$color_cyan   = "\e[1;36m";

echo $color_red . 'abc' . $color_green . 'def' . $color_purple . 'test' .$color_off . "\n";
echo $color_cyan . 'Hello...' . $color_off . "\n";
