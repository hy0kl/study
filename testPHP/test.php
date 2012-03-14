<?php
header('Content-type: text/html; charset=GBK');
date_default_timezone_set('Asia/Chongqing');
echo 'Welcome!';
echo 'This directory is used to create and test some thing about PHP.';
//6173ab649b55bf750015d71560ac55f5
//7b7f7d3f62d0b912a3c2ace33d9149d9
echo '<br />';
$time = strtotime('1970-01-01 00:04:17');
echo $time . '<br />';
$str = date('Y-m-d H:i:s', $time);
echo $str;

$test = array(
    'os' => array(
        'Linux',
        'unix',
        'iOS',
        'Android',
        '这里有中文,要注意哦.',
        '此文件本身的编码是 UTF-8, Header 被指定为 GBK...',
        '但是 JS 在处理中文件时有统一编码的逻辑...',
        '换言之,对于 JS 来说,UTF-8 中文与 GBK 中文没有区别',
    ),
);
?>
<div id="debug"></div>
<script type="text/javascript">
<!--
    var json=<?php echo json_encode($test); ?>;
    var str = '';
    var iterm;
    for (iterm in json.os)
    {
        str += json.os[iterm] + "\n";
    }
    alert(str);
//-->
</script>