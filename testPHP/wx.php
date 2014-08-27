<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
/* vi:set ts=4 sw=4 et fdm=marker: */

// 模拟微信回调

$xml = '<xml>
<ToUserName><![CDATA[wx3139a9a490265df9]]></ToUserName>
<FromUserName><![CDATA[olARquApYYA4IdBcK_G1iCuXIAOM]]></FromUserName>
<CreateTime>1409108301</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[我要test]]></Content>
<MsgId>1234567890123456</MsgId>
</xml>';

$url = 'http://mi.app.cc/wechat/event201408?signature=c828041218a241c0fd1d81deb67c27d5c363c75e&timestamp=1409109166&nonce=2003978968';

$header[] = "Content-type: text/xml"; //定义content-type为xml

$ch = curl_init(); //初始化curl

curl_setopt($ch, CURLOPT_URL, $url); //设置链接
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置是否返回信息
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置HTTP头
curl_setopt($ch, CURLOPT_POST, 1); //设置为POST方式
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); //POST数据

$response = curl_exec($ch); //接收返回信息
if(curl_errno($ch)){//出错则显示错误信息
    print curl_error($ch);
}

curl_close($ch); //关闭curl链接

echo $response . PHP_EOL; //显示返回信息

