<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/models/index.php';
class Signup {
    public $error = "";
    private Models $models;

    public function __construct()
    {
        $this->models = new Models();
    }


    public function evaluate($data) {
        // Required fields
        $requiredFields = [
            'userName',
            'fullName',
            'userEmail',
            'userPassword',
            'confirmPassword',
            'subType'
        ];

        $excludeKeys = ['btnSignIn'];

        // Check empty fields
        foreach ($data as $key => $value) {
            if (in_array($key, $excludeKeys)) continue;

            if (in_array($key, $requiredFields) && empty(trim($value))) {
                $this->error .= ucfirst($key) . " is empty!<br/>";
            }
        }

        // 1. Check if passwords match
        if (isset($data['userPassword'], $data['confirmPassword'])) {
            if (trim($data['userPassword']) !== trim($data['confirmPassword'])) {
                $this->error .= "Passwords do not match!<br/>";
            }
        }

        // 2. Check password strength
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/', $data['userPassword'])) {
            $this->error .= "Password must be at least 8 characters and include uppercase, lowercase, and a number.<br/>";
        }

        // If no errors so far, continue
        if ($this->error === "") {
            $this->checkUniqueness($data);
            if ($this->error === "") {
                $this->create_user($data);
            }
        }

        return $this->error;
    }

    public function checkUniqueness($data)
    {
        $userName = trim($data['userName']);

        if (!empty($userName) && $this->models->userNameExists($userName)) {
            $this->error .= "Account already exists with the provided username.<br>";
        }

        $userEmail = trim($data['userEmail']);

        if (!empty($userEmail)) {

            if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                $this->error .= "Invalid email format.<br>";
            }

            if ($this->models->emailExists($userEmail)) {
                $this->error .= "Account already exists with the provided email.<br>";
            }
        }
    }

    private function createUserID($type) {
        if ($type === "free") {
            return 'free_' . bin2hex(random_bytes(8));
        } elseif ($type === "Business") {
            return 'busi_' . bin2hex(random_bytes(8));
        }
        return 'user_' . bin2hex(random_bytes(8));
    }

    public function create_user($data)
    {
        $userId = $this->createUserID(trim($data['subType']));

        $user = [
            'userId'       => $userId,
            'userName'     => trim($data['userName']),
            'fullName'     => trim($data['fullName']),
            'email'        => trim($data['userEmail']),
            'passwordHash' => password_hash($data['userPassword'], PASSWORD_DEFAULT),
            'subType'      => trim($data['subType'])
        ];

        if (!$this->models->createUser($user)) {
            $this->error .= "Something went wrong creating your account.";
            return;
        }else{
            $this->models->createUserStats($userId, $user['userName']);
            $_SESSION['userID'] = $user['userID']; 
            header("Location: home");
            exit;
        }

        
    }
}
?>
