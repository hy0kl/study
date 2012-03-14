<?php
interface User
{
    const PI = 3.141592;
    public function getName();
    public function setName($_name);
}

class NormalUser implements User
{
    function getName(){}
    function setName($_name){}
}
?>