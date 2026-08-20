<?php 
$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
require_once $_SERVER['DOCUMENT_ROOT'] . '/root/config/config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= ($currentPage !== 'index' ? ucfirst($currentPage) : '') ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="public/css/global.css">
</head>