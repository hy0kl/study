<?php
$list = array();
for ($i = 0; $i < 10; $i++)
{
    $list = array('next' => $list, 'value' => 'Current value is: ' . $i);
}

$l = $list;
while (count($l))
{
    echo "list value: {$l['value']}\n";
    $l = $l['next'];
}
