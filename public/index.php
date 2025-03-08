<?php

declare(strict_types=1);

use App\Controllers\ProductController;
use App\Controllers\ProductIndexController;
use App\Middleware\AddJsonResponseHeaderMiddleware;
use App\Middleware\GetProductMiddleware;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Routing\RouteCollectorProxy;

define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

$builder = new ContainerBuilder();

$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')
    ->build();

AppFactory::setContainer($container);

$app = AppFactory::create();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs);

$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');

$app->add(AddJsonResponseHeaderMiddleware::class);

$app->group('/api', function (RouteCollectorProxy $group) {

    $group->get('/products', ProductIndexController::class);

    $group->post('/products', [ProductController::class, 'create']);

    $group->group('', function (RouteCollectorProxy $group) {

        $group->get('/products/{id:[0-9]+}', ProductController::class . ':show');

        $group->patch('/products/{id:[0-9]+}', ProductController::class . ':update');

        $group->delete('/products/{id:[0-9]+}', ProductController::class . ':delete');

    })->add(GetProductMiddleware::class);

});

$app->run();