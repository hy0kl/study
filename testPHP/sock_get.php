<?php
include_once('./functions.php');

/**
 * functionality:
 *
 * @access public
 * @param string
 * @return string
 */
function socket_get($url, $time_out = 1)
{
    $visit_url = $url;
    $url = parse_url($url);
	if (! $url)
    {
        return 'couldn\'t parse url';
	}
    if (!isset($url['port']))
    { 
        $url['port'] = '';
    }
	if (!isset($url['query']))
    { 
        $url['query'] = '';
    }

    $results  = '';

    $fp = @fsockopen($url['host'], $url['port'] ? $url['port'] : 80, $errno, $errstr, $time_out);
    if ($fp)
    {
        //echo 'Socket opening...';
        $out = "GET {$visit_url} HTTP/1.1\r\n";
        $out .= "Host: {$url['host']}\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fputs($fp, $out);

        $inheader = 1;
        while(! feof($fp))
        {
            $line = fgets($fp, 1024);
            if ($inheader && ($line == "\n" || $line == "\r\n"))
            {
                $inheader = 0;
            }
            elseif (! $inheader)
            {
                $results .= $line;
            }
        }

        fclose($fp);
    }

    return $results;
}

/**
    经多番手工测试发现, sock 方式取数据并没有明显的优于 file_get_contents 函数.
    同时, sock 会有取不到数据.不过这一现象初步判断是服务器作为防爬虫的配置.
*/

$url = 'http://127.0.0.1/test.php?para=testSock';
$s_start = get_msecond();
echo socket_get($url, $data);
$s_end = get_msecond();
echo '+++++++++++++++++++++++++++++++++++++++<br />';
echo '+Sock use time:'. ($s_end - $s_start);

echo '<br />+++++++++++++++++++++++++++++++++++++++<br />';

$f_start = get_msecond();
echo file_get_contents($url);
$f_end = get_msecond();
echo '+++++++++++++++++++++++++++++++++++++++<br />';
echo '+Get file contents use time:'. ($f_end - $f_start);

echo '<br />+++++++++++++++++++++++++++++++++++++++<br />';
?>
