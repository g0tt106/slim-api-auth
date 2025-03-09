<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;
use Valitron\Validator;

class LoginController
{
    public function __construct(
        private readonly PhpRenderer $view,
        private UserRepository $repository
    )
    {
    }

    public function new(Request $request , Response $response): Response
    {
        return $this->view->render($response, 'login.php');
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $user = $this->repository->find('email', $data['email']);

        if ($user && password_verify($data['password'], $user['password_hash'])) {

            $_SESSION['user_id'] = $user['id'];

            return $response
                ->withHeader('Location', '/')
                ->withStatus(302);
        }

        return $this->view->render($response, 'login.php', [
            'data' => $data,
            'errors' => 'Invalid login'
        ]);
    }

    public function destroy(Request $request, Response $response): Response
    {
        session_destroy();

        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }
}