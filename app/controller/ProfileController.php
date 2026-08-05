<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/PageController.php';

class ProfileController extends PageController
{
    /** GET/POST /profile.php */
    public function show(): void
    {
        AuthMiddleware::requireAuth();
        $this->handleCreatePostIfSubmitted();

        $this->profile->refreshDayStreak($_SESSION['myuserId']);

        $queryString = $_SERVER['QUERY_STRING'] ?? '';
        $queryString = explode('=', $queryString);
        $_SESSION['queryString'] = $queryString[1] ?? '';

        $context = $this->loadProfileContext();

        $this->render('profile/profile', $context);
    }

    /** GET /editprofile.php */
    public function edit(): void
    {
        AuthMiddleware::requireAuth();

        $context = $this->loadProfileContext();
        $this->render('profile/edit', $context);
    }

    /** POST /editprofile.php */
    public function update(): void
    {
        AuthMiddleware::requireAuth();

        $this->updateProfile->updateInfo(array_map('htmlspecialchars', $_POST));

        header('Location: /profile.php');
        exit;
    }

    /** GET/POST /changeimage.php — profile/cover picture upload. */
    public function changeImage(): void
    {
        AuthMiddleware::requireAuth();

        extract($this->loadProfileContext(), EXTR_SKIP);
        require __DIR__ . '/../../changeImage.php';
    }

    /** GET /stats.php — AJAX fragment: profile stats card. */
    public function stats(): void
    {
        AuthMiddleware::requireAuth();
        extract($this->loadProfileContext(), EXTR_SKIP);
        require __DIR__ . '/../views/profile/stats.php';
    }
}
