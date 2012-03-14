<?php
/** get basic html without post*/
function get_html($url, $debug = 0)
{
    $html = '';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $html = curl_exec($ch);

    if (curl_errno($ch)) 
    {
        $html = '';
    }
    curl_close($ch);

    if ($debug)
    {
        print_r($html);
    }

    return $html;
}

/**
 * get html with post data
 */
function get_post_html($url, $post)
{
    $html = '';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    /**
    Note: Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data, while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded. 
    */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    if (curl_errno($ch)) 
    {
        $html = '';
    }
    curl_close($ch);

    return $html;
}

/**
 * get html with GET data
 */
function get_g_html($url, $get = '')
{
    $html = '';
    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    $html = curl_exec($ch);
    if (curl_errno($ch)) 
    {
        $html = '';
    }
    curl_close($ch);

    return $html;
}

/**
 * trim white space and \r \n \t
 */
function absolute_trim($html)
{
    if ($html)
    {
        $html = trim($html);
        // Now remove any doubled-up whitespace
        //去掉跟随别的挤在一块的空白
        $html = preg_replace('/\s(?=\s)/', '', $html);
        // Finally, replace any non-space whitespace, with a space
        //最后，去掉非space 的空白，用一个空格代替
        $html = preg_replace('/[\n\r\t]/', '', $html);
        
        return $html;
    }
    
    return '';
}

/**
 * debug function
 */
function debug($arry, $variable = '', $str = false, $exit = false)
{
    $html =  '<pre>'. ($variable ? $variable .' =  ' : '') . print_r($arry, true) .'</pre>';

    if ($str)
    {    
        return '<div class="php_debug">'. $html .'</div>';                                                                                            
    } else 
    {    
        echo $html;
    }    

    if ($exit)
    {    
        exit();
    }    
}

/**
    与 Smarty 的 $tpl->fetch($file) 效果一样
*/
function tpl_fetch($resource_name)
{
    global $tpl;
    ob_start();
    
    $file = TEMPLATE . $resource_name;

    @include($file);
    $result = ob_get_contents();

    ob_end_clean();

    return $result;
}

/**
    @ php 依据权重返回的两种算法
    @ two method for return result order by weight
    $cfg_weight = array(
        array('version' => 1, 'weight' => 6),
        array('version' => 2, 'weight' => 4),
    );
    
    @method 1:
    $find_version = 0;
    $cfg_total = count($cfg_weight);
    $rand = time() % $cfg_total;  // or get rand number between 0 to ($cfg_total - 1);
    $rand_weight = $cfg_weight[$rand]['weight'];
    $tmp_weight = 0;
    foreach ($cfg_weight as $key => $value_weight)
    {
        $tmp_weight += $value_weight['weight'];
        if ($rand_weight <= $tmp_weight)
        {
            $find_version = $tmp_weight['version'];
            break;
        }
    }
    
    @method 2:
    $tmp_version = array();
    foreach ($cfg_total as $key => $value_weight)
    {
        for ($i = 0; $i < (int)$value_weight['weight']; $i++)
        {
            $tmp_version[] = $value_weight['version'];
        }
    }
    shuffle($tmp_version);
    $find_version = array_shift($tmp_version);
    
    @note: 两种方法各有千秋,第一种方法初看比较晦涩,但在权重数比较细而多时会有具大的优势;第二种方法适合小规模的权重分配,思路清晰
*/

