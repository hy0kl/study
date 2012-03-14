<?php
/**
 *
 * @Copyright	(c) All rights reserved
 * @Author		mengjie <mengjie1977@gmail.com>
 * @Version		$Id: class_validate.php,v 1.0 2007/04/27 08:24:42 mengjie Exp $
 */
 
class Validate
{
	//构造函数
  function Validate()
  {
  }
	
	//检验邮箱
	function is_valid_email($email)
	{
		return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>]+\.+[a-z]{2,6}))$#si', $email);
	}
	
	//检验数字
	function is_valid_number($number)
  {
  	return preg_match("/^([0-9]+)$/", $number);
  }
  
  //检验字母
  function is_valid_alpha($alpha)
  {
  	return preg_match('/^[a-zA-Z]+$/', $alpha);
  }
  
  //检验字母、数字
  function is_valid_alphanum($alphanum)
  {
  	return !preg_match('/\W/', $alphanum);
  }
  
  //检验IP
  function is_valid_ip($ip)
  {
  	return preg_match('/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', $ip);
  }
  
  //检验URL
  function is_valid_url($url)
  {
  	return preg_match('/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i', $url);
  }
  
  //检验时间
  function is_valid_date($date)
  {
  	$regex = '/^(\d{4})-(\d{2})-(\d{2})$/';
  	if (!preg_match($regex, $date))
  	{
  		return false;
  	}
  	list($year, $month, $day) = sscanf($date, '%d-%d-%d');
  	if (!checkdate($month, $day, $year)) 
  	{
  		return false;
  	}
  	return true;
  }
  
  //检验闰年
  function is_valid_leapyear($year)
  {
    if (empty($year)) 
    {
    	$year = date('Y');
    }
    if (preg_match('/\D/', $year)) 
    {
    	return false;
    }
    if ($year < 1000) 
    {
    	return false;
    }
    if ($year < 1582) 
    {
      // pre Gregorio XIII - 1582
      return ($year % 4 == 0);
    } 
    else 
    {
      // post Gregorio XIII - 1582
      return (($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0);
    }
  }
   
  //检验手机号码
  function is_valid_mobile($mobile)
  {
  	return preg_match('/(^0?[1][35][0-9]{9}$)/', $mobile);
  }
  
	//检验座机  
  function is_valid_phone($phone)
  {
  	return preg_match('/^((0[1-9]{3})?(0[12][0-9])?[-])?\d{6,8}$/', $phone);
  }
  
  //检验中文
  function is_valid_chinese($str, $encode = 'GBK')
  {
  	if ($encode == 'UTF-8')
  	{
  		return preg_match('/^[u4e00-u9fa5]+$/', $str);
  	}
  	else if ($encode == 'GBK')
  	{
  		return preg_match('/^[\x80-\xff]+$/', $str);
  	}
  	else
  	{
  		return false;
  	}
  }
  
  //检验是否两者之间
  function is_valid_between($value, $min, $max, $inclusive = true)
  {
  	if ($inclusive) 
  	{
      if ($min > $value || $value > $max) 
      {
	      return false;
      }
    } 
    else 
    {
		  if ($min >= $value || $value >= $max) 
		  {
		   	return false;
		  }
    }
    return true;
  }
  
  //检验是否合法文件名
  function is_valid_file($file, $allow)
  {
  	require_once('class_fso.php');
  	$ext = FSO::file_ext($file);
  	
  	if (!is_array($allow))
  	{
  		$tmp = explode(',', $allow);
  	}
  	else
  	{
  		$tmp = $allow;
  	}
		if (in_array($ext, $tmp))
		{
			return true;
		}
  	return false;
  }
  
  //检验身份证号码
  function is_valid_idcard($idcard)
  {
  	if (file_exists('class_idcard.php'))
  	{
	  	require_once('class_idcard.php');
	  	$card = new Idcard();
			$info = $card->parse_idc($idcard);
			
			if ($info[0] == 1 OR $info[0] == 2)
			{
				return true;
			}
			return false;
		}
		else
		{
			return preg_match("/^\d{15}$|^\d{18}$|^\d{17}x$/", $idcard);
		}
  }
  
  //检验md5码
  function is_valid_md5($md5)
  {
  	return preg_match('#^[a-f0-9]{32}$#', $md5);
  }
  
  //检验Serialize数据
  function is_valid_serialized($data)
  {
  	if ($data === '')
		{
			$data = serialize(array());
			return true;
		}
		else
		{
			if (!is_array($data))
			{
				$data = unserialize($data);
				if ($data === false)
				{
					return false;
				}
			}

			$data = serialize($data);
		}

		return true;
  }
  
  //通过正则表达式检验
  function is_valid_regex($value, $pattern)
  {
  	$status = @preg_match($pattern, $value);
  	if (false === $status) 
  	{
  		die('Internal error matching pattern!');
  	}
  	if (!$status) 
  	{
	    return false;
    }
    return true;
  }
}

