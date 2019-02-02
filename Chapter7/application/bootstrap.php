<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/08/19
 * Time: 11:24
 */

/**
 * bootstrap.phpはルートディレクトリ直下に置く
 * bootstrap.phpにはアプリケーションを立ち上げるための動作という意味がある
 * そのためのオートロードを設定する
 */
require 'core/ClassLoader.php';

// core,modelディレクトリのクラスを読み込む
$loader = new ClassLoader();
$loader->registerDir(dirname(__FILE__) . '/core');
$loader->registerDir(dirname(__FILE__) . '/models');
$loader->register();
