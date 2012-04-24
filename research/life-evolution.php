<?php
$life_common = array(
    'head' => 1,
    'eyes' => 2,
    'mouth'=> 1,
);

$life_evolution = array(
    '-1' => array(
        'life_stat'   => 'None',
        'description' => '在一个奇妙而且美妙的时刻,我在不知道中即将诞生了,精彩马上开始...',
        'breath' => 0,
        'legs'   => 0,
        'tail'   => 0,
    ),

    '0' => array(
        'life_stat'   => 'tabpole',
        'description' => 'HI, 大家好,我是一个小蝌蚪',
        'breath' => 0,
        'legs'   => 0,
        'tail'   => 1,
    ),
    
    '1' => array(
        'life_stat'   => 'tabpole',
        'description' => '我还是一个小蝌蚪,但经过一段时间的进化,我长出了兩条腿',
        'breath' => 0,
        'legs'   => 2,
        'tail'   => 1,
    ),
    
    '2' => array(
        'life_stat'   => 'tabpole',
        'description' => '我依然可以算是一个小蝌蚪,但经过一段时间的进化,
            我有了四条腿,但尾巴却没有退去,我好想去陆地上看看呀',
        'breath' => 0,
        'legs'   => 4,
        'tail'   => 1,
    ),

    '3' => array(
        'life_stat'   => 'frog',
        'description' => '感谢郭嘉,我终于进化成为一只青蛙,可以享受兩栖的快乐了!',
        'breath' => 1,
        'legs'   => 4,
        'tail'   => 0,
    ),
);

function print_life($life_step = -1)
{
    global $life_common;
    global $life_evolution;

    $html = '';
    $life = array();
    
    if (! isset($life_evolution[$life_step]))
    {
        return $html;
    }

    $life = $life_common + $life_evolution[$life_step];
    //print_r($life);

    $html .= '<div class="description">';
    $html .= '生命姿态: ' . $life['life_stat'] . '<br />';
    $html .= '生命自述: ' . $life['description'] . '<br />';
    $html .= '我有 ' . $life['head'] . ' 个头<br />';
    $html .= '有 ' . $life['eyes'] . ' 个眼睛<br />';
    $html .= '有 ' . $life['mouth'] . ' 个嘴<br />';
    $html .= '有 ' . $life['legs'] . ' 条腿<br />';
    $html .= '有 ' . $life['tail'] . ' 条尾巴<br />';
    if ($life_step > -1)
    {
        $html .= '我用 ' . ($life['breath'] ? '肺' : '腮') . '  呼吸<br />';
    }
    if ($life_step >= -1 && $life_step < 3)
    {
        $html .= '<a href="/life-evolution.php?step=' . ($life_step + 1) . '">进化</a>';
    }
    $html .= '</div>';

    return $html;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Life Evolution</title>
<style>
.main{
    margin: 1em auto;
    padding: 1em;
    max-width: 1000px;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 2px 2px 5px #000000;
    overflow: auto;
}
</style>
</head>
<body>
<div class="main">
<?php
$life_step = isset($_GET['step']) ? $_GET['step'] + 0 : -1;
echo print_life($life_step);
?>
</div>
</body>
</html>