/** get client brower*/
//获取用户浏览器
/*
    $user_agent =  Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.9.1.6) Gecko/20091215 Ubuntu/9.10 (karmic) Firefox/3.5.6
    $user_agent =  Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/532.5 (KHTML, like Gecko) Chrome/4.0.249.43 Safari/532.5
    $user_agent = Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)
    $user_agent = Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6
    $user_agent =  Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2)
*/
function GetClinetBrowser()
{
    $Browser = 'Unknow';
    $Agent = $_SERVER['HTTP_USER_AGENT'];
    if(stristr($Agent,'MSIE 7') != FALSE)
    {
        $Browser = 'Internet Explorer 7';
    }
    elseif(stristr($Agent,'MSIE 6') != false)
    {
        $Browser = 'Internet Explorer 6';
    }
    elseif(stristr($Agent,'MSIE 5.5') != false)
    {
        $Browser = 'Internet Explorer 5.5';
    }
    elseif(stristr($Agent,'MSIE 5.0') != false)
    {
        $Browser = 'Internet Explorer 5';
    }
    elseif(stristr($Agent,'MSIE 4.0') != false)
    {
        $Browser = 'Internet Explorer 4';
    }
    elseif(stristr($Agent,'MSIE 3.0') != false)
    {
        $Browser = 'Internet Explorer 3';
    }
    elseif(stristr($Agent,'MSIE') != false)
    {
        $Browser = 'Internet Explorer';
    }
    elseif(stristr($Agent,'Firefox/2.0') != false)
    {
        $Browser = 'Mozilla FireFox 2.0';
    }
    elseif(stristr($Agent,'Firefox') != false)
    {
        $Browser = 'Mozilla FireFox';
    }
    elseif(stristr($Agent,'Netscape/8.1') != false)
    {
        $Browser = 'Netscape 8.1';
    }
    elseif(stristr($Agent,'Netscape/7.1') != false)
    {
        $Browser = 'Netscape 7.1';
    }
    elseif(stristr($Agent,'Netscape6/') != false)
    {
        $Browser = 'Netscape 6';
    }
    elseif(stristr($Agent,'Netscape') != false)
    {
        $Browser = 'Netscape';
    }
    elseif(stristr($Agent,'Mozilla/4') != false)
    {
        $Browser = 'Mozilla 4';
    }
    elseif(stristr($Agent, 'Safari') != false)
    {
        $Browser = 'Safari';
    }
    elseif(stristr($Agent,'Mozilla') != false)
    {
        $Browser = 'Mozilla';
    }
    elseif(stristr($Agent,'Firebird') != false)
    {
        $Browser = 'Firebird';
    }
    elseif(stristr($Agent,'Opera/9.1') != false)
    {
        $Browser = 'Opera 9.1';
    }
    elseif(stristr($Agent,'Opera/9.0') != false)
    {
        $Browser = 'Opera 9';
    }
    elseif(stristr($Agent,'Opera/8') != false)
    {
        $Browser = 'Opera 8';
    }
    elseif(stristr($Agent,'Opera') != false)
    {
        $Browser = 'Opera';
    }
    elseif((stristr($Agent,'googlebot') != false) or
(stristr($Agent,'slurp') != false) or (stristr($Agent,'baiduspider') != false)
or (stristr($Agent,'iaskspider') != false))
    {
        $Browser = 'Search Engines';
    }
    if($Browser == '')
    {
        $Browser = 'Unknow Brower';
    }
    return $Browser;
}

//debug(GetClinetBrowser(), 'Client Browser');

//获取客户端IP

function GetClinetIP()
{
    static $ClinetIP;
    if(isset($_SERVER))
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ClinetIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $ClinetIP = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            $ClinetIP = $_SERVER['REMOTE_ADDR'];
        }
    }
    else
    {
        if(getenv('HTTP_X_FORWARDED_FOR'))
        {
            $ClinetIP = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif(getenv('HTTP_CLIENT_IP'))
        {
            $ClinetIP = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $ClinetIP = getenv('REMOTE_ADDR');
        }
    }
    return $ClinetIP;
}

//echo GetClinetIP();

//获取用户操作系统

