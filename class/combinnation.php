<?php
/*
    通过组合模拟多重继承
*/
class User
{
    protected $name = 'Jerry';
    public function getName()
    {
        return $this -> name;
    }
}

class Teacher
{
    private $lengthOfService = 5;   //工龄
    public function getLengthOfService()
    {
        return $this -> lengthOfService;
    }
}

//多态,既是学生,也算工龄;
class GraduateStudent extends User
{
    private $teacher;
    public function __construct()
    {
        $this -> teacher = new Teacher();
    }
    public function getLengthOfService()
    {
        return $this -> teacher -> getLengthOfService();
    }
}

$graduateStudent = new GraduateStudent();
echo $graduateStudent -> getName().'<BR>';
echo 'lengthOfService is '.$graduateStudent -> getLengthOfService();
?>