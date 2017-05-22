<?php
/**
 * @describe:
 * @url: https://jmfeurprier.com/2010/01/03/method_exists-vs-is_callable/
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
class Foo {
  public function PublicMethod() {}
  private function PrivateMethod() {}
  public static function PublicStaticMethod() {}
  private static function PrivateStaticMethod() {}
}
 
$foo = new Foo();
 
$callbacks = array(
  array($foo, 'PublicMethod'),
  array($foo, 'PrivateMethod'),
  array($foo, 'PublicStaticMethod'),
  array($foo, 'PrivateStaticMethod'),
  array('Foo', 'PublicMethod'),
  array('Foo', 'PrivateMethod'),
  array('Foo', 'PublicStaticMethod'),
  array('Foo', 'PrivateStaticMethod'),
);
 
foreach ($callbacks as $callback) {
  var_dump($callback);
  var_dump(method_exists($callback[0], $callback[1])); // 0: object / class name, 1: method name
  var_dump(is_callable($callback));
  echo str_repeat('-', 40), "\n";
}
/* vim:set ts=4 sw=4 et fdm=marker: */

