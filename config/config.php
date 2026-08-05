<?php
    declare(strict_types=1);

    define('APP_NAME', '{n/a}');
    define('APP_URL','http:localhost/root/');
    define('APP_ENV','development');
    define('ROOT_COLORS',':root{
    --Main: #FF6E00;
    --Primary: #FFFFFF;
    --Secondary: #EAE6e0;
    --Substitute: #FFA74F;
    --Tertiary: #FFFFFF;
    --muted:#7a6a55;
    --border:rgba(255,110,0,0.15);
}');
    define('DEBUG', true);

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'linkspamdb');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    define('UPLOAD_PATH', __DIR__ . '/../public/uploads/');

    date_default_timezone_set('Africa/Johannesburg');