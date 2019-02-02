<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/08/19
 * Time: 10:59
 */

/**
 * オートローダクラス
 * オートロードが行われた際に､クラス名を元にcore/クラス名.phpかmodel/クラス名.phpがあれば読み込む
 */
class ClassLoader
{
    /**
     * @var
     */
    protected $dirs;

    /**
     * オートローダクラスを登録する処理
     * @throws Exception
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * coreディレクトリ､modelディレクトリからクラスファイルを読み込む
     * @param $dir
     */
    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    /**
     * オートロードが実行された際にクラスファイルを読み込む処理
     * @param $class
     */
    public function loadClass($class)
    {
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $class . '.php';
            if (is_readable($file)) {
                require $file;

                return;
            }
        }
    }
}