function GetClinetOS()
{
    $OS='未知操作系统';
    $Agent=$_SERVER['HTTP_USER_AGENT'];
    if(stristr($Agent,'win') != false and stristr($Agent,'95') != false)
    {
        $OS = 'Windows 95';
    }
    elseif(stristr($Agent,'win 9x') != false and
stristr($Agent,'4.90') != false)
    {
        $OS = 'Windows Me';
    }
    elseif(stristr($Agent,'win') != false and stristr($Agent,'98') != false)
    {
        $OS = 'Windows 98';
    }
    elseif(stristr($Agent,'win') != false and stristr($Agent,'nt
5.2') != false)
    {
        $OS = 'Windows 2003';
    }
    elseif(stristr($Agent,'win') != false and stristr($Agent,'nt
5.1') != false)
    {
        $OS = 'Windows XP';
    }
    elseif(stristr($Agent,'win') != false and stristr($Agent,'nt
5.0') != false)
    {
        $OS = 'Windows 2000';
    }
    elseif(stristr($Agent,'win') != false and stristr($Agent,'nt') != false)
    {
        $OS = 'Windows NT';
    }
    elseif(stristr($Agent,'win') != false and stristr($Agent,'32') != false)
    {
        $OS = 'Windows 32';
    }
    elseif(stristr($Agent,'win') != false)
    {
        $OS = 'Windows';
    }
    elseif(stristr($Agent,'linux') != false)
    {
        $OS = 'Linux';
    }
    elseif(stristr($Agent,'unix') != false)
    {
        $OS = 'UNIX';
    }
    elseif(stristr($Agent,'sun') != false and stristr($Agent,'os') != false)
    {
        $OS = 'SUN OS';
    }
    elseif(stristr($Agent,'ibm') != false and stristr($Agent,'os') != false)
    {
        $OS = 'IBM OS';
    }
    elseif(stristr($Agent,'Mac') != false and stristr($Agent,'PC') != false)
    {
        $OS = 'MAC OS';
    }
    elseif(stristr($Agent,'PowerPC') != false)
    {
        $OS = 'PowerPC';
    }
    elseif(stristr($Agent,'AIX') != false)
    {
        $OS = 'AIX';
    }
    elseif(stristr($Agent,'HPUX') != false)
    {
        $OS = 'HPUX';
    }
    elseif(stristr($Agent,'NetBSD') != false)
    {
        $OS = 'NetBSD';
    }
    elseif(stristr($Agent,'FreeBSD') != false)
    {
        $OS = 'FreeBSD';
    }
    elseif(stristr($Agent,'OSF1') != false)
    {
        $OS = 'OSF1';
    }
    elseif(stristr($Agent,'IRIX') != false)
    {
        $OS = 'IRIX';
    }
    elseif(stristr($Agent,'BSD') != false)
    {
        $OS = 'BSD';
    }
    elseif(stristr($Agent,'googlebot') != false)
    {
        $OS = '谷歌';
    }
    elseif(stristr($Agent,'slurp') != false)
    {
        $OS = '雅虎';
    }
    elseif(stristr($Agent,'baiduspider') != false)
    {
        $OS = '百度';
    }
    elseif(stristr($Agent,'iaskspider') != false)
    {
        $OS = '爱问';
    }
    if($OS == '')
    {
        $OS  = '未知操作系统';
    }
    return $OS;
}

/**
* image cache
*/

/**   BEGIN function
*
*    作者：偶然
*    功能：生成缩略图
*    时间：2003.12.14
*
*/
function makethumb($srcFile, $dstFile, $dstW, $dstH, $rate=75, $markwords=null, $markimage=null)
{
    $data = GetImageSize($srcFile);
    switch($data[2])
    {
        case 1:
            $im=@ImageCreateFromGIF($srcFile);
            break;

        case 2:
            $im=@ImageCreateFromJPEG($srcFile);
            break;

        case 3:
            $im=@ImageCreateFromPNG($srcFile);
            break;
    }
    if(!$im) return False;
    $srcW = ImageSX($im);
    $srcH = ImageSY($im);
    $dstX = 0;
    $dstY = 0;
    if ($srcW * $dstH > $srcH * $dstW)
    {
        $fdstH = round($srcH * $dstW / $srcW);
        $dstY  = floor(($dstH - $fdstH) / 2);
        $fdstW = $dstW;
    }
    else
    {
        $fdstW = round($srcW * $dstH / $srcH);
        $dstX  = floor(($dstW - $fdstW) / 2);
        $fdstH = $dstH;
    }
    $ni = imageCreateTrueColor($dstW, $dstH);
    $dstX = ($dstX < 0) ? 0 : $dstX;
    $dstY = ($dstX < 0) ? 0 : $dstY;
    $dstX = ($dstX > ($dstW / 2)) ? floor($dstW / 2) : $dstX;
    $dstY = ($dstY > ($dstH / 2)) ? floor($dstH / s) : $dstY;
    $white = imageColorAllocate($ni, 255, 255, 255);
    imagefilledrectangle($ni, 0, 0, $dstW, $dstH, $white);// 填充背景色
    imageCopyResized($ni, $im, $dstX, $dstY, 0, 0, $fdstW, $fdstH, $srcW, $srcH);

    // 生成水印
    if($markwords != null)
    {
        imagestring($ni, 2, 3, 3, $markwords, $white);
    }
    elseif($markimage != null)
    {
        $wimage = imagecreatefromgif($markimage);
        imagecopy($ni, $wimage, 0, 0, 0, 0, 100, 35);
        imagedestroy($wimage);
    }
    imageJpeg($ni, $dstFile, $rate);
    imagedestroy($im);
    imagedestroy($ni);
}

//echo GetClinetOS();

/**
	得到系统精确时间
*/
function microtime_float()
{
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}


/**
    functins come from DZ
*/
/*测试目录的可写性*/
function dir_writeable($dir)
{
    //目录不存在则创建之
    if(!is_dir($dir))
     {
         @mkdir($dir, 0777);
     }
    //创建一个文件,再删除它,以此判断目录的可写性;
    if(is_dir($dir))
     {
         if($fp = @fopen("$dir/test.txt", 'w')) {
             @fclose($fp);
             @unlink("$dir/test.txt");
            $writeable = 1;
         } else {
            $writeable = 0;
         }
     }
     return $writeable;
}

/*递归替换掉字符串里面的特殊 HTML 字符*/
function dhtmlspecialchars($string) {
     if(is_array($string)) {
         foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars($val);
         }
     } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
        //数组作为操作对象,妙!
        str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
     }
     return $string;
}

/*递归的过滤字符串,防止 SQL 注入 DZ*/
function daddslashes($string, $force = 0) {
     !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
     if(!MAGIC_QUOTES_GPC || $force) {
         if(is_array($string)) {
             foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
             }
         } else {
            $string = addslashes($string);
         }
     }
     return $string;
} 

/*
     hash 编码
     $length      字串长度;
     $numeric     编码内容控制:0为纯数字;1为数字字母随机组合;
*/
function random($length, $numeric = 0) {
    /*php 版本小于 4.2.0 时,mt_rand() 函数需要事先播随机种子 mt_srand()*/
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
     if($numeric)
     {
        /*格式化字串,共有 $length 位,少于则有 0 补*/
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        //number pow ( number base, number exp );
         //返回 base 的 exp 次方的幂;
    } else
     {
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($chars) - 1;
         for($i = 0; $i < $length; $i++)
         {
            $hash .= $chars[mt_rand(0, $max)];
         }
     }
     return $hash;
} 

/*截中文字符串 DZ*/
function cutstr($string, $length, $dot = ' ...') {
     global $charset;
     $charset = isset($charset) ? $charset : 'utf-8';

     if(strlen($string) <= $length) {
         return $string;
     }

    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

    $strcut = '';
     if(strtolower($charset) == 'utf-8') {

        $n = $tn = $noc = 0;
         while($n < strlen($string)) {

            $t = ord($string[$n]);
             if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
             } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
             } elseif(224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 2;
             } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
             } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
             } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
             } else {
                $n++;
             }

             if($noc >= $length) {
                 break;
             }

         }
         if($noc > $length) {
            $n -= $tn;
         }

        $strcut = substr($string, 0, $n);

     } else {
         for($i = 0; $i < $length - strlen($dot) - 1; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
         }
     }

    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

    return $strcut . $dot;
} 

