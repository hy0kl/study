<?php
/*
1) 远程代理，为一个对象在不同的地址空间提供局部代表
略解：保险公司只会派出他们的代表和你打交道，而不是把公司搬到你家里来
2)虚代理，根据需要创建开销很大的对象
略解：想找我们老大？先过我这关
3)保护代理，控制对原始对象的访问
略解：有所为，有所不为
4)智能引用，在访问对象的时候执行一些附加操作
略解：算算有多少人找过我们的老大
*/
//打架的家伙
interface Fighter
{
    function fight(Fighter $target);
}
//大老
class Boss implements Fighter
{
    function fight(Fighter $target)
    {
        if ($target instanceof Boss )
        {
            echo "大老对大老，打平\r\n";
        }else
        {
             echo '大老打赢'.get_class($target)."\r\n";
        }
    }
}
//小兵
class Soldier implements Fighter
{
    /** * @var Fighter */
    private $boss;
    private $callCount = 0;
    private static $counter = 0;
    private $id;
    function __construct(Fighter $boss)
    {
        $this->boss = $boss;
        $this->id = ++self::$counter ;
    }
    function fight(Fighter $target)
    {
        if ($target instanceof Soldier )
        {
            echo "小兵对小兵，打平\r\n";
        }else
        {
            echo '小兵不够'.get_class($target)."打，叫长官出面\r\n";
            $this->callCount++;//统计叫出大老的次数 
            $this->boss->fight($target);
        }
    }
    function __destruct()
    {
        echo '小兵',$this->id,'共叫出大老',$this->callCount,"次\r\n";
    }
}
$boss1=new Boss();
$boss2=new Boss();
$soldier=new Soldier($boss1);
$soldier->fight(new Soldier($boss2));
$soldier->fight($boss2);
?>