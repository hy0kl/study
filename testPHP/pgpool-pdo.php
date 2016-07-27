<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
CREATE TABLE study (
    id SERIAL NOT NULL,
    lang character varying(32) DEFAULT ''::character varying NOT NULL,
    start_time timestamp without time zone DEFAULT now() NOT NULL
);
 * */
$dsn  = 'pgsql:dbname=dev;host=192.168.11.173;port=9999';
$user = 'work';
$password = 'work';

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //设置异常模式
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage() . PHP_EOL;
    exit;
}

function print_all($dbh) {
    $sql = 'SELECT * FROM study WHERE 1 = 1';

    $res  = $dbh->query($sql, PDO::FETCH_ASSOC);
    $rows = $res->fetchAll();
    echo '-----', PHP_EOL;
    print_r($rows);
    echo '#####', PHP_EOL;
}

print_all($dbh);

$stmt = $dbh->prepare('INSERT INTO study (lang) VALUES(?)');

//$stmt->execute( array('lua'));

try {
    $dbh->beginTransaction();
    $stmt->execute( array('Go'));
    echo 'lastInsertId: ' . var_dump($dbh->lastInsertId('study_id_seq')) . PHP_EOL;
    $dbh->commit();
} catch(PDOExecption $e) {
    $dbh->rollback();
    echo "Error!: " . $e->getMessage() . PHP_EOL;
}

print_all($dbh);
/* vim:set ts=4 sw=4 et fdm=marker: */

