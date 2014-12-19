<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
$test = array();
for ($i = 0; $i < 10000; $i++)
{
    $test[$i] = sprintf('%s', uniqid() . '|' . time());
}
echo 'memory usage: ' . memory_get_usage() . PHP_EOL;

$copy = $test;
echo 'memory usage: ' . memory_get_usage() . PHP_EOL;

$copy['copy_on_write'] = 'new memory malloc';
echo 'memory usage: ' . memory_get_usage() . PHP_EOL;
/* vi:set ts=4 sw=4 et fdm=marker: */

