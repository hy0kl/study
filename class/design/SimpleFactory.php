<?php
/*
略解：培养一个人才的代价太高了，直接问才人市场要一个比较简单
*/
if(!defined('CRLF')) define('CRLF',"");
//人才列表
require 'worker.php';
//人才工厂
class WorkerFactory
{
    /** * 由人才市场负责提供人才 * * @param string $type * @return Worker */
    static function seekWorker($type)
    {
        if ('art'==$type)
        {
            $worker=new ArtDesigner();
            $worker->training('艺术课程'.rand(0,9));
        }elseif('logic'==$type)
        {
            $worker=new Programmer();
            $worker->training('编程语言'.rand(0,9));
        }else
        {
            throw new Exception("没有这种类型的人才");
        }
        return $worker;
    }
}
$team=array();
//三个美工
for ($i=0;$i<3;$i++)
{
    $team[]=WorkerFactory::seekWorker('art');
}
//五个程序员
for ($i=0;$i<5;$i++)
{
    $team[]=WorkerFactory::seekWorker('logic');
}
//组合
shuffle($team);
//开始工作/*@var $worker Worker*/
foreach ($team as $worker)
{
    $worker->work();
}
?>