<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
$serv = new swoole_server("127.0.0.1", 9501);
$serv->set(array(
    'worker_num' => 2,   //工作进程数量
    'daemonize' => true, //是否作为守护进程
));
$serv->on('connect', function ($serv, $fd){
    echo "Client:Connect.\n";
});

$serv->on('start', function($serv, $fd){
});

$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, 'Swoole: '.$data);
    $serv->close($fd);
});
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();
/* vi:set ts=4 sw=4 et fdm=marker: */

