<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */

/* vi:set ts=4 sw=4 et fdm=marker: */
$db_name = './statistics.db';
$db = new SQLite3($db_name);

if (! $db)
{
    echo "Can NOT connect db: $db_name\n";
    exit();
}

$conf = array(
    'request_total' => '总请数',
    'max_tr' => '最大tr值(ms)',
    'avg_tr' => '平均tr(ms)',
    'max_tt' => '最大tt值(ms)',
    'avg_tt' => '平均tt值(ms)',
    'is_200' => '接口200数',
    'rate_200' => '200占比',
    'not_200'  => '非200数',
    'rate_n200' => '非200占比',
);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<style>
.title{
    color: red;
    font-weight: bold;
}
</style>
<title>API 历史图表</title>
</head>
<body>
<form method="get">
<?php
$i = 0;
foreach ($conf as $field => $label)
{
    echo '<input id="lab_' . $field . '" type="checkbox" name="' . $field . '" value="1"';
    echo (isset($_GET[$field]) || (0 == count($_GET) && 0 == $i) ? ' checked="checked"' : '') . '/>';
    echo '<label for="lab_' . $field . '">' . $label . '</label>';

    $i++;
}
?>
<input type="submit" />
<form/>
<?php
$query_field = array();
$df_qf = array('request_total');
if (count($_GET))
{
    foreach ($_GET as $k => $v)
    {
        if (isset($conf[$k]))
        {
            $query_field[] = $k;
        }
    }
}
$query_field = count($query_field) ? $query_field : $df_qf;

$sql = sprintf('SELECT id, date_str, api_name, %s FROM statistics ORDER BY id ASC', implode(', ', $query_field));
$results = $db->query($sql);
$labels_cntr = array();
$fields = array();

$data_cntr = array();
while ($row = $results->fetchArray(SQLITE3_ASSOC))
{
    if (0 == count($fields))
    {
        $fields = array_keys($row);
        $fields = array_flip($fields);
        unset($fields['id']);
        unset($fields['date_str']);
        unset($fields['api_name']);
    }

    //print_r($row);exit;
    $primary_key = $row['date_str'];
    $api_name    = $row['api_name'];
    if (! isset($labels_cntr[$primary_key]))
    {
        $labels_cntr[$primary_key] = 1;
    }

    foreach ($fields as $f => $num)
    {
        $data_cntr[$f][$api_name][$primary_key] = $row[$f];
    }
}
//print_r($data_cntr);

$labels = array_keys($labels_cntr);

$dump_data = array();
foreach ($data_cntr as $field => $dt)
{
    $datasets = array();
    foreach ($dt as $api_name => $api_data)
    {
        $show_data = array();
        foreach ($labels as $lbl)
        {
            $show_data[] = isset($api_data[$lbl]) ? $api_data[$lbl] : 0;
        }
        $datasets[] = array(
            'name' => $api_name,
            'data' => $show_data,
        );
    }

    $dump_data[$field] = array(
        'labels'   => $labels,
        'series' => $datasets,
    );
}
//print_r($dump_data);

foreach ($fields as $f => $num)
{
?>
    <div id="<?php echo $f; ?>"></div>
<?php
}
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js"></script -->
<script src="//cdnjs.cloudflare.com/ajax/libs/highcharts/4.0.4/highcharts.js"></script>
<script>
$(document).ready(function(){
<?php
foreach ($dump_data as $key => $dt)
{
?>
    $('#<?php echo $key; ?>').highcharts({
        title: {
            text: '<?php echo $conf[$key]; ?> 历史统计',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: 老mi',
            x: -20
        },
        xAxis: {
            categories: <?php echo json_encode($labels); ?>
        },
        yAxis: {
            title: {
                text: '[<?php echo $conf[$key]; ?>] History data(历史数据)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: 'N/ms/%'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: <?php echo json_encode($dt['series']); ?>
    });
<?php
}
?>
});
</script>
</body>
</html>

