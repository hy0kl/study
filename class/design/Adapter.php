<?php
/*
你想使用已经存在的类，而它的接口不符合你的需求
略解：买个变压器，在220电压下使用额定电压为110电器
*/
//220的电源
class Power220
{
    function accept(Wiring220 $wiring)
    {
        echo "220伏电压接入电器".get_class($wiring)."\r\n";
        $wiring->runWith($this);
    }
}

//110的电源
class Power110
{
    /** * 意味着电源比较远,不能直接使用 * */
    protected function __construct()
    {
    }
    function accept(Wiring110 $wiring)
    {
        echo "110伏电压接入电器".get_class($wiring)."\r\n";
        $wiring->runWith($this);
    }
}

//电压220的电器
interface Wiring220
{
    function runWith(Power220 $p);
}
//电压110的电器
interface Wiring110
{
    function runWith(Power110 $p);
}

//电压为110伏的电风扇,无法修改的类
final class Fan110 implements Wiring110
{
    function runWith(Power110 $p)
    {
        echo '110伏电器[电风扇]工作在'.get_class($p)."电源下工作\r\n";
    }
}
//变压器,可以看做电源和用电器的组合
class Adapter extends Power110 implements Wiring220
{
    function __construct()
    {
        parent::__construct(); 
    }
    function runWith(Power220 $wiring)
    {
        echo '变压器输入电源'.get_class($wiring)."\r\n";
    }
}
//组合工作
//110伏用电器
$wiring110=new Fan110();
//220伏电压
$power220=new Power220();
//变压器
$adapter=new Adapter();
//把变压器接入电源
$power220->accept($adapter);
//把用电器接入变压器
$wiring110->runWith($adapter);
?>