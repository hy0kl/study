<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
register_shutdown_function(function() {
    if ($e = error_get_last()) {
        var_dump($e);
    }
});

test();
/* vim:set ts=4 sw=4 et fdm=marker: */

