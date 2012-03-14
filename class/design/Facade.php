<?php
/*
当你要为一个复杂子系统提供一个简单接口时
略解：把技术总监叫来，我要和他开会。（数据库类基本是这种思想）
*/
class Complex1
{
    function op1()
    {
        echo "Complex1.op1\n";
    }
    function op2()
    {
        echo "Complex1.op2\n";
    }
}
class Complex2
{
    function op3()
    {
        echo "Complex2.op3\n";
    }
    function op4()
    {
        echo "Complex2.op4\n";
    }
}
class Facade
{
    static function operation1()
    {
        $c1 = new Complex1();
        $c1->op1();
        $c2 = new Complex2();
        $c2->op4();
    }
    static function operation2()
    {
        $c2 = new Complex2();
        $c2->op3();
    }
}
Facade::operation1();
Facade::operation2();
?>