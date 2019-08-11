<?php


class StatusRepository extends DbRepository
{
    public function insert(int $user_id, string $body)
    {
        $now = new DateTime();

        $sql = 'INSERT INTO statuses(user_id, body, created_at) VALUES(:user_id, :body, :created_at)';

        $this->execute($sql, [
            ':user_id' => $user_id,
            ':body' => $body,
            ':created_at' => $now->format('Y-m-d H:i:s')
        ]);
    }

    public function fetchAllByUserId(int $user_id)
    {
        $sql = '
                SELECT a.*, u.user_name 
                FROM statuses AS a 
                    LEFT JOIN users AS u ON a.user_id = u.id 
                WHERE u.id = :user_id 
                ORDER BY a.created_at DESC
                ';

        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }

    public function fetchByIdAndUserName(int $id, string $user_name)
    {
        $sql = '
                SELECT s.*, u.user_name 
                FROM statuses AS s 
                    LEFT JOIN users AS u ON u.id = s.user_id
                WHERE s.id = :id AND u.user_name = :user_name
                ';

        return $this->fetch($sql, [
            ':id' => $id,
            ':user_name' => $user_name
        ]);
    }

    public function fetchAllPersonalArchvesByUserId(int $user_id)
    {
        $sql = '
                SELECT s.*, u.user_name
                FROM statuses AS s
                LEFT JOIN users AS u ON s.user_id = u.id
                LEFT JOIN followings AS f ON f.following_id = s.user_id
                AND f.user_id = :user_id
                WHERE f.user_id = :user_id OR u.id = :user_id
                ORDER BY s.created_at DESC
                ';

        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }
}