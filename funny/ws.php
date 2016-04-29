<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
$serv = new swoole_websocket_server("127.0.0.1", 8500);

$serv->on('Open', function($server, $req) {
    echo "new connection: ".$req->fd;
});

$serv->on('Message', function($server, $frame) {
    echo "new message: ".$frame->data;
    $server->push($frame->fd, json_encode(["hello", "world"]));
});

$serv->on('Close', function($server, $fd) {
    echo "connection ".$fd." is closed\n";
});

$serv->start();
/* vi:set ts=4 sw=4 et fdm=marker: */

