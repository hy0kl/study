<?php
/*
为了避免创建一个与产品类层次一样的工厂类层次时
略解：工作压力大了，培养人才人成本又太高了，某些人才便练就了分身术
由于php本身自带有clone关键字，所有这个模式的实现是非常简单的，
复制完成之后将类的__clone()方法,如果存在的话
*/
if(!defined('CRLF')) define('CRLF',"");
require_once 'worker.php';
$team=array(new ArtDesigner(),new Programmer());
//集体分身
/*@var $worker Worker*/
foreach ($team as $worker)
{
    $team[]=clone $worker;
}
//工作
foreach ($team as $worker)
{ 
    /*@var $worker Worker*/
    $worker->work();
}
?>