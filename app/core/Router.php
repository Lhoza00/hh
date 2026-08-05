<?php

declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][strtolower($path)] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][strtolower($path)] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        // The legacy templates link to the same page with inconsistent casing
        // (Profile.php, profile.php, PROFILE.php...). Routes are registered
        // lowercase, so normalize incoming paths the same way.
        $path = strtolower($path ?? '/');

        // Legacy views/components still read PHP_SELF to know which page
        // they're on. Under the front controller it would otherwise always
        // read "/index.php", so we normalize it to the matched route path.
        $_SERVER['PHP_SELF'] = $path;

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];

            if (is_array($handler)) {
                [$controller, $action] = $handler;
                $controller = new $controller();
                $controller->$action();
            } else {
                $handler();
            }

            return;
        }

        http_response_code(404);
        echo "404 - Page Not Found";
    }
}