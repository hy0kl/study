<?php
$data["username"] = '15801598759';
$data["password"] = 'hy0kl168';
$data["sendto"] = '15810006199';
$data["message"] = '';

$friends = array(
        'Me'       => '15801598759',
        '小瑞'      => '15122208192',
        'XiaoZha'  => '15068052630',
        '长伟'      => '13466561898',
        '志群'      => '15911115791',
        '文静'      => '15068052630',
        '孙琴霞'   => '15097282806',
        //'ZhouWei'  => '',
    );

if ($_POST['sendto'] && $_POST['message'])
{
    $data['sendto'] = $_POST['sendto'];
    $data['message']= $_POST['message'];

    $curl = new Curl_Class();
    $result = $curl->post("http://sms.api.bz/fetion.php", $data);

    header('Content-type: text/html; charset=UTF-8');
    echo $result; //输出结果如果 GBK 有乱码,则改用 UTF-8 输出
    echo 'Send to: '. $data['sendto'];
    echo '<a href="curl_fetion.php">Go Back</a>';
    //echo iconv("UTF-8", "GBK", $result);
//
 } else
{
?>
<form method="post" action="">
    Send TO: <!--input type="text" name="sendto"><br /> -->
    <select name="sendto">
<?php
    foreach ($friends AS $friend => $phone)
    {
        echo '<option value="'. $phone .'"">'. $friend;
    }
?>
    </select><br />
    Message: <textarea name="message" rows="5" cols="30"></textarea><br />
    <input type="submit"><input type="reset">
</form>
<?php
}



//cur 类
class Curl_Class
{
   function Curl_Class()
   {
       return true;
   }

   function execute($method, $url, $fields = '', $userAgent = '', $httpHeaders = '', $username = '', $password = '')
   {
       $ch = Curl_Class::create();
       if (false === $ch)
       {
           return false;
       }

       if (is_string($url) && strlen($url))
       {
           $ret = curl_setopt($ch, CURLOPT_URL, $url);
       }
       else
       {
           return false;
       }
       //设置参数
       curl_setopt($ch, CURLOPT_HEADER, false);
       //
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       if ($username != '')
       {
           curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
       }

       $method = strtolower($method);
       if ('post' == $method)
       {
           curl_setopt($ch, CURLOPT_POST, true);
           if (is_array($fields))
           {
               $sets = array();
               foreach ($fields AS $key => $val)
               {
                   $sets[] = $key . '=' . urlencode($val);
               }
               $fields = implode('&', $sets);
           }
           curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
       }
       else if ('put' == $method)
       {
           curl_setopt($ch, CURLOPT_PUT, true);
       }

       //curl_setopt($ch, CURLOPT_PROGRESS, true);
       //curl_setopt($ch, CURLOPT_VERBOSE, true);
       //curl_setopt($ch, CURLOPT_MUTE, false);
       curl_setopt($ch, CURLOPT_TIMEOUT, 10);//设置超时时间

       if (strlen($userAgent))
       {
           curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
       }

       if (is_array($httpHeaders))
       {
           curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
       }

       $ret = curl_exec($ch);

       if (curl_errno($ch))
       {
           curl_close($ch);
           return array(curl_error($ch), curl_errno($ch));
       }
       else
       {
           curl_close($ch);
           if (!is_string($ret) || !strlen($ret))
           {
               return false;
           }
           return $ret;
       }
   }

   function post($url, $fields, $userAgent = '', $httpHeaders = '', $username = '', $password = '')
  {
      $ret = Curl_Class::execute('POST', $url, $fields, $userAgent, $httpHeaders, $username, $password);
      if (false === $ret)
      {
          return false;
      }

      if (is_array($ret))
      {
          return false;
      }
      return $ret;
  }

  function get($url, $userAgent = '', $httpHeaders = '', $username = '', $password = '')
  {
      $ret = Curl_Class::execute('GET', $url, '', $userAgent, $httpHeaders, $username, $password);
      if (false === $ret)
      {
          return false;
      }

      if (is_array($ret))
      {
          return false;
      }
      return $ret;
  }

  function create()
  {
      $ch = null;
      if (!function_exists('curl_init'))
      {
          return false;
      }
      $ch = curl_init();
      if (!is_resource($ch))
      {
          return false;
      }
      return $ch;
  }

}
?>
