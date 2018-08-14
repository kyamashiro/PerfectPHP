<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/08/14
 * Time: 12:56
 */

require_once 'SomeClass.php';
require_once 'samefile/SomeClass.php';

$obj = new Food\Sweet\SomeClass();
echo $obj->__toString();

$obj2 = new testfile\Food\Test\SomeClass();
echo $obj2->__toString();