<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/08/14
 * Time: 12:52
 */

namespace testfile\Food\Test;

class SomeClass
{
    private $value = [];

    public function __construct()
    {
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->value;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->value = $value;
    }

    public function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    public function __unset($name)
    {
        // TODO: Implement __unset() method.
    }

    public function __sleep()
    {
        // TODO: Implement __sleep() method.
    }

    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return 'This Class is Copy'.__CLASS__;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function __debugInfo()
    {
        // TODO: Implement __debugInfo() method.
    }

    public static function __set_state($an_array)
    {
        // TODO: Implement __set_state() method.
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }
}