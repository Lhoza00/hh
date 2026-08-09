<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/models/index.php';
class Post{
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
     * $userId  - int/string, from session (e.g. $_SESSION['myuserId'])
     * $data    - the raw $_POST array (post text, optional hashTags/userTags)
     * $files   - the raw $_FILES array (optional 'file' upload)
     */
    public function createPost($userId, $data, $files = []){
        $userName = $this->models->getUserNameById($userId);
        if(empty($userName)){
            $this->error = "Invalid user.";
            return false;
        }

        $postText = trim($data['post'] ?? '');
        $hasFile  = !empty($files['file']['name']);

        if($postText === '' && !$hasFile){
            $this->error = "Insert into the input to post";
            return false;
        }

        $hashTags = $this->parseHashTags($data['hashTags'] ?? '');
        $userTags = $this->parseUserTags($data['userTags'] ?? '');

        $postId    = $this->createPostID();
        $imagePath = '';
        $hasImage  = 0;

        if($hasFile){
            $imagePath = $this->handleImageUpload($files['file'], $userName, $postId);
            if($imagePath === false){
                $this->error = "Invalid image file.";
                return false;
            }
            $hasImage = 1;
        }

        $saved = $this->models->insertPost(
            $userId,
            $userName,
            json_encode($hashTags),
            json_encode($userTags),
            $postId,
            $postText,
            $imagePath,
            $hasImage
        );

        if(!$saved){
            $this->error = "Could not save post.";
            return false;
        }

        return $postId;
    }

    /**
     * Expects a comma-separated string (e.g. from a hidden field your
     * hashtag dialog populates). Strips a leading '#', keeps only
     * word characters, dedupes, and caps the count so someone can't
     * paste in 500 "hashtags".
     */
    
    private function parseHashTags($raw){
        if(trim($raw) === ''){
            return [];
        }
        $tags = explode(',', $raw);
        $clean = [];
        foreach($tags as $tag){
            $tag = ltrim(trim($tag), '#');
            $tag = preg_replace('/[^A-Za-z0-9_]/', '', $tag);
            if($tag !== ''){
                $clean[] = $tag;
            }
        }
        return array_slice(array_values(array_unique($clean)), 0, 10);
    }

    /**
     * Expects a comma-separated string of userIDs (e.g. from a hidden field
     * your "tag user" dialog populates). Every ID is verified against
     * userdetails before being saved — never trust client-supplied IDs
     * as-is, since that field could be edited to tag arbitrary/nonexistent
     * users.
     */
    private function parseUserTags($raw){
        if(trim($raw) === ''){
            return [];
        }
        $ids = array_filter(array_map('trim', explode(',', $raw)));
        $ids = array_values(array_unique($ids));
        if(empty($ids)){
            return [];
        }
        $ids = array_slice($ids, 0, 10);
        return $this->models->getExistingUserIds($ids);
    }

    /**
     * Validates the upload against a whitelist (checked against the ACTUAL file
     * content, not the client-supplied MIME type, which is trivially spoofed),
     * stores it under uploads/<userName>/, and crops it.
     * Returns the stored path, or false if the file is rejected.
     */
    private function handleImageUpload($file, $userName, $postId){
        $allowedTypes = [
            'image/png'  => 'png',
            'image/jpeg' => 'jpeg',
        ];

        if($file['error'] !== UPLOAD_ERR_OK){
            return false;
        }

        $finfo      = finfo_open(FILEINFO_MIME_TYPE);
        $actualType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if(!isset($allowedTypes[$actualType])){
            return false;
        }

        // userName is trusted-ish (came from DB via userId), but never build
        // filesystem paths from raw client input without stripping traversal chars.
        $safeUserName = preg_replace('/[^A-Za-z0-9_\-]/', '', $userName);
        $folder = "uploads/" . $safeUserName . "/";

        if(!file_exists($folder)){
            mkdir($folder, 0755, true);
            $this->protectFolder($folder);
        }

        $image_class = new Image();
        $fileName    = $image_class->generatePost($postId, $safeUserName) . '.' . $allowedTypes[$actualType];
        $destination = $folder . $fileName;

        if(!move_uploaded_file($file['tmp_name'], $destination)){
            return false;
        }

        $image_class->cropImage($destination, $destination, 800, 800, $actualType);

        return $destination;
    }

