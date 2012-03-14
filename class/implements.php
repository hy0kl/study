<?php
/*
接口只包含抽象方法与静态常量;
*/
interface User
{
    const MaxGrade = 99;
    //static $mark = '';
    //public $mark = '';
    function getName();
    function setName($_name);
}

class NormalUser implements User
{
    function getName(){;}
    function setName($_name){;}
}

/*StudentAdmin 继承自 Student 类,并实现了 User 和 Administrator 接口*/
class Student
{
    protected $grade = 0;
    protected $name  = '';
    public function getGrade()
    {
        return $this -> grade;
    }
}

interface Administrator
{
    function setMsg($_msg);
}

class StudentAdmin extends Student implements User,Administrator
{
    function getName(){return $this -> name;}
    function setName($_name){$this -> name = $_name;}
    function setMsg($msg){;}
}

$s = new StudentAdmin();
$s -> setName('Jerry & Tom');
echo $s -> getName();
?>
<BR>23