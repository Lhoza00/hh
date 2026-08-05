<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/PageController.php';

class HomeController extends PageController
{
    /** GET / and /index.php — public landing page. */
    public function landing(): void
    {
        if (!empty($_SESSION['myuserId'])) {
            header('Location: /home.php');
            exit;
        }
        $this->render('pages/index');
    }

    /** GET/POST /home.php — the logged-in feed. */
    public function home(): void
    {
        AuthMiddleware::requireAuth();
        $this->handleCreatePostIfSubmitted();

        $context = $this->loadProfileContext();
        $this->render('pages/home', $context);
    }
}
