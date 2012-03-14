<?php
print_r($_DCACHE);
print_r($_GET);
echo '<BR>';
echo '$_GET[\'id\'] = '.$_GET['id'].'<BR>';
echo dirname(__FILE__).'<BR>';
echo substr(dirname(__FILE__), 0, -7).'<BR>';
$mtime = explode(' ', microtime());
$discuz_starttime = $mtime[1] + $mtime[0];
print_r($mtime);
echo '<BR>'.microtime().'<BR>';
$str = 'Hello world!';
if (is_array($str))
{
    echo '$str'.$str.' is a array.';
}else
{
    echo '$str ="'.$str.'" is NOT a array.';
}

echo '<BR>----------------------------------------------<BR>';
if (($test = empty($_COOKIE['my'])) && $test)
{
    echo '$test = '.$test;
}else
{
    echo 'I don\'t know! $test = '.$test;
}
echo '<BR>';
echo '<a href="test.php?action=modify&apm=arrays;id=8;type=0">来看看</a><BR>';

echo 'PHP_SELF = '.($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);

$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
echo '<BR>substr($PHP_SELF, 0, strrpos($PHP_SELF, \'/\')) = '.substr($PHP_SELF, 0, strrpos($PHP_SELF, '/')).'<BR>';

echo 'http://'.$_SERVER['HTTP_HOST'].preg_replace("/\/+(api|archiver|wap)?\/*$/i", '', substr($PHP_SELF, 0, strrpos($PHP_SELF, '/'))).'/';
echo '<BR>';

$myArray = array('number' => 1,
                 'string' => 'I am is a string.',
                 'others' => array('color' => 'red',
                                   'life'  => 'Hello world!'
                                    )
                );
extract($myArray);
echo '$number = '.$number.' $string = '.$string.' $others = '.$others.'<BR>';

echo 'PHP 环境是: '.PHP_OS.'<BR>';

echo 'mt_rand(5,15) = '.mt_rand(5,15).'<BR>';

echo 'random(6,1) = '.random(6,1).'<BR>';

echo 'time() = '.time().' ; substr(time(), 0, -7) ='.substr(time(), 0, -7).'<BR>';
echo 'Please upload all files to install Discuz! Board<br>&#x5b89;&#x88c5; Discuz! &#x8bba;&#x575b;&#x60a8;&#x5fc5;&#x987b;&#x4e0a;&#x4f20;&#x6240;&#x6709;&#x6587;&#x4ef6;&#xff0c;&#x5426;&#x5219;&#x65e0;&#x6cd5;&#x7ee7;&#x7eed;<BR>';
echo 'display_errors = ' . ini_get('display_errors') . "<br />";

if(@ini_get(file_uploads))
{
    $max_size = @ini_get(upload_max_filesize);
    echo '最大上传: '.$max_size;
} else {
    echo '不允许上传!';
}
echo '<BR>';
$s  = 'cd';
$$s = "dog is ($s).";
$$s = 'hello ($s)';
echo $cd;
?>
<BR>variable:变量

<?php
function random($length, $numeric = 0) {
	/*php 版本小于 4.2.0 时,mt_rand() 函数需要事先播随机种子 mt_srand()*/
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric)
    {
		/*格式化字串,共有 $length 位,少于则有 0 补*/
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        //number pow ( number base, number exp );
        //返回 base 的 exp 次方的幂;
	} else
    {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++)
        {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}
?>