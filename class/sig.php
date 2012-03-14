<?php
class Sig
{
    static private $sig = NULL;
    private function __construct(){}
    static function getClassSig()
    {
        if(NULL == self :: $sig)
        {
            self :: $sig = new Sig();
        }
        return self :: $sig;
    }
}

$sig1 = Sig :: getClassSig();
$sig2 = Sig :: getClassSig();
echo '$sig1 的类是:'.get_class($sig1).'<BR>$sig2 的类是: '.get_class($sig2).'<br>';
if($sig1 === $sig2)
{
    echo '$sig1 $sig2 是同一类.';
}else
{
    echo '$sig1 $sig2 不 是同一类.';
}
?>