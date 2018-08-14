<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/08/14
 * Time: 12:56
 */

require_once 'SomeClass.php';

$obj = new SomeClass();
$obj->__set('setter', 'setValue');
echo $obj->__get('setter');