<?php

declare(strict_types=1);

use App\Database;
use Slim\Views\PhpRenderer;

return [
  Database::class => function () {
    return new Database(
        driver: $_ENV['DB_DRIVER'],
        host: $_ENV['DB_HOST'],
        database: $_ENV['DB_NAME'],
        user: $_ENV['DB_USER'],
        pass: $_ENV['DB_PASS'],
    );
  },
    PhpRenderer::class => function () {

    $renderer = new PhpRenderer(APP_ROOT . '/views');

    $renderer->setLayout('layout.php');

    return $renderer;
    }
];