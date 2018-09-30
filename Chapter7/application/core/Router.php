<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/09/30
 * Time: 11:37
 */

class Router
{
    /**
     * @var array
     */
    protected $routes;

    /**
     * ルーティング定義配列を受け取り、compileRoutesメソッドに渡して変換したものを$routesプロパティとして設定する
     * Router constructor.
     * @param $definitions
     */
    public function __construct($definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }

    /**
     * ルーティング定義配列のキーに含まれる動的パラメータを変換する
     * @param $definitions
     * @return array
     */
    public function compileRoutes($definitions)
    {
        $routes = [];

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $i => $token) {
                if (strpos($tokens, ':')) {
                    $name = substr($token, 1);
                    $token = "?P<{$name}>[^/]+";
                }
                $tokens[$i] = $token;
            }
        }

        $pattern = '/' . implode('/', $tokens);
        $routes[$pattern] = $params;

        return $routes;
    }

    public function resolve($path_info)
    {
        if (substr($path_info, 0, 1) !== '!') {
            $path_info = "/{$path_info}";
        }
    }
}