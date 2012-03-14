<?php
/*
你不希望在抽象和它的实现部分之间有一个固定的绑定关系
略解：商品可以很多种销售方法，也有很多种生产方法，让生产和销售相分离
*/
//产品
class Product
{
    private static $serial = 1;
    private $id;
    private $type;
    
    function __construct($type)
    {
        $this->id = self::$serial++;
        $this->type = $type;
    }
    function getDesc()
    {
        return '类型:'.$this->type.' 序号:'.$this->id;
    }
}

//生产者接口,实现部分独立发展
interface Producer
{
    /** * 生产某类产品 * * @param string $type * @return Product */
    function produce($type);
}
//销售人员,抽象部分独立发展
interface Seller
{
    function sell();
    /** * 通过这个方法，在运行把生产部分桥接起来 * * @param Producer $producer */
    function setProducer(Producer $producer);
}
//偷懒用的抽象类
abstract class AbstractSeller implements Seller
{
    /** * 关连生产者 * * @var Producer */
    protected $producer;
    
    function setProducer(Producer $producer)
    {
        $this->producer=$producer;
    }
}

//生产者
class AmericanProducer implements Producer
{
    function produce($type)
    {
        $product=new Product('美国的'.$type);
        echo '生产',$product->getDesc(),"\r\n";
        return $product;
    }
}
//生产者
class ChineseProducer implements Producer
{
    function produce($type)
    {
        $product=new Product('中国的'.$type);
        echo '生产',$product->getDesc(),"\r\n";
        return $product;
    }
}
//零售人员
class RetailSeller extends AbstractSeller
{
    function sell()
    {
        $this->producer->produce('洗发水');
        echo "卖出洗发水\r\n";
    }
}
//超级商场
class SuperMarket extends AbstractSeller
{
    function sell()
    {
        $this->producer->produce('洗发水');
        echo "卖出洗发水\r\n";
        $this->producer->produce('中药');
        echo "卖出中药\r\n";
    }
}
//构造服务,分离生产和销售
$seller=new SuperMarket();
$seller->setProducer(new ChineseProducer());
$seller->sell();
?>