<?php
/*
在不影响其他对象的情况下，以动态，透明的方式给单个对象添加职责
当不对采用生成子类的方法进行扩充时
略解：武术有很多种，很多人学了两种以上．如果都给来上一个类别的话，派别就多如牛毛了，通过动态组合，让一个人把几个派别的武功混在一起就成了绝世高手了
*/
//功夫接口
interface GongFu
{
    function show();
}
//组合功夫抽象类
abstract class DecoratedGongFu implements GongFu
{
    /** * 组合功夫的基础 * * @var GongFu */
    protected $base;
    /** * 通常抽象的构造函数都声明成保护类型 * */
    protected function __construct(GongFu $gongfu = null)
    {
        $this->base = $gongfu;
    }
    function show()
    {
        echo get_class($this).'的';
        if ($this->base)
        {
            $this->base->show();
        }
    }
}
//基础:少林功夫 天下武功出少林(周星驰)
class ShaoLinGongFu implements GongFu
{
    function show()
    {
        echo "少林的功夫\r\n";
    }
}
//华山
class HuaShang extends DecoratedGongFu
{
    function __construct(GongFu $gongfu = null)
    {
        parent::__construct($gongfu);
    }
}
//恒山
class HengShang extends DecoratedGongFu
{
    function __construct(GongFu $gongfu=null)
    {
        parent::__construct($gongfu);
    }
}
//武当
class TaiShang extends DecoratedGongFu
{
    function __construct(GongFu $gongfu=null)
    {
        parent::__construct($gongfu);
    }
}
//现在可以任意组合上面的武功了 //少林，华山，泰山的都会的人
$gongfu=new HuaShang(new TaiShang(new ShaoLinGongFu()));
$gongfu->show();
?>