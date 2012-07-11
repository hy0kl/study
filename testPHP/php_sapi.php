<?php
$sapi_type = php_sapi_name();
//echo $sapi_type . "\n";
if ('cli' == $sapi_type)
{
    define('LCRT', "\n");
}
else
{
    define('LCRT', '<br />');
}

echo 'Your sapi_type: ' . $sapi_type . LCRT;
?>
