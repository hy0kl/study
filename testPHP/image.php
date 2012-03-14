<?php
$image = './chinese.jpg';
$img_info = getimagesize($image);

header('Content-type: image/'.$img_info['mime']);

generate_thumb($image, 200, 200, 0);
//print_r($img_info);

function generate_thumb($source_img, $new_width, $new_height, $if_cut = 0)
{   //图片类型
    $img_info = getimagesize($source_img);
    $img_type = $img_info['mime'];
    //初始化图像
    if('image/jpeg' == $img_type) $temp_img = imagecreatefromjpeg($source_img);
    if('image/gif'  == $img_type) $temp_img = imagecreatefromgif($source_img);
    if('image/png'  == $img_type) $temp_img = imagecreatefrompng($source_img);
    //原始图象的宽和高
    $old_width = imagesx($temp_img);
    $old_height= imagesy($temp_img);
    //改变前后的比例
    $old_ratio = $old_width / $old_height;
    $new_ratio = $new_width / $new_height;

    //生成新图象参数
    if(1 == $if_cut)
    {   //情况一:截图 则按设置的大小生成目标图象
        $new_width = $new_width;
        $new_height= $new_height;
        if($old_ratio >= $new_ratio)
        {   //高度优先
            $old_width = $old_height * $new_ratio;
            $old_height= $old_height;
        }else
        {   //宽度优先
            $old_width = $old_width;
            $old_height= $old_width / $new_ratio;
        }
    }else
    {   //情况二: 不截图 则按比例生成目标图像
        $old_width = $old_width;
        $old_height= $old_height;
        if($old_ratio >= $new_ratio)
        {   //高度优先
            $new_width = $new_width;
            $new_height= $new_width / $old_ratio;
        }else
        {   //宽度优先
            $new_width = $new_height * $old_ratio;
            $new_height= $new_height;
        }
    }

    //生成新图片
    $new_img = imagecreatetruecolor($new_width, $new_height);
    if($img_type == 'image/png' || $img_type == 'image/gif')
    {
        imagealphablending($new_img, FALSE);    //取消默认的混色模式
        imagesavealpha($new_img, TRUE); //设定保存完整的 alpha 通道信息
    }

    //拷贝图片
    imagecopyresampled($new_img, $temp_img, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

    if($img_type == 'image/jpeg') imagejpeg($new_img);
    if($img_type == 'image/gif')  imagegif($new_img);
    if($img_type == 'image/png')  imagepng($new_img);

    imagedestroy($new_img);
}
?>