// 来自 Discuz 的 WAP 输出函数
function wapheader($title) {
     global $action, $_SERVER;
    header("Content-type: text/vnd.wap.wml; charset=utf-8");
    /*
     header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
     header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
     header("Cache-Control: no-cache, must-revalidate");
     header("Pragma: no-cache");
     */
    echo "<?xml version=\"1.0\"?>\n".
        "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n".
        "<wml>\n".
        "<head>\n".
        "<meta http-equiv=\"cache-control\" content=\"max-age=180,private\" />\n".
        "</head>\n".
        "<card id=\"discuz_wml\" title=\"$title\">\n";
        // newcontext=\"true\"
}

function wapfooter() {
     echo "</card>\n".
         "</wml>";
}
/**============================= End come from DZ ====================================*/

/**
    functions come from phpMyAdmin
*/

/**
 * trys to find the value for the given environment vriable name
 *
 * searchs in $_SERVER, $_ENV than trys getenv() and apache_getenv()
 * in this order
 *
 * @param   string  $var_name   variable name
 * @return  string  value of $var or empty string
 */
function PMA_getenv($var_name) {
    if (isset($_SERVER[$var_name])) {
        return $_SERVER[$var_name];
    } elseif (isset($_ENV[$var_name])) {
        return $_ENV[$var_name];
    } elseif (getenv($var_name)) {
        return getenv($var_name);
    } elseif (function_exists('apache_getenv')
     && apache_getenv($var_name, true)) {
        return apache_getenv($var_name, true);
    }

    return '';
}

