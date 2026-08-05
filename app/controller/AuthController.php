<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../Classes/LoginClass.php';
require_once __DIR__ . '/../../Classes/SignupClass.php';

class AuthController extends Controller
{
    public function login(): void
    {
        AuthMiddleware::guestOnly();

        $db    = new Database();
        $login = new Login($db);
        $logerror = '';
        $userName = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName = trim($_POST['userName'] ?? '');
            $logerror = $login->evaluate($_POST); // redirects to /home.php itself on success
        }

        $this->render('auth/login', [
            'logerror' => $logerror,
            'userName' => $userName,
        ]);
    }

    public function register(): void
    {
        AuthMiddleware::guestOnly();

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db     = new Database();
            $signup = new Signup($db);
            $error  = $signup->evaluate($_POST);

            if ($error === '') {
                header('Location: /home.php');
                exit;
            }
        }

        $this->render('auth/register', ['error' => $error]);
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            session_unset();
            session_destroy();
        }
        header('Location: /login.php');
        exit;
    }

    public function forgotPassword(): void
    {
        $this->render('auth/forgot-password');
    }

    /** POST /sendforgotmail.php — placeholder until a mailer is wired up. */
    public function sendForgotMail(): void
    {
        // TODO: wire up an actual mailer (see send-mail.php, which needs
        // PHPMailer installed via `composer require phpmailer/phpmailer`
        // and real SMTP credentials before it can send anything).
        $this->render('auth/forgot-password', [
            'notice' => 'If an account exists for that email, password reset instructions have been queued.',
        ]);
    }
}
