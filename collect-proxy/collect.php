<?php
define('CHARSET', 'UTF-8');
$config = array(
    'proxy' => 'data/proxy',
);

$port_map = array(
    'z' => '3',
    'm' => '4',
    'k' => '2',
    'l' => '9',
    'd' => '0',
    'b' => '5',
    'i' => '7',
    'w' => '6',
    'r' => '8',
    'c' => '1',
);

$api = 'http://www.cnproxy.com/proxy%d.html';

for ($i = 1; $i <= 10; $i++)
{
    $proxy_cn_api = sprintf($api, $i);
    $html = get_html($proxy_cn_api);
    $html = mb_convert_encoding($html, CHARSET, 'GBK');
    $html = mb_strtolower($html, CHARSET);
    echo $html;exit;
}

/** get basic html without post*/
function get_html($url)
{
    $html = '';
    $user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11';
    $referer = 'https://www.google.com.hk/search?hl=zh-CN&newwindow=1&safe=strict&tbo=d&site=webhp&source=hp&q=%E4%BB%A3%E7%90%86%E4%B8%AD%E5%9B%BD&btnK=Google+%E6%90%9C%E7%B4%A2';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

    $html = curl_exec($ch);

    if (curl_errno($ch))
    {
        $html = '';
    }
    else
    {
        echo 'Curl error: ' . curl_error($ch) . "\n";
    }
    curl_close($ch);

    return $html;
}
