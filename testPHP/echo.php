<?php
$value = '';

if ( $value === 08 )
      echo '2008年';
else
      echo 'tell me the year!';

printf("<br /> 08 = %f", 08);

echo '<br />';
echo "echo('hello, I am here.') && {echo 'I can not execute...'}";
echo '<br />';
echo sprintf('%0.2f', 12369.0321569);
echo '<br />';
echo count('abcdefg');

function test_temp_var()
{
    //$temp;
    echo '$temp = '. $temp;
}

test_temp_var();

echo '<br />print_r(NULL) = ';
print_r(NULL);
echo 'var_dump(NULL) = ';
var_dump(NULL);

//var obj = {};
echo 'time() ='. time();
?>