<?php
$config = array(
        'dbName' => 'test',
        'dbUser' => 'test',
        'dbPass' => 'test',
    );
/**
 * Class for testing
 * the leager function how to use the global variables.
 */

class TestClass
{
    public function __construct()
    {
        echo 'Here, function is __construct().'. "\n";
    }

    public function debug()
    {
        global $config;
        /** test include or require file and variables.*/
        //require_once('config.inc.php');

        print_r($config);

    }
}

$test = new TestClass();
$test->debug();
?>