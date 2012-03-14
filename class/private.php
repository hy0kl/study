<?php
/*
    子类继承了父关的 private 属性,但不能修改其值;
*/
class User
{
    //private $name = 'Jerry';
    protected $name = 'Jerry';
    public function getName()
    {
        return $this -> name;
    }
}

class NewUser extends User
{
    public function setName($_name)
    {
        $this -> name = $_name;
    }
}
$user = new NewUser();
$user -> setName('Tom');
echo 'I am '.$user -> getName().'.<BR>';
echo phpversion();
?>