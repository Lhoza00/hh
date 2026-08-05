<?php
declare(strict_types=1);

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../../Classes/LoginClass.php';
require_once __DIR__ . '/../../Classes/ProfileClass.php';
require_once __DIR__ . '/../../Classes/PostClass.php';
require_once __DIR__ . '/../../Classes/ImageClass.php';
require_once __DIR__ . '/../../Classes/updateProfileClass.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

/**
 * Shared base for controllers that render a logged-in page. Wires up the
 * same objects/variables autoLoader.php used to set up globally, but scoped
 * per-request instead.
 */
abstract class PageController extends Controller
{
    protected Database $db;
    protected Login $login;
    protected Profile $profile;
    protected Post $post;
    protected Image $imageClass;
    protected UpdateProfile $updateProfile;

    public function __construct()
    {
        $this->db            = new Database();
        $this->login         = new Login($this->db);
        $this->profile       = new Profile();
        $this->post          = new Post($this->db);
        $this->imageClass    = new Image();
        $this->updateProfile = new UpdateProfile($this->db);
    }

    /**
     * Load profile_data / user_post / checkData for either the logged-in
     * user or a ?username=/?userName=/?search= target — the same logic
     * every profile-ish page (home, profile, search, sidebar) used to
     * duplicate for itself.
     */
    protected function loadProfileContext(): array
    {
        $targetUsername = null;
        foreach (['username', 'userName', 'search'] as $key) {
            if (!empty($_GET[$key])) {
                $targetUsername = htmlspecialchars($_GET[$key], ENT_QUOTES);
                break;
            }
        }

        $userData = null;
        if (!empty($_SESSION['myuserId'])) {
            $userData = $this->login->checkLogin($_SESSION['myuserId']);
        }

        $targetUsername = $targetUsername ?? htmlspecialchars($userData['userName'] ?? '', ENT_QUOTES);
        $getProfile     = $this->profile->getProfile($targetUsername);

        if ($getProfile && isset($getProfile[0]['userID'])) {
            $profileData = $this->profile->xpLevel($getProfile[0]['userID']);
            $checkData   = $this->login->checkData($profileData['userID']);
            $userPost    = $this->post->getPost($profileData['userID']);
        } else {
            $profileData             = $this->profile->xpLevel($_SESSION['myuserId'] ?? '');
            $profileData['userName'] = $profileData['userName'] ?? 'User not found';
            $checkData                = ['Gender' => ' '];
            $userPost                 = [];
        }

        return [
            'DB'              => $this->db,
            'login'           => $this->login,
            'profile'         => $this->profile,
            'post'            => $this->post,
            'imageClass'      => $this->imageClass,
            'updateProfile'   => $this->updateProfile,
            'user_data'       => $userData,
            'target_username' => $targetUsername,
            'get_profile'     => $getProfile,
            'profile_data'    => $profileData,
            'checkData'       => $checkData,
            'user_post'       => $userPost,
        ];
    }

    /**
     * Handle the "create post" form (postBox.php) that can be submitted
     * from several pages (home, search, inbox). Mirrors autoLoader.php's
     * global handling of $_POST['btnSavePost'].
     */
    protected function handleCreatePostIfSubmitted(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['btnSavePost'])) {
            return;
        }

        $userTags = (!empty($_COOKIE['selectedUsers']))
            ? implode(', ', json_decode($_COOKIE['selectedUsers'], true) ?: [])
            : '';

        $hashTags = (!empty($_COOKIE['hashtags']))
            ? implode(', ', json_decode($_COOKIE['hashtags'], true) ?: [])
            : '';

        setcookie('selectedUsers', '', time() - 3600, '/');
        setcookie('hashtags', '', time() - 3600, '/');

        $this->post->createPost(
            $_SESSION['myuserId'],
            array_map('htmlspecialchars', $_POST),
            $_FILES,
            $hashTags,
            $userTags
        );

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
