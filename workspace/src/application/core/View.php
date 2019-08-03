<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/03
 * Time: 14:10
 */

class View
{
    /**
     * @var string
     */
    protected $base_dir;
    /**
     * @var array
     */
    protected $defaults;
    /**
     * @var array
     */
    protected $layout_variables = [];

    /**
     * View constructor.
     * @param string $base_dir viewsディレクトリへの絶対パス
     * @param array viewファイルへ渡す変数をセットする
     */
    public function __construct(string $base_dir, array $defaults)
    {
        $this->base_dir = $base_dir;
        $this->defaults = $defaults;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setLayoutVar(string $name, $value): void
    {
        $this->layout_variables[$name] = $value;
    }

    /**
     * extractで変数展開時に変数の衝突を防ぐため､引数の接頭辞にアンダースコアをつける
     * @param string $_path
     * @param array $_variables
     * @param string|bool $_layout
     * @return false|string
     */
    public function render(string $_path, array $_variables, $_layout = false): string
    {
        $_file = "{$this->base_dir}/{$_path}.php";
        extract(array_merge($this->defaults, $_variables));
        ob_start();
        ob_implicit_flush(0);

        require $_file;

        $content = ob_get_clean();

        if ($_layout) {
            $content = $this->render(
                $_layout,
                array_merge($this->layout_variables, ['_content' => $content]),
                );
        }

        return $content;
    }

    /**
     * @param string $string
     * @return string
     */
    public function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
