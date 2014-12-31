<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
/**
http://wlog.cn/performance/assets-version.html

function AutoVersion( $file ) {
    if( file_exists($_SERVER['DOCUMENT_ROOT'].$file) ) {
        $ver = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
    } else {
        $ver = 1;
    }

    return $file .'v=' .$ver;
}

<link rel="stylesheet" href="<?=AutoVersion('assets/css/style.css')?>" type="text/css" />

通过测试发现,这种方法在水平多台机器部署时,文件最后修改时间可能各个服务器不一致
 * */

$self = './filemtime.php';

echo filemtime($self) . PHP_EOL;

/* vi:set ts=4 sw=4 et fdm=marker: */

