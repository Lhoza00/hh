<?php

declare(strict_types=1);
require_once __DIR__ . '/../../config/database.php';

class Models {
    private Database $DB;
    public function __construct()
    {
        $this->DB = new Database();
    }
    
    public function findByLogin($login)
    {
        $result = $this->DB->read(
            'SELECT * FROM userdetails WHERE userName = ? OR userEmail = ? LIMIT 1',
            [$login, $login]
        );

        $user = $result[0] ?? null;

        if (!$user) {
            return null;
        }

        return $user;
    }
    public function userNameExists($userName)
    {
        $result = $this->DB->read(
            "SELECT 1 FROM userdetails WHERE userName = ? LIMIT 1",
            [$userName]
        );

        return !empty($result);
    }
    public function emailExists($email)
    {
        $result = $this->DB->read(
            "SELECT 1 FROM userdetails WHERE userEmail = ? LIMIT 1",
            [$email]
        );

        return !empty($result);
    }
    public function createUser(array $user)
    {
        return $this->DB->save(
            "INSERT INTO userdetails
            (userID, userName, fullName, userEmail, userPassword, subType)
            VALUES (?, ?, ?, ?, ?, ?)",
            [
                $user['userId'],
                $user['userName'],
                $user['fullName'],
                $user['email'],
                $user['passwordHash'],
                $user['subType']
            ]
        );
    }
    public function createUserStats($userId, $userName)
    {
        return $this->DB->save(
            "INSERT INTO userstats
            (userID, userName, userLevel, xpLevel, totalXP, bioStatement)
            VALUES (?, ?, 0, 0, 0, '')",
            [
                $userId,
                $userName
            ]
        );
    }

    // --- Post-related methods (used by the Post class) ---

    public function getUserNameById($userId)
    {
        $result = $this->DB->read(
            "SELECT userName FROM userdetails WHERE userID = ? LIMIT 1",
            [$userId]
        );

        return $result[0]['userName'] ?? false;
    }
    public function getUserByName($userName)
    {
        $result = $this->DB->read(
            "SELECT * FROM userStats WHERE userName = ? LIMIT 1",
            [$userName]
        );
        return $result[0];
    }
    public function getExistingUserIds(array $userIds)
    {
        if (empty($userIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($userIds), '?'));
        $result = $this->DB->read(
            "SELECT userID FROM userdetails WHERE userID IN ($placeholders)",
            $userIds
        );

        return array_column($result, 'userID');
    }

    public function insertPost($userId, $userName, $hashTags, $userTags, $postId, $post, $image, $hasImage)
    {
        return $this->DB->save(
            "INSERT INTO posts(userId, userName, hashTags, userTags, postid, post, image, hasImage)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [$userId, $userName, $hashTags, $userTags, $postId, $post, $image, $hasImage]
        );
    }

    public function getRecentPosts($limit = 5)
    {
        $limit = (int) $limit; // some drivers reject LIMIT as a bound param, so cast + interpolate
        return $this->DB->read("SELECT * FROM posts LIMIT {$limit}") ?: false;
    }
    public function getMyPosts($user){
        $limit = (int) 20;
        return $this->DB->read("SELECT * FROM posts WHERE userId= ?", [$user]) ?: false;
    }

    public function getPostById($postId)
    {
        $result = $this->DB->read(
            "SELECT * FROM posts WHERE postID = ? LIMIT 1",
            [$postId]
        );

        return $result[0] ?? false;
    }

    public function deletePostAndEngagement($postId)
    {
        $this->DB->save("DELETE FROM posts WHERE postID = ?", [$postId]);
        $this->DB->save("DELETE FROM engagement WHERE postID = ?", [$postId]);
    }

    public function getUserPostsByUserId($userId)
    {
        $result = $this->DB->read(
            "SELECT * FROM posts WHERE userId = ? LIMIT 1",
            [$userId]
        );

        return $result[0] ?? false;
    }

    public function getEngagement($postId, $type)
    {
        $result = $this->DB->read(
            "SELECT * FROM engagement WHERE postID = ? AND types = ? LIMIT 1",
            [$postId, $type]
        );

        return $result[0] ?? false;
    }

    public function updateEngagementUsers($postId, $type, $usersJson)
    {
        return $this->DB->save(
            "UPDATE engagement SET users = ? WHERE types = ? AND postID = ? LIMIT 1",
            [$usersJson, $type, $postId]
        );
    }

    public function insertEngagement($postId, $type, $usersJson)
    {
        return $this->DB->save(
            "INSERT INTO engagement (types, postID, users) VALUES (?, ?, ?)",
            [$type, $postId, $usersJson]
        );
    }

    /**
     * $column must already be whitelisted by the caller (Post::engage_post
     * whitelists $postType before building it) — this is a second check,
     * not the only one, since building SQL from any variable column name
     * is a SQL-injection vector even when the value looks "internal".
     */
    public function adjustEngagementCount($postId, $column, $increment)
    {
        $allowedColumns = ['likes', 'loves', 'shares', 'promotes'];
        if (!in_array($column, $allowedColumns, true)) {
            return false;
        }

        $op = $increment ? '+' : '-';
        return $this->DB->save(
            "UPDATE posts SET {$column} = {$column} {$op} 1 WHERE postID = ?",
            [$postId]
        );
    }
}/*class Models
{
    public function findUser(string $login)
    {
        return $this->DB->read(
            "SELECT * FROM userdetails
             WHERE userName = ? OR email = ?
             LIMIT 1",
            [$login, $login]
        )[0] ?? null;
    }

    public function updateSessionToken(
        int $userId,
        string $token,
        string $expires
    )
    {
        return $this->DB->save(
            "UPDATE userdetails
             SET sessionToken = ?, sessionExpires = ?
             WHERE userId = ?",
            [$token, $expires, $userId]
        );
    }

    public function findBySessionToken(string $token)
    {
        return $this->DB->read(
            "SELECT *
             FROM userdetails
             WHERE sessionToken = ?
             AND sessionExpires > NOW()
             LIMIT 1",
            [$token]
        )[0] ?? null;
    }

    public function clearSessionToken(int $userId)
    {
        return $this->DB->save(
            "UPDATE userdetails
             SET sessionToken = NULL,
                 sessionExpires = NULL
             WHERE userId = ?",
            [$userId]
        );
    }
} */