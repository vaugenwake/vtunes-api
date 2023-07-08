<?php

use Monolog\Handler\StreamHandler;
use willitscale\Streetlamp\Builders\RouterConfigBuilder;
use willitscale\Streetlamp\RouteBuilder;
use willitscale\Streetlamp\RouteCacheHandlers\NullRouteCacheHandler;
use willitscale\Streetlamp\Router;

require_once __DIR__ . '/../vendor/autoload.php';

// $dotent = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
// $dotent->load();

$logger = new \Monolog\Logger('api');
$logger->pushHandler(new StreamHandler(
    $_ENV['log_output'] ?? 'php://stdout'
));

$routeConfig = (new RouterConfigBuilder())
    ->setRootDirectory(__DIR__ . '/../')
    ->setComposerFile(__DIR__ . '/../composer.json')
    ->setCached(false)
    ->setRethrowExceptions(true)
    ->setExcludedDirectories(['tests'])
    ->setRouteCacheHandler(new NullRouteCacheHandler())
    ->build();

$routeBuilder = new RouteBuilder(
    $routeConfig,
    $logger
);

(new Router($routeBuilder))->route();