<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

readonly class SignupController
{
    public function __construct(private PhpRenderer $view)
    {
    }

    public function __invoke(Request $request , Response $response): Response
    {
        return $this->view->render($response, 'home.php');
    }
}