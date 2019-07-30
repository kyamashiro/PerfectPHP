<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/09/30
 * Time: 11:37
 */

/**
 * ルーティングパラメータを特定する役割を持つクラス
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
    public function compileRoutes($definitions): array
    {
        $routes = [];

        foreach ($definitions as $url => $params) {
            //URLをスラッシュごとに分割する
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $i => $token) {
                if (strpos($token, ':')) {
                    $name = substr($token, 1);
                    $token = "?P<{$name}>[^/]+";
                }
                $tokens[$i] = $token;
            }
            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }
        return $routes;
    }

    /**
     * @param $path_info
     * @return array|bool
     */
    public function resolve($path_info)
    {
        if (substr($path_info, 0, 1) !== '/') {
            $path_info = "/{$path_info}";
        }

        foreach ($this->routes as $pattern => $params) {
            if (preg_match("#^{$pattern}$#", $path_info, $matches)) {
                return array_merge($params, $matches);
            }
        }

        return false;
    }
}
