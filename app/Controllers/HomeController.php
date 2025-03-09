<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

readonly class HomeController
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function __invoke(Request $request , Response $response): Response
    {
        $data = $this->repository->getAll();

        $body = json_encode($data);

        $response->getBody()->write($body);

        return $response;
    }
}