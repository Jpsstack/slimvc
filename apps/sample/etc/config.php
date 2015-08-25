<?php
return array(
    'debug' => true,
    'templates.path' => BASE_DIR .'/app/views',
    'pdo' => array(
        'default' => array(
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => '',
            'options' => array()
        ),
    ),
);