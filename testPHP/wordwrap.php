<?php
$text = 'The quick brown fox jumped over the lazy dog.';

echo $text ."</br>\n";

$newtext = wordwrap($text, 10, "<br />\n");

echo $newtext;

$chinese = '这是是一段中文,是用来测试一个 PHP 的函数的.用此函数来实现换行,主要用在对字符串长度有限制的地方.';

$wordwrap = wordwrap($chinese, 10, '<br />');
echo $wordwrap;
?> 