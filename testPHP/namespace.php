<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
//namespace Study\PhpLang\php;

spl_autoload_register(function($class) {
    echo $class, PHP_EOL;
    $exp_class = explode('\\', $class);
    print_r($exp_class);
    $file = './'. array_pop($exp_class) . '.php';
    echo $file, PHP_EOL;
    require($file);
});

\PhpDoc\TestNS::ping();
/* vim:set ts=4 sw=4 et fdm=marker: */
