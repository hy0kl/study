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
用 md5_file 替代最后修改时间更为靠谱
 * */

$self = './filemtime.php';

echo filemtime($self) . PHP_EOL;

$start = microtime(true);
echo md5_file($self) . PHP_EOL;
$end = microtime(true);
echo 'md5_file() exec time: ' . ($end - $start) .  PHP_EOL;

/* vi:set ts=4 sw=4 et fdm=marker: */

