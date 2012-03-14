<?php
/**
    We can also define function just like this. ^_*
*/
if(!function_exists("ob_get_clean")) {
    function ob_get_clean() {
        $ob_contents = ob_get_contents();
        ob_end_clean();
        return $ob_contents;
    }
}

function &test_function()
{
    echo 'Hello, I can execute.';
}

test_function();
?>