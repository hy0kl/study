<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */

/* vi:set ts=4 sw=4 et fdm=marker: */
$db_name = './statistics.db';
$db = new SQLite3($db_name);

if (! $db)
{
    echo "Can NOT connect db: $db_name\n";
    exit();
}

$results = $db->query('SELECT * FROM statistics');
$data = array();
while ($row = $results->fetchArray(SQLITE3_ASSOC))
{
    $data[] = $row;
}
print_r($data);
