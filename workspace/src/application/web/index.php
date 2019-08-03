<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/09/30
 * Time: 11:13
 */

// フロントコントローラ
require '../bootstrap.php';
require '../MiniBlogApplication.php';

$request = new MiniBlogApplication(false);
echo $request->run();
