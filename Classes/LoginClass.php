<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/models/index.php';
class Login{
    private $error = "";
    private Models $models;

    public function __construct()
    {
        $this->models = new Models();
    }
    public function evaluate($data){
        $userName = htmlspecialchars(trim($data['userName']));
        $userPassword = htmlspecialchars(trim($data['userPassword']));
        if ($userName  === '') {
            $this->error .= "Username or email is required.";
        }elseif($userPassword  === '') {
            $this->error .= "Password is required.";
        }
        if ($userName && $userPassword) {
            $user = $this->models->findByLogin($userName);
            if($user) {
                if(password_verify($userPassword, $user["userPassword"])) {
                   $_SESSION['userID'] = $user['userID']; 
                    header("Location: home");
                    exit;
                } else {
                    $this->error .= "Incorrect Username or Password";
                }
            } else {
                $this->error .= "Incorrect Username or Password<br>";
            }
        }
        return $this->error;
    }
}
?>
