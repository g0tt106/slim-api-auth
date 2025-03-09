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
        private Validator $validator,
        private UserRepository $repository,
    )
    {
        $this->validator->mapFieldsRules([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', ['lengthMin', 6]],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }

    public function new(Request $request , Response $response): Response
    {
        return $this->view->render($response, 'signup.php');
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $this->validator = $this->validator->withData($data);

        if (! $this->validator->validate()) {

            return $this->view->render($response, 'signup.php', [
                'errors' => $this->validator->errors(),
                'data' => $data
            ]);
        }

        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $api_key = bin2hex(random_bytes(16));

        $data['api_key'] = '';

        $data['api_key_hash'] = hash_hmac('sha256', $api_key, $_ENV['HASH_SECRET_KEY']);

        $this->repository->create($data);

        $response->getBody()
            ->write("Here is your API key: $api_key");

        return $response;
    }
}