<?php
function find_array_key($find, $src_array)
{
    if (is_array($src_array))
    {
        if (isset($src_array[$find]))
        {
            return true;
        }
        else
        {
            foreach ($src_array as $key => $value)
            {
                if (is_array($value))
                {
                    return find_array_key($find, $value);
                }
            }
            return false;
        }
    }
    else
    {
        return false;
    }
}

$src_array = array(
    'test' => '123',
    array(
        'has' => 'OK',
        'find'=> true,
        array(
            'depth' => 'soso',
        ),
    ),
);

function recursion_iconv(&$src_array, $from = 'gbk', $to = 'utf-8')
{   
    foreach ($src_array as $key => $value)
    {   
        if (is_array($value))
        {   
            return recursion_iconv(&$src_array[$key], $from, $to);
        }   
        else
        {   
            if (is_numeric($value))
            {   
                continue;
            }   

            if (mb_check_encoding($value, $to))
            {   
                continue;
            }   
                
            if (mb_check_encoding($value, $from))
            {   
                $src_array[$key] = mb_convert_encoding($value, $to, $from);
            }   
        }   

    }   

    return 0;
}

var_dump(find_array_key('123', $src_array));
?>