<?php
/**
 * db connect
 */
function dbConnect($dbConfig)
{
    $link = mysql_connect($dbConfig['dbHost'] , $dbConfig['dbUser'] , $dbConfig['dbPass']) or die('Can not connect database.'.mysql_error());
    mysql_select_db($dbConfig['dbData'] , $link) or die('Can not select database : '.$dbConfig['dbData'].mysql_error());
    mysql_query('SET character_set_connection='. $dbConfig['dbCharset'] .', character_set_results='. $dbConfig['dbCharset'] .', character_set_client=binary');
    return $link;
}

$dbConfig = array('dbUser' => 'test' , 'dbPass' => 'test' ,
                  'dbHost' => 'localhost' , 'dbData' => 'test',
                  'dbCharset' => 'utf8', 
            );

$db = dbConnect($dbConfig);

/***
 * functionality:
 *
 * @access public
 * @param string
 * @return string
 */
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

/* test LIKE */
$start_time = microtime_float();
echo $sql = 'SELECT * FROM test WHERE name LIKLE "%Jerry%"';
for ($i = 0; $i < 1000; $i++)
{
    mysql_query($sql);
}
$end_time = microtime_float();
echo '<br />This SQL used time is : '. ($end_time - $start_time) .'<br />';

/* test = */
$start_time = microtime_float();
echo $sql = 'SELECT * FROM test WHERE name = "Jerry"';
for ($i = 0; $i < 1000; $i++)
{
    mysql_query($sql);
}
$end_time = microtime_float();
echo '<br />This SQL used time is : '. ($end_time - $start_time) .'<br />';

/* test = number*/
$start_time = microtime_float();
echo $sql = 'SELECT * FROM test WHERE id = 1"';
for ($i = 0; $i < 1000; $i++)
{
    mysql_query($sql);
}
$end_time = microtime_float();
echo '<br />This SQL used time is : '. ($end_time - $start_time) .'<br />';
?>