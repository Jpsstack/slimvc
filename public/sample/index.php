<?php
define('BASE_DIR', __DIR__ . "/..");

use Slim\Slim;

// Load php configuration file & initialize the autoloader
$config = require BASE_DIR . '/app/etc/config.php';
$loader = require BASE_DIR . '/vendor/autoload.php';

$app = new Slim($config);

// Automatically load router files
$routers = glob(BASE_DIR . '/app/routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

$app->run();
