<?php
/*
    instanceof 运算符
*/
class User
{
    private $name;
    public function getName()
    {
        return 'UserName is '.$this -> name;
    }
}

class NormalUser extends User
{
    private $age = 20;
    public function getAge()
    {
        return 'age is '.$this -> age;
    }
}

class UserAdmin
{//操作
    public static function getUserInfo(User $_user)
    {
        if($_user instanceof NormalUser)
        {
            echo $_user -> getAge();
        }else
        {
            echo '类型不对,不能使用这个方法.:(';
        }
    }
}

//$user = new User();
$user = new NormalUser();
UserAdmin :: getUserInfo($user);
?>