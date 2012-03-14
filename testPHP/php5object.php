<?php
class testObj
{
    private $name = 'test';

    public function __construct()
    {
        echo 'I am execute...';
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function __destruct()
    {
        echo 'I am destroy...';
    }
}

/**
    当类 testObj 被实例化的时候, PHP 引擎会在内存中开辟一块空间,并在符号表中建立一个符号引用.此后可能会有多个符号链接指向这块内存,直到没有符号引用这块内存时, PHP 引擎将它消毁.
*/
$a = new testObj();

$b = $a;
/**
    php5 手册说从 5 开始,对象赋值是引用,但如果不显示的引用的话,当级 $b = null 时,对象并没有被销毁.
*/
//$b = &$a;

/** $a $b 指向的同一块内存.*/
echo '$a->getName() = '. $a->getName();
echo '<br />';
echo '$b->getName() = '. $b->getName();

/** 用 $b 来操作成员方法*/
$b->setName('I am Jerry.');

/** 输出结果表明它们的确指向的同一块内存.*/
echo '<br />';
echo '$a->getName() = '. $a->getName();
echo '<br />';
echo '$b->getName() = '. $b->getName();

/**
    删掉 $b
    总结说明: $a, $b 虽然指向的同一块内存,但是相当是将 $b 符号链接到 $a 所指向的内存空间, unset $b 时,只是将符号链接取消了,但不会影响到 $a 所指向真实的内存空间.如同 UNXI 系统中的符号链接.   
*/
//unset($b);
/**
    如果是显示的 $b = &$a; 赋值,下面的语句会销毁对象,否则不会.
*/
$b = null;
//$a = null;

echo '<br />';
echo '$a->getName() = '. $a->getName();
/** 
    下面这行出报 Fatal error, 因为符号链已经断开,找不到可用的成员方法了.
*/
//echo '$b->getName() = '. $b->getName();

//unset($a);
print_r($a);
?>
