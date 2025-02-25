<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config.php';

use App\Controllers\KvStore\DeleteKeyController;
use App\Controllers\KvStore\GetKeyController;
use App\Controllers\KvStore\ListKeysController;
use App\Controllers\KvStore\SetKeyController;
use App\Middleware\PlainTextErrorResponseMiddleware;
use App\Services\KvStoreService;
use App\Services\SqliteService;
use App\Support\Config;

Config::load($config);

// Initialize database
$sqliteService = new SqliteService($config['db']['path']);
$sqliteService->initialize();

// Initialize KV store
$kvStoreService = new KvStoreService($sqliteService);
$kvStoreService->initialize();

$container = new FrameworkX\Container([
    SqliteService::class => fn() => $sqliteService,
    KvStoreService::class => fn() => $kvStoreService,
]);

$app = new FrameworkX\App(
    $container,
    PlainTextErrorResponseMiddleware::class
);

// KV Store routes
$app->get('/', ListKeysController::class);
$app->get('/{key}', GetKeyController::class);
$app->put('/{key}', SetKeyController::class);
$app->delete('/{key}', DeleteKeyController::class);

$app->run();