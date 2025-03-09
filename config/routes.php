<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ProductController;
use App\Controllers\ProductIndexController;
use App\Controllers\ProfileController;
use App\Controllers\SignupController;
use App\Middleware\ActivateSessionMiddleware;
use App\Middleware\AddJsonResponseHeaderMiddleware;
use App\Middleware\GetProductMiddleware;
use App\Middleware\RequireAPIKeyMiddleware;
use App\Middleware\RequireLoginMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $app->group('', function (RouteCollectorProxy $group) {

        $group->get('/', HomeController::class);

        $group->get('/signup', [SignupController::class, 'new']);
        $group->post('/signup', [SignupController::class, 'create']);
        $group->get('/signup/success', [SignupController::class, 'success']);

        $group->get('/login', [LoginController::class, 'new']);
        $group->post('/login', [LoginController::class, 'create']);

        $group->get('/logout', [LoginController::class, 'destroy']);

        $group->get('/profile', [ProfileController::class, 'show'])
            ->add(RequireLoginMiddleware::class);

    })->add(ActivateSessionMiddleware::class);

    $app->group('/api', function (RouteCollectorProxy $group) {

        $group->get('/products', ProductIndexController::class);

        $group->post('/products', [ProductController::class, 'create']);

        $group->group('', function (RouteCollectorProxy $group) {

            $group->get('/products/{id:[0-9]+}', ProductController::class . ':show');

            $group->patch('/products/{id:[0-9]+}', ProductController::class . ':update');

            $group->delete('/products/{id:[0-9]+}', ProductController::class . ':delete');

        })->add(GetProductMiddleware::class);

    })->add(RequireAPIKeyMiddleware::class)
        ->add(AddJsonResponseHeaderMiddleware::class);
};