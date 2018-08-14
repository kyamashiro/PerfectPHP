<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/08/14
 * Time: 12:56
 */


//requireはディレクトリで指定したファイルを読み込む
require_once 'hello.php';
require_once 'folder/copy.php';

//同じメソッド名があるので衝突して呼べない
$obj = new original\hello();
$obj->hello();

$obj2 = new copy\copy();
$obj2->hello();