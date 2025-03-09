<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;

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

$routes = require APP_ROOT . '/config/routes.php';

$routes($app);

$app->run();
