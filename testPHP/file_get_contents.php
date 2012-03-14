<?php
/**
 * curl functions
 */
if (!function_exists('curl_init'))
{
    echo 'curl_init () has NOT exists';
    exit();
}

include_once('functions.php');

$url = 'http://php.weather.sina.com.cn/search.php?city=%B1%B1%BE%A9&dpc=1';
/*$html = file_get_contents($url);
print_r($html);*/

$html = get_html($url);
//echo $html;
if ($html)
{
    $html =  absolute_trim($html);
    //echo '+++'. $html;

    $pattern = '/<div class="box-s1-l">.*?<\/div>.*?<\/div>.*?<\/div>/i';
    preg_match_all($pattern, $html, $divs);
    //debug($divs);
    if (is_array($divs))
    {
        /*echo '<style type="text/css">
.WeatherB1{ 
    background:#FFFFFF none repeat scroll 0 0;
    border:1px solid #D1E4FF;
    height:60px;
    margin:3px auto;
    overflow:hidden;
    width:573px;
}
        </style>';
        */
        foreach ($divs[0] as $div)
        {
            echo $div .'<br />';
        }
    }
}
/**
 * 为 file_get_contents() 设置超时时间,否则它会用完默认的超时时间.
$opts = array(
    'http'=>array(
        'method' => "GET",
        'timeout'=> 1,
    )
);

$context = stream_context_create($opts);
$html = file_get_contents('http://www.example.com', false, $context);
*/
?>