/**
 * Converts numbers like 10M into bytes
 * Used with permission from Moodle (http://moodle.org) by Martin Dougiamas
 * (renamed with PMA prefix to avoid double definition when embedded
 * in Moodle)
 *
 * @param   string  $size
 * @return  integer $size
 */
function PMA_get_real_size($size = 0)
{
    if (!$size) {
        return 0;
    }
    $scan['MB'] = 1048576;
    $scan['Mb'] = 1048576;
    $scan['M']  = 1048576;
    $scan['m']  = 1048576;
    $scan['KB'] =    1024;
    $scan['Kb'] =    1024;
    $scan['K']  =    1024;
    $scan['k']  =    1024;

    while (list($key) = each($scan)) {
        if ((strlen($size) > strlen($key))
          && (substr($size, strlen($size) - strlen($key)) == $key)) {
            $size = substr($size, 0, strlen($size) - strlen($key)) * $scan[$key];
            break;
        }
    }
    return $size;
} // end function PMA_get_real_size()

/**
 * calls $function vor every element in $array recursively
 *
 * @param   array   $array      array to walk
 * @param   string  $function   function to call for every array element
 */
function PMA_arrayWalkRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            PMA_arrayWalkRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }

        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

/**
* Generates a hidden field which should indicate to the browser
* the maximum size for upload
*
* @param   integer  the size
*
* @return  string   the INPUT field
*
* @access  public
*/
function PMA_generateHiddenMaxFileSize($max_size)
{
    return '<input type="hidden" name="MAX_FILE_SIZE" value="' .$max_size . '" />';
}

/**
 * Binary search of a value in a sorted array
 *
 * @param   string   string to search for
 * @param   array    sorted array to search into
 * @param   integer  size of sorted array to search into
 *
 * @return  boolean  whether the string has been found or not
 */
