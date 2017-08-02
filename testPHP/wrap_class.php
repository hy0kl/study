<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
class Logger
{
    public static function debug($log = '')
    {
        echo sprintf("[debug]%s\n", $log);
    }

    public static function notice($log = '')
    {
        echo sprintf("[notice]%s\n", $log);
    }
}

class WrapLogger
{
    public static function __callStatic($name, $arguments)
    {
        print_r($arguments);
        call_user_func_array('Logger::' . $name, $arguments);
    }
}

WrapLogger::debug('wrap', __FILE__, __LINE__);
