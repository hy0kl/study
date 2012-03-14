<?php
/**
 *
 * @Copyright	(c) All rights reserved
 * @Author		mengjie <mengjie1977@gmail.com>
 * @Version		$Id: class_fso.php,v 1.0 2007/04/27 08:24:42 mengjie Exp $
 */
 
class FSO
{
	var $seperate;
	
	//���캯��
	function FSO()
  {
		$this->seperate = DIRECTORY_SEPARATOR;
  }
  
  //�½�һ��Ŀ¼
  function mk_dir($path, $mode = 0777)
	{
		$path = FSO::_parse_path($path);
		if (is_dir($path))
		{
			if (!(is_writable($path)))
			{
				@chmod($path, $mode);
			}
			return true;
		}
		else
		{
			$oldmask = @umask(0);
			$partialpath = dirname($path);
			if (!FSO::mk_dir($partialpath, $mode))
			{
				return false;
			}
			else
			{
				return @mkdir($path, $mode);
			}
		}
	}

  //ɾ��һ��Ŀ¼���ļ�
  function rm_dir($path)
  {
  	$path = FSO::_parse_path($path);
	  if (@is_dir($path) && is_writable($path)) 
	  {
	    $dp = opendir($path);
	    while ($ent = readdir($dp)) 
	    {
	      if ($ent == '.' || $ent == '..') continue;
	      $file = $path . '/' . $ent;
	      if (@is_dir($file)) 
	      {
	      	FSO::rm_dir($file);
	      } 
	      elseif (is_writable($file)) 
	      {
	      	@unlink($file);
	      } 
	      else 
	      {
	      	return false;
	      }
	    }
	    closedir($dp);
	    return rmdir($path);
	  } 
	  else 
	  {
	    return @unlink($path);
	  }
  }
  
  //����һ��Ŀ¼
  function copy_dir($from_path, $to_path, $mode = 0777)
	{
		$from_path = preg_replace( "#/$#", "", FSO::_parse_path($from_path));
		$to_path   = preg_replace( "#/$#", "", FSO::_parse_path($to_path));
		
		if (!is_dir($from_path))
		{
			return false;
		}
		if (!is_dir($to_path))
		{
			if (!@mkdir($to_path, $mode))
			{
				return false;
			}
			else
			{
				@chmod($to_path, $mode);
			}
		}
		if (is_dir($from_path))
		{
			$handle = opendir($from_path);
			while (false !== ($file = readdir($handle)))
			{
				if (($file != ".") && ($file != ".."))
				{
					if (is_dir($from_path . "/" . $file ))
					{
						FSO::copy_dir($from_path . "/" . $file, $to_path . "/" . $file);
					}
					
					if (is_file($from_path . "/" . $file))
					{
						copy($from_path . "/" . $file, $to_path . "/" . $file);
						@chmod($to_path . "/" . $file, 0777);
					} 
				}
			}
			closedir($handle); 
		}
		return true;
	}
	
	//�õ�һ��Ŀ¼�µ�����Ŀ¼���ļ��б�
	function scan_dir($path, &$array, $grade = 0)
  {
    if (is_dir($path))
    {
      $handle = opendir($path);
      while (false !== ($file = readdir($handle)))
      {
        if ($file != "." && $file != "..")
        {
          $fullDir = FSO::_parse_path($path . "/" . $file);
          if (is_dir($fullDir))
          {
          	$extension = null;	
          }
          else
          {
          	$infos = pathinfo($fullDir);
          	$extension = @$infos["extension"];	
          }
          $array[] = array("type" => (is_dir($fullDir)) ? "dir" : "file", 
          								 "name" => $fullDir, 
          								 "extension" => $extension, 
          								 "size" => @filesize($fullDir), 
          								 "time" => @filemtime($fullDir), 
          								 "grade" => $grade);
          if (is_dir($fullDir))
          {
          	FSO::scan_dir($fullDir, $array, ++$grade);
          }
        }
      }
    }
  }
  
  //���������ļ�����
  function read_file($filename, $binary = true, $getdata = true)
  {
  	if (function_exists('file_get_contents')) 
		{
			return file_get_contents($filename);
		} 
		else 
		{
			$mode = 'r' . ($binary ? 'b' : '');
			$data = '';
			if (is_readable($filename) AND is_resource($fp = @fopen($filename, $mode)) 
			AND (!$getdata OR filesize($filename) == 0 OR $data = @fread($fp, @filesize($filename))) 
			AND @fclose($fp)) 
			{
				return $data;
			} 
			return false;
		}
  }
  
  //��һ���ļ���д������
  function write_file($filename, $data, $append = false, $binary = true)
  {
  	$folder = substr($filename, 0, strrpos($filename, '/'));
  	$mode = ($append ? 'a' : 'w') . ($binary ? 'b' : '');
  	
  	return (is_writable($folder) AND
			is_resource($fp = @fopen($filename, $mode)) AND
			@fputs($fp, $data) !== false AND
			@fclose($fp));
  }
  
  //��ȡ�ļ����ĺ�׺
  function file_ext($filename, $default = '.')
	{
		return substr(strrchr(strtolower($filename), $default), 1);
	}
	
	//ת���ָ���Ϊ��ǰ��ʶ��ķָ���
  function _parse_path($path)
  {
	  $path = preg_replace("/\\\\+/", "/", $path);
	  $path = preg_replace("/\/{2,}/", "/", $path);
	  return $path;
  }
}

?>