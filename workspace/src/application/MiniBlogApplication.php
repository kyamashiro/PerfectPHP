<?php


class MiniBlogApplication extends Application
{
    protected $login_action = ['account', 'signin'];

    public function getRootDir(): string
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes(): array
    {
        return [
            '/' => ['controller' => 'status', 'action' => 'index'],
            '/status/post' => ['controller' => 'status', 'action' => 'post'],
            '/account' => ['controller' => 'account', 'action' => 'signup'],
            '/account/register' => ['controller' => 'account', 'action' => 'register'],
            '/account/:action' => ['controller' => 'account']
        ];
    }

    protected function configure(): void
    {
        $this->db_manager->connect('perfect_php', [
            'dsn' => 'mysql:dbname=perfect_php;host=mysql',
            'user' => 'root',
            'password' => 'password'
        ]);
    }
}