<?php
$line = 'other_access_log:60.207.212.38 - - [22/Dec/2010:11:00:00 +0800] "GET /static/images/stat_phpui.gif?ref=view&rand=1292986800 HTTP/1.1" 200 43 mod_gzip: 100pct. "http://mp3.baidu.com/m?f=3&tn=baidump3&ct=134217728&lf=&rn=&word=%C4%D0%C8%CB%BE%CD%CA%C7%C0%DB+%B3%C2%D3%F1%BD%A8&lm=-1&oq=%C4%D0%C8%CB%BE%CD%CA%C7%C0%DB&rsp=0" BAIDUID=A1EE168B7640CBDB9E1B6C9F5C607A7C:FG=1 "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)"';
function agent($line)
{
    $res['_OriginalLogLine'] = $line;
    $res['_ClientIp'] = null;
    $res['_ClientIpInLong'] = null;
    $res['_AccessTime'] = null;
    $res['_TimeZone'] = null;
    $res['_Method'] = null;
    $res['_Url'] = null;
    $res['_HttpVersion'] = null;
    $res['_StatusCode'] = null;
    $res['_Referer'] = null;
    $res['_Cookie'] = null;
    $res['_UserAgent'] = null;

    if (preg_match("/.*?(\d+\.\d+\.\d+\.\d+) .*? \[(.*?)\+(\d+)\] \"(.*?) (.*?) HTTP\/(.*?)\" (\d+) .*?\"(.*?)\" (.*?) \"(.*?)\"$/", $line, $out))
    {
        $res['_ClientIp'] = $out[1];
        $res['_ClientIpInLong'] = sprintf("%u", $out[1]);
        $res['_AccessTime'] = $out[2];
        $res['_TimeZone'] = $out[3];
        $res['_Method'] = $out[4];
        $res['_Url'] = $out[5];
        $res['_HttpVersion'] = $out[6];
        $res['_StatusCode'] = $out[7];
        $res['_Referer'] = $out[8];
        $res['_Cookie'] = $out[9];
        $res['_UserAgent'] = $out[10];
    }

    return $res;
}
?>
