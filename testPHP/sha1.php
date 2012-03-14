<?php
$str = 'password';
$str = sha1($str);

echo 'Password len is :'. strlen($str);
echo '<br />';

echo 'd0be2dc421be4fcd0172e5afceea3970e2f3d940' . ' | This string\'s long is: '. strlen('d0be2dc421be4fcd0172e5afceea3970e2f3d940');
echo '<br />';

$pass = 'password';
$pass = md5($pass);
echo $pass .' | the long of pass is :'. strlen($pass);
?>