<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/PageController.php';

class PagesController extends PageController
{
    /** GET/POST /search.php */
    public function search(): void
    {
        AuthMiddleware::requireAuth();
        $this->handleCreatePostIfSubmitted();

        $context = $this->loadProfileContext();
        $this->render('pages/search', $context);
    }

    /** GET /leaderboard.php */
    public function leaderboard(): void
    {
        AuthMiddleware::requireAuth();

        $context = $this->loadProfileContext();
        $context['leaderboard'] = $this->profile->getLeaderboard();
        $this->render('pages/leaderboard', $context);
    }

    /** GET /dashboard.php */
    public function dashboard(): void
    {
        AuthMiddleware::requireAuth();

        $context = $this->loadProfileContext();
        $this->render('pages/dashboard', $context);
    }

    /** GET/POST /inbox.php */
    public function inbox(): void
    {
        AuthMiddleware::requireAuth();
        $this->handleCreatePostIfSubmitted();

        $context = $this->loadProfileContext();
        $this->render('pages/inbox', $context);
    }

    /** GET/POST /faq.php and /feedback.php */
    public function feedback(): void
    {
        AuthMiddleware::requireAuth();

        $context = $this->loadProfileContext();
        $this->render('pages/faq', $context);
    }

    /** GET /affiliate.php */
    public function affiliate(): void
    {
        AuthMiddleware::requireAuth();
        $this->handleCreatePostIfSubmitted();

        extract($this->loadProfileContext(), EXTR_SKIP);
        require __DIR__ . '/../../affiliate.php';
    }

    /** GET /fetch_users.php — AJAX username-tag autocomplete. */
    public function fetchUsers(): void
    {
        AuthMiddleware::requireAuth();
        require __DIR__ . '/../../fetch_users.php';
    }

    /** GET /confirmed.php?deleteId=... — confirms and performs a post deletion. */
    public function confirmDelete(): void
    {
        AuthMiddleware::requireAuth();
        extract($this->loadProfileContext(), EXTR_SKIP);
        require __DIR__ . '/../../confirmed.php';
    }

    /** GET /postview.php — AJAX fragment: renders the logged-in user's own posts. */
    public function postView(): void
    {
        AuthMiddleware::requireAuth();
        extract($this->loadProfileContext(), EXTR_SKIP);
        require __DIR__ . '/../views/pages/postView.php';
    }

    /** GET /sharedlink.php — public "join us" landing page for shared links. */
    public function sharedLink(): void
    {
        require __DIR__ . '/../../sharedlink.php';
    }

    /** GET /contact.php — public page, no auth required. */
    public function contact(): void
    {
        $this->render('pages/contact');
    }

    /** GET /privacypolicy.php */
    public function privacyPolicy(): void
    {
        $this->render('pages/privacyPolicy');
    }

    /** GET /termscondition.php */
    public function termsCondition(): void
    {
        $this->render('pages/termsCondition');
    }
}
