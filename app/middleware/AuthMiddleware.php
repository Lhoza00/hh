<?php
declare(strict_types=1);

class AuthMiddleware
{
    /** Call at the top of any controller action that requires login */
    public static function requireAuth(): void
    {
        if (empty($_SESSION['myuserId'])) {
            header("Location: /login.php");
            exit;
        }
    }

    /** Call at the top of guest-only pages (login/register) */
    public static function guestOnly(): void
    {
        if (!empty($_SESSION['myuserId'])) {
            header("Location: /home.php");
            exit;
        }
    }
}
