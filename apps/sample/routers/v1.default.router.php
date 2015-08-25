<?php
// default index action, GET /
$app->get('/', 'Sample\Controller\IndexController:actionIndex')
    ->name('get-homepage');

$app->group('/v1', function () use ($app) {
    // get programmers list, GET /v1/programmers
    $app->get('/programmers', 'Sample\Controller\ProgrammerController:actionGetProgrammers')
        ->name('get-programmers-list');

    // get programmer detail, GET /v1/programmers/:id
    $app->get('/programmers/:id', 'Sample\Controller\ProgrammerController:actionGetProgrammer')
        ->conditions(array('id' => '\d+'))
        ->name('get-programmer-detail');
});