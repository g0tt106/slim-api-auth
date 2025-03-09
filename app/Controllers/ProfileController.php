<?php

declare(strict_types=1);

namespace App\Controllers;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

class ProfileController
{
    public function __construct(private PhpRenderer $view)
    {
    }

    public function show(Request $request, Response $response): Response
    {
        $user = $request->getAttribute('user');

        $encryption_key = Key::loadFromAsciiSafeString($_ENV['ENCRYPTION_KEY']);

        $api_key = Crypto::decrypt($user['api_key'], $encryption_key);

        return $this->view->render($response, 'profile.php', [
            'api_key' => $api_key
        ]);
    }
}