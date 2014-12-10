<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
$dsn = 'mysql:dbname=test;host=127.0.0.1';
$user= 'test';
$password = 'test';

try {
    $db = new PDO($dsn, $user, $password);

    $sql = 'SELECT * FROM log';
    $res = $db->query($sql, PDO::FETCH_ASSOC);

    $rows = $res->fetchAll();
    print_r($rows);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage() . PHP_EOL;
}

/* vi:set ts=4 sw=4 et fdm=marker: */

