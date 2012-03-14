<?php
/*-----------------------------------------------------------
*功能：使用PHP socke 向指定页面提交数据
*
*作者：Honghe.c
*
*说明：sock_post($url, $data)
*
* $url = 'http://www.xxx.com:8080/login.php';
* $data[user] = 'hong';
* $data[pass] = 'xowldo';
* echo post($url, $data);
*-----------------------------------------------------------*/

function sock_post($url, $data) {

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

    //print_r($url);

	$encoded = '';

	foreach ($data as $k => $v) 
    {
		$encoded .= ($encoded ? '&' : '');
		$encoded .= rawurlencode($k) .'='. rawurlencode($v);
	}

    //echo '***'. $encoded .'$$$';

	$fp = fsockopen($url['host'], $url['port'] ? $url['port'] : 80);
	if (! $fp)
    {    
        return 'Failed to open socket to '. $url[host];
    }

	fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], $url['query'] ? '?' : '', $url['query']));
	fputs($fp, "Host: $url[host]\n");
	/** 这一行对 POST 给 PHP 脚本的数据来说至关重要,如果没有,不会角发 POST 数据解析*/
	fputs($fp, "Content-Type: application/x-www-form-urlencoded\n");
	fputs($fp, 'Content-Length: ' . strlen($encoded) . "\n");
    /**
        测试表明,将请求设为 close 会提高执行速度
    */
	fputs($fp, "Connection: close\n\n");
	//fputs($fp, "Connection: Keep-Alive\n\n");
    
	fputs($fp, "$encoded\n");

	$line = fgets($fp, 1024);
	if (! eregi('^HTTP/1\.. 200', $line))
    {    
        return;
    }

	$results  = '';
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

	return $results;
}

$url = 'http://127.0.0.1/test.php?para=testSock';
$data['user'] = 'hong';
$data['pass'] = 'xowldo';
echo sock_post($url, $data);
?>
