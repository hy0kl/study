<?php
include('./config.php');

$api = 'http://www.cnproxy.com/proxy%d.html';

for ($ci = 1; $ci <= 10; $ci++)
{
    $proxy_cn_api = sprintf($api, $ci);
    $html = get_html($proxy_cn_api);
    $html = mb_convert_encoding($html, CHARSET, 'GBK');
    $html = mb_strtolower($html, CHARSET);

    $start = 'id="proxylisttb"';
    $s_pos = strpos($html, $start);

    $end   = 'class="foot"';
    $e_pos = strpos($html, $end);

    /*
    var_dump($s_pos);
    var_dump($e_pos);
    exit;
    //echo $html; exit;
    */

    if (! ($s_pos > 0 && $e_pos > 0))
    {
        continue; 
    }

    $find_str = substr($html, $s_pos, $e_pos - $s_pos);

    $pattern = '/<tr><td>.*?tr>/';
    preg_match_all($pattern, $find_str, $matches);
    //print_r($matches);

    foreach ($matches[0] as $k => $table_str)
    {   
        $record = array();
        $script = '<script'; 
        $s_pos  = strpos($table_str, $script);
        $ip     = strip_tags(substr($table_str, 0, $s_pos));
        $record['ip'] = $ip;

        $exp_data = explode('+', $table_str);
        $exp_count= count($exp_data);
        $port_value = array();
        for ($i = 1; $i < $exp_count; $i++)
        {   
            $key = $exp_data[$i][0];
            $port_value[] = $port_map[$key];
        }   
            
        $port = implode('', $port_value) + 0;
        $record['port'] = $port;

        $log = "{$record['ip']}\t{$record['port']}\t\n";
        file_put_contents($config['proxy'], $log, FILE_APPEND);
        //print_r($record);
    }
    //echo $find_str;
    //exit;
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
        echo 'Curl error: ' . curl_error($ch) . "\n";
    }
    
    curl_close($ch);

    return $html;
}
