<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('log_errors', true);
ini_set('html_errors', 1);
error_reporting(E_ALL | E_STRICT); // with E_STRICT for PHP 5.3 compatibility

return array(
    'debug' => true,

    // Templates settings
    'templates.path' => APP_DIR . '/views',

    // Logging settings
    'log.level' => Slim\Log::DEBUG,

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