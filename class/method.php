<?php
/*
    多态,类型提示符
*/
class User
{
    public function getName(){}
}
//继承类
class NormalUser extends User
{
    private $name = '';

    public function getName()
    {
        return $this -> name;
    }
    public function setName($_name)
    {
        $this -> name = $_name;
    }
}

class UserAdmin
{//操作
    public static function ChangUserName(/*User*/NormalUser $_user, $_userName)
    {
        $_user -> setName($_userName);
    }
}

$normalUser = new NormalUser();
UserAdmin :: ChangUserName($normalUser, 'Jerry');
echo $normalUser -> getName();
?>