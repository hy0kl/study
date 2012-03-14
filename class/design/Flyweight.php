<?php
/*
略解：减少大量重复对象的创建及存储开销
*/
class FlyWeight
{
    /** * 对象池，放在自己静态属性里 */
    private static $pool = array(); 
    private $word; 
    /** * 防止外部创建 */
    private function __construct($word)
    { 
        $this->word = "<b>$word</b>";
    }
    /** * 统一获取方法 * * @param string $word * @return FlyWeight*/
    static function getFlyWeight($word)
    {
        if (!isset(self::$pool[$word]))
        {
            self::$pool[$word] = new FlyWeight($word);
        }
        return self::$pool[$word];
    }
    /** * @return int 计算总共创建了多少个对象 */
    static function count()
    {
        return count(self::$pool);
    }
    function display()
    {
        echo $this->word;
    }
}
$a = FlyWeight::getFlyWeight('a');
$b = FlyWeight::getFlyWeight('b');
$c = FlyWeight::getFlyWeight('Firefox');
$d = FlyWeight::getFlyWeight('a');
$a->display();
$b->display();
$c->display();
$d->display();
echo '<br />',FlyWeight::count(),'<br />';
?>