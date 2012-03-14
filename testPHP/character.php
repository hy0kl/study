<?php
define('IN_BLOG',true);
header('Content-Type: text/html; charset=UTF-8');
require_once('include/function.php');
require_once('./lang.php');
$link = dbConnect($config);
/*
$config = array('dbHost'=>'localhost',
                    'dbUser'=>'test',
                    'dbPassword'=>'test',
                    'dbName'=>'tem');
$link = mysql_connect($config['dbHost'],$config['dbUser'],$config['dbPassword']) or die("Could not connect: " . mysql_error());
mysql_select_db($config['dbName']) or die('Could not select:'.$config['dbName']).mysql_error();
mysql_query("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
*/
if($_POST['text'] != '')
{
    $query = "INSERT INTO test(id,small,text) VALUES(NULL,2,'".$_POST['text']."')";
    $result= mysql_query($query);
    echo (mysql_affected_rows()) ? 'INSERT OK!' : 'I am sorry.';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>utf-8</title>
</head>
<body>
<FORM METHOD="POST" ACTION="">
<TEXTAREA NAME="text" ROWS="15" COLS="50"></TEXTAREA><BR>
<INPUT TYPE="submit" value="submit">
</FORM>
<?php
echo '<font color="#0000EE">'.date('Y'.$lang['year'].'m'.$lang['month'].'d'.$lang['day'],time());
$query = "SELECT * FROM test ORDER BY id DESC";
$result= mysql_query($query);
while($rows = mysql_fetch_array($result,MYSQL_ASSOC))
{
    echo $rows['id'].' | '.nl2br($rows['text']).'&nbsp;&nbsp;<a href="?action=delete&id='.$rows['id'].'">['.$lang['delete'].']</a><br>';
}
echo '$lang[\'info\'] = '.$lang['info'];
?>
<body>
</html>