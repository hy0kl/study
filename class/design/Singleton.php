<?php
/*
当类只能有一个实例而且客户可以从一个众所周知的访问点访问它时
略解：一山不需二虎
*/
if(!defined('CRLF')) define('CRLF',"");
//老虎来了
final class Tiger
{
    private static $self;
    private $name;
    /** * 私有构造函数，防止随便创建 * * @param string $name */
    private function __construct(){ }
    /** * 召唤超人的唯一方法 * * @return SuperMan */
    static function call()
    {
        if (!self::$self)
        {
            self::$self=new Tiger();
        }
        return self::$self;
    }
    /** * @return string */
    function getName()
    {
        return $this->name;
    }
    /** * @param string $name */
    function setName($name)
    {
        $this->name=$name;
    }
    /** * 关闭复制 */
    function __clone()
    {
        throw new Exception("老虎不能克隆");
    }
    /** * 关闭序列化 */
    function __sleep()
    {
        throw new Exception("老虎不能保存");
    }
    /** * 关闭反序列化 */
    function __wakeup()
    {
        throw new Exception("老虎不能恢复");
    }
}
$tigerA=Tiger::call();
$tigerA->setName('Super Man');
//unset($tigerA);
$tigerB=Tiger::call();
//echo $tigerA,' ',$tigerA->getName().CRLF;
echo get_class($tigerA),' ',$tigerA->getName().CRLF;
//echo $tigerB,' ',$tigerB->getName().CRLF.CRLF;
echo get_class($tigerB),' ',$tigerB->getName().CRLF.CRLF;
Tiger::call()->setName("Bat Man");
$tigerA=Tiger::call();
$tigerB=Tiger::call();
echo get_class($tigerA),' ',$tigerA->getName().CRLF;
echo get_class($tigerB),' ',$tigerB->getName();
?>