//信用卡验证类
class Cc_Validation 
{
  var $cc_type, $cc_number, $cc_expiry_month, $cc_expiry_year;

  function validate($number, $expiry_m, $expiry_y) 
  {
    $this->cc_number = ereg_replace('[^0-9]', '', $number);

    if (ereg('^4[0-9]{12}([0-9]{3})?$', $this->cc_number)) 
    {
      $this->cc_type = 'Visa';
    } 
    elseif (ereg('^5[1-5][0-9]{14}$', $this->cc_number)) 
    {
      $this->cc_type = 'Master Card';
    } 
    elseif (ereg('^3[47][0-9]{13}$', $this->cc_number))
    {
      $this->cc_type = 'American Express';
    } 
    elseif (ereg('^3(0[0-5]|[68][0-9])[0-9]{11}$', $this->cc_number)) 
    {
      $this->cc_type = 'Diners Club';
    } 
    elseif (ereg('^6011[0-9]{12}$', $this->cc_number)) 
    {
      $this->cc_type = 'Discover';
    } 
    elseif (ereg('^(3[0-9]{4}|2131|1800)[0-9]{11}$', $this->cc_number)) 
    {
      $this->cc_type = 'JCB';
    } 
    elseif (ereg('^5610[0-9]{12}$', $this->cc_number)) 
    { 
      $this->cc_type = 'Australian BankCard';
    }
    elseif (ereg('^2014[0-9]{11}$|^2149[0-9]{11}$', $this->cc_number)) 
    { 
      $this->cc_type = 'EnRoute';
    }
    else 
    {
      return -1;
    }

    if (is_numeric($expiry_m) && ($expiry_m > 0) && ($expiry_m < 13)) 
    {
      $this->cc_expiry_month = $expiry_m;
    } 
    else 
    {
      return -2;
    }

    $current_year = date('Y');
    $expiry_y = substr($current_year, 0, 2) . $expiry_y;
    if (is_numeric($expiry_y) && ($expiry_y >= $current_year) && ($expiry_y <= ($current_year + 10))) 
    {
      $this->cc_expiry_year = $expiry_y;
    } 
    else 
    {
      return -3;
    }

    if ($expiry_y == $current_year) 
    {
      if ($expiry_m < date('n')) 
      {
        return -4;
      }
    }
    return $this->is_valid();
  }

  function is_valid() 
  {
    $cardNumber = strrev($this->cc_number);
    $numSum = 0;

    for ($i = 0; $i < strlen($cardNumber); $i++) 
    {
      $currentNum = substr($cardNumber, $i, 1);
      if ($i % 2 == 1) 
      {
        $currentNum *= 2;
      }
      if ($currentNum > 9) 
      {
        $firstNum = $currentNum % 10;
        $secondNum = ($currentNum - $firstNum) / 10;
        $currentNum = $firstNum + $secondNum;
      }
      $numSum += $currentNum;
    }

    return ($numSum % 10 == 0);
  }
}
?>
