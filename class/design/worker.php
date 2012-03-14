<?php
/*
Factory模式
工厂模式：提供创建对象的接口
分三种：简单工厂，工厂方法以及多态工厂
*/
if(!defined('CRLF'))
{
    define('CRLF',"<br />\n");
}

// 生产工人,训练技能,才能工作
interface Worker
{
    function work();
    function training($data);
}

//程序员
class Programmer implements Worker
{
    private $data;
    function work()
    {
        echo "培训过" . $this->data . "的程序员在工作" . CRLF;
    }
    function training($data)
    {
        $this->data = $data;
    }
}
//美工
class ArtDesigner implements Worker
{
    private $data;
    function work()
    {
        echo "培训过" . $this->data . "的美工在工作" . CRLF;
    }
    function training($data)
    {
        $this->data = $data;
    }
    
    //复制时的回调方法,用于标志与原对象的相异
    function __clone()
    {
        $this->data .= '1';
    }
}
?>