<?php
$test = array(
    128 => 'I am 128',
    11 => 'I am 11',
);
ksort($test);
echo array_pop($test);
//exit();

$array_one = array(
        'array_one',
        'option' => 'test',
        'sub_array' => array(
                'perl', 'php', 'C/C++',
        ),
        'os' => 'test',
    );

$array_tow = array(
    2 => 'array_two',
    'os' => array(
        'FreeBSD', 'OpenBSD', 'Linux/GNU', 'Windows', 'Other',
    ),
    'browser' => array(
        'Firefox', 'IE', 'Opera', 'Lynx', 'Other',
    ),
);

$merge = $array_one + $array_tow;

print_r($merge);
exit();

echo '<br />';

$object_for_test_array_function = array(
    'people' => 'All human.',
    'person' => 'one person.',
    'man' => 'boy or man?',
    'woman' => 'girl or woman',
    'name' => 'every thing is object!!!',
    'access' => 'equal mean permission.',
);

echo '<pre>'. print_r($object, true) .'</pre>';
echo '<br />';

$flag = 0;
foreach ($object_for_test_array_function as $key => $value)
{
    echo '@@@'. current($object_for_test_array_function);
    foreach ($array_tow as $t_key => $t_value)
    {

    }
    
    echo $key .' = '. $value .'<br />';
    //print_r(next($object));
    echo $key == 'name' ? '***current = '. current($object_for_test_array_function) .'<br />' : 'NO.!!!<br />';;
    if (!$flag)
    {
        //echo '+++++'. $object[count($object) - 1]. '+++++<br />';
        $flag = 1;
    }
}

//echo array_pop($object);

echo '<br />------------------------------------------------------------------<br />';
$arryBuddy = array();
$airline   = array('BeiJing', 'ShangHai');
//array_push($arryBuddy, $airline);
$arryBuddy[] = $airline;
print_r($arryBuddy);

echo '<br />------Test array_rand()------<br />';
$test = array(                                                                                                                                               
    'system' => 'MacBook',
    'fav'    => 'FreeBSD',
    'program'=> 'PHP',
    'js'     => 'jQuery',
);

print_r($test);
print_r(array_rand($test));

$rand = array('a', 'b', 1, 2, 3);
//print_r(array_pop(shuffle(array('a', 'b', 1, 2, 3))));
//print_r(array_pop(shuffle($rand)));
?>
