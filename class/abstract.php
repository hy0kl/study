<?php
abstract class User
{
    protected $sal = 0;

    abstract function getSal();
    abstract function setSal($sal);

    public function __toString()
    {
        return get_class($this);
    }
}

class NormalUser extends User
{
    function getSal(){;}
    function setSal($sal){;}
}

abstract class VipUser extends User
{
    abstract function Vip($name);
    //abstract function getSal();
}
?>