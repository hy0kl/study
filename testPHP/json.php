<?php
$applications = array(
    'os' => array(
        'FreeBSD',
        'OpenBSD',
        'Linux/GNU',
        'Windows',
        'Other',
    ),
    'browser' => array(
        'Firefox',
        'IE',
        'Opera',
        'Lynx',
        'Safai',
        'Other',
    ),
);

$json = json_encode($applications);
print_r($json);

$json_arr = json_decode($json, true);
print_r($json_arr);

$json_obj = json_decode($json, false);
print_r($json_obj);

echo '<br />-----------------------------------------------------------------<br />';
echo urlencode('CZ6762|2009-09-07');
?>