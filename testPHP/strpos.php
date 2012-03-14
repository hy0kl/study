<?php
/**
    one tip to use this function to escape return first char is truned 0!;
*/
$str = 'abc-def-This is my abc song.';
$needle = 'a';

$position = strpos(' ' . $str, $needle);

echo $position;

echo '<hr>';

/** next lines come from phpManual*/
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}
?>