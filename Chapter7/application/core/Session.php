<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/03
 * Time: 10:38
 */

class Session
{
    /**
     * @var bool
     */
    protected static $sessionStarted = false;
    /**
     * @var bool
     */
    protected static $sessionIdRegenerated = false;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->checkSessionStarted();
    }

    /**
     * @param string $name
     * @param $value
     */
    public function set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $name
     * @param null $default
     * @return null
     */
    public function get(string $name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $default;
    }

    /**
     * @param string $name
     */
    public function remove(string $name): void
    {
        unset($_SESSION[$name]);
    }

    /**
     * clear session
     */
    public function clear(): void
    {
        $_SESSION = [];
    }

    /**
     * @param bool $destroy
     */
    public function regenerate(bool $destroy = true): void
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);
            self::$sessionIdRegenerated = true;
        }
    }

    /**
     * @param bool $bool
     */
    public function setAuthenticated(bool $bool): void
    {
        $this->set('_authenticated', $bool);
        $this->regenerate();
    }

    /**
     * ログイン状態か判定する
     * $_Session['_authenticated']というキーがtrueならログイン状態
     * @return null
     */
    public function isAuthenticated()
    {
        return $this->get('_authenticated', false);
    }

    private function checkSessionStarted(): void
    {
        if (!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = true;
        }
    }
}
