<?php


class UserRepository extends DbRepository
{
    public function insert(string $user_name, string $password)
    {
        $password = $this->hashPassword($password);

        $sql = 'INSERT INTO users(user_name, password, created_at) VALUES(:user_name, :password, NOW())';

        $this->execute($sql, [
            ':user_name' => $user_name,
            ':password' => $password
        ]);
    }

    public function hashPassword(string $password): string
    {
        return sha1($password . 'SecretKey');
    }

    public function fetchByUserName(string $user_name): array
    {
        $sql = 'SELECT * FROM users WHERE user_name = :user_name';

        return $this->fetch($sql, [':user_name' => $user_name]);
    }

    public function isUniqueUserName(string $user_name): bool
    {
        $sql = 'SELECT COUNT(id) as count FROM users WHERE user_name = :user_name';
        $row = $this->fetch($sql, [':user_name' => $user_name]);
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }
}