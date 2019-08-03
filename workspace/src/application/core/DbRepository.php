<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/03
 * Time: 9:22
 */

/**
 * DBへアクセスを行う
 */
class DbRepository
{
    /**
     * @var PDO
     */
    protected $con;

    /**
     * DbRepository constructor.
     * @param PDO $con
     */
    public function __construct(PDO $con)
    {
        $this->setCon($con);
    }

    /**
     * @param PDO $con
     */
    public function setCon(PDO $con): void
    {
        $this->con = $con;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public function execute(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * PDO::FETCH_ASSOCは取得結果を連想配列で受け取る
     * @param string $sql 'INSERT INTO user (name) VALUES (:name)'
     * @param array $params
     * @return mixed
     */
    public function fetch(string $sql, $params = []): array
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array $params [
     *      ':name' => $_POST['name']
     * ]
     * @return array
     */
    public function fetchAll(string $sql, $params = []): array
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}
