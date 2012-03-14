<?php
$password = 'password';
echo $password .'<br />';
$password = crypt($password);
echo 'crypt($password) = '. $password .'<br />';
echo 'strlen($password) = '. strlen($password);
?>