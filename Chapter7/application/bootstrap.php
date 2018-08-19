<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/08/19
 * Time: 11:24
 */

require 'core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registerDir(dirname(__FILE__) . '/core');
$loader->registerDir(dirname(__FILE__) . '/models');
$loader->register();
