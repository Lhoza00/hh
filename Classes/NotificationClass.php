<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/models/index.php';

class Notification{
    private $error = "";
    private Models $models;

    public function __construct()
    {
        $this->models = new Models();
    }

    public function getError(){
        return $this->error;
    }

    /**
     * $fromUserId - int/string, the user who triggered the notification
     * $toUserId   - int/string, the user who should receive it (from session on read,
     *               but comes from context — e.g. the post owner — when creating)
     * $type       - must be one of the whitelisted types below
     * $postId     - optional, the related post ID (null for things like 'follow')
     *
     * Silently no-ops (and does not error) if $fromUserId === $toUserId, since
     * users shouldn't get notified about their own actions on their own content.
     */
    public function createNotification($fromUserId, $toUserId, $type, $postId = null){
        $allowedTypes = ['like', 'love', 'share', 'promote', 'comment', 'tag', 'follow'];
        if(!in_array($type, $allowedTypes, true)){
            $this->error = "Invalid notification type.";
            return false;
        }

        if(empty($fromUserId) || empty($toUserId)){
            $this->error = "Invalid user.";
            return false;
        }

        if((string)$fromUserId === (string)$toUserId){
            // Don't notify people about their own actions.
            return true;
        }

        $notifId = $this->createNotificationID();

        $saved = $this->models->insertNotification(
            $notifId,
            $fromUserId,
            $toUserId,
            $type,
            $postId
        );

        if(!$saved){
            $this->error = "Could not save notification.";
            return false;
        }

        return $notifId;
    }

    /**
     * Returns the most recent notifications for a user, newest first.
     */
    public function getNotifications($userId, $limit = 20){
        if(empty($userId)){
            return false;
        }
        return $this->models->getNotificationsByUserId($userId, $limit);
    }

    public function getUnreadCount($userId){
        if(empty($userId)){
            return 0;
        }
        return $this->models->getUnreadNotificationCount($userId);
    }

    /**
     * $userId is required and checked against the notification's owner in the
     * query itself (see Models::markNotificationRead) — never trust a
     * client-supplied notifID alone to mark someone else's notification read.
     */
    public function markAsRead($notifId, $userId){
        if(empty($notifId) || empty($userId)){
            $this->error = "Invalid request.";
            return false;
        }

        $notification = $this->models->getNotificationById($notifId);
        if(!$notification || (string)$notification['toUserId'] !== (string)$userId){
            $this->error = "Notification not found.";
            return false;
        }

        return $this->models->markNotificationRead($notifId, $userId);
    }

    public function markAllAsRead($userId){
        if(empty($userId)){
            $this->error = "Invalid user.";
            return false;
        }
        return $this->models->markAllNotificationsRead($userId);
    }

    public function deleteNotification($notifId, $userId){
        if(empty($notifId) || empty($userId)){
            $this->error = "Invalid request.";
            return false;
        }

        $notification = $this->models->getNotificationById($notifId);
        if(!$notification || (string)$notification['toUserId'] !== (string)$userId){
            $this->error = "Notification not found.";
            return false;
        }

        return $this->models->deleteNotification($notifId, $userId);
    }

    public function createNotificationID(){
        return 'notif_' . bin2hex(random_bytes(8));
    }
}
