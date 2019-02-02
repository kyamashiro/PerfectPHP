<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/09/30
 * Time: 10:56
 */

/**
 * ユーザのリクエスト情報を制御するク
 * HTTPメソッドの判定や$_GET,$_POSTの値を取得する
 * URLに関する情報を制御する
 */
class Request
{
    /**
     * HTTPメソッドがPOSTか判定する
     * @return bool
     */
    public function isPost(): bool
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
     * @return mixed
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
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return $default;
    }

    /**
     * サーバのホスト名を取得する
     * @return mixed
     */
    public function getHost(): string
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
    public function isSsl(): bool
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
    public function getRequestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * $script_name, $request_uriの値を用いてベースURLを取得する
     * @return string
     */
    public function getBaseUrl(): string
    {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request_uri = $this->getRequestUri();

        if (strpos($request_uri, $script_name) === 0) {
            return $script_name;
        } else if (strpos($request_uri, dirname($script_name))) {
            return rtrim(dirname($script_name), '/');
        }
        return '';
    }

    /**
     * PATH_INFOを取得する
     * REQUEST_URIからベースURLを除く
     * @return string
     */
    public function getPathInfo(): string
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if (($pos = strpos($request_uri, '?')) !== false) {
            $request_uri = substr($request_uri, 0, $pos);
        }

        $path_info = (string)substr($request_uri, strlen($base_url));

        return $path_info;
    }
}