    private function protectFolder($folder){
        $content = <<<'PHP'
<?php
session_start();
if (empty($_SESSION["myuserId"])) {
    session_destroy();
    header("Location: /index.php");
    exit;
} else {
    header("Location: /home.php");
    exit;
}
PHP;
        file_put_contents($folder . "index.php", $content);
    }

    public function createPostID(){
        return 'post_' . bin2hex(random_bytes(8));
    }

    public function getTime($pasttime, $today = 0, $differentFormat = '%y') {
        $today = date("Y-m-d H:i:s");
        $past = date_create($pasttime);
        $dateTime2 = date_create($today);

        $interval = date_diff($past, $dateTime2);
        if ($interval->invert) {
            return "Invalid date";
        }

        switch (true) {
            case ($interval->y >= 1):
                return $past->format("F jS, Y");
            case ($interval->m >= 1):
                return $past->format("jS F");
            case ($interval->d > 2):
                return $past->format("jS F");
            case ($interval->d == 2):
                return "2 days ago";
            case ($interval->d == 1):
                return "A day ago";
            case ($interval->h >= 2):
                return $interval->h . " hours ago";
            case ($interval->h == 1):
                return "1 hour ago";
            case ($interval->i >= 2):
                return $interval->i . " minutes ago";
            case ($interval->i == 1):
                return "1 minute ago";
            case ($interval->s >= 2):
                return $interval->s . " seconds ago";
            default:
                return "just now";
        }
    }
    public function getProfilePost($user){
        if(empty($user)){
            return false;
        }
        $temp = $this->models->getUserByName($user);
        return $this->models->getMyPosts($temp['userID']);
    }
    public function getPost($userId){
        if(empty($userId)){
            return false;
        }
        return $this->models->getRecentPosts(10);
    }

    public function get_deletePost($postId){
        return $this->models->getPostById($postId);
    }

    public function deletePost($postId){
        $this->models->deletePostAndEngagement($postId);
    }

    public function getUser($userId){
        return $this->models->getUserPostsByUserId($userId);
    }

    public function isPromoted($postId, $userId) {
        $result = $this->models->getEngagement($postId, 'promote');
        if(!$result){
            return false;
        }
        $userArray = json_decode($result['users'], true) ?? [];
        return in_array($userId, $userArray);
    }

    /**
     * $postType must be one of a known whitelist — it gets used to build a
     * column name ("{$postType}s"), so an unvalidated value here is a SQL
     * injection risk via the column name, not just a logic bug.
     */
    public function engage_post($postId, $postType, $userId) {
        $allowedTypes = ['like', 'love', 'share', 'promote'];
        if(!in_array($postType, $allowedTypes, true)){
            $this->error = "Invalid engagement type.";
            return false;
        }

        $column = $postType . 's';
        $result  = $this->models->getEngagement($postId, $postType);

        $userArray = [];
        $engaged   = false;

        if($result){
            $userArray = json_decode($result['users'], true) ?? [];

            if(in_array($userId, $userArray)){
                $userArray = array_values(array_diff($userArray, [$userId]));
                $engaged = false;
            }else{
                $userArray[] = $userId;
                $engaged = true;
            }

            $this->models->updateEngagementUsers($postId, $postType, json_encode($userArray));
        }else{
            $userArray = [$userId];
            $this->models->insertEngagement($postId, $postType, json_encode($userArray));
            $engaged = true;
        }

        $this->models->adjustEngagementCount($postId, $column, $engaged);
        return true;
    }

    public function getLikes($postId, $type) {
        $result = $this->models->getEngagement($postId, $type);
        if($result && isset($result['users'])){
            return json_decode($result['users'], true) ?? [];
        }
        return [];
    }
}