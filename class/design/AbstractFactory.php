<?php
/*
一个系统要由多个产品系列中的一个来配置时
略解：果园分热带，温带．水果也有很多种．热带果园负责生产热带的……
当你强调一系列相关的产品对象的设计以便进行联合使用时
略解：Linux的图形界面和Windows的图形界面相似而无法混用，使用一个抽象的界面工厂(不同系统不同实现)，来生产不同的元素以便组合使用
当你提供一个产品类库，而只想显示它们的接口而不是实现时
略解：黑猫白猫能抓老鼠就是好猫，黑狗白狗能看门的就是好狗
*/
if(!defined('CRLF')) define('CRLF',"");
//猫
class Cat
{
    function catchMice()
    {
        echo "猫抓老鼠".CRLF;
    }
}
//狗
class Dog
{
    function watch()
    {
        echo "狗看门".CRLF;
    }
}
//宠物店
abstract class PetShop
{
    /** * @return Cat*/
    abstract function newCat();
    /** * @return Dog */
    abstract function newDog();
}
//白猫
class WhiteCat extends Cat
{
    function catchMice()
    {
        echo "白猫抓老鼠".CRLF;
    }
}
//黑猫
class BlackCat extends Cat
{
    function catchMice()
    {
        echo "黑猫抓老鼠".CRLF;
    }
}
//白狗
class WhiteDog extends Dog
{
    function watch()
    {
        echo "白狗看门".CRLF;
    }
}
//黑狗
class BlackDog extends Dog
{
    function watch()
    {
        echo "黑狗看门".CRLF;
    }
}
//白宠物店
class WhitePetShop extends PetShop
{
    function newCat()
    {
        return new WhiteCat();
    }
    function newDog()
    {
        return new WhiteDog();
    }
}
//黑宠物店
class BlackPetShop extends PetShop
{ 
    function newCat()
    {
        return new BlackCat();
    }
    function newDog()
    {
        return new BlackDog();
    }
}
//主人
class Housemaster
{
    static function usePet(PetShop $shop)
    {
        $shop->newCat()->catchMice();
        $shop->newDog()->watch();
    }
}
Housemaster::usePet(new BlackPetShop());
?>