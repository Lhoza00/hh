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
            'SELECT * FROM userlogin WHERE userName = ? OR userEmail = ? LIMIT 1',
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
            "SELECT 1 FROM userlogin WHERE userName = ? LIMIT 1",
            [$userName]
        );

        return !empty($result);
    }
    public function emailExists($email)
    {
        $result = $this->DB->read(
            "SELECT 1 FROM userlogin WHERE userEmail = ? LIMIT 1",
            [$email]
        );

        return !empty($result);
    }
    public function createUser(array $user)
    {
        return $this->DB->save(
            "INSERT INTO userlogin
            (userID, userName, fullName, userEmail, userPassword, status)
            VALUES (?, ?, ?, ?, ?, ?)",
            [
                $user['userId'],
                $user['userName'],
                $user['fullName'],
                $user['email'],
                $user['passwordHash'],
                $user['status']
            ]
        );
    }
    public function createUserStats($userId, $userName)
    {
        return $this->DB->save(
            "INSERT INTO userprofile
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
            "SELECT userName FROM userlogin WHERE userID = ? LIMIT 1",
            [$userId]
        );

        return $result[0]['userName'] ?? false;
    }
    public function getUserByName($userName)
    {
        $result = $this->DB->read(
            "SELECT * FROM userprofile WHERE userName = ? LIMIT 1",
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
            "SELECT userID FROM userlogin WHERE userID IN ($placeholders)",
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

    public function deletePost($postId)
    {
        $this->DB->save("DELETE FROM posts WHERE postID = ?", [$postId]);
    }

    public function getUserPostsByUserId($userId)
    {
        $result = $this->DB->read(
            "SELECT * FROM posts WHERE userId = ? LIMIT 1",
            [$userId]
        );

        return $result[0] ?? false;
    }

    public function getSettings($userId){
        $result = $this->DB->read(
            "SELECT * FROM settings WHERE userId = ? LIMIT 1",
            [$userId]
        );
        return $result[0] ?? false;

    }

    // --- Notification-related methods (used by the Notification class) ---

    public function insertNotification($notifId, $fromUserId, $toUserId, $type, $postId, $isRead = 0)
    {
        return $this->DB->save(
            "INSERT INTO notifications (notifID, fromUserId, toUserId, type, postID, isRead)
             VALUES (?, ?, ?, ?, ?, ?)",
            [$notifId, $fromUserId, $toUserId, $type, $postId, $isRead]
        );
    }

    public function getNotificationsByUserId($userId, $limit = 20)
    {
        $limit = (int) $limit; // some drivers reject LIMIT as a bound param, so cast + interpolate
        return $this->DB->read(
            "SELECT * FROM notifications WHERE toUserId = ? ORDER BY createdAt DESC LIMIT {$limit}",
            [$userId]
        ) ?: false;
    }

    public function getNotificationById($notifId)
    {
        $result = $this->DB->read(
            "SELECT * FROM notifications WHERE notifID = ? LIMIT 1",
            [$notifId]
        );

        return $result[0] ?? false;
    }

    public function markNotificationRead($notifId, $userId)
    {
        return $this->DB->save(
            "UPDATE notifications SET isRead = 1 WHERE notifID = ? AND toUserId = ? LIMIT 1",
            [$notifId, $userId]
        );
    }

    public function markAllNotificationsRead($userId)
    {
        return $this->DB->save(
            "UPDATE notifications SET isRead = 1 WHERE toUserId = ? AND isRead = 0",
            [$userId]
        );
    }

    public function deleteNotification($notifId, $userId)
    {
        return $this->DB->save(
            "DELETE FROM notifications WHERE notifID = ? AND toUserId = ? LIMIT 1",
            [$notifId, $userId]
        );
    }

    public function getUnreadNotificationCount($userId)
    {
        $result = $this->DB->read(
            "SELECT COUNT(*) as cnt FROM notifications WHERE toUserId = ? AND isRead = 0",
            [$userId]
        );

        return (int) ($result[0]['cnt'] ?? 0);
    }
}