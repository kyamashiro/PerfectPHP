<?php


/**
 * Class FollowingRepository
 */
class FollowingRepository extends DbRepository
{
    public function insert(int $user_id, int $following_id)
    {
        $sql = 'INSERT INTO followings VALUES(:user_id, :following_id)';
        $this->execute($sql, [
            ':user_id' => $user_id,
            ':following_id' => $following_id
        ]);
    }

    public function isFollowing(int $user_id, int $following_id): bool
    {
        $sql = 'SELECT COUNT(user_id) as count FROM followings WHERE user_id = :user_id AND following_id = :following_id';

        $row = $this->fetch($sql, [
            ':user_id' => $user_id,
            ':following_id' => $following_id
        ]);

        if ($row['count'] !== '0') {
            return true;
        }

        return false;
    }

}