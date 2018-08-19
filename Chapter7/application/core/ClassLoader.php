<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/08/19
 * Time: 10:59
 */

class ClassLoader
{
    protected $dirs;

    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

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