<?php
class Human
{
    public $name;
    public $sex;
    private $age;
    private $weight;
    private $height;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

$tom = new Human();
$tom->setName('Tom');
echo $tom->getName();
//echo Human::__sleep();
$test = unserialize('a:5:{i:0;a:7:{s:8:"quantity";s:1:"5";s:12:"product_name";s:20:"QzQxNDlBILrayavO+LnE";s:11:"product_num";s:8:"usSyxA==";s:12:"product_sort";s:8:"zvi5xA==";s:10:"unit_price";s:4:"1001";s:11:"trade_price";s:2:"78";s:11:"singleTotal";s:6:"390.00";}i:1;a:7:{s:8:"quantity";s:1:"8";s:12:"product_name";s:20:"QzQxOTFBILrayavO+LnE";s:11:"product_num";s:8:"usSyxA==";s:12:"product_sort";s:8:"zvi5xA==";s:10:"unit_price";s:3:"754";s:11:"trade_price";s:2:"98";s:11:"singleTotal";s:6:"784.00";}i:2;a:7:{s:8:"quantity";s:1:"1";s:12:"product_name";s:36:"QzQxOTdBRnVzZXLM17z+KDExMS12b2x0KQ==";s:11:"product_num";s:8:"usSyxA==";s:12:"product_sort";s:8:"zvi5xA==";s:10:"unit_price";s:4:"2024";s:11:"trade_price";s:2:"88";s:11:"singleTotal";s:5:"88.00";}i:3;a:7:{s:8:"quantity";s:2:"11";s:12:"product_name";s:24:"QzQxOTZBVHJhbnNmZXLM17z+";s:11:"product_num";s:8:"usSyxA==";s:12:"product_sort";s:8:"zvi5xA==";s:10:"unit_price";s:4:"1722";s:11:"trade_price";s:2:"99";s:11:"singleTotal";s:7:"1089.00";}s:5:"total";a:3:{s:8:"subtotal";s:7:"2351.00";s:10:"adjustment";s:0:"";s:5:"total";s:7:"2351.00";}}');
print_r($test);
?>
