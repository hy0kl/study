<?php
$array = array(
        'test' => 'this is a test string.',
        'another' => array(
            'echo' => 'This function is test for extract function.',
            2 => 'Hello.',
        ),
    );

extract($array);
print_r($another);
?>