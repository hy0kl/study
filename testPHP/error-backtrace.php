<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
function exception_handler($exception){
    //error_log("Uncaught exception: ". $exception->getMessage());
    print_r(debug_backtrace());
}
set_exception_handler('exception_handler');

throw new exception('Just 4 debug_backtrace()');
/* vim:set ts=4 sw=4 et fdm=marker: */

