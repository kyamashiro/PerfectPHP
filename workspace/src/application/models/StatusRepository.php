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

    public function fetchAllPersonalArchivesByUserId(int $user_id)
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
}