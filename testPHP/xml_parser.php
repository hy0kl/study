<?php
$simple = "<rss version=\"2.0\">

<hotel>

<item>
<title>北京最便宜的酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&sort=price|asc
</link>
<price>40</price>
</item>

<item>
<title>北京经济型酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&grade=000111&sort=price|asc
</link>
<price>40</price>
</item>

<item>
<title>北京三星级酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&grade=001000&sort=price|asc
</link>
<price>70</price>
</item>

<item>
<title>首都机场附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E9%A6%96%E9%83%BD%E6%9C%BA%E5%9C%BA&sort=price|asc
</link>
<price>138</price>
</item>

<item>
<title>南苑机场附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E5%8D%97%E8%8B%91%E6%9C%BA%E5%9C%BA&sort=price|asc
</link>
<price>298</price>
</item>

<item>
<title>中关村附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E4%B8%AD%E5%85%B3%E6%9D%91&sort=price|asc
</link>
<price>108</price>
</item>

<item>
<title>天安门附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E5%A4%A9%E5%AE%89%E9%97%A8&sort=price|asc
</link>
<price>40</price>
</item>

<item>
<title>故宫附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E6%95%85%E5%AE%AB&sort=price|asc
</link>
<price>60</price>
</item>

<item>
<title>王府井附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E7%8E%8B%E5%BA%9C%E4%BA%95&sort=price|asc
</link>
<price>60</price>
</item>

<item>
<title>北京大学附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E5%8C%97%E4%BA%AC%E5%A4%A7%E5%AD%A6&sort=price|asc
</link>
<price>158</price>
</item>

<item>
<title>清华大学附近酒店</title>

<link>
http://hotel.kuxun.cn/search.php?city=%E5%8C%97%E4%BA%AC&hotel=%E6%B8%85%E5%8D%8E%E5%A4%A7%E5%AD%A6&sort=price|asc
</link>
<price>158</price>
</item>
</hotel>
</rss>";
$p = xml_parser_create();
xml_parse_into_struct($p, $simple, $vals, $index);
xml_parser_free($p);
echo "Index array\n";
print_r($index);
echo "\nVals array\n";
print_r($vals);

echo '<br />---------------------------------------------------<br/>';
class AminoAcid {
    var $name;  // aa 姓名
    var $symbol;    // 三字母符号
    var $code;  // 单字母代码
    var $type;  // hydrophobic, charged 或 neutral

    function AminoAcid ($aa)
    {
        foreach ($aa as $k=>$v)
            $this->$k = $aa[$k];
    }
}

function readDatabase($filename)
{
    // 读取 aminoacids 的 XML 数据
    $data = implode("",file($filename));
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    // 遍历 XML 结构
    echo '$data = ';
    print_r($data);
    echo '$values = ';
    print_r($values);
    echo '$tags = ';
    print_r($tags);
    foreach ($tags as $key=>$val) {
        if ($key == "molecule") {
            $molranges = $val;
            // each contiguous pair of array entries are the
            // lower and upper range for each molecule definition
            for ($i=0; $i < count($molranges); $i+=2) {
                $offset = $molranges[$i] + 1;
                $len = $molranges[$i + 1] - $offset;
                $tdb[] = parseMol(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }
    return $tdb;
}

function parseMol($mvalues)
{
    for ($i=0; $i < count($mvalues); $i++) {
        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
    }
    return new AminoAcid($mol);
}

$db = readDatabase("http://hotel.kuxun.cn/api/api_search_keyword.php?city=%E5%8C%97%E4%BA%AC&from=jipiao");
echo "** Database of AminoAcid objects:\n";
print_r($db);


/**
    new function, get hotel form new api:http://hotel.kuxun.cn/api/api_search_keyword.php?city=city&from=jipiao
*/
function get_hotle_from_api($city){
    $hotel = array();

    $api = 'http://hotel.kuxun.cn/api/api_search_keyword.php?city='. urlencode($city) .'&from=jipiao';
    $data = implode('', file($api));

    if (! strlen($data)){
        return $hotel;
    }

    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    $key_tags = array('title' => 'hotel_title', 'link' => 'hotel_link', 'price' => 'hotel_price');
    foreach ($key_tags as $tag => $label) {
        $i = 0;
        foreach ($tags[$tag] as $title_index){
            $hotel[$i][$label] = $values[$title_index]['value'];
            $hotel[$i]['hotel_grade'] = '';
            $i++;
        }
    }

    $count = count($hotel);
    if ($count > 3)
    {
        $hotel = array_slice($hotel, 3);
    }
    else
    {
        return array();
    }

    return $hotel;
}

?> 