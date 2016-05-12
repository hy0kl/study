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
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //设置为警告模式
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //设置异常模式

    $sql = 'SELECT * FROM log WHERE id = ? AND create_time > 0';

    //$res = $db->query($sql, PDO::FETCH_ASSOC);
    //$rows = $res->fetchAll();
    //print_r($rows);

    $stmt = $db->prepare($sql);   //准备查询语句
    $id = 2;
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
} catch (PDOException $e) {
    echo '[PDO Exception Caught]' . PHP_EOL;
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    echo 'Code:  ' . $e->getCode() . PHP_EOL;
    echo 'File:  ' . $e->getFile() . PHP_EOL;
    echo 'Line:  ' . $e->getLine() . PHP_EOL;
    echo 'Trace: ' . $e->getTraceAsString() . PHP_EOL;
}

/* vi:set ts=4 sw=4 et fdm=marker: */