function PMA_STR_binarySearchInArr($str, $arr, $arrsize)
{
    // $arr MUST be sorted, due to binary search
    $top    = $arrsize - 1;
    $bottom = 0;
    $found  = FALSE;

    while (($top >= $bottom) && ($found == FALSE)) {
        $mid = intval(($top + $bottom) / 2);
        $res = strcmp($str, $arr[$mid]);
        if ($res == 0) {
            $found  = TRUE;
        } elseif ($res < 0) {
            $top    = $mid - 1;
        } else {
            $bottom = $mid + 1;
        }
    } // end while

    return $found;
} // end of the "PMA_STR_binarySearchInArr()" function

/**
 * Adds backquotes on both sides of a database, table or field name.
 * and escapes backquotes inside the name with another backquote
 *
 * <code>
 * echo PMA_backquote('owner`s db'); // `owner``s db`
 * </code>
 *
 * @param   mixed    $a_name    the database, table or field name to "backquote"
 *                              or array of it
 * @param   boolean  $do_it     a flag to bypass this function (used by dump
 *                              functions)
 * @return  mixed    the "backquoted" database, table or field name if the
 *                   current MySQL release is >= 3.23.6, the original one
 *                   else
 * @access  public
 */
function PMA_backquote($a_name, $do_it = true)
{
    if (! $do_it) {
        return $a_name;
    }

    if (is_array($a_name)) {
         $result = array();
         foreach ($a_name as $key => $val) {
             $result[$key] = PMA_backquote($val);
         }
         return $result;
    }

    // '0' is also empty for php :-(
    if (strlen($a_name) && $a_name !== '*') {
        return '`' . str_replace('`', '``', $a_name) . '`';
    } else {
        return $a_name;
    }
} // end of the 'PMA_backquote()' function

/**
 * just to be sure there was no import (registering) before here
 * we empty the global space
 */
/*
$variables_whitelist = array (
    'GLOBALS',
    '_SERVER',
    '_GET',
    '_POST',
    '_REQUEST',
    '_FILES',
    '_ENV',
    '_COOKIE',
    '_SESSION',
);

foreach (get_defined_vars() as $key => $value) {
    if (! in_array($key, $variables_whitelist)) {
        unset($$key);
    }
}
unset($key, $value, $variables_whitelist);
*/
// add some character for testing in VIM

/**
    get array from simpal XML file.
    @para: $xml the XML file
    @para: $key_tags which data we want to get parse
    @return: array
*/
function get_info_from($xml, $key_tags = array())
{
    $info = array();

    //$data = @file_get_contents($server);
    //$data = $xml;    

    if (! strlen($xml))
    {
        return $info;
    }

    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    //xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parse_into_struct($parser, $xml, $values, $tags);
    xml_parser_free($parser);

    //print_r($data);
    /*echo '$values = ';
    print_r($values);
    echo '$tags';
    print_r($tags);*/

    #$key_tags = array('cstar', 'cdest', 'tstar', 'tdest');

    /** parse XML to array*/
    foreach ($key_tags as $tag)
    {
        $i = 0;
        foreach ($tags[$tag] as $title_index)
        {
            $info[$i][$tag] = $values[$title_index]['value'];
            $i++;
        }
    }

    return $info;
}

/**
    get all files name from one directory.
*/
function get_file_names($path)
{
    $file_names = array();

    if (! is_dir($path))
    {
        return $file_names;
    }

    if ($handle = opendir($path))
    {
        while (false !== ($file = readdir($handle)))
        {
            $file_names[] = $file;
        }

        closedir($handle);
    }

    return $file_names;
}

/**
    create options for select element.
*/
function get_select_options($options = array(), $selected = '')
{
    $option = '';

    foreach ($options as $key => $value)
    {
        $option .= '<option value="'. $key .'" '. ($selected == $key ? 'selected' : '') .'>'. $value .'</option>';
    }

    return $option;
}

