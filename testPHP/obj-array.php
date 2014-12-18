<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
// 实验证明,传对象开销比传数组小
/* vi:set ts=4 sw=4 et fdm=marker: */
function fix($arg)
{
    $arg->name = '123';
}

function fix_array($arg)
{
    $arg['name'] = 'I change it.';
}

class T
{
    public $name = '';
}

$obj = new T();
$obj->name = 'OK';
echo $obj->name . "\n";
fix($obj);
echo $obj->name . "\n";

$test = array('name' => 'array');
print_r($test);
fix_array($test);
print_r($test);

$a_obj = new stdClass();
$a_obj->name = 'stdClass()';
print_r($a_obj);
fix($a_obj);
print_r($a_obj);
