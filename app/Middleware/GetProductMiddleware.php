<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Repositories\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

readonly class GetProductMiddleware implements MiddlewareInterface
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $context = RouteContext::fromRequest($request);

        $route = $context->getRoute();

        $id = $route->getArgument('id');

        $product = $this->repository->getById((int)$id);

        if (! $product) {
            throw new HttpNotFoundException($request, message: 'Product not found');
        }

        $request = $request->withAttribute('product', $product);

        return $handler->handle($request);

    }
}