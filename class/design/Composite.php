<?php
/*
你想表示对象的部分整体层次结构
你希望用户忽略组会对象与单个对象的不同，用户将统一地使用组合结构中的所有对象
略解：树状结构，树叶和树枝同属于结点，每个结点都有管理其下属结点的功能．
（通常用来进行无限分级菜单的递归设计）
*/
//结点
interface Node
{
    /** * 结点重量 ** @return int */
    function getWeight();
}
//树枝
class Branch implements Node
{
    //子结点
    private $children = array();
    private $weight;
    
    function __construct()
    {
        $this->weight=rand(100,500);
    }
    /** * 统计自己和子结点的总重量 * * @return int */
    function getWeight()
    {
        $childrenWeight=0;
        /*@var $node Node*/
        foreach ($this->children as $node)
        {
            $childrenWeight += $node->getWeight();
        }
        return $this->weight + $childrenWeight;
    }
    /** * 增加结点 * * @param Node $node */
    function addNode(Node $node)
    {
        $this->children[]=$node;
    }
}
//叶子
class Leaf implements Node
{
    function getWeight()
    {
        return rand(1,9);
    }
}
//开始造树了
//通常这个树的过程采用builder模式进行的,如xml dom树的解析过程
$mainBranch=new Branch();
$subBranch=new Branch();
$mainBranch->addNode($subBranch);
$subBranch->addNode(new Branch());
$subBranch->addNode(new Leaf());
$mainBranch->addNode(new Leaf());
$mainBranch->addNode(new Branch());
echo '树的重量为:',$mainBranch->getWeight();
?>