//简化三元运算符
function iif($expression, $returntrue, $returnfalse = '')
{
    return ($expression ? $returntrue : $returnfalse);
}

//php js_unescape correspond to js escape
function js_unescape($str)
{
    $ret = '';
    $len = strlen($str);

    for ($i = 0; $i < $len; $i++)
    {
        if ($str[$i] == '%' && $str[$i+1] == 'u')
        {
            $val = hexdec(substr($str, $i+2, 4));

            if ($val < 0x7f)
            {    
                /* ASCII 码*/
                $ret .= chr($val);
            }else if($val < 0x800)
            {    
                $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));
            }else
            {    
                $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));
            }
            $i += 5;
        }
        else if ($str[$i] == '%')
        {
            /** url 编码的汉字*/
            $ret .= urldecode(substr($str, $i, 3));
            $i += 2;
        }
        else $ret .= $str[$i];
    }
    return $ret;
}

/**
 * functionality:
 *
 * @access public
 * @param string
 * @return string
 */
function unicode_url_to_gbk($url)
{
    $res_url = '';
    $start_sub = 0;
    while ($position = strpos('|'. $url, '%'))
    {
        $res_url .= substr($url, $start_sub, $position - 1);

        $char = substr($url, $position - 1, 6);

        $char = js_unescape($char);
        $char = iconv('UTF-8', 'GBK', $char);
        $char = urlencode($char);

        $res_url .= $char;
        
        $url = substr($url, $position + 5);
        //$start_sub = $postion;  //迭代到下一轮
    }

    return $res_url .= $url;
}

/**
 * functionality:
 *
 * @access public
 * @param string
 * @return string
 */
function get_msecond()
{
    $time = explode(' ', microtime());

    return ((float)$time[0] + (float)$time[1]);
}

/**
 * create permission option
 */
function create_select_optgroup($options = array(), $enable_opts = array(), $db_option = '')
{
    $optgroup = '';
     foreach ($options as $key => $option)
     {
         if (in_array($key, $enable_opts))
         {
            $optgroup .= '<option value="'. $key .'" '. ($db_option == $key ? 'selected' : '') .'>'. $option .'</option>';
         }else
         {
            $optgroup .= '<optgroup label="'. $option .'"></optgroup>';
         }
     }

     return $optgroup;
}

/**
 * find next key in an array by one key.
 */
function get_next_key($needle, $haystack)
{
    $find = 0;

     foreach ($haystack as $key => $value)
     {
         if ($needle == $key)
         {
            $find = 1;
             continue;
         }
         if ($find)
         {
             return $key;
         }
     }

     return '';
}

$config_code = '1234567890abcdefghijkmlnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

/**
    get the random string.
*/
function get_rand_code($long = 2)
{
    global $config_code;

    if ($long <= 0)
    {
        return;
    }

    $code = '';
    $max = strlen($config_code) - 1;
    for ($i = 0; $i < $long; $i++)
    {
        $code .= $config_code[rand(0, $max)];
    }

    return $code;
}

/**
 * Converts numbers like 10268 into readable
 * @author: hy0kle@gmail.com
 *
 * @param   integer  $size
 * @return  string $res B, KB, MB.
 */
function get_readable_size($size = 0)
{
    $res = '0B';
    if (! $size)
    {   
        return $res;
    }   
        
    $scan = array(
        'MB' => 1048576,
        'KB' => 1024,
        'B'  => 1,
    );  

    foreach ($scan as $unit => $number)
    {   
        if ($size >= $number)
        {   
            $res = sprintf('%.2f%s',($size /  $number), $unit);
            break;
        }   
    }   

    return $res;
}

function custom_strtolower($string)
{
    $lower_str = '';
    $str_len = strlen($string);
    for ($i = 0; $i < $str_len; $i++)
    {
        $lower_str .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : strtolower($string[$i]);
    }

    return $lower_str;
}
