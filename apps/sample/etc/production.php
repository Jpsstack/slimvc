<?php
ini_set('display_errors', false);
ini_set('display_startup_errors', false);
ini_set('log_errors', true);
ini_set('html_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

return array(
    'debug' => false,

    // Templates settings
    'templates.path' => APP_DIR . '/views',

    // Logging settings
    'logs.level' => Slim\Log::DEBUG,

    // PDO database settings
    'pdo' => array(
        'default' => array(
            'dsn' => 'mysql:host=localhost;dbname=sample',
            'username' => 'root',
            'password' => '',
            'options' => array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            )
        ),
    ),
);