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
            '/account' => ['controller' => 'account', 'action' => 'index'],
            '/account/:action' => ['controller' => 'account'],
            '/user/:user_name' => ['controller' => 'status', 'action' => 'user'],
            '/user/:user_name/status/:id' => ['controller' => 'status', 'action' => 'show'],
            '/follow' => ['controller' => 'account', 'action' => 'follow'],
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