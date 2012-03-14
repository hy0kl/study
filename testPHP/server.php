<?php
foreach ($_SERVER as $key => $value)
{
    if (is_array($value))
    {
        foreach ($value as $key2 => $value2)
        {
            echo $key2.' => '.$value2.'<BR>';
        }
    }else
    {
        echo $key.' => '.$value.'<BR>';
    }
}
?>