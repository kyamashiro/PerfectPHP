<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/02
 * Time: 16:41
 */

/**
 * DBとの接続情報を管理する
 */
class DbManager
{
    /**
     * PDOインスタンスを保持する
     * @var array
     */
    protected $connections = [];
    /**
     * @var array
     */
    protected $repository_connection_map = [];
    /**
     * @var array
     */
    protected $repositories = [];

    /**
     * DBとの接続を開放する
     * 各Repository内に参照が存在すると､connectionをunsetできないので先にRepositoryインスタンスをunsetする
     */
    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $connection) {
            unset($connection);
        }
    }

    /**
     * @param string $db_name
     * @param array $db_params Array containing the necessary params.
     *    $db_params = [
     *      'dsn'          => (string) Data source name. Required.
     *      'username'     => (string) DB username. Required.
     *      'password'     => (string) DB password. Required.
     *      'options'      => [
     *          'key' => options.
     *      ]
     *    ]
     */
    public function connect(string $db_name, array $db_params): void
    {
        $db_params = array_merge([
            'dsn' => null,
            'user' => '',
            'password' => '',
            'options' => []
        ], $db_params);

        $con = new PDO(
            $db_params['dsn'],
            $db_params['user'],
            $db_params['password'],
            $db_params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$db_name] = $con;
    }

    /**
     * 接続したコネクションを取得する
     * @param string|null $name
     * @return mixed
     */
    public function getConnection(?string $name = null)
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }

    /**
     * @param $repository_name
     * @param $name
     */
    public function setRepositoryConnectionMap(string $repository_name, string $name): void
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    /**
     * @param $repository_name
     * @return mixed
     */
    public function getConnectionForRepository(string $repository_name)
    {
        if (isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connection_map[$repository_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }
        return $con;
    }

    /**
     * @param string $repository_name
     * @return mixed
     */
    public function get(string $repository_name)
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class[$con];
            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }
}
