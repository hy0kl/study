<?php
if(!defined('CRLF')) define('CRLF','<BR>');

//电脑构件 
interface Part{
    function work();
    function price();
}

//构件厂商
interface PartFactory{
    /** * @return Part * */ 
    function build();
}

//配件商店
interface Builder{
    /** * @return Cpu */
    function buildCpu(); 
    
    /** * @return MainBoard */
    function buildMainBoard();
    
    /** * @return Ram */
    function buildRam();
    
    /** * @return VideoCard */
    function buildVideoCard();
    
    /** * @return Power */
    function buildPower();
}

class Computer {
    private $parts=array();
    
    function addPart(Part $part){ 
        $this->parts[]=$part;
    }
    
    function price(){ 
        $price=0; 
        /*@var $part Part*/
        foreach ($this->parts as $part) {
            $price+=$part->price();
        }
        return $price;
    }
    function run(){
        /*@var $part Part*/
        foreach ($this->parts as $part) {
            $part->work();
        }
    }
}

abstract class RandomPricePart implements Part {
    function price(){
        return rand(300,500);
    }
}

class Cpu extends RandomPricePart {
    function work(){
        echo 'cpu: '. get_class($this)." running".CRLF;
    }
}
class MainBoard extends RandomPricePart {
    function work(){
        echo 'main board: '.get_class($this)." running".CRLF;
    }
}
class Power extends RandomPricePart {
    function work(){echo 'power: '.get_class($this)." running".CRLF;
    }
}
class Ram extends RandomPricePart {
    function work(){echo 'ram: '.get_class($this)." running".CRLF;
    }
}
class VideoCard extends RandomPricePart {
    function work(){
        echo 'video cark: '.get_class($this)." running".CRLF;
    }
}

class AmdCpu extends Cpu {}
class AsusMainBoard extends MainBoard {}
class GreatWallPower extends Power {}
class KingMaxRam extends Ram {}
class AtiVideoCard extends VideoCard {}

class Amd implements PartFactory {
    function build(){
        return new AmdCpu();
    }
}
class Asus implements PartFactory {
    function build(){
        return new AsusMainBoard();
    }
}
class GreatWall implements PartFactory {
    function build(){
        return new GreatWallPower();
    }
}
class KingMax implements PartFactory {
    function build(){
        return new KingMaxRam();
    }
}
class Ati implements PartFactory {
    function build(){
        return new AtiVideoCard();
    }

}
/** * 负责生产各个零件 * */
class MixedBuilder implements Builder{
    /** * @var PartFactory */
    private $cpuFactory,$powerFactory,$mainBoardFactory,$videoCardFactory,$ramFactory;
    
    function __construct(){ 
        $this->cpuFactory=new Amd();
        $this->mainBoardFactory=new Asus();
        $this->powerFactory=new GreatWall();
        $this->ramFactory=new KingMax();
        $this->videoCardFactory=new Ati();
    }
    
    function buildCpu(){
        return $this->cpuFactory->build();
    }
    function buildPower(){
        return $this->powerFactory->build();
    }
    function buildMainBoard(){
        return $this->mainBoardFactory->build();
    }
    function buildVideoCard(){     
        return $this->videoCardFactory->build();
    }
    function buildRam(){
        return $this->ramFactory->build();
    }
}

/** * 负责组装各个零件 * */
class Director {
    /** * @var Builder */
    private $builder;
    
    function __construct(Builder $builder){
        $this->builder=$builder;
    }
    
    /** * @return Computer * */
    function buildComputer(){
        $computer=new Computer();
        $computer->addPart($this->builder->buildPower()); 
        $computer->addPart($this->builder->buildMainBoard());
        $computer->addPart($this->builder->buildCpu()); 
        $computer->addPart($this->builder->buildRam()); 
        $computer->addPart($this->builder->buildVideoCard());
        return $computer;
    }
}
//builder目的，使部件的生产与组装解耦 
//部件零售者，处理构置零件
$builder=new MixedBuilder();
//装机人，处理装配顺序
$director=new Director($builder);
$computer=$director->buildComputer();
echo $computer->price().CRLF;
$computer->run();
?>