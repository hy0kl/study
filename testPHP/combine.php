<?php
include_once('config/config.inc.php');

$file_type = isset($_GET['type']) && $_GET['type'] ? $_GET['type'] : '';
$last_modified_time = isset($_GET['last_modified_time']) ? $_GET['last_modified_time'] : time();
$search_type = isset($_GET['search_type']) && $_GET['search_type'] ? $_GET['search_type'] : '';

/** fix version*/
$version = isset($_GET['version']) ? $_GET['version'] : 0;
if (! in_array($version, array(5, 6, 0)))
{
    $version = 5;
}
if ($version)
{
    $point = $search_type .'-v'. $version;
} else
{                                                                                                                                                     
    $point = $search_type;
}

$css_js_map = APP_PATH .'/cache/css_js_map.php';
$time_now = time();
$cache_css_js_map = array(
    'js_last_modified_time'  => $time_now,
    'css_last_modified_time' => $time_now, 
);
if (file_exists($css_js_map))
{
    include($css_js_map);
}

//echo $css_js_map;
//print_r($cache_css_js_map, '$cache_css_js_map');

if ($file_type && in_array($file_type, array('js', 'css')) && $search_type && in_array($search_type, array('single', 'round')))
{
    $header_type = 'html';
    switch ($file_type)
    {
        case 'js' :
            $header_type = 'javascript';
            $cache_time = $cache_css_js_map['js_last_modified_time']; 
            break;

        case 'css' :
            $header_type = 'css';
            $cache_time = $cache_css_js_map['css_last_modified_time'];
            break;
    }
    
    $etag = md5($last_modified_time); 
    header('Last-Modified: '. gmdate('D, d M Y H:i:s', $last_modified_time) .' GMT');
    header("Etag: $etag");
    //if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time /*|| @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag*/)
    if ($last_modified_time == $cache_time && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time)
    {
        header("HTTP/1.1 304 Not Modified");
        exit;
    } else
    {
        header('Content-Type: text/' . $header_type . '; charset=UTF-8');
        header('HTTP/1.1 200 OK');
        echo combine($file_type, $point);
    }
} else
{
    echo '';
}

/**
  combine css and js
 */
function combine($file_type = '', $search_type = '')
{
    global $cache;
    global $root_path;

    $combine_map = array();
    $base_path = '';

    if (! $file_type || ! $search_type)
    {
        return '';
    }

    switch ($file_type)
    {
        case 'css' :
            global $css_combine_map;
            $combine_map = $css_combine_map[$search_type];
            $base_path = $root_path .'/css/';
            break;

        case 'js' :
            global $js_combine_map;
            $combine_map = $js_combine_map[$search_type];
            $base_path = $root_path .'/js/';
            break;

        default ;
            return '';
    }

    $combine_file = '';
    if ($cache)
    {
        if (count($combine_map))
        {
            foreach ($combine_map as $map)
            {
                $combine_file .= file_get_contents($base_path . $map);
            }
        }
    }

    return $combine_file;
}
?>
