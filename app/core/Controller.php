<?php
declare(strict_types=1);

class Controller
{
    /**
     * Render a view under app/views/, extracting $data as local variables.
     * e.g. $this->render('pages/home', ['user_post' => $posts]);
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!is_file($viewFile)) {
            http_response_code(500);
            echo "View not found: {$view}";
            return;
        }

        require $viewFile;
    }
}
