<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/09/30
 * Time: 10:56
 */

/**
 * ユーザのリクエスト情報を制御するクラス
 * HTTPメソッドの判定や$_GET,$_POSTの値を取得する
 * URLに関する情報を制御する
 */
class Request
{
    /**
     * HTTPメソッドがPOSTか判定する
     * @return bool
     */
    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }

        return false;
    }

    /**
     * $_GET変数から値を取得する
     * @param string $name
     * @param null $default
     * @return null
     */
    public function getGet(string $name, $default = null)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
        return $default;
    }

    /**
     * $_POST変数から値を取得する
     * @param string $name
     * @param null $default
     * @return null
     */
    public function getPost(string $name, $default = null)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
        return $default;
    }

    /**
     * サーバのホスト名を取得する
     * @return mixed
     */
    public function getHost()
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * HTTPSでアクセスされたのか判定する
     * HTTPSでアクセスされた場合、$_SERVER['HTTPS']に'on'という文字が含まれる
     * @return bool
     */
    public function isSsl()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }
        return false;
    }

    /**
     * リクエストされたURLの情報を返す
     * URLのホスト部分以降の値を返す
     * @return mixed
     */
    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}