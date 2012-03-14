<?php
/*
当一个类不知道它所必须创建的对象的类的时候
略解：社会分工细化了，只对人才的培养做规范，由具体类别的专业培训机构培养
*/
if(!defined('CRLF')) define('CRLF',"");
//人才列表
require 'worker.php';
//人才市场
abstract class WorkerFactory {
    /** * 抽象方法生产工人 * * @return Worker */
    abstract function newWorker();
    /** * 根据工人类型，提供生成工厂的具体类 * * @param string $type * @return WorkerFactory */
    static function newFactory($type)
    {
        if ('art' == $type) 
        {
            return new ArtSchool();
        }elseif('logic' == $type)
        {
            return new TrainingCenter();
        }else
        {
            throw new Exception("not such type");
        }
    }
}
//训练中心
class TrainingCenter extends WorkerFactory
{
    function newWorker()
    {
        $worker = new Programmer();
        $worker->training("培训资料");
        return $worker;
    }
}
//艺校
class ArtSchool extends WorkerFactory
{
    function newWorker()
    {
        $worker = new ArtDesigner();
        $worker->training("学习资料");
        return $worker;
    }
}
//找来两个人才培训机构
$factorys = array(WorkerFactory::newFactory('logic'), WorkerFactory::newFactory('art'));
$team = array();
for ($i = 0; $i < 4; $i++)
{
    $factory = $factorys[ ($i%2) ];
    //一半美工,一半程序员
    /*@var $factory WorkerFactory*/
    $team[]=$factory->newWorker();
}
//开会
shuffle($team);
//开工
/*@var $worker Worker*/
foreach ($team as $worker)
{
    $worker->work();
}
?>